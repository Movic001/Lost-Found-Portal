<?php
session_start();
require_once(__DIR__ . '/../../backend/config/db_config.php');
require_once(__DIR__ . '/../../backend/controller/Edit_itemController.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to edit an item.'); window.location.href='view_items.php';</script>";
    exit;
}
// Get the item ID from the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $itemId = $_GET['id'];

    // Fetch the item details from the database
    $stmt = $db->prepare("SELECT * FROM found_items WHERE id = :id");
    $stmt->execute([':id' => $itemId]);
    $item = $stmt->fetch();

    // Check if the logged-in user is the owner of the item
    if (!$editItemController->checkItemOwner($itemId, $_SESSION['user_id'])) {
        echo "<script>alert('You are not authorized to edit this item.'); window.location.href='view_items.php';</script>";
        exit;
    }
    if (!$item) {
        echo "<script>alert('Item not found'); window.location.href='view_items.php';</script>";
    }
} else {
    echo "<script>alert('Invalid item ID'); window.location.href='view_items.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Found Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/post_item.css">
</head>

<body>
    <div class="navbar">
        <h1>Edit Found Item</h1>
        <span class="toggle_back"><a href="view_items.php">
                <<< Back to Items</a></span>
    </div>

    <div class="form-container">
        <h2>Edit Item Details</h2>
        <form action="../../backend/routes/editItem.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden ID Field -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

            <input type="text" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" placeholder="Item Name" required>
            <input type="text" name="category" value="<?php echo htmlspecialchars($item['category']); ?>" placeholder="Category" required>
            <textarea name="description" placeholder="Description" rows="4" required><?php echo htmlspecialchars($item['description']); ?></textarea>
            <input type="text" name="location_found" value="<?php echo htmlspecialchars($item['location_found']); ?>" placeholder="Location Found" required>
            <input type="date" name="date_found" value="<?php echo htmlspecialchars($item['date_found']); ?>" required>
            <input type="text" name="person_name" value="<?php echo htmlspecialchars($item['person_name']); ?>" placeholder="Your Name" required>
            <input type="number" name="contact_info" value="<?php echo htmlspecialchars($item['contact_info']); ?>" placeholder="Contact Information" required>

            <!-- Existing Image -->
            <?php if ($item['image_path']): ?>
                <img src="../../frontend/uploads/<?php echo basename($item['image_path']); ?>" alt="Current Image" style="width: 100px; height: auto; margin-bottom: 10px;">
                <input type="hidden" name="existing_image_path" value="<?php echo htmlspecialchars($item['image_path']); ?>">
            <?php endif; ?>

            <input type="file" name="image_path" accept="image/*">
            <button type="submit" name="postItem">Update Item</button>
        </form>
    </div>
</body>

</html>