<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Lost & Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <div class="navbar">
        <h1>Lost & Found</h1>

        <span class="toggle_back"><a href='/index.php'>
                <<< </a></span>

    </div>
    <div class="login-container">
        <h2>Login</h2>
        <form action="processes/login_process.php" method="POST">
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <div>
            <div class="register-link">
                Don't have an account? <a href="register.php">Register</a>
            </div>
        </div>

</body>

</html>