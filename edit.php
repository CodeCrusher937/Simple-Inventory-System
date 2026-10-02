<?php

include "connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("location: login.php");
    exit;
}

$id = $_GET["id"];

$result = mysqli_query($connection, "SELECT * FROM users WHERE id = $id AND role = 'customer'");
$customer = mysqli_fetch_assoc($result);


if (isset($_POST["update"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    mysqli_query($connection, "UPDATE users SET
        name = '$name',
        email = '$email',
        phone = '$phone',
        password = '$password'
        WHERE id = $id AND role = 'customer'");

    header("location: customers.php");
    exit;
}

if (isset($_POST["delete"])) {

    mysqli_query($connection, "DELETE FROM users WHERE id = $id AND role = 'customer'");

    header("location: customers.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit Customer</title>

    <link rel="stylesheet" href="edit.css">

</head>

<body>

<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>
        <nav>
            <a href="admin_dashboard.php" class="active">Dashboard</a>
            <a href="users.php">Users</a>
            <a href="products.php">Products</a>
            <a href="customers.php">Customers</a>
            <a href="sales.php">Sales</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

<div class="form-box">
    
    <form method="POST">

     <h3 class="topbar">Edit Customer</h3>

        <label>Customer Name</label>
        <input type="text" name="name" value="<?php echo $customer['name']; ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $customer['email']; ?>">

        <label>Phone</label>
        <input type="tel" name="phone" value="<?php echo $customer['phone']; ?>">

        <label>Password</label>
        <input type="text" name="password" value="<?php echo $customer['password']; ?>">

        <button type="submit" name="update" class="btn">Update Customer</button>

        <a href="customers.php" class="btn">Cancel</a>

    </form>

    <br>

    <form method="POST">

 <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Delete this customer?')">  
        Delete Customer
        </button>

    </form>

</div>
</div>
</body>
</html>