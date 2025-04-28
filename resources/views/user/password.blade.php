@extends('user.layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="container-fluid">
        <h1 class="dashboard-title mb-4 animate__animated animate__fadeIn">Change Password</h1>

        <div class="card shadow-lg border-0 animate__animated animate__zoomIn">
            <div class="card-header bg-primary text-white text-center py-4">
                <h4 class="mb-0"><i class="bi bi-lock-fill me-2"></i>Secure Your Account</h4>
            </div>
            <div class="card-body form-container">
                <form id="passwordForm">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="password" class="form-label fw-bold">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control professional-input shadow-sm" id="password" name="password" required>
                            </div>
                            <span class="text-danger small d-none error-password"></span>
                        </div>
                        <div class="col-12">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control professional-input shadow-sm" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button type="submit" class="btn btn-success w-50 py-3 fw-bold shadow-sm update-btn">
                            <i class="bi bi-key me-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .update-btn {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .update-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('scripts')
    <script>
        // AJAX password update
        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();
            $('.error-password').addClass('d-none').text('');
            const formData = new FormData(this);

            $.ajax({
                url: '{{ route("user.password.update") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    showNotification(response.message, 'success');
                    document.getElementById('passwordForm').reset();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.password) $('.error-password').removeClass('d-none').text(errors.password[0]);
                }
            });
        });
    </script>
@endsection