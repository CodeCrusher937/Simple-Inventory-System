<?php

include"connection.php";

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

$total_customers = 0;
$result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_customers = $row["total"];
}

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
                <h1>Customers</h1>
                <p>Manage customers</p>
            </div>

            <div class="admin-profile">
                Admin
            </div>
        </header>


        <section class="cards">
            <div class="card">
                <h3>Customers</h3>
                <p><?php echo $total_customers; ?></p>
            </div>
        </section>

        <section class="content-grid">
            <div class="table-box">
                <div class="section-header">
                    <h2>Customers</h2>
                    <a href="add_customer.php" class="btn" name="add_customer"> +Add Customers </a>
                </div>


                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>

                    <?php if ($customers && $customers->num_rows > 0): ?>

                        <?php while ($customer = $customers->fetch_assoc()): ?>

                            <tr>
                                <td><?php echo $customer["id"]; ?></td>
                                <td><?php echo htmlspecialchars($customer["name"]); ?> </td>
                                <td><?php echo htmlspecialchars($customer["email"]); ?></td>
                                <td><?php echo htmlspecialchars($customer["phone"]); ?></td>
                                
                    <td><a href="edit.php?id=<?php echo $customer["id"]; ?>" class="btn">Edit </a>
                    <a href="customers.php?delete=<?php echo $customer["id"]; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this customer?');">
                     Delete </a>
                    </td>
                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6">No customers found. <br><br> 
                            <a href="add_customer.php" class="btn">Add Customers </a>
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