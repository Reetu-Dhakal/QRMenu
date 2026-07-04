<?php
session_start();
require '../config/db.php';

// Check if user is logged in and is staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff' || !isset($_SESSION['restaurant_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$restaurant_id = $_SESSION['restaurant_id'];

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ? AND restaurant_id = ?");
    $stmt->execute([$new_status, $order_id, $restaurant_id]);
    
    header('Location: dashboard.php');
    exit;
}

// Fetch active orders (pending, preparing)
$stmt = $pdo->prepare("
    SELECT o.id, o.status, o.created_at, t.table_number 
    FROM orders o 
    JOIN tables t ON o.table_id = t.id 
    WHERE o.restaurant_id = ? AND o.status IN ('pending', 'preparing')
");
$stmt->execute([$restaurant_id]);
$raw_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch items for these orders
$order_ids = array_column($raw_orders, 'id');
$order_items = [];
if (!empty($order_ids)) {
    $in = str_repeat('?,', count($order_ids) - 1) . '?';
    $item_stmt = $pdo->prepare("
        SELECT oi.order_id, oi.quantity, m.name 
        FROM order_items oi 
        JOIN menu_items m ON oi.menu_item_id = m.id 
        WHERE oi.order_id IN ($in)
    ");
    $item_stmt->execute($order_ids);
    $items_raw = $item_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($items_raw as $item) {
        $order_items[$item['order_id']][] = $item['quantity'] . 'x ' . $item['name'];
    }
}

// Implement PHP array queue logic
$queue = [];
foreach ($raw_orders as $order) {
    $order['items'] = $order_items[$order['id']] ?? [];
    $queue[] = $order;
}

// Custom sort to enforce FIFO queue based on created_at ASC
usort($queue, function($a, $b) {
    return strtotime($a['created_at']) - strtotime($b['created_at']);
});

// Identify longest waiting (first item in the queue)
$longest_waiting_id = !empty($queue) ? $queue[0]['id'] : null;

// Helper to calculate time elapsed
function timeElapsedString($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->h > 0) return $diff->h . 'h ' . $diff->i . 'm ago';
    if ($diff->i > 0) return $diff->i . 'm ' . $diff->s . 's ago';
    return $diff->s . 's ago';
}

// Fetch restaurant name for header
$stmt = $pdo->prepare("SELECT name FROM restaurants WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant_name = $stmt->fetchColumn();

// Status progression map
$next_status = [
    'pending' => 'preparing',
    'preparing' => 'ready',
    'ready' => 'completed'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - <?= htmlspecialchars($restaurant_name) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta http-equiv="refresh" content="30"> <!-- Auto refresh queue every 30 seconds -->
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <?= htmlspecialchars($restaurant_name) ?>
            </div>
            <div class="sidebar-nav">
                <a href="dashboard.php" style="background-color: var(--sidebar-hover); color: #fff;">Order Queue</a>
                <a href="../auth/logout.php" style="color: #FCA5A5; margin-top: auto;">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="topbar">
                <h1>Active Order Queue</h1>
                <div class="user-info">
                    <span>Staff: <?= htmlspecialchars($_SESSION['name']) ?></span>
                </div>
            </div>

            <?php if (empty($queue)): ?>
                <div class="card" style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <h2>No active orders right now!</h2>
                    <p>The queue is empty.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-2">
                    <?php foreach ($queue as $order): ?>
                        <div class="card <?= ($order['id'] === $longest_waiting_id) ? 'longest-wait' : '' ?>">
                            <div class="card-header" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                                <div style="display:flex; justify-content:space-between; width:100%; align-items:center;">
                                    <h2 style="font-size: 1.5rem;">Table <?= htmlspecialchars($order['table_number']) ?></h2>
                                    <span class="badge <?= $order['status'] === 'pending' ? 'badge-warning' : 'badge-info' ?>">
                                        <?= strtoupper($order['status']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div style="margin-top: 15px; margin-bottom: 15px; padding-top:15px; border-top: 1px solid var(--border-color);">
                                <strong style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">Items Ordered:</strong>
                                <ul style="list-style-type: none; padding-left: 0; margin-top: 5px;">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <li style="font-size: 1.1rem; padding: 4px 0;">&bull; <?= htmlspecialchars($item) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                <div style="color: var(--text-muted); font-weight: 500;">
                                    Waited: <span style="color: <?= ($order['id'] === $longest_waiting_id) ? 'var(--danger)' : 'var(--text-main)' ?>; font-weight: 700;"><?= timeElapsedString($order['created_at']) ?></span>
                                </div>
                                
                                <div>
                                    <div style="display:flex; gap:10px;">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                            <input type="hidden" name="new_status" value="<?= $next_status[$order['status']] ?>">
                                            <button type="submit" class="btn btn-primary">
                                                Mark as <?= ucfirst($next_status[$order['status']]) ?>
                                            </button>
                                        </form>
                                        <a href="receipt.php?id=<?= $order['id'] ?>" target="_blank" class="btn btn-secondary">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>