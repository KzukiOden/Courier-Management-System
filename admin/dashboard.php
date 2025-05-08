<?php
include('../includes/header.php');
include('../includes/db.php');

// Fetch courier statistics
$total = $pending = $transit = $delivered = $cancelled = 0;

$sql = "SELECT status, COUNT(*) as count FROM couriers GROUP BY status";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    switch ($row['status']) {
        case 'Pending': $pending = $row['count']; break;
        case 'In Transit': $transit = $row['count']; break;
        case 'Delivered': $delivered = $row['count']; break;
        case 'Cancelled': $cancelled = $row['count']; break;
    }
    $total += $row['count'];
}
?>

<div class="container mt-5">
    <h3 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)</h3>

    <div class="row text-white">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Couriers</h5>
                    <h3 class="card-text"><?php echo $total; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Pending</h5>
                    <h3 class="card-text"><?php echo $pending; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info">
                <div class="card-body text-center">
                    <h5 class="card-title">In Transit</h5>
                    <h3 class="card-text"><?php echo $transit; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Delivered</h5>
                    <h3 class="card-text"><?php echo $delivered; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <a href="add_courier.php" class="btn btn-outline-primary">Add New Courier</a>
            <a href="manage_couriers.php" class="btn btn-outline-secondary">Manage Couriers</a>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
