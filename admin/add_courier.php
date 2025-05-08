<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

include '../includes/header.php';
include '../includes/db.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_name = $conn->real_escape_string($_POST['sender_name']);
    $receiver_name = $conn->real_escape_string($_POST['receiver_name']);
    $pickup_address = $conn->real_escape_string($_POST['pickup_address']);
    $delivery_address = $conn->real_escape_string($_POST['delivery_address']);
    $status = $conn->real_escape_string($_POST['status']);

    // Generate unique tracking ID
    $tracking_id = "CR" . rand(1000, 9999);

    // Insert into database
    $sql = "INSERT INTO couriers (tracking_id, sender_name, receiver_name, pickup_address, delivery_address, status)
            VALUES ('$tracking_id', '$sender_name', '$receiver_name', '$pickup_address', '$delivery_address', '$status')";

    if ($conn->query($sql) === TRUE) {
        $success = "Courier added successfully! Tracking ID: <strong>$tracking_id</strong>";
    } else {
        $error = "Error adding courier: " . $conn->error;
    }
}
?>

<h3 class="mt-4">Add New Courier</h3>

<?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="sender_name" class="form-label">Sender Name</label>
            <input type="text" name="sender_name" id="sender_name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="receiver_name" class="form-label">Receiver Name</label>
            <input type="text" name="receiver_name" id="receiver_name" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="pickup_address" class="form-label">Pickup Address</label>
        <textarea name="pickup_address" id="pickup_address" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="delivery_address" class="form-label">Delivery Address</label>
        <textarea name="delivery_address" id="delivery_address" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            <option value="">-- Select Status --</option>
            <option value="Pending">Pending</option>
            <option value="In Transit">In Transit</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Courier</button>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</form>

<?php include '../includes/footer.php'; ?>