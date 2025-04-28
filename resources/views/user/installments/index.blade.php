@extends('user.layouts.app')

@section('title', 'Contributions')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Your Contributions</h1>

        <div class="card shadow-lg border-0 animate__animated animate__slideIn animate__delay-1s">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-4">
                <h4 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Contribution List</h4>
                <div>
                    <a href="{{ route('user.installments.create') }}" class="btn btn-success btn-sm me-2">
                        <i class="bi bi-plus-circle me-1"></i> Add Contribution
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
            <div class="card-body form-container">
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
                    <p class="text-muted text-center py-4">No contributions recorded. Click "Add Contribution" to start!</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-light">
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
                                            <a href="{{ route('user.installments.edit', ['installment' => $installment->id]) }}" class="btn btn-sm btn-primary shadow-sm">
                                                <i class="bi bi-pencil me-1"></i> Update
                                            </a>
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

@section('styles')
    <style>
        .table th, .table td {
            vertical-align: middle;
            padding: 12px;
        }
        .table-hover tbody tr:hover {
            background: #f1f5f9;
        }
        .dark-mode .table-hover tbody tr:hover {
            background: #4b5563;
        }
        .badge {
            font-size: 0.9rem;
            padding: 6px 12px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.table').addClass('animate__animated animate__fadeIn animate__delay-2s');
        });
    </script>
@endsection