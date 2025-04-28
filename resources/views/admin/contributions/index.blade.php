@extends('admin.layouts.app')

@section('title', 'contribution Index')

@section('content')

<div class="container">
        <h1 class="my-4 animate__animated animate__fadeIn">All Contributions</h1>

        <!-- Filter Form -->
        <div class="filter-form mb-4 animate__animated animate__fadeIn">
            <form action="{{ route('admin.contributions.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="month" class="form-label">Month</label>
                    <select name="month" id="month" class="form-control">
                        <option value="">All Months</option>
                        @foreach ($months as $m)
                            <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-control">
                        <option value="">All Years</option>
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>

        <div class="card animate__animated animate__slideInUp">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Contribution Records</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success animate__animated animate__bounceIn">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger animate__animated animate__shakeX">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($installments->isEmpty())
                    <p class="text-muted text-center py-4">No contributions recorded.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-light">
                                    <th>User</th>
                                    <th>Amount (BDT)</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Payment Date</th>
                                    <th>Method</th>
                                    <th>Transaction ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installments as $installment)
                                    <tr>
                                        <td>{{ $installment->user->name }}</td>
                                        <td>{{ number_format($installment->amount, 2) }}</td>
                                        <td>{{ $installment->payment_month }}</td>
                                        <td>{{ $installment->payment_year }}</td>
                                        <td>{{ $installment->payment_date ? $installment->payment_date->format('M d, Y') : '-' }}</td>
                                        <td>{{ $installment->payment_method ?? '-' }}</td>
                                        <td>{{ $installment->transaction_id ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $installment->status === 'approved' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($installment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($installment->status === 'pending')
                                                <form action="{{ route('admin.contributions.approve', $installment) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection












