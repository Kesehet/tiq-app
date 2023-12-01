<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<div class="w3-container w3-center w3-padding-64">
    <h2>Login</h2>
    <form class="w3-container w3-card-4 w3-padding-16 w3-white" action="/path_to_login_logic" method="post">
        <div class="w3-section">
            <label>Username</label>
            <input class="w3-input" type="text" name="username" required>
        </div>
        <div class="w3-section">
            <label>Password</label>
            <input class="w3-input" type="password" name="password" required>
        </div>
        <button type="submit" class="w3-button w3-block w3-teal">Login</button>
    </form>

    <!-- Google Login Button -->
    <div class="w3-section">
        <a href="{{ url('/auth/google') }}" class="w3-button w3-block w3-red">Login with Google</a>
    </div>
</div>

</body>
</html>
