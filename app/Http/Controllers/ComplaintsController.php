<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        $complaints = Complaint::query()->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->get();

        return view('patient.complaints', compact('complaints'));
    }

    // Patient: submit a complaint
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:2000'],
        ]);

        /** @var \App\Models\Patient $patient */
        $patient = auth()->guard('patient')->user();

        Complaint::create([
            'patient_id'  => $patient->id,
            'description' => $request->description,
            'status'      => 'open',
        ]);

        // ✅ أضف الـ redirect بعد الحفظ
        return redirect()->route('patient.complaints.index')
                        ->with('success', 'تم إرسال الشكوى بنجاح');
    }

    // Admin: list all complaints
    public function adminIndex()
    {
        $complaints = Complaint::with('patient')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.complaints', compact('complaints'));
    }

    // Admin: update complaint status
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved'],
        ]);

        $complaint->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Complaint status updated.');
    }
}
