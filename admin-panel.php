<?php
session_start();
include 'config.php';

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $orderId);
    $stmt->execute();
}

// // Fetch current/pending orders
$currentOrders = $conn->query("SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.user_id WHERE status IN ('Pending', 'Processing')");

// // Fetch all orders for history
$orderHistory = $conn->query("SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.user_id ORDER BY order_time DESC");

// // Calculate total sales
$salesResult = $conn->query("SELECT SUM(total_amount) AS total_sales FROM orders WHERE status = 'Completed'");
$sales = $salesResult->fetch_assoc()['total_sales'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light admin">
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
                            <a class="nav-link active" href="logout.php">logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



<div class="container py-5">
    <h2 class="mb-4">Admin Panel</h2>

    <!-- Current Orders -->
    <div class="card mb-4">
        <div class="card-header">Current Orders</div>
        <div class="card-body">
            <?php if ($currentOrders->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Food</th>
                            <th>Add-ons</th>
                            <th>Status</th>
                            <th>Total (৳)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $currentOrders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['food_item']; ?></td>
                            <td><?php echo $row['addons']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo number_format($row['total_amount'], 2); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                    <select name="new_status" class="form-select form-select-sm d-inline w-auto">
                                        <option value="Pending">Pending</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No current orders.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Order History -->
    <div class="card mb-4">
        <div class="card-header">Order History</div>
        <div class="card-body">
            <?php if ($orderHistory->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Food</th>
                            <th>Add-ons</th>
                            <th>Status</th>
                            <th>Total (৳)</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $orderHistory->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['food_item']; ?></td>
                            <td><?php echo $row['addons']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo number_format($row['total_amount'], 2); ?></td>
                            <td><?php echo $row['order_time']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders in history.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Total Sales -->
    <div class="card">
        <div class="card-body text-center">
            <h4>Total Revenue: ৳<?php echo number_format($sales, 2); ?></h4>
        </div>
    </div>

</div>
</body>
</html>
