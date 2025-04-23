<?php
session_start();
require_once(__DIR__ . '/../controller/Edit_itemController.php');

// Make sure form was submitted and required ID is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $editItemController = new EditItemController($db);

    // Sanitize and collect form data
    $data = [
        'id' => $_POST['id'],
        'item_name' => $_POST['item_name'],
        'category' => $_POST['category'],
        'description' => $_POST['description'],
        'location_found' => $_POST['location_found'],
        'date_found' => $_POST['date_found'],
        'person_name' => $_POST['person_name'],
        'contact_info' => $_POST['contact_info'],
        'existing_image_path' => $_POST['existing_image_path'] ?? ''
    ];

    $file = $_FILES['image_path'] ?? null;

    // Attempt update
    if ($editItemController->updateItem($data, $file)) {
        echo "<script>alert('Item updated successfully'); window.location.href='../../frontend/pages/view_items.php';</script>";
    } else {
        echo "<script>alert('Failed to update item.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
