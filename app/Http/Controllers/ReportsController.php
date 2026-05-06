<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
  
    public function index()
    {
        /** @var \App\Models\Therapist $therapist */
        $therapist = auth()->guard('therapist')->user();

        $reports = Report::query()->where('therapist_id', $therapist->id)
            ->with('patient')
            ->orderByDesc('created_at')
            ->get();

        return view('therapist.reports', compact('reports'));
    }



    public function store(Request $request)
    {
        /** @var \App\Models\Therapist $therapist */
        $therapist = auth()->guard('therapist')->user();

        $request->validate([
            'patient_id'                 => ['required', 'exists:patients,id'],
            'intake_form_id'             => ['required', 'exists:intake_forms,id'],
            'total_score'                => ['required', 'integer', 'min:0'],
            'condition_level'            => ['required', 'in:low,medium,high,severe'],
            'recommended_specialization' => ['nullable', 'string', 'max:255'],
            'notes'                      => ['nullable', 'string', 'max:5000'],
        ]);

        Report::create([
            'patient_id'                 => $request->patient_id,
            'therapist_id'               => $therapist->id,
            'intake_form_id'             => $request->intake_form_id,
            'total_score'                => $request->total_score,
            'condition_level'            => $request->condition_level,
            'recommended_specialization' => $request->recommended_specialization,
            'notes'                      => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Report created.');
    }



    public function show(Report $report)
    {
        /** @var \App\Models\Therapist $therapist */
        $therapist = auth()->guard('therapist')->user();

        if ($report->therapist_id !== $therapist->id) {
            abort(403);
        }

        $report->load(['patient', 'intakeForm']);

        return view('therapist.report-detail', compact('report'));
    }
}
