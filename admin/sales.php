<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'owner']) || !isset($_SESSION['restaurant_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$restaurant_id = $_SESSION['restaurant_id'];

// Fetch restaurant name
$stmt = $pdo->prepare("SELECT name FROM restaurants WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant_name = $stmt->fetchColumn();

// --- 1. Count Menu Items & Sort (PHP usort) ---
// Fetch all completed order items for this restaurant
$stmt = $pdo->prepare("
    SELECT oi.menu_item_id, oi.quantity, m.name 
    FROM order_items oi 
    JOIN orders o ON oi.order_id = o.id 
    JOIN menu_items m ON oi.menu_item_id = m.id 
    WHERE o.restaurant_id = ? AND o.status = 'completed'
");
$stmt->execute([$restaurant_id]);
$raw_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$item_counts = [];
foreach ($raw_sales as $sale) {
    $id = $sale['menu_item_id'];
    if (!isset($item_counts[$id])) {
        $item_counts[$id] = [
            'name' => $sale['name'],
            'total_qty' => 0
        ];
    }
    $item_counts[$id]['total_qty'] += $sale['quantity'];
}

// Convert associative array to indexed array for sorting
$sales_array = array_values($item_counts);

// Sort using usort with custom comparator (descending by total_qty)
usort($sales_array, function($a, $b) {
    return $b['total_qty'] - $a['total_qty']; // DESC
});

// Get top 5
$top_5_items = array_slice($sales_array, 0, 5);


// --- 2. Total Revenue per day ---
$stmt = $pdo->prepare("
    SELECT DATE(created_at) as order_date, SUM(total_amount) as daily_revenue 
    FROM orders 
    WHERE restaurant_id = ? AND status = 'completed' 
    GROUP BY DATE(created_at) 
    ORDER BY order_date DESC 
    LIMIT 7
");
$stmt->execute([$restaurant_id]);
$daily_revenues = $stmt->fetchAll(PDO::FETCH_ASSOC);


// --- 3. Peak Hour ---
$stmt = $pdo->prepare("
    SELECT HOUR(created_at) as order_hour, COUNT(*) as order_count 
    FROM orders 
    WHERE restaurant_id = ? 
    GROUP BY HOUR(created_at)
");
$stmt->execute([$restaurant_id]);
$hourly_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$peak_hour = null;
$max_orders = 0;
foreach ($hourly_stats as $stat) {
    if ($stat['order_count'] > $max_orders) {
        $max_orders = $stat['order_count'];
        $peak_hour = $stat['order_hour'];
    }
}

// Format peak hour nicely
if ($peak_hour !== null) {
    $formatted_peak_hour = str_pad($peak_hour, 2, '0', STR_PAD_LEFT) . ':00 - ' . str_pad(($peak_hour + 1) % 24, 2, '0', STR_PAD_LEFT) . ':00';
} else {
    $formatted_peak_hour = "N/A (No orders yet)";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - <?= htmlspecialchars($restaurant_name) ?></title>
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
                <a href="tables.php">Table Management</a>
                <a href="staff.php">Staff Management</a>
                <a href="sales.php" style="background-color: var(--sidebar-hover); color: #fff;">Sales Report</a>
                <?php if ($_SESSION['role'] === 'owner'): ?>
                    <a href="../owner/dashboard.php" style="color: var(--warning); margin-top: 20px;">&larr; Back to Owner</a>
                <?php endif; ?>
                <a href="../auth/logout.php" style="color: #FCA5A5; margin-top: auto;">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="topbar">
                <h1>Sales & Analytics Report</h1>
            </div>

            <div class="grid grid-cols-2">
                <!-- Peak Hour -->
                <div class="card" style="grid-column: span 2; display: flex; align-items: center; justify-content: space-between; background: linear-gradient(to right, var(--primary-color), var(--info)); color: white;">
                    <div>
                        <h2 style="margin-bottom: 5px; color: rgba(255,255,255,0.8);">Peak Ordering Hour</h2>
                        <div style="font-size: 2.5rem; font-weight: 700;"><?= $formatted_peak_hour ?></div>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 1.5rem; font-weight: 600;"><?= $max_orders ?> Orders</span>
                    </div>
                </div>

                <!-- Top 5 Selling Items -->
                <div class="card">
                    <div class="card-header">
                        <h2>Top 5 Selling Items (All Time)</h2>
                    </div>
                    <?php if (empty($top_5_items)): ?>
                        <p style="color: var(--text-muted); text-align: center; padding: 20px;">No sales data available yet.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Item Name</th>
                                        <th>Total Quantity Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rank = 1; foreach ($top_5_items as $item): ?>
                                    <tr>
                                        <td><strong>#<?= $rank++ ?></strong></td>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><span class="badge badge-success"><?= $item['total_qty'] ?> sold</span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Daily Revenue -->
                <div class="card">
                    <div class="card-header">
                        <h2>Daily Revenue (Last 7 Days)</h2>
                    </div>
                    <?php if (empty($daily_revenues)): ?>
                        <p style="color: var(--text-muted); text-align: center; padding: 20px;">No revenue data available yet.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($daily_revenues as $day): ?>
                                    <tr>
                                        <td><?= date('M j, Y', strtotime($day['order_date'])) ?></td>
                                        <td><strong>$<?= number_format($day['daily_revenue'], 2) ?></strong></td>
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
</body>
</html>
