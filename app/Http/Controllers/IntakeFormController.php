<?php

namespace App\Http\Controllers;

use App\Models\IntakeQuestion;
use Illuminate\Http\Request;

class IntakeFormController extends Controller
{
    /**
     * Show the intake form with all questions and options.
     */
    public function show()
    {
        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        // If already submitted, redirect to matching
        if ($patient->intakeForm) {
            return redirect()->route('patient.matching')
                ->with('info', 'You have already completed the intake form.');
        }

        $questions = IntakeQuestion::with('options')
            ->orderBy('order')
            ->get();

        return view('patient.intake', compact('questions'));
    }
}
