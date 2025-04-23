<?php
session_start();

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
