<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionBank;
use App\Models\ClassList;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\ClassSubject;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuestionBankQuestion;
use App\Http\Requests\StoreQuestionBankRequest;
use App\Http\Requests\StoreQuestionBankQuestionRequest;

class QuestionBankController extends Controller
{
    protected $question_banks;
    protected $classes;
    protected $subjects;
    protected $class_subjects;
    protected $chapters;
    protected $topics;
    protected $questions;
    protected $question_bank_questions;

    public function __construct(QuestionBank $question_bank, ClassList $class, Subject $subject,
                                ClassSubject $class_subject, Chapter $chapter, Topic $topic,
                                Question $question,QuestionBankQuestion $question_bank_question){
        $this->middleware('auth');
        $this->question_banks = $question_bank;
        $this->classes = $class;
        $this->subjects = $subject;
        $this->class_subjects = $class_subject;
        $this->chapters = $chapter;
        $this->topics = $topic;
        $this->questions = $question;
        $this->question_bank_questions = $question_bank_question;
    }

    public function index(){
        $question_banks = $this->question_banks->get();
        return view('question-banks.index', compact('question_banks'));
    }

    public function create(){
        $question_banks = $this->question_banks->get();
        if (!$this->question_banks->all()->isEmpty()) {
            $next_id = ($this->question_banks->orderBy('id', 'desc')->first()->id) + 1;
        }else{
            $next_id = 1;
        }
        $classes = $this->classes->get();
        $question_bank_id = "BANK ".$next_id;
        return view('question-banks.form', compact('question_bank_id','classes'));
    }

    public function store(StoreQuestionBankRequest $request){
        $question_bank = $this->question_banks;
        $question_bank->class_id = $request->class;
        $question_bank->title = $request->title;
        $question_bank->number_of_question = $request->number_of_question;
        $question_bank->duration = $request->duration;
        $question_bank->save();
        return redirect(route('questions-banks.index'))->with('success',['Success'=>'New Question Bank Saved Successfully']);
    }

    public function manage($id){
        $question_bank = $this->question_banks->find($id);
        $class_subjects = $this->class_subjects->where('class_id',$question_bank->class_id)->get();
       // $question_bank_questions = $this->question_bank_questions->where('question_bank_id', $id)->get();
        //$question_bank_questions = $this->question_bank_questions->where('question_bank_id', $id)->get();
        return view('question-banks.manage', compact('question_bank', 'class_subjects','question_bank_questions'));
    }

    public function getChapter($subject_id){
        $chapters = $this->chapters->where('subject_id',$subject_id)->get();
        return response()->json($chapters);
       // return $chapters;
    }

    public function getTopic($chapter_id){
        $topic = $this->topics->where('chapter_id',$chapter_id)->get();
        return response()->json($topic);
        // return $chapters;
    }

    public function countQuestion($topic_id){
        $number_of_question = $this->questions->where('topic_id',$topic_id)->get()->count();
        return response()->json($number_of_question);
        // return $chapters;
    }

    public function setQuestion(StoreQuestionBankQuestionRequest $request, $question_bank_id){
        $number_of_questions = $request->question;
        $subject_id = $request->subject;
        $chapter_id = $request->chapter;
        $topic_id = $request->topic;
        $question_bank =$this->question_banks->find($question_bank_id);
        $questions = $this->questions->where('subject_id',$subject_id)->where('chapter_id',$chapter_id)->where('topic_id',$topic_id)->pluck('id')->toArray() ;
        $question_bank_questions = $this->question_bank_questions->where('question_bank_id',$question_bank_id)->pluck('question_id')->toArray();
        if(($question_bank->number_of_question - count($question_bank_questions)) ===0){
            return redirect(route('questions-banks.manage',$question_bank_id))->with('error',['Error'=>'Question Bank Limit Exceed']);
        }

        $selected_questions = [];
        foreach ($questions as $question_id){
            if(!in_array($question_id,$question_bank_questions )){
               array_push($selected_questions, $question_id);
            }
        }
        /* if (!empty(array_intersect($question_bank_questions, $questions))){
            return redirect(route('questions-banks.manage',$question_bank_id))->with('success',['Success'=>'Topic Already Exists into  Question Bank']);
        }*/
        if (count($selected_questions) === 0){
            return redirect(route('questions-banks.manage',$question_bank_id))->with('error',['Error'=>'Questions of this topic Already Added to Question Bank']);
        }else{
            shuffle($selected_questions);
            $selected_questions =array_slice($selected_questions, 0,$number_of_questions);

            foreach ($selected_questions as $question){
                QuestionBankQuestion::create(['question_bank_id'=>$question_bank_id, 'question_id'=>$question]);
            }
            return redirect(route('questions-banks.manage',$question_bank_id))->with('success',['Success'=>'Questions Added to Question Bank']);
        }

    }

}
