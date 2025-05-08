<?php
session_start();
include '../includes/db.php';

$username = $conn->real_escape_string($_POST['username']);
$password = $_POST['password']; // Don't hash here!

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify hashed password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit;
    }
}

$error = "Invalid username or password.";
header("Location: login.php?error=" . urlencode($error));
exit;
?>