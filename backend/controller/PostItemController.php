<?php
session_start(); // Start the session
// Include database configuration file
require_once(__DIR__ . '../../config/db_config.php');

class FoundItem
{
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }
    public function postFoundItem($data, $image)
    {
        try {
            //handle image upload
            $imagePath = $this->uploadImage($image);

            $sql = "INSERT INTO found_items ( user_id, item_name, category, description, location_found, date_found, person_name, contact_info, image_path, created_at) 
            VALUES ( :user_id, :item_name, :category, :description, :location_found, :date_found, :person_name, :contact_info, :image_path, NOW())";

            $stmt = $this->db->prepare($sql);

            //execute the statement with the provided data
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'], // Assuming you have user_id in session
                ':item_name' => $data['item_name'],
                ':category' => $data['category'],
                ':description' => $data['description'],
                ':location_found' => $data['location_found'],
                ':date_found' => $data['date_found'],
                ':person_name' => $data['person_name'],
                ':contact_info' => $data['contact_info'],
                ':image_path' => $imagePath,
            ]);
            return true;
        } catch (PDOException $e) {
            //handle any errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function uploadImage($image)
    {
        $targetDir = realpath(__DIR__ . '/../../frontend/uploads') . '/';

        // Check if the directory exists, if not create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $check = getimagesize($image["tmp_name"]);

        // Check if image file is a actual image or fake image
        if ($check === false) {
            echo "File is not an image.";
            return false;
        }

        // Check file size
        if ($image["size"] > 500000) {
            echo "<script>alert('🎉 Sorry, your file is too large.'); window.location.href='../post_item.php';</script>";
            return false;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return false;
        }

        // Try to upload file
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "<script> alert('Sorry, there was an error uploading your file.'); window.location.href='../post_item.php';</script>";
            return false;
        }
    }
}
