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

        if ($user->RoleId == 1 || $user->RoleId == 3) { // Mentee
            $previousSessions = TrmentoringSchedule::where('MenteeUserId', $user->id)
                ->where('MeetingTime', '<', now())
                ->with('mentor')
                ->orderBy('MeetingTime', 'desc')
                ->get();

            $upcomingSessions = TrmentoringSchedule::where('MenteeUserId', $user->id)
                ->where('MeetingTime', '>=', now())
                ->with('mentor')
                ->orderBy('MeetingTime', 'asc')
                ->get();

            return view('sessions.index', compact('previousSessions', 'upcomingSessions'));
        } else if ($user->RoleId == 2 || $user->RoleId == 3) { // Mentor
            $previousSessions = TrmentoringSchedule::where('MentorUserId', $user->id)
                ->where('MeetingTime', '<', now())
                ->with('mentee')
                ->orderBy('MeetingTime', 'desc')
                ->get();

            $upcomingSessions = TrmentoringSchedule::where('MentorUserId', $user->id)
                ->where('MeetingTime', '>=', now())
                ->with('mentee')
                ->orderBy('MeetingTime', 'asc')
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
        $meetingTime = now()->addDay()->format('Y-m-d') . ' ' . $startTime . ':00';

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }

        // Get the full UUID
        $userId = $user->id;
        // dd($userId);

        TrMentoringSchedule::create([
            'TrMentoringScheduleId' => (string) Str::uuid(),
            'IsDone' => false,
            'MeetingTime' => $meetingTime,
            'MenteeUserId' => $userId,
            'MentorUserId' => null,
            'MeetingLink' => null,
            'UniqueCode' => $this->getUniqueCode(),
            'SubjectId' => $validatedData['subject'],
            'SpecificTopic' => $validatedData['specificTopic'] ?? '',
        ]);

        return redirect()->route('sessions.index')->with('status', 'Session requested successfully.');
    }

    public function generateMeetingLink()
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
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $uniqueCode = '';

        for ($i = 0; $i < 4; $i++) {
            $uniqueCode .= $characters[rand(0, $charactersLength - 1)];
        }

        return $uniqueCode;
    }

    public function available()
    {
        $availableSessions = TrmentoringSchedule::whereNull('MentorUserId')
            ->with('mentee')
            ->orderBy('MeetingTime', 'asc')
            ->get();

        return view('sessions.available', compact('availableSessions'));
    }

    public function accept(TrmentoringSchedule $session)
    {
        $session->mentorUserId = Auth::id();
        $session->meetingLink =  $this->generateMeetingLink();
        $session->save();
        return redirect()->route('sessions.index')->with('status', 'Session accepted successfully.');
    }

    public function storeReview(Request $request, TrmentoringSchedule $session)
    {
        $validatedData = $request->validate([
            'MenteeReview' => 'required|string|max:1000',
        ]);

        $session->MenteeReview = $validatedData['MenteeReview'];
        $session->save();

        return redirect()->route('sessions.index')->with('status', 'Review submitted successfully.');
    }
}
