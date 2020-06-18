<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    public function question(){
        return $this->hasMany(QuestionBankQuestion::class);
    }
}
