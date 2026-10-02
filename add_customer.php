<?php

include "connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("location: login.php");
    exit;
}

if (isset($_POST['add_customer'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($name == "" || $phone == "" || $email == "" || $password == "") {
        $message = "Please fill all fields.";

    } else {
        $check = mysqli_query($connection, "SELECT id FROM users WHERE email = '$email'" );

        if (mysqli_num_rows($check) > 0) {
            $message = "Email already exists.";

        } else {

            $hashed_password = sha1($password);

            $result = mysqli_query($connection, "INSERT INTO users (name, email, phone, password, role)
                 VALUES ('$name', '$email', '$phone', '$hashed_password', 'customer')");

            if ($result) {
                header("location: customers.php");
                exit;

            } else {
                $message = "Customer registration failed: " . mysqli_error($connection);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Customer</title>
    <link rel="stylesheet" href="edit.css">

</head>

<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>

        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="users.php">Users</a>
            <a href="products.php">Products</a>
            <a href="customers.php" class="active">Customers</a>
            <a href="sales.php">Sales</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <div class="form-box">
        <form method="POST">
            <h3 class="topbar">Add Customer</h3>

            <?php if (isset($message)) { ?>

                <p><?php echo $message; ?></p>

            <?php } ?>

            <label>Customer Name</label>
            <input type="text" name="name" placeholder="Enter customer name" value="<?php echo isset($name) ? $name : ''; ?>">

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter customer email" value="<?php echo isset($email) ? $email : ''; ?>">

            <label>Phone</label>
            <input type="tel" name="phone" placeholder="Enter phone number" value="<?php echo isset($phone) ? $phone : ''; ?>">

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password">

            <button type="submit" name="add_customer" class="btn">Add Customer</button>
            <a href="customers.php" class="btn">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>