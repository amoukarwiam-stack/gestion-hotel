<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body style="font-family: Arial; background-color: #f4f4f4; padding:20px;">

    <div style="background:white; padding:20px; border-radius:8px;">
        
        <h2 style="color:#2c3e50;">
            @yield('header')
        </h2>

        <div>
            @yield('content')
        </div>

        <hr>

        <p style="font-size:12px; color:gray;">
            © 2026 Hotel Reservation System
        </p>

    </div>

</body>
</html>