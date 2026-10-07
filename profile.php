<?php

include "connection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Database error: " . mysqli_error($connection));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Inventory System</title>
    <link rel="stylesheet" href="profile.css">
</head>

<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>
        <nav>
            <a href="customer_dashboard.php">Dashboard</a>
            <a href="product.php">Products</a>
            <a href="sale.php">Sales</a>
            <a href="profile.php" class="active">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php
                    echo strtoupper(substr($user['name'], 0, 1));
                    ?>
                </div>

                <h1>
                    <?php echo htmlspecialchars($user['name']); ?>
                </h1>

                <p>Inventory System Account</p>

                <span class="role-badge">
                    <?php echo ucfirst($user['role']); ?>
                </span>
            </div>

            <div class="section">
                <h2>Account Information</h2>
                <div class="info-grid">

                    <div class="info-box">
                        <span>Full Name</span>
                        <strong>
                            <?php echo htmlspecialchars($user['name']); ?>
                        </strong>
                    </div>

                    <div class="info-box">
                        <span>Email Address</span>
                        <strong>
                            <?php echo htmlspecialchars($user['email']); ?>
                        </strong>
                    </div>

                    <div class="info-box">
                        <span>Phone Number</span>
                        <strong>
                            <?php echo htmlspecialchars($user['phone']); ?>
                        </strong>
                    </div>

                    <div class="info-box">
                        <span>Account Role</span>
                        <strong>
                            <?php echo ucfirst($user['role']); ?>
                        </strong>
                    </div>

                    <div class="info-box">
                        <span>User ID</span>
                        <strong>
                            #<?php echo $user['id']; ?>
                        </strong>
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="editprofile.php" class="btn">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>