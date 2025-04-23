<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../../backend/includes/auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lost & Found</title>
    <link rel="stylesheet" href="../../frontend/assets/css/dashboard.css">
</head>

<body>
    <div class="sidebar">
        <h3>User Profile</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($userName); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
        <p><strong>Role:</strong> User</p>

        <!-- section to logOut -->
        <form method="POST" action="/backend/routes/logOut.php">
            <button class="logout-btn" type="submit" name="logOut" onclick="return confirm('Are you sure you want to LogOut?')"> LogOut</button>
        </form>

    </div>


    <div class="navbar">
        <h1>Lost & Found Portal</h1>
        <span class="toggle-btn" onclick="toggleSidebar()">☰</span>

    </div>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($userName); ?> 👋</h2>
        <p>What would you like to do today?</p>

        <div class="dashboard-links">
            <a href="../../frontend/pages/post_item.html">➕ Post Found Item</a>
            <a href="../../frontend/pages/view_items.php">🔍 View Lost Items</a>

        </div>
    </div>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>

</body>

</html>