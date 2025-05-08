<?php
session_start();

// Check if user is logged in and is a regular user
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

include '../includes/header.php';
include '../includes/db.php';

$results = [];
$error = "";
$searchPerformed = false;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $searchPerformed = true;

    $tracking_id = $conn->real_escape_string($_GET['tracking_id'] ?? '');
    $sender = $conn->real_escape_string($_GET['sender'] ?? '');
    $receiver = $conn->real_escape_string($_GET['receiver'] ?? '');
    $start_date = $conn->real_escape_string($_GET['start_date'] ?? '');
    $end_date = $conn->real_escape_string($_GET['end_date'] ?? '');

    // Build SQL query dynamically
    $conditions = [];

    if (!empty($tracking_id)) {
        $conditions[] = "tracking_id LIKE '%$tracking_id%'";
    }
    if (!empty($sender)) {
        $conditions[] = "sender_name LIKE '%$sender%'";
    }
    if (!empty($receiver)) {
        $conditions[] = "receiver_name LIKE '%$receiver%'";
    }
    if (!empty($start_date)) {
        $conditions[] = "created_at >= '$start_date'";
    }
    if (!empty($end_date)) {
        $end_date .= " 23:59:59";
        $conditions[] = "created_at <= '$end_date'";
    }

    $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

    $sql = "SELECT * FROM couriers $whereClause ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    } else {
        $error = "No matching courier found.";
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Track Your Courier</h3>

                    <!-- Advanced Search Form -->
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="tracking_id" class="form-control" placeholder="Tracking ID" 
                                       value="<?= isset($_GET['tracking_id']) ? htmlspecialchars($_GET['tracking_id']) : '' ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="sender" class="form-control" placeholder="Sender Name" 
                                       value="<?= isset($_GET['sender']) ? htmlspecialchars($_GET['sender']) : '' ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="receiver" class="form-control" placeholder="Receiver Name" 
                                       value="<?= isset($_GET['receiver']) ? htmlspecialchars($_GET['receiver']) : '' ?>">
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="date" name="start_date" class="form-control" 
                                           value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
                                    <input type="date" name="end_date" class="form-control" 
                                           value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- Results Count -->
                    <?php if (!empty($results)): ?>
                        <p class="text-muted mb-3"><?= count($results) ?> result(s) found.</p>
                    <?php endif; ?>

                    <!-- Error Message -->
                    <?php if ($error && $searchPerformed): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <!-- Results Table -->
                    <?php if (!empty($results)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tracking ID</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Status</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $courier): 
                                        // Set badge class based on status
                                        $statusClass = '';
                                        switch ($courier['status']) {
                                            case 'Delivered':
                                                $statusClass = 'bg-success';
                                                break;
                                            case 'In Transit':
                                                $statusClass = 'bg-primary';
                                                break;
                                            case 'Pending':
                                                $statusClass = 'bg-warning text-dark';
                                                break;
                                            default:
                                                $statusClass = 'bg-secondary';
                                        }
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($courier['tracking_id']) ?></td>
                                            <td><?= htmlspecialchars($courier['sender_name']) ?></td>
                                            <td><?= htmlspecialchars($courier['receiver_name']) ?></td>
                                            <td>
                                                <span class="badge <?= $statusClass ?>">
                                                    <?= htmlspecialchars($courier['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('d M Y, h:i A', strtotime($courier['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>