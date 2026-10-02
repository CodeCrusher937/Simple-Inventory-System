<?php

include"connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

$total_sales = 0;
$result = mysqli_query($connection, "SELECT COALESCE(SUM(revenue), 0) AS total FROM sale_items");

if ($result) {
    $row = $result->fetch_assoc();
    $total_sales = $row["total"];
}

$sales = mysqli_query($connection, "SELECT * FROM sale_items ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales - Inventory System</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>
        <nav>
            <a href="admin_dashboard.php">Dashboard </a>
            <a href="users.php">Users</a>
            <a href="products.php">Products</a>
            <a href="customers.php">Customers</a>
            <a href="sales.php" class="active">Sales</a>
            <a href="logout.php"> Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Sales</h1>
                <p>
                    Monitor inventory sales and revenue
                </p>
            </div>
            <div class="admin-profile">
                Admin
            </div>
        </header>

        <section class="cards">
            <div class="card">
                <h3>Total Revenue</h3>
                <p>
                    TZS
                    <?php echo number_format($total_sales); ?>
                </p>
            </div>
        </section>

        <section class="table-box">
            <div class="section-header">
                <h2>Sales Records</h2>
            </div>
            <table>
                <thead>
                <tr>
                    <?php

                    if ($sales && $sales->num_rows > 0) {

                        $fields = $sales->fetch_fields();

                        foreach ($fields as $field) {
                            echo "<th>";
                            echo htmlspecialchars($field->name);
                            echo "</th>";
                        }
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($sale = $sales->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($fields as $field) {
                                $value = $sale[$field->name];
                                echo "<td>";

                                if ($field->name === "revenue") {
                                    echo "TZS " .
                                         number_format($value);

                                } else {
                                    echo htmlspecialchars($value);
                                }
                                echo "</td>";
                            }
                            echo "</tr>";
                        }

                    } else {

                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td colspan='10'>";
                        echo "No sales records found";
                        echo "</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>