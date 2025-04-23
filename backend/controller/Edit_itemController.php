<?php
require_once(__DIR__ . '/../config/db_config.php');

class EditItemController
{
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }

    // Fetch an item by ID
    public function getItemById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM found_items WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching item: " . $e->getMessage();
            return false;
        }
    }
    // Check if the current user is the owner of the item
    public function checkItemOwner($itemId, $userId)
    {
        $stmt = $this->db->prepare("SELECT user_id FROM found_items WHERE id = :id");
        $stmt->execute([':id' => $itemId]);
        $item = $stmt->fetch();

        return ($item['user_id'] == $userId);  // Compare the stored user_id with the current user_id
    }

    // Update item
    public function updateItem($data, $file = null)
    {
        try {
            // Image upload
            $imagePath = $data['existing_image_path']; // default: no change

            if ($file && $file['error'] === 0) {
                $uploadDir = __DIR__ . '/../../frontend/uploads/';
                $fileName = basename($file['name']);
                $targetPath = $uploadDir . $fileName;

                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    throw new Exception("Failed to upload image");
                }

                $imagePath = 'frontend/uploads/' . $fileName;
            }

            $sql = "UPDATE found_items SET item_name = :item_name, category = :category, description = :description,
                    location_found = :location_found, date_found = :date_found, person_name = :person_name,
                    contact_info = :contact_info, image_path = :image_path WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':item_name' => $data['item_name'],
                ':category' => $data['category'],
                ':description' => $data['description'],
                ':location_found' => $data['location_found'],
                ':date_found' => $data['date_found'],
                ':person_name' => $data['person_name'],
                ':contact_info' => $data['contact_info'],
                ':image_path' => $imagePath,
                ':id' => $data['id'],
            ]);

            return true;
        } catch (Exception $e) {
            echo "Error updating item: " . $e->getMessage();
            return false;
        }
    }
}

// Create an instance to use in the view
$editItemController = new EditItemController($db);
