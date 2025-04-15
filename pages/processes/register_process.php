<?php
// var_dump($_POST);
// exit;

session_start();
// Include database configuration file
// the /../../config/db_config.php will move up two levels to reach the config folder.
require_once(__DIR__ . '/../../config/db_config.php');

//define a class user
class user
{
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }

    public function register($data)
    {
        try {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (fullName, userName, mobile, email, adress, city, password, role, created_at) 
             VALUES (:fullName, :userName, :mobile, :email, :adress, :city, :password, :role, NOW())";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':fullName' => $data['fullName'],
                ':userName' => $data['userName'],
                ':mobile'   => $data['mobile'],
                ':email'    => $data['email'],
                ':adress'   => $data['adress'],
                ':city'     => $data['city'],
                ':password' => $hashedPassword,
                ':role'     => $data['role']
            ]);
        } catch (PDOException $e) {
            echo "Catch Error: " . $e->getMessage();
            return false;
        }
    }
}


//check if form was submitted;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    // Validate and sanitize form data
    $formData = [
        'fullName' => trim($_POST['fullName']),
        'userName' => trim($_POST['userName']),
        'mobile'   => trim($_POST['mobile']),
        'email'    => trim($_POST['email']),
        'adress'   => trim($_POST['adress']),
        'city'     => trim($_POST['city']),
        'password' => $_POST['password'],
        'role'     => $_POST['role']
    ];

    $user = new User($db);

    try {
        if ($user->register($formData)) {
            echo "<script>alert('🎉 Registration successful!'); window.location.href='../login.php';</script>";
        } else {
            echo "<script>alert('❌ Registration failed.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='../register.php';</script>";
}
