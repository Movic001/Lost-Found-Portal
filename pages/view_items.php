<?php
session_start();
// the /../../config/db_config.php will move up one levels to reach the config folder.
require_once(__DIR__ . '/../config/db_config.php');

// Fetch items from the database
$stmt = $db->query("SELECT * FROM found_items ORDER BY created_at DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Found Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/view_items.css">
</head>

<body>
    <div class="navbar">
        <h1>Lost Items</h1>

        <span class="toggle_back"><a href='./dashboard.php'>
                <<< </a></span>

    </div>
    <div class="container">
        <div class="grid">
            <?php foreach ($items as $item): ?>
                <div class="card">
                    <?php if (!empty($item['image_path'])): ?>
                        <img src="<?php echo '../uploads/' . basename($item['image_path']); ?>" alt="Item Image">
                    <?php endif; ?>
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($item['location_found']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($item['date_found']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
                        <p><strong>Contact:</strong> <a class="contact_info" href="tel:<?php echo htmlspecialchars($item['contact_info']); ?>"><?php echo htmlspecialchars($item['contact_info']); ?></a></p>
                        <small>Posted by <?php echo htmlspecialchars($item['person_name']); ?> on <?php echo htmlspecialchars($item['created_at']); ?></small>
                    </div>

                    <div class="item-actions">
                        <a href="#" class="edit-btn">Edit</a>
                        <a href="#" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>