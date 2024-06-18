<?php

namespace App\Http\Controllers;

use App\Models\Mssubject;
use App\Models\TrmentoringSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $validatedData = $request->validate([
            'batch' => 'required|string|in:Batch 1,Batch 2,Batch 3,Batch 4,Batch 5,Batch 6',
            'subject' => 'required|string|exists:mssubject,SubjectId',
            'specificTopic' => 'nullable|string|max:255',
        ]);

        $batchTimes = [
            'Batch 1' => '07:20',
            'Batch 2' => '09:20',
            'Batch 3' => '11:20',
            'Batch 4' => '13:20',
            'Batch 5' => '15:20',
            'Batch 6' => '17:20',
        ];

        $startTime = $batchTimes[$validatedData['batch']];
        $meetingTime = now()->format('Y-m-d') . ' ' . $startTime . ':00';

        // Verify that the authenticated user exists
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        // dd($user->id);

        TrMentoringSchedule::create([
            'TrMentoringScheduleId' => (string) Str::uuid(),
            'IsDone' => false,
            'MeetingTime' => $meetingTime,
            'MeetingLink' => $this->generateMeetingLink(),
            'MenteeUserId' => $user->id,
            'MentorUserId' => null,
            'UniqueCode' => $this->getUniqueCode(),
            'SubjectId' => $validatedData['subject'],
            'SpecificTopic' => $validatedData['specificTopic'] ?? '',
        ]);

        return redirect()->route('sessions.index')->with('status', 'Session requested successfully.');
    }

    private function generateMeetingLink()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $linkLength = 10;
        $googleMeetLink = 'https://meet.google.com/';

        for ($i = 0; $i < $linkLength; $i++) {
            $randomIndex = random_int(0, strlen($characters) - 1);
            $googleMeetLink .= $characters[$randomIndex];
        }

        return $googleMeetLink;
    }

    private function getUniqueCode()
    {
        return strtoupper(Str::random(10));
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
