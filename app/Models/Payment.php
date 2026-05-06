<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'therapist_id', 'patient_id', 'amount',
        'status', 'payment_method', 'session_id', 'transaction_id'
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
