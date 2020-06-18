<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['title', 'question_id','is_answer'];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
