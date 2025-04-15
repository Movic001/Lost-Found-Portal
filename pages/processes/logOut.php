<?php
session_start();
// // Check if the user is already logged in
// if (isset($_SESSION['user_id'])) {
//     echo "<script>alert('You are already logged in!'); window.location.href='../dashboard.php';</script>";
//     exit;
// }

//logOut;
if (isset($_POST['logOut'])) {
    session_destroy();
    echo "<script>confirm('You have logged out successfully!'); window.location.href='../login.php';</script>";
    exit;
}
// Check if the form is submitted
if (isset($_POST['login'])) {
    // Validate and sanitize form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];
} else {
    echo "<script>alert('Invalid request.'); window.location.href='../login.php';</script>";
    exit;
}
