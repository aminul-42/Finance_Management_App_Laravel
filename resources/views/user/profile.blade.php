@extends('user.layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Your Profile</h1>

        <div class="card shadow-lg border-0 animate__animated animate__zoomIn">
            <div class="card-header bg-primary text-white text-center py-4">
                <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Update Your Profile</h4>
            </div>
            <div class="card-body form-container">
                <form id="profileForm" enctype="multipart/form-data" action="{{ route('user.profile.update') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12 text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('storage/default-avatar.png') }}"
                                     alt="Profile Picture" class="profile-img mb-3 shadow animate__animated animate__flipInX"
                                     id="profilePreview">
                                <label for="profile_picture" class="btn btn-warning px-4 py-2 fw-bold shadow-sm rounded-pill change-btn">
                                    <i class="bi bi-camera me-2"></i>Change Picture
                                </label>
                                <input type="file" class="d-none" id="profile_picture" name="profile_picture" accept="image/*">
                            </div>
                            <span class="text-danger small d-none error-profile_picture"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control professional-input shadow-sm" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <span class="text-danger small d-none error-name"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control professional-input shadow-sm" id="email" name="email" value="{{ Auth::user()->email }}" required>
                            </div>
                            <span class="text-danger small d-none error-email"></span>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-success w-50 py-3 fw-bold shadow-sm update-btn">
                            <i class="bi bi-save me-2"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('user.partials.messages') <!-- Include the messages.blade.php here -->
@endsection

@section('styles')
    <style>
        .profile-img {
            width: 140px;
            height: 140px;
            border: 4px solid #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .profile-img:hover {
            transform: scale(1.05);
        }
        .change-btn {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .change-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .update-btn {
            transition: transform 0.3s ease;
        }
        .update-btn:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Profile picture preview
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profilePreview');
                    preview.classList.remove('animate__flipInX');
                    preview.style.opacity = '0';
                    setTimeout(() => {
                        preview.src = e.target.result;
                        preview.style.opacity = '1';
                        preview.classList.add('animate__flipInX');
                    }, 300);
                };
                reader.readAsDataURL(file);
            }
        });

        // AJAX profile update
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            $('.error-name, .error-email, .error-profile_picture').addClass('d-none').text('');
            const formData = new FormData(this);

            $.ajax({
                url: '{{ route("user.profile.update") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response); // Debug: Log the response
                    showNotification(response.message || 'Profile updated successfully', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    console.log(xhr); // Debug: Log the error
                    const errors = xhr.responseJSON?.errors || {};
                    if (errors.name) $('.error-name').removeClass('d-none').text(errors.name[0]);
                    if (errors.email) $('.error-email').removeClass('d-none').text(errors.email[0]);
                    if (errors.profile_picture) $('.error-profile_picture').removeClass('d-none').text(errors.profile_picture[0]);
                    if (!errors.name && !errors.email && !errors.profile_picture) {
                        showNotification(xhr.responseJSON?.message || 'An error occurred while updating the profile.', 'danger');
                    }
                }
            });
        });
    </script>
@endsection