<?php
require_once(__DIR__ . '/../controller/PostItemController.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postItem'])) {

    //collect and sanitize form inputs
    $formData = [
        'item_name' => trim($_POST['item_name']),
        'category' => trim($_POST['category']),
        'description' => trim($_POST['description']),
        'location_found'   => trim($_POST['location_found']),
        'date_found'   => trim($_POST['date_found']),
        'person_name'    => trim($_POST['person_name']),
        'contact_info'     => trim($_POST['contact_info']),
    ];

    $foundItem = new FoundItem($db);

    try {
        // Post the found item to the database
        if ($foundItem->postFoundItem($formData, $_FILES['image_path'])) {
            include('../../frontend/status/post_success_message.html');
        } else {
            echo "<script>alert('❌ Failed to post item.'); window.location.href='../../frontend/pages/post_item.html';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Invalid request');window.location.href='../../frontend/pages/post_item.html'; </script>";
}
