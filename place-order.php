<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$food_item = $_POST['food_item'];
$addons = $_POST['addons'];
$status = "Pending";
$total_amount = $_POST['total_amount'];

$stmt = $conn->prepare("INSERT INTO orders (user_id, food_item, addons, status, total_amount, order_time) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isssd", $user_id, $food_item, $addons, $status, $total_amount);

if ($stmt->execute()) {
    echo "<script>alert('Order placed successfully!'); window.location='user-panel.php';</script>";
} else {
    echo "<script>alert('Failed to place order: " . $stmt->error . "'); window.history.back();</script>";
}
?>
