<?php

include "connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("location: login.php");
    exit;
}

$id = $_GET["id"];

$result = mysqli_query($connection, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);


if (isset($_POST["update"])) {

    $name = $_POST["product_name"];
    $buying = $_POST["buying_price"];
    $selling = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

    mysqli_query($connection, "UPDATE products SET
        product_name = '$name',
        buying_price = '$buying',
        selling_price = '$selling',
        quantity = '$quantity',
        description = '$description'
        WHERE id = $id
    ");

    header("location: products.php");
    exit;
}

if (isset($_POST["delete"])) {
    mysqli_query($connection, "DELETE FROM products WHERE id = $id");
    header("location: products.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit Product</title>
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

       <h3 class="topbar">Edit Product</h2>

        <label>Product Name</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>">

        <label>Buying Price</label>
        <input type="number" name="buying_price" value="<?php echo $product['buying_price']; ?>">

        <label>Selling Price</label>
        <input type="number" name="selling_price" value="<?php echo $product['selling_price']; ?>">

        <label>Quantity</label>
        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>">

        <label>Description</label>
        <textarea name="description"><?php echo $product['description']; ?></textarea>

        <button type="submit" name="update" class="btn">
            Update Product
        </button>

        <a href="products.php" class="btn">
            Cancel
        </a>

    </form>

    <br>

    <form method="POST">

        <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Delete this product?')">  
             Delete Product
        </button>

    </form>

</div>
</div>
</body>
</html>