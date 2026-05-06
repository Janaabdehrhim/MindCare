<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeOption extends Model
{
    protected $fillable = ['option_text', 'score', 'intake_question_id'];

    public function question()
    {
        return $this->belongsTo(IntakeQuestion::class, 'intake_question_id');
    }
}
