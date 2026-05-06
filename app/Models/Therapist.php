<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Therapist extends Authenticatable
{
    protected $table = 'therapists';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
        'specialization', 'language', 'rating', 'is_available',
        'wallet', 'session_fee', 'total_patients', 'total_sessions'
    ];

    protected $hidden = ['password'];

    public function sessions()
    {
        return $this->hasMany(PatientSession::class);
    }

    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
