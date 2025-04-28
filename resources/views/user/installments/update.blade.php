@extends('user.layouts.app')

@section('title', 'Update Contribution')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Update Contribution</h1>

        <div class="card shadow-lg border-0 animate__animated animate__zoomIn">
            <div class="card-header bg-primary text-white text-center py-4">
                <h4 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Manage Your Contribution</h4>
            </div>
            <div class="card-body form-container">
                @if ($errors->any())
                    <div class="alert alert-danger animate__animated animate__shakeX">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.installments.update', $installment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="amount" class="form-label fw-bold">Amount (BDT)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-currency-exchange"></i></span>
                                <input type="number" class="form-control professional-input shadow-sm" id="amount" name="amount"
                                       value="{{ old('amount', $installment->amount) }}" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_month" class="form-label fw-bold">Payment Month</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-month"></i></span>
                                <select class="form-control professional-input shadow-sm" id="payment_month" name="payment_month" required>
                                    <option value="" disabled {{ old('payment_month', $installment->payment_month) ? '' : 'selected' }}>Select Month</option>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}" {{ old('payment_month', $installment->payment_month) === $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_year" class="form-label fw-bold">Payment Year</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-year"></i></span>
                                <input type="number" class="form-control professional-input shadow-sm" id="payment_year" name="payment_year"
                                       value="{{ old('payment_year', $installment->payment_year) }}" min="2000" max="2100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_date" class="form-label fw-bold">Payment Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control professional-input shadow-sm" id="payment_date" name="payment_date"
                                       value="{{ old('payment_date', $installment->payment_date ? $installment->payment_date->format('Y-m-d') : '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label fw-bold">Payment Method</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                                <select class="form-control professional-input shadow-sm" id="payment_method" name="payment_method" required>
                                    <option value="" disabled {{ old('payment_method', $installment->payment_method) ? '' : 'selected' }}>Select Method</option>
                                    <option value="bKash" {{ old('payment_method', $installment->payment_method) === 'bKash' ? 'selected' : '' }}>bKash</option>
                                    <option value="Nagad" {{ old('payment_method', $installment->payment_method) === 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                    <option value="Bank Transfer" {{ old('payment_method', $installment->payment_method) === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="Cash" {{ old('payment_method', $installment->payment_method) === 'Cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="transaction_id" class="form-label fw-bold">Transaction ID (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-receipt"></i></span>
                                <input type="text" class="form-control professional-input shadow-sm" id="transaction_id" name="transaction_id"
                                       value="{{ old('transaction_id', $installment->transaction_id) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-success w-50 py-3 fw-bold shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>Update Contribution
                        </button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('user.installments.index') }}" class="btn btn-outline-primary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Back to Contributions
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .form-control:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 10px rgba(79, 70, 229, 0.3);
        }
    </style>
@endsection