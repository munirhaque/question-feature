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

    public function __construct( ClassList $class, Subject $subject, Chapter $chapter,
                                 Question $question, Topic $topic, Option $option,
                                 ClassSubject $class_subject )
    {
        $this->middleware('auth');
        $this->classes = $class;
        $this->subjects = $subject;
        $this->chapters = $chapter;
        $this->questions = $question;
        $this->topics = $topic;
        $this->options = $option;
        $this->class_subjects = $class_subject;
    }

    public function index(){
        $classes = $this->classes->get();
        $subjects = $this->subjects->get();
        return view('questions.index',compact('classes','subjects'));
    }

    public function getSubject($class_id){
        $class_subjects = $this->class_subjects->where('class_id',$class_id)->get();
        $class_subjects = $class_subjects->subject;
        return response()->json($class_subjects);
    }

    public function manage(Request $request){
        $class = $request->class;
        $subject = $request->subject;
        $subject_info = $this->subjects->find($subject);
        //echo $class.$subject;
        $questions = $this->questions->where('subject_id',$subject)->where('class_id',$class)->get();
        return view('questions.questions-manage', compact('questions', 'class','subject','subject_info' ));
    }

    public function create($class, $subject){
        $chapters = $this->chapters->where('class_id',$class)->where('subject_id',$subject)->get();
        $topics = $this->topics->where('class_id',$class)->where('subject_id', $subject)->get();
        return view('questions.form', compact('chapters', 'topics', 'class', 'subject'));
    }

    public function upload($class, $subject){
        $chapters = $this->chapters->where('class_id',$class)->get();
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
        $question->topic_id = $request->topic;
        $question->class_id = $class;
        $question->subject_id = $subject;
        $question->chapter_id = $request->chapter;
        $question->save();

        $question_id = $question->id;
        //$length = count($options);
        foreach ($options as $option){
            $is_answer =0;
            if(substr($option,-8) ==="(answer)"){
                $is_answer = 1;
            }
            $option_title = str_replace('(answer)','',$option);
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
                'title'=>$collection[$i]['question'],
                'topic_id'=>$topic_id,
                'class_id'=>$class_id,
                'subject_id'=>$subject_id,
                'chapter_id'=>$chapter_id
            ]);

           // echo $question->id;

            $options = [
                $collection[$i]['option_1'],
                $collection[$i]['option_2'],
                $collection[$i]['option_3'],
                $collection[$i]['option_4'],
                $collection[$i]['option_5'],
                $collection[$i]['option_6'],
                $collection[$i]['option_7'],
                $collection[$i]['option_8'],
                $collection[$i]['option_9'],
                $collection[$i]['option_10'],
            ];

            for ($option_item = 0;$option_item < count($options); $option_item++){
                 $is_answer =0;
                 $option_title = "";
                 if(substr($options[$option_item],-8) ==="(answer)"){
                    $is_answer = 1;
                 }

                //$option_title = $options[$option_item];

                 //echo gettype($option_title)."<br/>";
                if($options[$option_item] !==""){
                    $option_title = str_replace('(answer)','',$options[$option_item]);
                    Option::create([
                        'title'=>$option_title,
                        'question_id'=>$question->id,
                        'is_answer'=> $is_answer,
                    ]);
                }

                 //$is_answer = 0;
            }
        }

        return redirect(route('questions.manage',['class'=>$class_id, 'subject'=>$subject_id]))->with('success',['Success'=>'Questions Added Successfully']);

    }




    public function details($id){
        $question = $this->questions->find($id);
        $options = $this->options->where('question_id', $id)->get();
        return view('questions.details', compact('question','options'));
    }

    public function destroy(Request $request){
        $question_id = $request->question_id;
        $question = $this->questions->find($question_id);
        $class_id = $question->class_id;
        $subject_id = $question->subject_id;
        $question->delete();
        return redirect(route('questions.manage',['class'=>$class_id, 'subject'=>$subject_id]))->with('success',['Success'=>'Question Deleted Successfully']);
    }
}
