<?php
session_start();
// the /../../config/db_config.php will move up two levels to reach the config folder.
require_once(__DIR__ . '/../../config/db_config.php');

class User
{
    private $db;

    public function __construct($dbconn)
    {
        $this->db = $dbconn;
    }

    public function login($email, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullName'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Login Error: " . $e->getMessage();
            return false;
        }
    }
}
//check if form exist

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    // Validate and sanitize form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = new User($db);

    if ($user->login($email, $password)) {
        echo "<script>alert('Login successful!'); window.location.href='../dashboard.php';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid email or password.');window.location.href='../login.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='../login.php';</script>";
}
