<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserSettingsController extends Controller
{
    public function index()
    {
        if (auth()->user()->RoleId != '3') return redirect()->route('home');

        $mentors = User::where('RoleId', '2')
                       ->leftJoin('MsSubject', 'users.SubjectId', '=', 'MsSubject.SubjectId')
                       ->select('users.*', 'MsSubject.SubjectName')
                       ->get();
        $mentees = User::where('RoleId', '1')->get();

        return view('user-settings.index', compact('mentors', 'mentees'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'nullable|integer',
            'is_valid' => 'nullable|boolean',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($request->has('points')) {
            $user->UserPoint = $request->points;
        }
        if ($request->has('is_valid')) {
            $user->IsValid = $request->is_valid;
        }
        $user->save();

        return redirect()->route('user.settings')->with('status', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.settings')->with('status', 'User deleted successfully');
    }
}
