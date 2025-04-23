<?php
session_start();
require_once(__DIR__ . '/../config/db_config.php');
require_once(__DIR__ . '/../classes/User.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $formData = [
        'fullName' => trim($_POST['fullName']),
        'userName' => trim($_POST['userName']),
        'mobile'   => trim($_POST['mobile']),
        'email'    => trim($_POST['email']),
        'address'   => trim($_POST['address']),
        'city'     => trim($_POST['city']),
        'password' => $_POST['password'],
        'role'     => $_POST['role']
    ];

    $user = new User($db);

    try {
        if ($user->register($formData)) {
            include('../../frontend/status/registration_success_message.html');
        } else {
            echo "<script>alert('❌ Registration failed.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='../../frontend/html/register.html';</script>";
}
