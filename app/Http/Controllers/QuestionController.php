<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
Use App\Models\ClassList;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Option;
use App\Models\ClassSubject;
use App\Models\ClassQuestion;
use Excel;
use App\Http\Requests\UploadQuestionRequest;

class QuestionController extends Controller
{
    protected  $classes;
    protected $subjects;
    protected $chapters;
    protected $questions;
    protected $topics;
    protected $options;
    protected $class_subjects;
    protected $class_questions;

    public function __construct( ClassList $class, Subject $subject, Chapter $chapter,
                                 Question $question, Topic $topic, Option $option,
                                 ClassSubject $class_subject, ClassQuestion $class_question )
    {
        $this->middleware('auth');
        $this->classes = $class;
        $this->subjects = $subject;
        $this->chapters = $chapter;
        $this->questions = $question;
        $this->topics = $topic;
        $this->options = $option;
        $this->class_subjects = $class_subject;
        $this->class_questions = $class_question;
    }

    public function index(){
        $classes = $this->classes->get();
        $subjects = $this->subjects->get();
        return view('questions.index',compact('classes','subjects'));
    }

    public function getSubject($class_id){
        $class_subjects = $this->class_subjects->with('subject')->where('class_id',$class_id)->get();
        //$subjects = [];

        //$subjects = $class_subjects->subject->title;
        return response()->json($class_subjects);
    }

    public function manage(Request $request){
        $class = $request->class;
        $subject = $request->subject;
        $subject_info = $this->subjects->find($subject);
        //echo $class.$subject;
        $questions = $this->class_questions->where('class_id',$class)->where('subject_id',$subject)->get();
        return view('questions.manage', compact('questions', 'class','subject','subject_info' ));
    }

    public function create($class, $subject){
        $chapters = $this->chapters->where('subject_id',$subject)->where('class_id',$class)->get();
        $topics = $this->topics->where('class_id',$class)->where('subject_id', $subject)->get();
       // return $chapters;
        return view('questions.form', compact('chapters', 'topics', 'class', 'subject'));
    }

    public function upload($class, $subject){
        $chapters = $this->chapters->where('class_id',$class)->where('subject_id',$subject)->get();
        $topics = $this->topics->where('subject_id', $subject)->get();
        return view('questions.upload-form', compact('chapters', 'topics'));
    }

    public function store(Request $request, $class, $subject){
        /*$question = $request->question;
        $chapter = $request->chapter;
        $question = $request->question;*/
        $options = $request->option;

        $question = $this->questions;
        $question->title = $request->question;
  /*      $question->topic_id = $request->topic;
        $question->class_id = $class;
        $question->subject_id = $subject;
        $question->chapter_id = $request->chapter;*/
        $question->save();

        $question_id = $question->id;
        ClassQuestion::create([
            'question_id'=>$question_id,
            'topic_id'=>$request->topic,
            'class_id'=>$class,
            'subject_id'=>$subject,
            'chapter_id'=>$request->chapter
        ]);

        //$length = count($options);
        foreach ($options as $option){
            $is_answer =0;
            if(substr($option,-1) ==="@"){
                $is_answer = 1;
            }
            $option_title = str_replace('@','',$option);
            Option::create([
                'title'=>$option_title,
                'question_id'=>$question_id,
                'is_answer'=> $is_answer,
            ]);
        }
        //$answers =  $request->answer;
        return redirect(route('questions.manage',['class'=>$class, 'subject'=>$subject]))->with('success',['Success'=>'Questions Added Successfully']);
    }

    public function save_upload(UploadQuestionRequest $request){
        $topic_id = $request->topic;
        $chapter_id = $request->chapter;
        $subject_id = $this->chapters->find($chapter_id)->subject_id;
        $class_id = $this->chapters->find($chapter_id)->class_id;

        //echo $class_id;
        $question_pic = $request->file('question_file');
        $question_pic_name = time().$question_pic->getClientOriginalName();
        $destination_path = "question_files";
        $question_pic->move($destination_path, $question_pic_name);
        $question_pic_path = $destination_path."/".$question_pic_name;
        //$question = $this->questions;
        $path = $question_pic_path;
        //$data = Excel::load($path)->get();
        $collection = (new FastExcel)->import($path);
        $length = count($collection);
        $options=[];
        for ($i=0; $i < $length; $i++){
            //$question->title = $collection[$i]['question'];


            $question = Question::create([
                'title'=>$collection[$i]['Question'],
            ]);

            $question_positions = [
                $collection[$i]['1'],
                $collection[$i]['2'],
                $collection[$i]['3'],
                $collection[$i]['4'],
                $collection[$i]['5'],
                $collection[$i]['6'],
                $collection[$i]['7'],
                $collection[$i]['8'],
                $collection[$i]['9'],
                $collection[$i]['10'],
                $collection[$i]['11'],
                $collection[$i]['12'],
                ];
            foreach ($question_positions as $key=>$question_position){
                if($question_position !== ""){
                    $class = 0;

                    $position = explode('-',$question_position);
                   // return $class_id;
                    $subject = $this->subjects->where('short_code',$position[0])->get('id')->first();
                    $chapter = $this->chapters->where('serial_no',$position[1])->get('id')->first();
                    $topic = $this->topics->where('serial_no',$position[2])->get('id')->first();
                    $class = $key + 1;
                   // return gettype( $class);
                    ClassQuestion::create([
                        'question_id'=>$question->id,
                        'class_id'=>$class,
                        'subject_id'=>$subject->id,
                        'chapter_id'=>$chapter->id,
                        'topic_id'=>$topic->id,
                    ]);
                }
            }

            /*ClassQuestion::create([
                'question_id'=>$question->id,
                'topic_id'=>$topic_id,
                'class_id'=>$class_id,
                'subject_id'=>$subject_id,
                'chapter_id'=>$chapter_id
            ]);*/

           // echo $question->id;

            $options = [
                $collection[$i]['Option_1'],
                $collection[$i]['Option_2'],
                $collection[$i]['Option_3'],
                $collection[$i]['Option_4'],
                $collection[$i]['Option_5'],
                $collection[$i]['Option_6'],
            ];

            for ($option_item = 0;$option_item < count($options); $option_item++){
                 $is_answer =0;
                 $option_title = "";
                 if(substr($options[$option_item],-1) ==="@"){
                    $is_answer = 1;
                 }

                if($options[$option_item] !==""){
                    $option_title = str_replace('@','',$options[$option_item]);
                    Option::create([
                        'title'=>$option_title,
                        'question_id'=>$question->id,
                        'is_answer'=> $is_answer,
                    ]);
                }


            }
        }

        return redirect(route('questions.manage',['class'=>$class_id, 'subject'=>$subject_id]))->with('success',['Success'=>'Questions Added Successfully']);

    }




    public function details($id){
        $question = $this->questions->find($id);
        $options = $this->options->where('question_id', $id)->get();
        return view('questions.details', compact('question','options'));
    }

    public function question_manage($id){
        $questions = $this->class_questions->where('question_id',$id)->get();
        $classes = $this->classes->get();
        return view('questions.question-manage', compact('questions','classes','id'));
    }

    public function add_question_to_class(Request $request,$id){
        //return $id;
        $question = $this->class_questions;
        $question->question_id = $id;
        $question->class_id = $request->class;
        $question->subject_id = $request->subject;
        $question->chapter_id = $request->chapter;
        $question->topic_id = $request->topic;
        $question->save();
        return redirect(route('questions.question-manage', [$id]))->with('success',['Success'=>'Question added to new Field']);

    }

    public function destroy(Request $request){
        $question_id = $request->question_id;
        $question = $this->class_questions->find($question_id);
        $class_id = $question->class_id;
        $subject_id = $question->subject_id;
        $question->delete();
        return redirect(route('questions.manage',['class'=>$class_id, 'subject'=>$subject_id]))->with('success',['Success'=>'Question Deleted Successfully']);
    }
}
