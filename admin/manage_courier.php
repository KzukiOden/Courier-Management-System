<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

include '../includes/header.php';
include '../includes/db.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM couriers WHERE id = '$id'";
    $conn->query($sql);
    header("Location: manage_couriers.php");
    exit;
}

// Filter by status
$filter = "";
if (isset($_GET['status']) && in_array($_GET['status'], ['Pending', 'In Transit', 'Delivered', 'Cancelled'])) {
    $filter = "WHERE status = '" . $conn->real_escape_string($_GET['status']) . "'";
}

// Fetch all couriers
$sql = "SELECT * FROM couriers $filter ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<div class="container mt-5">
    <h3>Manage Couriers</h3>

    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <label for="status" class="form-label">Filter by Status:</label>
        <select name="status" id="status" class="form-select w-auto d-inline-block me-2" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="Pending" <?= ($_GET['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="In Transit" <?= ($_GET['status'] ?? '') === 'In Transit' ? 'selected' : '' ?>>In Transit</option>
            <option value="Delivered" <?= ($_GET['status'] ?? '') === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
            <option value="Cancelled" <?= ($_GET['status'] ?? '') === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <a href="manage_couriers.php" class="btn btn-secondary btn-sm">Reset</a>
    </form>

    <!-- Courier Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Tracking ID</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Status</th>
                    <th>Added On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['tracking_id']) ?></td>
                            <td><?= htmlspecialchars($row['sender_name']) ?></td>
                            <td><?= htmlspecialchars($row['receiver_name']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a href="edit_courier.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No couriers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="add_courier.php" class="btn btn-success">Add New Courier</a>
</div>

<?php include '../includes/footer.php'; ?>