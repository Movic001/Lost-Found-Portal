<?php
// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
    exit;
}
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION["user_email"];
