<?php

include "connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin"){
    header("location: login.php");
    exit;
}

if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    mysqli_query($connection, "DELETE FROM products WHERE id = $id");
    header("location: products.php");
    exit;
}

$products = mysqli_query($connection, "SELECT id, product_name, buying_price, selling_price, quantity
     FROM products ORDER BY id ASC");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Inventory System</title>
    <link rel="stylesheet" href="admin.css">
</head>


<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="users.php">Users</a>
            <a href="products.php" class="active">Products</a>
            <a href="customers.php">Customers</a>
            <a href="sales.php">Sales</a>
            <a href="logout.php">Logout</a>
        </nav>

    </aside>
    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Products</h1>
                <p>
                    Manage products and stock
                </p>
            </div>

            <div class="admin-profile">
                Admin
            </div>
        </header>

        <section class="table-box">
            <div class="section-header">
                <h2>Products</h2>
                <a href="add_product.php" class="btn">+ Add Product</a>
            </div>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php if ($products && mysqli_num_rows($products) > 0): ?>
                    <?php while ($product = mysqli_fetch_assoc($products)): ?>
                        <tr>

                            <td>
                                <?php echo $product["id"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars( $product["product_name"] ); ?>
                            </td>

                            <td>
                                TZS
                                <?php echo number_format( $product["buying_price"]); ?>
                            </td>
                            <td>
                                TZS
                                <?php echo number_format($product["selling_price"]); ?>
                            </td>
                            <td>
                                <?php echo $product["quantity"]; ?>
                            </td>
                            <td>
                    <a href="editDel.php?id=<?php echo $product["id"]; ?>" class="btn">Edit </a>
                 <a href="products.php?delete=<?php echo $product["id"]; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this product?');">
                                    Delete </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>

                <tr>
                <td colspan="6">No products found.<br><br>
                 <a href="add_product.php" class="btn">Add Your First Product </a>
                </td>
                </tr>

                <?php endif; ?>

                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>