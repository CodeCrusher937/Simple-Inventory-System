<?php
include"connection.php";
session_start();

if (isset($_POST["add_product"])) {

    $product_name = trim($_POST["product_name"]);
    $buying_price = $_POST["buying_price"];
    $selling_price = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
    $description = trim($_POST["description"]);

    $image_name = $_FILES["product_image"]["name"];
    $image_tmp = $_FILES["product_image"]["tmp_name"];

    $image_folder = "uploads/";

    $new_image_name = time() . "_" . $image_name;

    $sql = "INSERT INTO products(product_name, product_image, buying_price, selling_price, quantity, description)
            VALUES('$product_name', '$new_image_name', '$buying_price', '$selling_price', '$quantity', '$description')";

    if (mysqli_query($connection, $sql)) {
        echo "Product added successfully.";
    } else {

        echo "Error: " . mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="customer.css" rel="stylesheet">
</head>

<body>

<div class="add-product-box">

    <h2>Add New Product</h2>
    <p>Enter product details below to add a new product to your inventory.</p>

    <form action="add_product.php" method="POST" enctype="multipart/form-data" class="add-product-form">

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="product_name" required>
        </div>

        <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="product_image" accept="image/*" required>
        </div>

        <div class="form-group">
            <label>Buying Price</label>
            <input type="number" name="buying_price" required>
        </div>

        <div class="form-group">
            <label>Selling Price</label>
            <input type="number" name="selling_price" required>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" required>
        </div>

        <div class="form-group full-width">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>

        <button type="submit" name="add_product" class="add-product-btn">
            Add Product
        </button>
    </form>
</div>
</body>
</html>