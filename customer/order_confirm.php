<?php
session_start();
require '../config/db.php';

if (!isset($_GET['order_id'])) {
    die("Order not found.");
}

$order_id = (int)$_GET['order_id'];

// Fetch order details
$stmt = $pdo->prepare("SELECT o.*, t.table_number, r.name as restaurant_name 
                       FROM orders o 
                       JOIN tables t ON o.table_id = t.id 
                       JOIN restaurants r ON o.restaurant_id = r.id 
                       WHERE o.id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Order not found.");
}

// Calculate estimated wait time
// (count pending + preparing orders created before this one) * 5 mins
$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE restaurant_id = ? AND status IN ('pending', 'preparing') AND created_at <= ?");
$stmt->execute([$order['restaurant_id'], $order['created_at']]);
$queue_ahead = $stmt->fetchColumn();

// If the order itself is pending/preparing, it's included in the count, so $queue_ahead is at least 1.
// 5 minutes per order ahead.
$estimated_wait = $queue_ahead * 5;

// Status Badge mapping
$status_colors = [
    'pending' => 'badge-warning',
    'preparing' => 'badge-info',
    'ready' => 'badge-success',
    'completed' => 'badge-success',
    'cancelled' => 'badge-danger'
];

$status_texts = [
    'pending' => 'In Queue',
    'preparing' => 'Being Prepared',
    'ready' => 'Ready to Serve',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled'
];

$current_status = $status_texts[$order['status']] ?? 'Unknown';
$badge_class = $status_colors[$order['status']] ?? 'badge-info';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order['id'] ?> - <?= htmlspecialchars($order['restaurant_name']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <?php if (in_array($order['status'], ['pending', 'preparing'])): ?>
    <meta http-equiv="refresh" content="15"> <!-- Auto refresh every 15 seconds -->
    <?php endif; ?>
    <style>
        .confirm-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .status-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--bg-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid var(--primary-color);
        }
        .time-big {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <div class="card">
            <h1 style="color: var(--primary-color); margin-bottom: 5px;">Order Received!</h1>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Thank you for ordering at <?= htmlspecialchars($order['restaurant_name']) ?></p>
            
            <div class="status-circle">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600;">Order #</span><br>
                    <span style="font-size: 1.5rem; font-weight: 700;"><?= $order['id'] ?></span>
                </div>
            </div>

            <h2 style="margin-bottom: 10px;">Status: <span class="badge <?= $badge_class ?>" style="font-size: 1rem;"><?= $current_status ?></span></h2>
            <p>Table <?= htmlspecialchars($order['table_number']) ?></p>

            <?php if (in_array($order['status'], ['pending', 'preparing'])): ?>
                <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid var(--border-color);">
                    <p style="color: var(--text-muted); font-weight: 500; text-transform: uppercase; font-size: 0.9rem;">Estimated Wait Time</p>
                    <div class="time-big">~<?= $estimated_wait ?> mins</div>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 10px;">This page updates automatically every 15 seconds.</p>
                </div>
            <?php endif; ?>

            <?php if ($order['status'] === 'ready'): ?>
                <div style="margin-top: 30px; padding: 20px; background-color: #D1FAE5; color: #065F46; border-radius: var(--border-radius);">
                    <h3 style="margin-bottom: 5px;">Your food is ready!</h3>
                    <p>It will be served to your table shortly.</p>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="menu.php" class="btn btn-secondary">Order More Items</a>
        </div>
    </div>
</body>
</html>
