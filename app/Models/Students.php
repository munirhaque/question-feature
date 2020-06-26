<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'std_student_datas';

    public function exam(){
        return $this->hasMany(ExamResult::class);
    }
}
