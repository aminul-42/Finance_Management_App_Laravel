<div class="position-fixed top-0 end-0 p-4" style="z-index: 1050; max-width: 450px;">
    <div id="notification-area"></div>
</div>

@section('scripts')
    @parent
    <script>
        function showNotification(message, type = 'success') {
            const notificationArea = document.getElementById('notification-area');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show shadow-lg border-0 animate__animated animate__bounceInRight`;
            alert.role = 'alert';
            alert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-3 fs-5 text-${type}"></i>
                    <div>
                        <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            notificationArea.appendChild(alert);
            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 150);
            }, 4000);
        }
    </script>
@endsection