<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Admin check
    if ($email === 'admin@gmail.com' && $password === 'admin') {
        $_SESSION['admin'] = true;
        header("Location: admin-panel.php");
        exit;
    }

    // Regular user check
    $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $name, $db_password);
        $stmt->fetch();

        if ($password === $db_password) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;
            header("Location: user-panel.php");
            exit;
        } else {
            echo "<script>alert('Invalid password'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location='login.html';</script>";
    }
}
?>
