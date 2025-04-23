<?php
require_once(__DIR__ . '/../config/db_config.php');

class DeleteItemController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function deleteItem($itemId, $userId)
    {
        // Make sure the item belongs to the user
        $stmt = $this->db->prepare("SELECT * FROM found_items WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':id' => $itemId, ':user_id' => $userId]);
        $item = $stmt->fetch();

        if (!$item) {
            return false; // Unauthorized or not found
        }

        // Delete image file if exists
        if (!empty($item['image_path']) && file_exists(__DIR__ . '/../../uploads/' . basename($item['image_path']))) {
            unlink(__DIR__ . '/../../uploads/' . basename($item['image_path']));
        }

        // Delete the item
        $deleteStmt = $this->db->prepare("DELETE FROM found_items WHERE id = :id AND user_id = :user_id");
        return $deleteStmt->execute([':id' => $itemId, ':user_id' => $userId]);
    }
}

$deleteItemController = new DeleteItemController($db);
