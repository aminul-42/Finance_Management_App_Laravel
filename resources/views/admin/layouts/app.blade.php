<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #e0e7ff, #a5b4fc);
            color: #1e293b;
            transition: background-color 0.5s ease, color 0.5s ease;
            overflow-x: hidden;
        }
        body.dark-mode {
            background: linear-gradient(135deg, #1e293b, #475569);
            color: #e2e8f0;
        }
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #4f46e5, #7c3aed);
            padding: 20px 10px;
            transition: width 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar .nav-link {
            color: #ffffff;
            padding: 12px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin: 5px 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #6d28d9;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #6d28d9;
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 12px;
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
        }
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        .sidebar.collapsed .nav .nav-item .nav-link span {
            display: none !important;
        }
        .sidebar .nav-link span {
            white-space: nowrap;
            overflow: hidden;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .main-content.collapsed {
            margin-left: 80px;
        }
        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4f46e5;
            letter-spacing: -0.5px;
        }
        .dark-mode .dashboard-title {
            color: #a5b4fc;
        }
        .card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        .dark-mode .card {
            background: #2d3748;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #4338ca, #6d28d9);
            transform: scale(1.05);
        }
        .btn-success {
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn-success:hover {
            background: linear-gradient(90deg, #16a34a, #15803d);
            transform: scale(1.05);
        }
        .form-container {
            background: #f9fafb;
            padding: 25px;
            border-radius: 12px;
        }
        .dark-mode .form-container {
            background: #4b5563;
        }
        .professional-input {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 12px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .professional-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 10px rgba(79, 70, 229, 0.3);
            outline: none;
        }
        .alert {
            border-radius: 10px;
            padding: 15px;
            font-weight: 500;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate__slideIn {
            animation: slideIn 0.5s ease-out;
        }
    </style>
    @yield('styles')
</head>
<body class="light-mode">
    @include('admin.partials.sidebar')
    <div class="main-content" id="main-content">
        @include('admin.partials.messages')
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleSidebar = document.getElementById('toggle-sidebar');

            if (toggleSidebar && sidebar && mainContent) {
                toggleSidebar.addEventListener('click', (e) => {
                    e.preventDefault();
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');
                    // Update data attribute and toggle icon
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    sidebar.dataset.collapsed = isCollapsed;
                    const icon = toggleSidebar.querySelector('i');
                    icon.className = isCollapsed ? 'bi bi-arrow-right' : 'bi bi-list';
                    // Debug: Log state and check span visibility
                    console.log('Sidebar collapsed:', isCollapsed);
                    console.log('Span elements:', document.querySelectorAll('.sidebar.collapsed .nav-link span').length);
                    if (isCollapsed) {
                        document.querySelectorAll('.sidebar.collapsed .nav-link span').forEach(span => {
                            console.log('Span style:', span.style.display);
                        });
                    }
                });
            } else {
                console.error('Sidebar toggle elements not found:', {
                    toggleSidebar: !!toggleSidebar,
                    sidebar: !!sidebar,
                    mainContent: !!mainContent
                });
            }
        });

        // Dark mode toggle (safeguarded)
        const darkModeSwitch = document.getElementById('dark-mode-switch');
        if (darkModeSwitch) {
            darkModeSwitch.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                document.body.classList.toggle('light-mode');
                const isDarkMode = document.body.classList.contains('dark-mode');
                localStorage.setItem('mode', isDarkMode ? 'dark' : 'light');
                darkModeSwitch.innerHTML = isDarkMode ? '<i class="bi bi-sun"></i> Light Mode' : '<i class="bi bi-moon"></i> Dark Mode';
            });
        }

        // Apply saved mode
        if (localStorage.getItem('mode') === 'dark') {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
            if (darkModeSwitch) {
                darkModeSwitch.innerHTML = '<i class="bi bi-sun"></i> Light Mode';
            }
        } else {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
            if (darkModeSwitch) {
                darkModeSwitch.innerHTML = '<i class="bi bi-moon"></i> Dark Mode';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>