@extends('admin.layouts.app')

@section('title', 'profit index')

@section('content')
    <div class="container">
        <h1 class="my-4 animate__animated animate__fadeInDown">Profit Management</h1>

        <!-- Add Profit Form -->
        <div class="card mb-5 animate__animated animate__zoomIn">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Profit</h5>
            </div>
            <div class="card-body form-container">
                <form action="{{ route('admin.profits.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label for="amount" class="form-label fw-bold">Profit Amount (BDT)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="month" class="form-label fw-bold">Month</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-month"></i></span>
                                <select name="month" id="month" class="form-control" required>
                                    <option value="" disabled selected>Select Month</option>
                                    @foreach ($months as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label fw-bold">Year</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-year"></i></span>
                                <input type="number" class="form-control" id="year" name="year" min="2000" max="2100"
                                    value="{{ now()->year }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="business_name" class="form-label fw-bold">Business Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                <input type="text" class="form-control" id="business_name" name="business_name"
                                    placeholder="e.g., Tech Ventures">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary px-5"><i class="bi bi-plus-circle me-2"></i>Add
                            Profit</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Profit Records -->
        <div class="card animate__animated animate__slideInUp">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Profit Records</h5>
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
                @if ($profits->isEmpty())
                    <p class="text-muted text-center py-4 animate__animated animate__fadeIn">No profits recorded. Add one to get
                        started!</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-light">
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Business Name</th>
                                    <th>Amount (BDT)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profits as $profit)
                                    <tr>
                                        <td>{{ $profit->month }}</td>
                                        <td>{{ $profit->year }}</td>
                                        <td>{{ $profit->business_name ?? '-' }}</td>
                                        <td>{{ number_format($profit->amount, 2) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                                                data-bs-target="#updateProfitModal{{ $profit->id }}">
                                                <i class="bi bi-pencil"></i> Update
                                            </button>
                                            <form action="{{ route('admin.profits.delete', $profit) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this profit?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-profit-id="{{ $profit->id }}"
                                                    data-profit-name="{{ $profit->month }} {{ $profit->year }}"
                                                    data-bs-toggle="modal" data-bs-target="#deleteProfitModal">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Update Profit Modal -->
                                    <div class="modal fade" id="updateProfitModal{{ $profit->id }}" tabindex="-1"
                                        aria-labelledby="updateProfitModalLabel{{ $profit->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateProfitModalLabel{{ $profit->id }}">Update
                                                        Profit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.profits.update', $profit) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="amount_{{ $profit->id }}" class="form-label">Profit Amount
                                                                (BDT)</label>
                                                            <input type="number" class="form-control" id="amount_{{ $profit->id }}"
                                                                name="amount" value="{{ old('amount', $profit->amount) }}"
                                                                step="0.01" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="month_{{ $profit->id }}" class="form-label">Month</label>
                                                            <select name="month" id="month_{{ $profit->id }}" class="form-control"
                                                                required>
                                                                @foreach ($months as $m)
                                                                    <option value="{{ $m }}" {{ old('month', $profit->month) === $m ? 'selected' : '' }}>{{ $m }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="year_{{ $profit->id }}" class="form-label">Year</label>
                                                            <input type="number" class="form-control" id="year_{{ $profit->id }}"
                                                                name="year" value="{{ old('year', $profit->year) }}" min="2000"
                                                                max="2100" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="business_name_{{ $profit->id }}" class="form-label">Business
                                                                Name</label>
                                                            <input type="text" class="form-control"
                                                                id="business_name_{{ $profit->id }}" name="business_name"
                                                                value="{{ old('business_name', $profit->business_name) }}"
                                                                placeholder="e.g., Tech Ventures">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>



        <!-- Profit Delete Confirmation Modal -->
        <div class="modal fade" id="deleteProfitModal" tabindex="-1" aria-labelledby="deleteProfitModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteProfitModalLabel"><i
                                class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        Are you sure you want to delete profit record for <strong id="deleteProfitName"></strong>?
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form method="POST" id="deleteProfitForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger confirm-delete-btn">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @include('admin.partials.messages')
    </div>
@endsection


@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .create-btn,
        .delete-btn,
        .confirm-delete-btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .create-btn:hover {
            background-color: #166534;
            /* Darker green */
            transform: scale(1.05);
        }

        .delete-btn,
        .confirm-delete-btn {
            background-color: #dc3545;
            /* Bootstrap danger color */
        }

        .delete-btn:hover,
        .confirm-delete-btn:hover {
            background-color: #c82333;
            /* Darker red */
            transform: scale(1.05);
        }

        .table thead th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            /* Light gray on hover */
            transition: background-color 0.2s ease;
        }

        .modal-content {
            border-radius: 12px;
        }
    </style>
@endsection

@section('scripts')
<script>
        // Hover effects
        const createButton = document.querySelector('.create-btn');
        if (createButton) {
            createButton.addEventListener('mouseover', () => {
                createButton.style.transform = 'scale(1.05)';
            });
            createButton.addEventListener('mouseout', () => {
                createButton.style.transform = 'scale(1)';
            });
        }

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('mouseover', () => {
                btn.style.transform = 'scale(1.05)';
            });
            btn.addEventListener('mouseout', () => {
                btn.style.transform = 'scale(1)';
            });

            // Populate modal with profit data
            btn.addEventListener('click', () => {
                const profitId = btn.getAttribute('data-profit-id');
                const profitName = btn.getAttribute('data-profit-name');

                document.getElementById('deleteProfitName').textContent = profitName;

                const deleteUrl = '{{ route("admin.profits.delete", ":id") }}'.replace(':id', profitId);
                document.getElementById('deleteProfitForm').action = deleteUrl;
            });
        });

        const confirmDeleteButton = document.querySelector('.confirm-delete-btn');
        confirmDeleteButton.addEventListener('mouseover', () => {
            confirmDeleteButton.style.transform = 'scale(1.05)';
        });
        confirmDeleteButton.addEventListener('mouseout', () => {
            confirmDeleteButton.style.transform = 'scale(1)';
        });
    </script>
@endsection