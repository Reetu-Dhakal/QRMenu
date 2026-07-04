<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'owner']) || !isset($_SESSION['restaurant_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$restaurant_id = $_SESSION['restaurant_id'];

// Fetch restaurant name for header and QR generation
$stmt = $pdo->prepare("SELECT name FROM restaurants WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant_name = $stmt->fetchColumn();
$restaurant_prefix = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $restaurant_name));

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $table_number = $_POST['table_number'];
        $qr_code = $restaurant_prefix . '-TABLE-' . str_pad($table_number, 3, '0', STR_PAD_LEFT);
        
        // Ensure table number doesn't exist for this restaurant
        $check = $pdo->prepare("SELECT id FROM tables WHERE restaurant_id = ? AND table_number = ?");
        $check->execute([$restaurant_id, $table_number]);
        if (!$check->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO tables (restaurant_id, table_number, qr_code) VALUES (?, ?, ?)");
            $stmt->execute([$restaurant_id, $table_number, $qr_code]);
        }
    } 
    elseif ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM tables WHERE id=? AND restaurant_id=?");
        $stmt->execute([$_POST['id'], $restaurant_id]);
    }
    header('Location: tables.php');
    exit;
}

// Fetch Tables
$stmt = $pdo->prepare("SELECT * FROM tables WHERE restaurant_id = ? ORDER BY table_number");
$stmt->execute([$restaurant_id]);
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Management - <?= htmlspecialchars($restaurant_name) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <?= htmlspecialchars($restaurant_name) ?>
            </div>
            <div class="sidebar-nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="menu.php">Menu Management</a>
                <a href="tables.php" style="background-color: var(--sidebar-hover); color: #fff;">Table Management</a>
                <a href="staff.php">Staff Management</a>
                <a href="sales.php">Sales Report</a>
                <?php if ($_SESSION['role'] === 'owner'): ?>
                    <a href="../owner/dashboard.php" style="color: var(--warning); margin-top: 20px;">&larr; Back to Owner</a>
                <?php endif; ?>
                <a href="../auth/logout.php" style="color: #FCA5A5; margin-top: auto;">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="topbar">
                <h1>Table Management</h1>
            </div>

            <div class="grid grid-cols-3">
                <!-- Add Form -->
                <div class="card" style="grid-column: span 1;">
                    <div class="card-header">
                        <h2>Add New Table</h2>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label>Table Number</label>
                            <input type="number" name="table_number" class="form-control" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Add Table</button>
                    </form>
                </div>

                <!-- List Items -->
                <div class="card" style="grid-column: span 2;">
                    <div class="card-header">
                        <h2>Tables</h2>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Table Number</th>
                                    <th>QR Code (URL Parameter)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tables as $table): ?>
                                <tr>
                                    <td><strong>Table <?= htmlspecialchars($table['table_number']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($table['qr_code']) ?></code></td>
                                    <td>
                                        <form method="POST" onsubmit="return confirm('Delete this table?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $table['id'] ?>">
                                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
