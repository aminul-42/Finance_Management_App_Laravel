@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Edit User</h1>

        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-info text-white text-center py-3">
                <h5 class="mb-0">Update User Details</h5>
            </div>
            <div class="card-body form-container">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PATCH')
                    <div class="row g-4">
                        <!-- Name Field -->
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control professional-input shadow-sm" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="col-md-12">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control professional-input shadow-sm" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success w-50 py-2 fw-bold shadow-sm update-btn" style="transition: transform 0.2s ease;">
                            <i class="bi bi-save me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @include('admin.partials.messages')
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .update-btn {
            background-color: #28a745; /* Bootstrap success color */
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .update-btn:hover {
            background-color: #218838; /* Darker green on hover */
            transform: scale(1.05);
        }
        .update-btn:active {
            transform: scale(0.95);
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Button hover effect
        const updateButton = document.querySelector('.update-btn');
        updateButton.addEventListener('mouseover', () => {
            updateButton.style.transform = 'scale(1.05)';
        });
        updateButton.addEventListener('mouseout', () => {
            updateButton.style.transform = 'scale(1)';
        });
    </script>
@endsection