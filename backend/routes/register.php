<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(__DIR__ . '/../controller/registerController.php');
} else {
    echo "<script>alert('Invalid Route'); window.location.href='../../frontend/html/register.html';</script>";
}
