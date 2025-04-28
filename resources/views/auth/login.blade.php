<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(180deg,rgb(133, 6, 6) 0%,rgb(18, 1, 1) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 90px;
            border-radius: 55px;
            box-shadow: 0 10px 30px rgba(255, 3, 3, 0.2);
            background-color:rgb(0, 0, 0);
        }
        .btn-login {
            background-color:rgb(255, 0, 0);
            color:rgb(0, 0, 0);
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(252, 0, 0, 0.3);
        }
        h2{
            color:rgba(221, 221, 221, 0.3)
        }
        p{
            color:rgba(221, 221, 221, 0.3)
        }
        
    </style>
</head>
<body>
    <div class="login-card animate__animated animate__zoomIn">
        <h2 class="text-center mb-4">Welcome !</h2>
        <p class="text-center  mb-5">Let's Make Money</p>
        <div class="text-center">
            <a href="{{ route('auth.google') }}" class="btn btn-login w-100">
                <i class="bi bi-google me-2"></i>Login with Google
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>