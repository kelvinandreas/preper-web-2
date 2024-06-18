<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Mssubject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'subjects' => Mssubject::all()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Only update email if it's different
        if ($request->email != $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        // Only update phone number if it's different
        if ($request->whatsapp != $user->UserPhoneNumber) {
            $user->UserPhoneNumber = $request->whatsapp;
        }

        $user->UserName = $request->UserName;
        $user->RoleId = $request->input('role') == 'mentee' ? 1 : 2; // Assuming 2 is mentor and 1 is mentee

        if ($request->input('role') == 'mentor') {
            $user->SubjectId = $request->input('subject');
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
