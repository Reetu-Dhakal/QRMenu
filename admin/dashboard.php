<?php
session_start();
require '../config/db.php';

// Allow both admin and owner (when managing a specific restaurant)
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'owner'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (!isset($_SESSION['restaurant_id'])) {
    // If owner somehow gets here without selecting a restaurant
    if ($_SESSION['role'] === 'owner') {
        header('Location: ../owner/dashboard.php');
        exit;
    }
    header('Location: ../auth/login.php');
    exit;
}

$restaurant_id = $_SESSION['restaurant_id'];

// Get restaurant info
$stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant = $stmt->fetch();

// Get summary stats
$stats = [];

// Total Menu Items
$stmt = $pdo->prepare("SELECT COUNT(*) FROM menu_items WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
$stats['menu_items'] = $stmt->fetchColumn();

// Total Tables
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tables WHERE restaurant_id = ?");
$stmt->execute([$restaurant_id]);
$stats['tables'] = $stmt->fetchColumn();

// Active Orders (Pending or Preparing)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE restaurant_id = ? AND status IN ('pending', 'preparing')");
$stmt->execute([$restaurant_id]);
$stats['active_orders'] = $stmt->fetchColumn();

// Total Staff
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE restaurant_id = ? AND role = 'staff'");
$stmt->execute([$restaurant_id]);
$stats['staff_count'] = $stmt->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= htmlspecialchars($restaurant['name']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <?= htmlspecialchars($restaurant['name']) ?>
            </div>
            <div class="sidebar-nav">
                <a href="dashboard.php" style="background-color: var(--sidebar-hover); color: #fff;">Dashboard</a>
                <a href="menu.php">Menu Management</a>
                <a href="tables.php">Table Management</a>
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
                <div style="display:flex; align-items:center; gap:14px;">
                    <img src="../assets/images/hamromenu-logo.png" alt="HamroMenu logo" style="width: 46px; height: 46px; border-radius: 12px; box-shadow: 0 8px 18px rgba(15,23,42,0.12);">
                    <div>
                        <p class="eyebrow">Operations Overview</p>
                        <h1>Admin Overview</h1>
                    </div>
                </div>
                <div class="user-info">
                    <div class="user-pill">
                        <div class="user-avatar"><?= strtoupper(substr($_SESSION['name'], 0, 1)) ?></div>
                        <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-4">
                <div class="stat-card">
                    <div class="stat-title">Menu Items</div>
                    <div class="stat-value"><?= $stats['menu_items'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Tables</div>
                    <div class="stat-value"><?= $stats['tables'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Active Orders</div>
                    <div class="stat-value text-warning"><?= $stats['active_orders'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Staff Members</div>
                    <div class="stat-value"><?= $stats['staff_count'] ?></div>
                </div>
            </div>
            
            <div class="card" style="margin-top: 30px;">
                <div class="card-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="grid grid-cols-3">
                    <a href="menu.php" class="btn btn-primary">Manage Menu</a>
                    <a href="tables.php" class="btn btn-secondary">Manage Tables</a>
                    <a href="staff.php" class="btn btn-primary" style="background-color: var(--info)">Manage Staff</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>