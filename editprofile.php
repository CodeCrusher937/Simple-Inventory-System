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

if (isset($_POST['update_profile'])) {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = sha1($_POST['password']);

    if ($name == "" || $phone == "" || $email == "" || $_POST['password'] == "") {

        $error = "Please fill all fields.";

    } else {

        $check_email = "SELECT id FROM users
                        WHERE email = '$email'
                        AND id != '$user_id'";

        $check_result = mysqli_query($connection, $check_email);

        if (mysqli_num_rows($check_result) > 0) {

            $error = "This email is already registered.";

        } else {

            $update = "UPDATE users SET
                       name = '$name',
                       phone = '$phone',
                       email = '$email',
                       password = '$password'
                       WHERE id = '$user_id'";

            if (mysqli_query($connection, $update)) {

                $_SESSION['name'] = $name;

                $success = "Profile updated successfully.";

                $sql = "SELECT * FROM users WHERE id = '$user_id'";
                $result = mysqli_query($connection, $sql);
                $user = mysqli_fetch_assoc($result);

            } else {

                $error = "Profile update failed: " . mysqli_error($connection);
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Inventory System</title>
    <link rel="stylesheet" href="editprofile.css">
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

    <main class="main-content">
        <div class="edit-container">
            <div class="edit-card">
                <div class="edit-header">
                    <div class="profile-icon">
                        <?php
                        echo strtoupper(substr($user['name'], 0, 1));
                        ?>
                    </div>
                    <h1>Edit Profile</h1>
                    <p>Update your Inventory System account</p>
                </div>


                <?php if (isset($error)) { ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                <?php } ?>


                <?php if (isset($success)) { ?>

                    <div class="success-message">
                        <?php echo $success; ?>
                    </div>

                <?php } ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Enter your full name">
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"placeholder="Enter phone number">
                    </div>


                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Enter email address">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>"placeholder="Enter Your password">
                    </div>

                    <div class="account-info">
                        <span>Account Role</span>
                        <strong>
                            <?php echo ucfirst($user['role']); ?>
                        </strong>
                    </div>

                    <div class="account-info">
                        <span>User ID</span>
                        <strong>
                            #<?php echo $user['id']; ?>
                        </strong>
                    </div>


                    <button type="submit" name="update_profile">
                        Save Changes
                    </button>
                </form>

                <div class="bottom-links">
                    <a href="profile.php">← Back to Profile</a>
            </div>
        </div>
    </main>
</div>
</body>
</html>