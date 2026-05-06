<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'therapist_id', 'session_id', 'patient_id',
        'user_type', 'message', 'is_read'
    ];

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function session()
    {
        return $this->belongsTo(PatientSession::class, 'session_id');
    }
}
