<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/track.php");
    }
    exit;
}
include 'includes/header.php';
?>

<div class="container text-center mt-5">
    <h2>Welcome to Courier Tracking System</h2>
    <p>Please <a href="auth/login.php">login</a> to continue.</p>
</div>

<?php include 'includes/footer.php'; ?>