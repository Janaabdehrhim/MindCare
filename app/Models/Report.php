<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'patient_id', 'therapist_id', 'intake_form_id',
        'total_score', 'condition_level',
        'recommended_specialization', 'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }

    public function intakeForm()
    {
        return $this->belongsTo(IntakeForm::class);
    }
}
