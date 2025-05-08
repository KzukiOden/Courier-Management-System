<?php
// auth/register_process.php

session_start();
include '../includes/db.php';

$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);

if (empty($username) || empty($password)) {
    $error = "All fields are required.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// Check if username already exists
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $error = "Username already taken.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// Hash password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'user')";
if ($conn->query($sql) === TRUE) {
    $_SESSION['success'] = "Registration successful! Please log in.";
    header("Location: login.php");
} else {
    $error = "Error registering user.";
    header("Location: register.php?error=" . urlencode($error));
}

$conn->close();
exit;
?>