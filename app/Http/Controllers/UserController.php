<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Installment;
use App\Models\Profit;
use Carbon\Carbon;

class UserController extends Controller
{
   

    public function dashboard()
    {
        $user = Auth::user();
        $installments = $user->installments()->orderBy('payment_date', 'desc')->get();
        $approvedContributions = Installment::where('status', 'approved')->sum('amount');
        $totalProfits = Profit::sum('amount');
        $organizationBalance = $approvedContributions + $totalProfits;
        $userContribution = $user->installments()->where('status', 'approved')->sum('amount');

        // Reminder: Check if user paid for current month
        $currentMonth = now()->format('F');
        $currentYear = now()->year;
        $hasPaidThisMonth = $user->installments()
            ->where('payment_month', $currentMonth)
            ->where('payment_year', $currentYear)
            ->exists();
        $showReminder = !$hasPaidThisMonth;

        return view('user.dashboard', compact('installments', 'organizationBalance', 'userContribution', 'totalProfits', 'showReminder'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully');
    }

    public function password()
    {
        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.password')->with('success', 'Password updated successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}