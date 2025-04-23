<?php
class User
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

            $sql = "INSERT INTO users (fullName, userName, mobile, email, address, city, password, role, created_at) 
            VALUES (:fullName, :userName, :mobile, :email, :address, :city, :password, :role, NOW())";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':fullName' => $data['fullName'],
                ':userName' => $data['userName'],
                ':mobile'   => $data['mobile'],
                ':email'    => $data['email'],
                ':address'   => $data['address'],
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
