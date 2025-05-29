<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get current (latest) order
$currentOrderQuery = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_time DESC LIMIT 1");
$currentOrder = $currentOrderQuery->fetch_assoc();

// Get order history
$orderHistoryQuery = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Panel - Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="image/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
                    Delicious Bites
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav mx-4">
                        <li class="nav-item">
                            <a class="nav-link " href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu.html">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="logout.php">logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<div class="container py-5">
    <h2 class="mb-4">Welcome, <?php echo $_SESSION['name']; ?>!</h2>

    <div class="card mb-4">
        <div class="card-header">Current Order Status</div>
        <div class="card-body">
            <?php if ($currentOrder): ?>
                <p><strong>Food:</strong> <?php echo $currentOrder['food_item']; ?></p>
                <p><strong>Add-ons:</strong> <?php echo $currentOrder['addons']; ?></p>
                <p><strong>Status:</strong> <?php echo $currentOrder['status']; ?></p>
            <?php else: ?>
                <p>No current orders.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Order History</div>
        <div class="card-body">
            <?php if ($orderHistoryQuery->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Food Item</th>
                            <th>Add-ons</th>
                            <th>Status</th>
                            <th>Ordered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while($row = $orderHistoryQuery->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['food_item']; ?></td>
                            <td><?php echo $row['addons']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['order_time']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No order history found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
