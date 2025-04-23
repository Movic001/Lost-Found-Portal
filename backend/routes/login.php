<?php
require_once(__DIR__ . '/../controller/loginController.php');
require_once(__DIR__ . '/../config/db_config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    // Validate and sanitize form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = new User($db);

    if ($user->login($email, $password)) {
        include('../../frontend/status/login_success_message.html');
    } else {
        echo "<script>alert('❌ Invalid email or password.');window.location.href='../../frontend/pages/login.html';</script>";
    }
} else {
    echo "<script>alert('❌ Invalid request.'); window.location.href='../../frontend/pages/login.html';</script>";
}
