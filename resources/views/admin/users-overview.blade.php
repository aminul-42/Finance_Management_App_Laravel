@extends('admin.layouts.app')

@section('title', 'Users Overview')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Users Overview</h1>

        <!-- Add New User Card -->
        <div class="card shadow-lg border-0 mb-4 animate__animated animate__zoomIn">
            <div class="card-header bg-success text-white text-center py-3">
                <h5 class="mb-0">Add New User</h5>
            </div>
            <div class="card-body form-container">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control professional-input shadow-sm" id="name" name="name" required>
                            </div>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control professional-input shadow-sm" id="email" name="email" required>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control professional-input shadow-sm" id="password" name="password" required>
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success w-50 py-2 fw-bold shadow-sm create-btn" style="transition: transform 0.2s ease;">
                            <i class="bi bi-plus-circle me-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users List Card -->
        <div class="card shadow-lg border-0 animate__animated animate__zoomIn">
            <div class="card-header bg-primary text-white text-center py-3">
                <h5 class="mb-0">Registered Users</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">Name</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                    <td class="align-middle">{{ $user->id }}</td>
                                    <td class="align-middle">{{ $user->name }}</td>
                                    <td class="align-middle">{{ $user->email }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary shadow-sm me-2">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 animate__animated animate__zoomIn">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Are you sure you want to delete <strong id="deleteUserName"></strong>? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteForm" action="" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm confirm-delete-btn">
                                <i class="bi bi-trash me-2"></i>Delete
                            </button>
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
        .create-btn, .delete-btn, .confirm-delete-btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .create-btn:hover {
            background-color: #166534; /* Darker green */
            transform: scale(1.05);
        }
        .delete-btn, .confirm-delete-btn {
            background-color: #dc3545; /* Bootstrap danger color */
        }
        .delete-btn:hover, .confirm-delete-btn:hover {
            background-color: #c82333; /* Darker red */
            transform: scale(1.05);
        }
        .table thead th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa; /* Light gray on hover */
            transition: background-color 0.2s ease;
        }
        .modal-content {
            border-radius: 12px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Button hover effects
        const createButton = document.querySelector('.create-btn');
        createButton.addEventListener('mouseover', () => {
            createButton.style.transform = 'scale(1.05)';
        });
        createButton.addEventListener('mouseout', () => {
            createButton.style.transform = 'scale(1)';
        });

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('mouseover', () => {
                btn.style.transform = 'scale(1.05)';
            });
            btn.addEventListener('mouseout', () => {
                btn.style.transform = 'scale(1)';
            });

            // Populate modal with user data
            btn.addEventListener('click', () => {
                const userId = btn.getAttribute('data-user-id');
                const userName = btn.getAttribute('data-user-name');
                document.getElementById('deleteUserName').textContent = userName;
                // Use Laravel's route helper directly in JS
                const deleteUrl = '{{ route("admin.users.delete", ":id") }}'.replace(':id', userId);
                document.getElementById('deleteForm').action = deleteUrl;
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