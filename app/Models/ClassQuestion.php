<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassQuestion extends Model
{
    protected $fillable = ['question_id','topic_id','class_id','subject_id','chapter_id'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function class(){
        return $this->belongsTo(ClassList::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }
}
