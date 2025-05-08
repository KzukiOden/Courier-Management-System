<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

include '../../includes/db.php';

// Get courier ID from URL
if (!isset($_GET['id'])) {
    header("Location: manage_couriers.php");
    exit;
}

$id = $conn->real_escape_string($_GET['id']);

// Fetch courier data
$sql = "SELECT * FROM couriers WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    header("Location: manage_couriers.php");
    exit;
}

$courier = $result->fetch_assoc();

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_name = $conn->real_escape_string($_POST['sender_name']);
    $receiver_name = $conn->real_escape_string($_POST['receiver_name']);
    $pickup_address = $conn->real_escape_string($_POST['pickup_address']);
    $delivery_address = $conn->real_escape_string($_POST['delivery_address']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update query
    $sql = "UPDATE couriers SET
                sender_name = '$sender_name',
                receiver_name = '$receiver_name',
                pickup_address = '$pickup_address',
                delivery_address = '$delivery_address',
                status = '$status'
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $success = "Courier updated successfully!";
    } else {
        $error = "Error updating courier: " . $conn->error;
    }
}
?>

<div class="container mt-5">
    <h3>Edit Courier</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="sender_name" class="form-label">Sender Name</label>
                <input type="text" name="sender_name" id="sender_name" class="form-control" value="<?= htmlspecialchars($courier['sender_name']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="receiver_name" class="form-label">Receiver Name</label>
                <input type="text" name="receiver_name" id="receiver_name" class="form-control" value="<?= htmlspecialchars($courier['receiver_name']) ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="pickup_address" class="form-label">Pickup Address</label>
            <textarea name="pickup_address" id="pickup_address" class="form-control" rows="3" required><?= htmlspecialchars($courier['pickup_address']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="delivery_address" class="form-label">Delivery Address</label>
            <textarea name="delivery_address" id="delivery_address" class="form-control" rows="3" required><?= htmlspecialchars($courier['delivery_address']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Select Status --</option>
                <option value="Pending" <?= $courier['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Transit" <?= $courier['status'] === 'In Transit' ? 'selected' : '' ?>>In Transit</option>
                <option value="Delivered" <?= $courier['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                <option value="Cancelled" <?= $courier['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Courier</button>
        <a href="manage_couriers.php" class="btn btn-secondary">Cancel</a>
        <a href="add_courier.php" class="btn btn-outline-success">Add New</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>