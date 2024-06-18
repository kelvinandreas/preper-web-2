<?php

namespace App\Http\Controllers;

use App\Models\Mssubject;
use App\Models\TrmentoringSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->RoleId == 1) { // Mentee
            $previousSessions = TrmentoringSchedule::where('menteeUserId', $user->id)
                ->where('meetingTIme', '<', now())
                ->get();

            $upcomingSessions = TrmentoringSchedule::where('menteeUserId', $user->id)
                ->where('meetingTIme', '>=', now())
                ->get();

            return view('sessions.index', compact('previousSessions', 'upcomingSessions'));
        } else if ($user->RoleId == 2) { // Mentor
            $previousSessions = TrmentoringSchedule::where('mentorUserId', $user->id)
                ->where('meetingTIme', '<', now())
                ->get();

            $upcomingSessions = TrmentoringSchedule::where('mentorUserId', $user->id)
                ->where('meetingTIme', '>=', now())
                ->get();

            return view('sessions.index', compact('previousSessions', 'upcomingSessions'));
        }
    }
    public function request()
    {
        $subjects = Mssubject::all();
        return view('sessions.request', compact('subjects'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'specificTopic' => 'required|string|max:255',
            'batch' => 'required|string',
        ]);

        TrmentoringSchedule::create([
            'menteeUserId' => Auth::id(),
            'subjectId' => $request->subject,
            'specificTopic' => $request->specificTopic,
            'scheduleTime' => $this->getBatchTime($request->batch),
        ]);

        return redirect()->route('sessions.index')->with('status', 'Session requested successfully.');
    }

    private function getBatchTime($batch)
    {
        $batchTimes = [
            'Batch 1' => '07:20 - 09:00',
            'Batch 2' => '09:20 - 11:00',
            'Batch 3' => '11:20 - 13:00',
            'Batch 4' => '13:20 - 15:00',
            'Batch 5' => '15:20 - 17:00',
            'Batch 6' => '17:20 - 19:00',
        ];

        return $batchTimes[$batch] ?? null;
    }

    public function available()
    {
        $availableSessions = TrmentoringSchedule::whereNull('mentorUserId')->get();
        return view('sessions.available', compact('availableSessions'));
    }

    public function accept(TrmentoringSchedule $session)
    {
        $session->mentorUserId = Auth::id();
        $session->save();
        return redirect()->route('sessions.index')->with('status', 'Session accepted successfully.');
    }
}
