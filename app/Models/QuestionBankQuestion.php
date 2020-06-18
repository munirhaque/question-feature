<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionBankQuestion extends Model
{
    protected $fillable = ['question_bank_id','question_id'];

    public function question_bank(){
        return $this->belongsTo(QuestionBank::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
