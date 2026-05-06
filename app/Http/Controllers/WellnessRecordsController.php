<?php

namespace App\Http\Controllers;

use App\Models\WellnessRecord;
use Illuminate\Http\Request;

class WellnessRecordsController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        $records = WellnessRecord::query()->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->get();

        return view('patient.wellness', compact('records'));
    }

    public function storeMood(Request $request)
    {
        $request->validate([
            'mood_score' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        WellnessRecord::query()->create([
            'patient_id' => $patient->id,
            'mood_score' => $request->mood_score,
            'visibility' => $request->visibility ?? 'private',
        ]);

        return redirect()->back()->with('success', 'Mood logged successfully.');
    }

    public function storeJournal(Request $request)
    {
        $request->validate([
            'journal_entry' => ['required', 'string', 'max:5000'],
            'sleep_quality' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'visibility'    => ['nullable', 'in:private,therapist_only,public'],
        ]);

        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        WellnessRecord::query()->create([
            'patient_id'    => $patient->id,
            'journal_entry' => $request->journal_entry,
            'sleep_quality' => $request->sleep_quality,
            'visibility'    => $request->visibility ?? 'private',
        ]);

        return redirect()->back()->with('success', 'Journal entry saved.');
    }
}
