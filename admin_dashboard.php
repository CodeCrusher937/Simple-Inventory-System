<?php

include"connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

$total_users = 0;
$total_products = 0;
$total_revenue = 0;
$total_customers = 0;

$result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM users");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_users = $row["total"];
}

$result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM products");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_products = $row["total"];
}

$result = mysqli_query($connection, "SELECT COALESCE(SUM(revenue), 0) AS total FROM sale_items");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_revenue = $row["total"];
}

$result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_customers = $row["total"];
}

$products = mysqli_query($connection, "SELECT id, product_name, buying_price, selling_price, quantity
     FROM products ORDER BY id ASC");

$customers = mysqli_query($connection, "SELECT id, name, email, phone FROM users
 WHERE role = 'customer' ORDER BY id ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
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


    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Admin Dashboard</h1>
                <p>
                    Welcome back, Admin
                </p>
            </div>

            <div class="admin-profile">
                Admin
            </div>
        </header>


        <section class="cards">
            <div class="card">
                <h3>Total Users</h3>
                <p>
                    <?php echo $total_users; ?>
                </p>
            </div>


            <div class="card">
                <h3>Total Products</h3>
                <p>
                    <?php echo $total_products; ?>
                </p>
            </div>


            <div class="card">
                <h3>Total Revenue</h3>
                <p>
                    TZS <?php echo number_format($total_revenue); ?>
                </p>
            </div>

            <div class="card">
                <h3>Customers</h3>
                <p>
                    <?php echo $total_customers; ?>
                </p>
            </div>
        </section>

        <section class="content-grid">
            <div class="table-box">
                <div class="section-header">
                    <h2>Products</h2>
                    <a href="add_product.php" class="btn">
                        Add Product
                    </a>
                </div>


                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if ($products && $products->num_rows > 0): ?>

                        <?php while ($product = $products->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $product["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($product["product_name"]); ?>
                                </td>

                                <td>
                                    TZS <?php echo number_format($product["buying_price"]); ?>
                                </td>

                                <td>
                                    TZS <?php echo number_format($product["selling_price"]); ?>
                                </td>

                                <td>
                                    <?php echo $product["quantity"]; ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5">
                                No products found
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <div class="table-box">

                <div class="section-header">

                    <h2>Customers</h2>

                    <a href="customers.php" class="btn">
                        View All
                    </a>

                </div>


                <table>

                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>

                    </thead>


                    <tbody>

                    <?php if ($customers && $customers->num_rows > 0): ?>

                        <?php while ($customer = $customers->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $customer["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($customer["name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($customer["email"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($customer["phone"]); ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="4">
                                No customers found
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
</body>
</html>