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
use App\Models\ClassSubject;
use App\Models\ExamQuestion;

class ExamsController extends Controller
{
    protected $exam_categories;
    protected $exams;
    protected $classes;
    protected $exam_questions;
    protected $class_questions;

    public function __construct(ExamCategory $exam_category, Exam $exam, ClassList $class,
                                ExamQuestion $exam_question, ClassQuestion $class_question)
    {
        $this->middleware('auth');
        $this->exam_categories = $exam_category;
        $this->exams = $exam;
        $this->classes = $class;
        $this->exam_questions = $exam_question;
        $this->class_questions = $class_question;
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
       // $class_subjects = $this->class_subjects->where('class_id',$question_bank->class_id)->get();
        // $question_bank_questions = $this->question_bank_questions->where('question_bank_id', $id)->get();
        //$question_bank_questions = $this->question_bank_questions->where('question_bank_id', $id)->get();
        $classes = $this->classes->get();
        return view('exams.manage', compact('exam','classes'));
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
        $questions = $this->exam_questions->where('exam_id', $id)->get();
        return view('exams.question-list',compact('questions'));

    }

}
