<?php

namespace App\Http\Controllers;

use App\Models\PatientSession;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    /**
     * Therapist: list all sessions.
     */
    public function index()
    {
        /** @var \App\Models\Therapist $therapist */
        $therapist = auth()->guard('therapist')->user();

        $sessions = PatientSession::query()->where('therapist_id', $therapist->id)
            ->with('patient')
            ->orderByDesc('session_time')
            ->get();

        return view('therapist.sessions', compact('sessions'));
    }


    public function updateNotes(Request $request, PatientSession $session)
    {
        /** @var \App\Models\Therapist $therapist */
        $therapist = auth()->guard('therapist')->user();

        if ($session->therapist_id !== $therapist->id) {
            abort(403);
        }

        $request->validate([
            'notes' => ['required', 'string', 'max:5000'],
        ]);

        $session->update(['notes' => $request->notes]);

        return redirect()->back()->with('success', 'Notes updated.');
    }

 
    public function updateStatus(Request $request, PatientSession $session)
    {
        /** @var \App\Models\Therapist $therapist */
        $therapist = auth()->guard('therapist')->user();

        if ($session->therapist_id !== $therapist->id) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:pending,scheduled,completed,canceled,rescheduled'],
        ]);

        $session->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Session status updated.');
    }

  
    public function waitingRoom(PatientSession $session)
    {
        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        if ($session->patient_id !== $patient->id) {
            abort(403);
        }

        $session->load('therapist');

        return view('patient.waiting-room', compact('session'));
    }
}
