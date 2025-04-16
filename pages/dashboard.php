<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
    exit;
}
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION["user_email"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lost & Found</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <div class="sidebar">
        <h3>User Profile</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($userName); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
        <p><strong>Role:</strong> User</p>

        <!-- section to logOut -->
        <form method="POST" action="processes/logOut.php">
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
            <a href="post_item.php">➕ Post Found Item</a>
            <a href="view_items.php">🔍 View Lost Items</a>

        </div>
    </div>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>

</body>

</html>