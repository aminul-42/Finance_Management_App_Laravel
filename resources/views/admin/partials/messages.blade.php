<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050; max-width: 400px;">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-lg border-0 animate__animated animate__bounceInRight" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 text-success" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0 animate__animated animate__bounceInRight" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 text-danger" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

@section('scripts')
    @parent
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150); // Remove from DOM after fade out
                }, 5000); // 5 seconds
            });
        });
    </script>
@endsection