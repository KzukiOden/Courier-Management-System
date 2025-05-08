<?php
session_start();

// Check if user is logged in and is a regular user
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../index.php");
    exit;
}

include '../includes/header.php';
?>

<h3 class="mt-4">Welcome, <?= $_SESSION['username'] ?></h3>
<p>This is your dashboard. You can track your courier using the form below or from the navbar.</p>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Track Your Courier</h5>
                <p class="card-text">Enter your tracking ID to check the current status of your shipment.</p>
                <a href="track.php" class="btn btn-primary">Go to Tracking Page</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Need Help?</h5>
                <p class="card-text">Contact our support team if you have any issues with your courier.</p>
                <a href="#" class="btn btn-outline-secondary">Contact Support</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>