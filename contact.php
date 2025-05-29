<?php
include 'config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "<script>alert('Message sent successfully!'); window.location='index.html';</script>";
} else {
    echo "<script>alert('Failed to send message.'); window.history.back();</script>";
}
?>
