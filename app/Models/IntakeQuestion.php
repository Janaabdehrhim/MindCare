<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeQuestion extends Model
{
    protected $fillable = ['question_text', 'category', 'order'];

    public function options()
    {
        return $this->hasMany(IntakeOption::class);
    }

    public function answers()
    {
        return $this->hasMany(IntakeAnswer::class, 'intake_question_id');
    }
}
