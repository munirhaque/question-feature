<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamQuestionRequest;
use App\Models\QuestionBankQuestion;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExamRequest;
use App\Models\ExamCategory;
use App\Models\Exam;
use App\Models\ClassList;
use App\Models\ClassQuestion;
use App\Models\ExamStudent;
use App\Models\ExamQuestion;
use App\Models\Option;
use App\Models\ExamResult;
use App\Models\Students;
use Illuminate\Support\Facades\Auth;


class ExamsController extends Controller
{
    protected $exam_categories;
    protected $exams;
    protected $classes;
    protected $exam_questions;
    protected $class_questions;
    protected $options;
    protected $exam_results;
    protected $students;
    protected $exam_students;

    public function __construct(ExamCategory $exam_category, Exam $exam, ClassList $class,
                                ExamQuestion $exam_question, ClassQuestion $class_question,
                                Option $option, ExamResult $exam_result, Students $student,
                                ExamStudent $exam_student)
    {
        $this->middleware('auth');
        $this->exam_categories = $exam_category;
        $this->exams = $exam;
        $this->classes = $class;
        $this->exam_questions = $exam_question;
        $this->class_questions = $class_question;
        $this->options = $option;
        $this->exam_results = $exam_result;
        $this->students = $student;
        $this->exam_students = $exam_student;
    }

    public function index(){
        $exams = $this->exams->get();
        return view('exams.index', compact('exams'));
    }

    public function create(){
        $categories = $this->exam_categories->get();
        $exam = $this->exams;
        return view('exams.form', compact('categories','exam'));
    }

    public function store(StoreExamRequest $request){
        $exam = $this->exams;
        $exam->exam_name = $request->exam_name;
        $exam->starts = $request->start_date . " " . $request->start_time;
        $exam->ends = $request->end_date . " " . $request->end_time;
        $exam->exam_category_id = $request->category;
        $exam->duration = $request->duration;
        $exam->number_of_question = $request->number_of_question;
        $exam->save();
        return redirect(route('exams.index'))->with('success',['Success'=>'New Exam Saved Successfully']);
    }

    public function edit($id){
        $exam = $this->exams->find($id);
        $categories = $this->exam_categories->get();
        return view('exams.form', compact('categories','exam'));
    }

    public function update(StoreExamRequest $request, $id){
        $exam = $this->exams->find($id);
        $exam->exam_name = $request->exam_name;
        $exam->starts = $request->start_date . " " . $request->start_time;
        $exam->ends = $request->end_date . " " . $request->end_time;
        $exam->exam_category_id = $request->category;
        $exam->duration = $request->duration;
        $exam->number_of_question = $request->number_of_question;
        $exam->save();
        return redirect(route('exams.index'))->with('success',['Success'=>'Exam Modified Successfully']);
    }

    public function destroy(Request $request){
        $exam_id = $request->exam_id;
        $exam = $this->exams->find($exam_id);
        $exam->delete();
        return redirect(route('exams.index'))->with('success',['Success'=>'Exam Removed Successfully']);
    }

    public function manage($id){
        $exam = $this->exams->find($id);
        $classes = $this->classes->get();
        return view('exams.set-question', compact('exam','classes'));
    }

    public function setQuestion(StoreExamQuestionRequest $request, $exam_id){
        $questions = [];
        $number_of_questions = $request->question;
        $subject_id = $request->subject;
        $chapter_id = $request->chapter;
        $topic_id = $request->topic;
        $answer_type = $request->answer_type;
        $exam =$this->exams->find($exam_id);
        //return $answer_type;
        if($answer_type === "any"){
            $questions = $this->class_questions->where('topic_id',$topic_id)->pluck('question_id')->toArray();
            //return $questions;
        }elseif ($answer_type === "has_no_answer"){
            //$count_answer = [];
            $allquestions = $this->class_questions->where('topic_id',$topic_id)->get();
            foreach ($allquestions as $question){
                $count_answer = $this->options->where('question_id',$question->question_id)->where('is_answer',1)->get()->count();
                if ($count_answer == 0){
                    array_push($questions,$question->question_id );
                }
            }
            //return $questions;
        }elseif ($answer_type === "has_one_answer"){
            $allquestions = $this->class_questions->where('topic_id',$topic_id)->get();
            foreach ($allquestions as $question){
                $count_answer = $this->options->where('question_id',$question->question_id)->where('is_answer',1)->get()->count();
                if ($count_answer == 1){
                    array_push($questions,$question->question_id );
                }
            }
            //return $questions;
        }elseif ($answer_type === "has_multiple_answer"){
            $allquestions = $this->class_questions->where('topic_id',$topic_id)->get();
            foreach ($allquestions as $question){
                $count_answer = $this->options->where('question_id',$question->question_id)->where('is_answer',1)->get()->count();
                if ($count_answer > 1){
                    array_push($questions,$question->question_id );
                }
            }
            //return $questions;
        }


        $exam_questions = $this->exam_questions->where('exam_id',$exam_id)->pluck('question_id')->toArray();
        if(($exam->number_of_question - count($exam_questions)) ===0){
            return redirect(route('exams.manage',$exam_id))->with('error',['Error'=>'Exam Question Limit Exceed']);
        }

        $selected_questions = [];
        foreach ($questions as $question_id){
            if(!in_array($question_id,$exam_questions )){
                array_push($selected_questions, $question_id);
            }
        }
        /* if (!empty(array_intersect($question_bank_questions, $questions))){
            return redirect(route('questions-banks.manage',$question_bank_id))->with('success',['Success'=>'Topic Already Exists into  Question Bank']);
        }*/
        if (count($selected_questions) === 0){
            return redirect(route('exams.manage',$exam_id))->with('error',['Error'=>'Questions of this topic Already Added to Question Bank']);
        }else{
            shuffle($selected_questions);
            $selected_questions =array_slice($selected_questions, 0,$number_of_questions);

            foreach ($selected_questions as $question){
                ExamQuestion::create(['exam_id'=>$exam_id, 'question_id'=>$question]);
            }
            return redirect(route('exams.manage',$exam_id))->with('success',['Success'=>'Questions Added to Exam']);
        }

    }

    public function question_list($id){
        $questions_set_1 = $this->exam_questions->where('exam_id', $id)->get()->shuffle();
        $questions_set_2 = $this->exam_questions->where('exam_id', $id)->get()->shuffle();
        $questions_set_3 = $this->exam_questions->where('exam_id', $id)->get()->shuffle();
        $questions_set_4 = $this->exam_questions->where('exam_id', $id)->get()->shuffle();

        return view('exams.question-list',compact('questions_set_1','questions_set_2','questions_set_3','questions_set_4'));

    }

    public function take_exam(){
        $student = $this->students->where('user_id',Auth::user()->id)->get()->first();
        //return $student->id;
        $exams = $this->exam_students->where('student_id',$student->id)->get();
        return view('student-exams.index', compact('exams','student'));
    }

    public function exam_question($id){
        $questions = $this->exam_questions->where('exam_id', $id)->get();
        $exam = $this->exams->find($id);
        $exam_duration = $this->exams->find($id)->pluck('duration');
        return view('student-exams.questions',compact('questions', 'exam','exam_duration'));
    }

    public function exam_submit(Request $request,$id){
        $exam_mark = 0;
        //$exam_id = $id;
        //$submited_answers = array_merge_recursive($request->answer);
        $questions = $this->exam_questions->where('exam_id', $id)->get();
        /*if (!isset($request->qqq)){
            return 'No';
        }*/
        foreach ($questions as $question){
            $key = 'question_'.$question->question_id;
            $correct_answer = $this->options->where('question_id',$question->question_id)->where('is_answer',1)->pluck('id')->toArray();
            //echo count($correct_answer);
            if (count($correct_answer) == 0 && !isset($request->$key)){
               // echo $key.':Correct';
                $exam_mark = $exam_mark + 1;
            }elseif(isset($request->$key)){
                if ($correct_answer == $request->$key){
                    $exam_mark = $exam_mark + 1;
                   // echo $key."Correct";
                }
            }


        }
        //return $request;
        // return gettype($request);

       /* $questions = $this->exam_questions->where('exam_id', $id)->get();
        $answers = $request->answer;
        $correct_option = [];
        $exam_mark = 0;
        foreach ($answers as $answer){
            $ans = explode(':',$answer);
            $question_id = $ans[0];
            $given_answer = $ans[1];
            $correct_option_id = $this->options->where('question_id',$question_id)->where('is_answer',1)->pluck('id')[0];
            if ($given_answer == $correct_option_id){
                //echo "Answer: Correct";
                $exam_mark = $exam_mark + 1;
            }
        }*/
        $exam_result = $this->exam_results;
        $exam_result->exam_id = $id;
        $exam_result->student_id = Auth::user()->id;
        $exam_result->mark = $exam_mark;
        $exam_result->save();

        return redirect(route('student-exams.index'))->with('success',['Success'=>'You successfully Complete Exam']);
    }

    public function exam_result($id){
        $exameens = $this->exam_results->where('exam_id', $id)->get();
        return view('exams.view-result', compact('exameens'));
    }
}
