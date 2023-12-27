<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .w3-feature{
            background-color:#005c27 !important;
            color: white;
        }
    </style>
</head>
<body>

<div class="w3-display-container w3-padding-64" style="height: 100vh">
    
    <!-- Google Login Button -->
    <div class="w3-display-middle">
        <h1 class="w3-center w3-round w3-large">Login</h1>
        <a href="{{ url('/auth/google') }}" class="w3-button w3-round w3-large w3-block w3-feature">Login with Google</a>
    </div>
</div>

</body>
</html>
