<?php
include"connection.php";

session_start();


if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

$users = $connection->query("SELECT id, name, email, phone, role FROM users ORDER BY id ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Inventory System</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>

        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="users.php" class="active">Users</a>
            <a href="products.php">Products</a>
            <a href="customers.php">Customers</a>
            <a href="sales.php">Sales</a>
            <a href="logout.php">Logout</a>
        </nav>

    </aside>
    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Users</h1>
                <p>
                    Manage system users
                </p>
            </div>

            <div class="admin-profile">
                 Admin
            </div>
        </header>

        <section class="table-box">
            <div class="section-header">
                <h2>All Users</h2>
            </div>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                </tr>
                </thead>


                <tbody>
                <?php if ($users && $users->num_rows > 0): ?>
                    <?php while ($user = $users->fetch_assoc()): ?>

                        <tr>
                            <td>
                                <?php echo $user["id"]; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["email"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["phone"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["role"]); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>

                    <tr>
                        <td colspan="5">
                            No users found
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