<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function exam_category(){
        return $this->belongsTo(ExamCategory::class);
    }

    public function question(){
        return $this->hasMany(ExamQuestion::class);
    }

    public function result(){
        return $this->hasMany(ExamResult::class);
    }
}
