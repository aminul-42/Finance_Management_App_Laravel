<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Installment;

class AdminController extends Controller
{
    public function dashboard()
    {
        $approvedContributions = Installment::where('status', 'approved')->sum('amount');
        $totalProfits = Profit::sum('amount');
        $organizationBalance = $approvedContributions + $totalProfits;
        $totalContributions = Installment::where('status', 'approved')->sum('amount');
        $pendingContributions = Installment::with('user')->where('status', 'pending')->orderBy('payment_date', 'desc')->get();

        return view('admin.dashboard', compact(
            'organizationBalance',
            'totalContributions',
            'totalProfits',
            'pendingContributions'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
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

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
    }

    public function usersOverview()
    {
        $users = User::all();
        return view('admin.users-overview', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.overview')->with('success', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users.overview')->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.overview')->with('success', 'User deleted successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $secrets = config('secrets.admins');
        $email = $request->email;

        if (isset($secrets[$email]) && Hash::check($request->password, $secrets[$email]['password'])) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $secrets[$email]['name'],
                    'password' => $secrets[$email]['password'],
                    'is_admin' => true,
                ]
            );

            Auth::login($user);
            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function contributions(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $query = Installment::with('user')->orderBy('payment_date', 'desc');

        if ($month) {
            $query->where('payment_month', $month);
        }

        if ($year) {
            $query->where('payment_year', $year);
        }

        $installments = $query->get();
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $years = range(date('Y') - 5, date('Y') + 5);

        return view('admin.contributions.index', compact('installments', 'months', 'years', 'month', 'year'));
    }

    public function approveContribution(Request $request, Installment $installment)
    {
        try {
            $installment->update(['status' => 'approved']);
            return redirect()->route('admin.contributions.index')->with('success', 'Contribution approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Approve Contribution Error: ' . $e->getMessage());
            return redirect()->route('admin.contributions.index')->with('error', 'Failed to approve contribution.');
        }
    }
    public function rejectContribution(Request $request, Installment $installment)
    {
        try {
            $installment->update(['status' => 'rejected']);
            return redirect()->route('admin.dashboard')->with('success', 'Contribution rejected successfully.');
        } catch (\Exception $e) {
            \Log::error('Reject Contribution Error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Failed to reject contribution.');
        }
    }

    public function profits()
    {
        $profits = Profit::orderBy('year', 'desc')->orderBy('month')->get();
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        return view('admin.profits.index', compact('profits', 'months'));
    }

    public function storeProfit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'year' => 'required|integer|min:2000|max:2100',
            'business_name' => 'nullable|string|max:255',
        ]);

        try {
            Profit::create([
                'amount' => $request->amount,
                'month' => $request->month,
                'year' => $request->year,
                'business_name' => $request->business_name,
            ]);
            return redirect()->route('admin.profits.index')->with('success', 'Profit added successfully.');
        } catch (\Exception $e) {
            \Log::error('Profit Store Error: ' . $e->getMessage());
            return redirect()->route('admin.profits.index')->with('error', 'Failed to add profit.');
        }
    }

    public function updateProfit(Request $request, Profit $profit)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'year' => 'required|integer|min:2000|max:2100',
            'business_name' => 'nullable|string|max:255',
        ]);

        try {
            $profit->update([
                'amount' => $request->amount,
                'month' => $request->month,
                'year' => $request->year,
                'business_name' => $request->business_name,
            ]);
            return redirect()->route('admin.profits.index')->with('success', 'Profit updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Profit Update Error: ' . $e->getMessage());
            return redirect()->route('admin.profits.index')->with('error', 'Failed to update profit.');
        }
    }

    public function deleteProfit(Profit $profit)
    {
        try {
            $profit->delete();
            return redirect()->route('admin.profits.index')->with('success', 'Profit deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Profit Delete Error: ' . $e->getMessage());
            return redirect()->route('admin.profits.index')->with('error', 'Failed to delete profit.');
        }
    }

}