<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Are Billionere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg,rgb(0, 0, 0) 0%,rgb(0, 0, 0) 100%);
            color:rgba(102, 87, 4, 0.35);
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .container {
            text-align: center;
            z-index: 2;
        }
        .business-name {
            font-size: 4.5rem;
            font-weight: 800;
            color:rgba(254, 21, 5, 0.46);
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            margin: 0;
            letter-spacing: 2px;
        }
        .login-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background:rgb(0, 0, 0);
            border: 2px solidrgb(222, 217, 217);
            padding: 10px 25px;
            border-radius: 25px;
            color:rgba(254, 21, 5, 0.46);
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease;
            z-index: 3;
        }
        .login-btn:hover {
            background:rgb(255, 0, 0);
            color:rgb(3, 3, 3);
        }
       
    </style>
</head>
<body>
   

    <div class="container">
        <h1 class="business-name">We Are Billionaire</h1>
        
        <a href="{{ route('login') }}" class="login-btn">
        <i class="bi bi-box-arrow-in-right me-2"></i>Make money
    </a>
    </div>

   

</body>
</html>