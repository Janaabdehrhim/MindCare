<?php

namespace App\Http\Controllers;

use App\Services\IntakeService;
use Illuminate\Http\Request;

class IntakeAnswerController extends Controller
{
    public function __construct(private IntakeService $intakeService) {}

    /**
     * Store intake answers and generate the report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'answers'                    => ['required', 'array'],
            'answers.*.question_id'      => ['required', 'exists:intake_questions,id'],
            'answers.*.option_id'        => ['required', 'exists:intake_options,id'],
        ]);

        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        // Prevent re-submission
        if ($patient->intakeForm) {
            return redirect()->route('patient.matching')
                ->with('info', 'Intake already submitted.');
        }

        $result = $this->intakeService->submit($patient->id, $request->answers);

        return redirect()->route('patient.matching')
            ->with('success', 'Intake form submitted. Recommended: ' . ($result['recommended'][0] ?? 'General Therapy'));
    }
}
