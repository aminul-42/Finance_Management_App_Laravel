@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">User Dashboard</h1>

        <div class="user-info mb-4 animate__animated animate__slideInRight p-3 rounded-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('storage/default-avatar.png') }}"
                     alt="Profile Picture" class="user-avatar shadow-sm animate__animated animate__zoomIn">
                <div>
                    <span class="fw-bold fs-4">Welcome, {{ Auth::user()->name }}</span>
                    <p class="text-muted mb-0">Manage your contributions and profile.</p>
                </div>
                
            </div>
        </div>

        <!-- Reminder Alert -->
        @if ($showReminder)
            <div class="alert alert-warning mb-4 animate__animated animate__bounceIn animate__delay-2s">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bell-fill fs-4 me-3"></i>
                    <div>
                        <strong>Reminder:</strong> You haven’t submitted your contribution for {{ now()->format('F Y') }}. Please submit soon!
                        <a href="{{ route('user.installments.create') }}" class="btn btn-sm btn-primary ms-2">
                            <i class="bi bi-plus-circle"></i> Add Now
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Financial Overview -->
        <div class="card mb-4 animate__animated animate__slideIn animate__delay-1s">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart-fill me-2"></i>Financial Overview</h5>
            </div>
            <div class="card-body form-container">
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 shadow-sm">
                            <h6 class="text-muted">Total Organization Balance (Contributions + Profits)</h6>
                            <h4 class="text-primary fw-bold">{{ number_format($organizationBalance, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 shadow-sm">
                            <h6 class="text-muted">Your Contribution</h6>
                            <h4 class="text-success fw-bold">{{ number_format($userContribution, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 shadow-sm">
                            <h6 class="text-muted">Total Profits</h6>
                            <h4 class="text-info fw-bold">{{ number_format($totalProfits, 2) }} BDT</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contribution Report -->
        <div class="card animate__animated animate__slideIn animate__delay-3s">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Contribution Report</h5>
                <a href="{{ route('user.installments.index') }}" class="btn btn-sm btn-light"><i class="bi bi-list-ul"></i> View All Contributions</a>
            </div>
            <div class="card-body form-container">
                @if (empty($installments) || $installments->isEmpty())
                    <p class="text-muted text-center">No contributions recorded. Start by adding one!</p>
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
                                            <a href="{{ route('user.installments.edit', ['installment' => $installment->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i> Update
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
        .user-info {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.15), rgba(168, 85, 247, 0.15));
            transition: background 0.3s ease;
        }
        .dark-mode .user-info {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.3), rgba(168, 85, 247, 0.3));
        }
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
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
            $('.table').addClass('animate__animated animate__fadeIn animate__delay-4s');
        });
    </script>
@endsection