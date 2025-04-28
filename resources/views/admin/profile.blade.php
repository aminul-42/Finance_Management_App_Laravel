@extends('admin.layouts.app')

@section('title', 'Profile Settings')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Profile Settings</h1>

        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header bg-primary text-white text-center py-3">
                <h5 class="mb-0">Manage Your Profile</h5>
            </div>
            <div class="card-body form-container">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    <div class="row g-4">
                        <!-- Profile Picture Section -->
                        <div class="col-md-12 text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <div class="profile-img-container">
                                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('storage/default-avatar.png') }}"
                                         alt="Profile Picture" class="profile-img mb-3 shadow-sm"
                                         id="profilePreview" style="transition: opacity 0.3s ease;">
                                </div>
                                <div class="mt-2">
                                    <label for="profile_picture" class="btn btn-warning btn-sm px-3 py-2 fw-bold text-dark shadow-sm rounded-pill change-btn">
                                        <i class="bi bi-camera me-2"></i>Change Picture
                                    </label>
                                    <input type="file" class="form-control professional-input d-none" id="profile_picture" name="profile_picture" accept="image/*"
                                           onchange="previewImage(event)">
                                </div>
                                @error('profile_picture')
                                    <span class="text-danger small d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <button type="submit" class="btn btn-success w-50 py-2 fw-bold shadow-sm" style="transition: transform 0.2s ease;">
                            <i class="bi bi-save me-2"></i>Update Profile
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
        .change-btn {
            background-color: #ffc107; /* Bootstrap warning color */
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .change-btn:hover {
            background-color: #e0a800; /* Darker shade on hover */
            transform: scale(1.1);
        }
        .change-btn:active {
            transform: scale(0.95);
        }
        .profile-img-container {
            width: 150px; /* Fixed width for the container */
            height: 150px; /* Fixed height for the container */
            overflow: hidden; /* Hide overflow to prevent distortion */
            border-radius: 50%; /* Circular shape */
            margin: 0 auto; /* Center the container */
        }
        .profile-img {
            width: 100%; /* Image fills container width */
            height: 100%; /* Image fills container height */
            object-fit: cover; /* Scale image to cover container without distortion */
            border-radius: 50%; /* Ensure image is circular */
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Preview profile picture before upload
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profilePreview');
                    preview.style.opacity = '0';
                    setTimeout(() => {
                        preview.src = e.target.result;
                        preview.style.opacity = '1';
                    }, 300);
                };
                reader.readAsDataURL(file);
            }
        }

        // Button hover effect for submit button
        const submitButton = document.querySelector('.btn-success');
        submitButton.addEventListener('mouseover', () => {
            submitButton.style.transform = 'scale(1.05)';
        });
        submitButton.addEventListener('mouseout', () => {
            submitButton.style.transform = 'scale(1)';
        });
    </script>
@endsection