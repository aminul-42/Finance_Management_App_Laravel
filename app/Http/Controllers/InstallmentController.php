<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Installment;
use Carbon\Carbon;

class InstallmentController extends Controller
{

    public function index()
    {
        $installments = Auth::user()->installments()->orderBy('payment_date', 'desc')->get();
        return view('user.installments.index', compact('installments'));
    }

    public function create()
    {
        return view('user.installments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'payment_year' => 'required|integer|min:2000|max:2100',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        try {
            Auth::user()->installments()->create([
                'amount' => $request->amount,
                'payment_month' => $request->payment_month,
                'payment_year' => $request->payment_year,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'status' => 'pending',
            ]);

            return redirect()->route('user.installments.index')->with('success', 'Contribution submitted successfully.');
        } catch (\Exception $e) {
            \Log::error('Installment Store Error: ' . $e->getMessage());
            return redirect()->route('user.installments.index')->with('error', 'Failed to submit contribution.');
        }
    }

    public function showUpdateForm(Installment $installment)
    {
        if ($installment->user_id !== Auth::id()) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized access.');
        }
        return view('user.installments.update', compact('installment'));
    }

    public function update(Request $request, Installment $installment)
    {
        if ($installment->user_id !== Auth::id()) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'payment_year' => 'required|integer|min:2000|max:2100',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        try {
            $installment->update([
                'amount' => $request->amount,
                'payment_month' => $request->payment_month,
                'payment_year' => $request->payment_year,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'status' => 'pending', // Reset to pending
            ]);

            return redirect()->route('user.installments.index')->with('success', 'Contribution updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Installment Update Error: ' . $e->getMessage());
            return redirect()->route('user.installments.index')->with('error', 'Failed to update contribution.');
        }
    }
}