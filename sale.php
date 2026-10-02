<?php

include "connection.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    header("Location: login.php");
    exit;
}

$name = $_SESSION["name"];
$message = "";

if (isset($_POST["make_sale"])) {
    $product_id = intval($_POST["product_id"]);
    $quantity = intval($_POST["quantity"]);

    if ($product_id <= 0 || $quantity <= 0) {
        $message = "Please select a product and enter a valid quantity.";
    } else {
        $product_query = mysqli_query( $connection, "SELECT * FROM products WHERE id = $product_id");

        if ($product_query && mysqli_num_rows($product_query) == 1) {
            $product = mysqli_fetch_assoc($product_query);
            $buying_price = $product["buying_price"];
            $selling_price = $product["selling_price"];
            $stock = $product["quantity"];

            if ($quantity > $stock) {
                $message = "Not enough stock available.";
             } else {

    $total_amount = $selling_price * $quantity;
    $revenue = ($selling_price - $buying_price) * $quantity;

    $user_id = $_SESSION["user_id"];

    $sale_query = mysqli_query($connection, "INSERT INTO sales (user_id, total_amount, total_revenue)
     VALUES ($user_id, $total_amount, $revenue)");

    if ($sale_query) {
        $sale_id = mysqli_insert_id($connection);

        $insert = mysqli_query($connection, "INSERT INTO sale_items (sale_id, product_id, quantity, buying_price, selling_price, revenue)
            VALUES($sale_id, $product_id, $quantity, $buying_price, $selling_price, $revenue)" );

        if ($insert) {$update = mysqli_query( $connection, "UPDATE products SET quantity = quantity - $quantity
                 WHERE id = $product_id");
        if ($update) {
                $message = "Sale completed successfully.";
            } else {
                $message = "Sale recorded but stock update failed: " . mysqli_error($connection);
            }
        } else {
            $message = "Sale item failed: " . mysqli_error($connection);
        }
    } else {
        $message = "Sale failed: " . mysqli_error($connection);
    }
}
            }
        }
    }

$products = mysqli_query($connection, "SELECT id, product_name, product_image, buying_price, selling_price, quantity
     FROM products ORDER BY product_name ASC");

$total_sales = 0;
$result = mysqli_query($connection, "SELECT COALESCE(SUM(revenue), 0) AS total FROM sale_items");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_sales = $row["total"];
}

$sales = mysqli_query($connection, "SELECT sale_items.id, products.product_name, products.product_image, sale_items.quantity, products.buying_price,
        sale_items.selling_price,
        sale_items.revenue
     FROM sale_items
     INNER JOIN products
        ON sale_items.product_id = products.id
     ORDER BY sale_items.id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales - Inventory System</title>
    <link rel="stylesheet" href="customer.css">

</head>

<body>

<div class="dashboard">
    <aside class="sidebar">
        <h2>Inventory System</h2>
        <nav>
            <a href="customer_dashboard.php"> Dashboard</a>
            <a href="product.php">Products</a>
            <a href="sale.php" class="active">Sales</a>
            <a href="profile.php">Profile </a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Sales</h1>
                <p>
                    Create and monitor product sales
                </p>
            </div>

            <div class="user-profile">
                <?php echo htmlspecialchars($name); ?>
            </div>
        </header>

        <?php if ($message != "") { ?>

            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>

        <section class="form-box">
            <div class="section-header">
                <h2>Make a Sale</h2>

                <p>
                    Select a product and enter the quantity
                </p>
            </div>

            <form action="sale.php" method="POST" id="salesForm">
                <div class="product-preview">
                    <img id="product_image" src="" alt="Product Image">

                    <p id="image_text">
                        Select a product
                    </p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Select Product</label>

                        <select name="product_id" id="product_id" required>

                            <option value="">
                                -- Select Product --
                            </option>

                            <?php
                            if ($products && mysqli_num_rows($products) > 0) {
                                while ($product = mysqli_fetch_assoc($products)) {
                            ?>

                                <option
                                    value="<?php echo $product["id"]; ?>"
                                    data-image="<?php echo htmlspecialchars($product["product_image"]); ?>"
                                    data-buying="<?php echo $product["buying_price"]; ?>"
                                    data-selling="<?php echo $product["selling_price"]; ?>"
                                    data-stock="<?php echo $product["quantity"]; ?>">
                                    <?php echo htmlspecialchars($product["product_name"]); ?>
                                </option>

                            <?php

                                }

                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Available Stock</label>
                        <input type="text" id="available_stock" readonly placeholder="Stock">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Buying Price</label>
                        <input type="text" id="buying_price" readonly placeholder="Buying price" >
                    </div>

                    <div class="form-group">
                        <label>Selling Price</label>
                        <input type="text" id="selling_price" readonly placeholder="Selling price">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" id="quantity" min="1" requiredplaceholder="Enter quantity" >
                    </div>

                    <div class="form-group">
                        <label>Total Sales</label>
                        <input type="text" id="total_sales" readonly placeholder="TZS 0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Revenue</label>
                    <input type="text" id="revenue" readonly placeholder="TZS 0">
                </div>

                <button type="submit" name="make_sale" class="sale-btn">Make Sale </button>
            </form>
        </section>

        <section class="cards">

            <div class="card">

                <h3>Total Revenue</h3>

                <p>
                    TZS <?php echo number_format($total_sales); ?>
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
                        <th>ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Revenue</th>
                    </tr>
                </thead>

                <tbody>
                <?php

                if ($sales && mysqli_num_rows($sales) > 0) {

                    while ($sale = mysqli_fetch_assoc($sales)) {

                ?>

                    <tr>
                        <td>
                            <?php echo $sale["id"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($sale["product_name"]); ?>
                        </td>

                        <td>
                            <?php echo $sale["quantity"]; ?>
                        </td>

                        <td>
                            TZS <?php echo number_format($sale["buying_price"]); ?>
                        </td>

                        <td>
                            TZS <?php echo number_format($sale["selling_price"]); ?>
                        </td>

                        <td>
                            TZS <?php echo number_format($sale["revenue"]); ?>
                        </td>
                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>
                        <td colspan="6">
                            No sales records found.
                        </td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </section>
    </main>
</div>
<script>

const productSelect = document.getElementById("product_id");
const productImage = document.getElementById("product_image");
const imageText = document.getElementById("image_text");
const buyingPrice = document.getElementById("buying_price");
const sellingPrice = document.getElementById("selling_price");
const availableStock = document.getElementById("available_stock");
const quantity = document.getElementById("quantity");
const totalSales = document.getElementById("total_sales");
const revenue = document.getElementById("revenue");

productSelect.addEventListener("change", function () {
    const option = this.options[this.selectedIndex];

    if (!option.value) {

        productImage.style.display = "none";
        imageText.style.display = "block";

        buyingPrice.value = "";
        sellingPrice.value = "";
        availableStock.value = "";
        quantity.value = "";
        totalSales.value = "";
        revenue.value = "";

        return;
    }

    const image = option.dataset.image;

    if (image) {

        productImage.src = "uploads/" + image;
        productImage.style.display = "block";
        imageText.style.display = "none";

    } else {

        productImage.style.display = "none";
        imageText.style.display = "block";
    }

    buyingPrice.value =
        "TZS " +
        Number(option.dataset.buying).toLocaleString();

    sellingPrice.value =
        "TZS " +
        Number(option.dataset.selling).toLocaleString();

    availableStock.value =
        option.dataset.stock;

    quantity.value = "";
    totalSales.value = "";
    revenue.value = "";

});

quantity.addEventListener("input", function () {

    const option =
        productSelect.options[productSelect.selectedIndex];

    if (!option.value) {
        return;
    }

    const buying =
        Number(option.dataset.buying);

    const selling =
        Number(option.dataset.selling);

    const stock =
        Number(option.dataset.stock);

    const qty =
        Number(this.value);

    if (qty > stock) {

        this.setCustomValidity(
            "Quantity is greater than available stock."
        );

    } else {

        this.setCustomValidity("");

    }

    const total =
        selling * qty;

    const profit =
        (selling - buying) * qty;

    totalSales.value =
        "TZS " + total.toLocaleString();

    revenue.value =
        "TZS " + profit.toLocaleString();

});
</script>
</body>
</html>