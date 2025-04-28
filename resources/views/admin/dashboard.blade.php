@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Admin Dashboard</h1>

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

        
 <!-- Financial Overview -->
 <div class="card mb-4 animate__animated animate__slideIn animate__delay-1s">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pie-chart-fill me-2"></i>Financial Overview</h5>
            </div>
            <div class="card-body">
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="financial-card">
                            <h6 class="text-muted">Total Organization Balance (Contributions + Profits)</h6>
                            <h4 class="text-primary fw-bold">{{ number_format($organizationBalance, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="financial-card">
                            <h6 class="text-muted">Total Contributions</h6>
                            <h4 class="text-success fw-bold">{{ number_format($totalContributions, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="financial-card">
                            <h6 class="text-muted">Total Profits</h6>
                            <h4 class="text-info fw-bold">{{ number_format($totalProfits, 2) }} BDT</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Contributions -->
        <div class="card animate__animated animate__slideInUp animate__delay-2s">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-hourglass-split me-2"></i>Pending Contributions</h5>
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
                @if ($pendingContributions->isEmpty())
                    <p class="text-muted text-center py-4">No pending contributions.</p>
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
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingContributions as $contribution)
                                    <tr>
                                        <td>{{ $contribution->user->name }}</td>
                                        <td>{{ number_format($contribution->amount, 2) }}</td>
                                        <td>{{ $contribution->payment_month }}</td>
                                        <td>{{ $contribution->payment_year }}</td>
                                        <td>{{ $contribution->payment_date ? $contribution->payment_date->format('M d, Y') : '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ ucfirst($contribution->status) }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.contributions.approve', $contribution) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success me-2">
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.contributions.reject', $contribution) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to reject this contribution?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-x-circle"></i> Reject
                                                </button>
                                            </form>
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











