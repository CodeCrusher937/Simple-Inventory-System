<?php

include "connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "customer") {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$name = $_SESSION["name"];


$result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM products");

$row = mysqli_fetch_assoc($result);
$total_products = $row["total"];

$result = mysqli_query($connection, "SELECT COALESCE(SUM(revenue), 0) AS total FROM sale_items");

$row = mysqli_fetch_assoc($result);
$total_revenue = $row["total"];


$result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM sale_items");

$row = mysqli_fetch_assoc($result);
$total_sales = $row["total"];


$products = mysqli_query($connection, "SELECT * FROM products ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="customer.css">

</head>


<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>
        <nav>
            <a href="customer_dashboard.php" class="active">Dashboard</a>
            <a href="product.php">Products</a>
            <a href="sale.php">Sales</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Customer Dashboard</h1>
                <p>
                    Welcome, <?php echo htmlspecialchars($name); ?>
                </p>
            </div>


            <div class="user-profile">
                <?php echo htmlspecialchars($name); ?>
            </div>
        </header>

        <section class="cards">
            <div class="card">
                <h3>Total Products</h3>
                <p>
                    <?php echo $total_products; ?>
                </p>
            </div>

            <div class="card">
                <h3>Total Sales</h3>
                <p>
                    <?php echo $total_sales; ?>
                </p>
            </div>

            <div class="card">
                <h3>Total Revenue</h3>
                <p>
                    TZS <?php echo number_format($total_revenue); ?>
                </p>
            </div>
        </section>

        <section class="table-box">
            <div class="section-header">
                <h2>Products</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Quantity</th>
                        <th>Description</th>
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
                                <?php echo htmlspecialchars($product["product_name"] );?>
                            </td>


                            <td>
                                TZS
                                <?php echo number_format($product["buying_price"]);?>
                            </td>


                            <td>
                                TZS
                                <?php echo number_format($product["selling_price"]);?>
                            </td>


                            <td>
                                <?php echo $product["quantity"]; ?>
                            </td>


                            <td>
                                <?php echo htmlspecialchars($product["description"]);?>
                            </td>


                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>

                        <td colspan="6">
                            No products found.
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