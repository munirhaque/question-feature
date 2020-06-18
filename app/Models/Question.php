<?php

namespace App\Models;

use DemeterChain\C;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title','topic_id','class_id','subject_id','chapter_id'];

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
