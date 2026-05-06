<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    public function index()
    {
    
        if (auth()->guard('patient')->check()) {
            $userId   = auth()->guard('patient')->id();
            $userType = 'patient';
        } elseif (auth()->guard('therapist')->check()) {
            $userId   = auth()->guard('therapist')->id();
            $userType = 'therapist';
        } else {
            abort(403);
        }

        $notifications = Notification::query()->where('user_type', $userType)
            ->where(function ($q) use ($userId, $userType) {
                if ($userType === 'patient') {
                    $q->where('patient_id', $userId);
                } else {
                    $q->where('therapist_id', $userId);
                }
            })
            ->orderByDesc('created_at')
            ->get();

        return view('shared.notifications', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

   
    public function adminIndex()
    {
        $notifications = Notification::with(['patient', 'therapist'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.notifications', compact('notifications'));
    }
}
