<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function student(){
        return $this->belongsTo(Students::class);
    }
}
