<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff' || !isset($_SESSION['restaurant_id'])) {
    die("Unauthorized.");
}

if (!isset($_GET['id'])) {
    die("Order ID required.");
}

$order_id = (int)$_GET['id'];
$restaurant_id = $_SESSION['restaurant_id'];

// Fetch order
$stmt = $pdo->prepare("SELECT o.*, t.table_number, r.name as restaurant_name, r.address, r.phone 
                       FROM orders o 
                       JOIN tables t ON o.table_id = t.id 
                       JOIN restaurants r ON o.restaurant_id = r.id 
                       WHERE o.id = ? AND o.restaurant_id = ?");
$stmt->execute([$order_id, $restaurant_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Order not found or access denied.");
}

// Fetch items
$stmt = $pdo->prepare("SELECT oi.quantity, m.name, oi.price 
                       FROM order_items oi 
                       JOIN menu_items m ON oi.menu_item_id = m.id 
                       WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order #<?= $order_id ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
            width: 300px; /* Thermal printer width approximation */
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 0; text-align: left; }
        th { border-bottom: 1px dashed #000; }
        .total-row td { border-top: 1px dashed #000; padding-top: 10px; font-weight: bold; font-size: 16px;}
        
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2 style="margin:0; font-size: 20px;"><?= htmlspecialchars($order['restaurant_name']) ?></h2>
        <p style="margin: 2px 0; font-size: 12px;"><?= htmlspecialchars($order['address']) ?></p>
        <p style="margin: 2px 0; font-size: 12px;">Tel: <?= htmlspecialchars($order['phone']) ?></p>
    </div>
    
    <div class="divider"></div>
    
    <div>
        <p style="margin: 2px 0;">Order #: <?= $order['id'] ?></p>
        <p style="margin: 2px 0;">Table: <?= htmlspecialchars($order['table_number']) ?></p>
        <p style="margin: 2px 0;">Date: <?= date('Y-m-d H:i', strtotime($order['created_at'])) ?></p>
    </div>
    
    <div class="divider"></div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 15%">Qty</th>
                <th style="width: 55%">Item</th>
                <th style="width: 30%" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['quantity'] ?></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td class="text-right">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="2">TOTAL</td>
                <td class="text-right">$<?= number_format($order['total_amount'], 2) ?></td>
            </tr>
        </tbody>
    </table>
    
    <div class="divider"></div>
    
    <div class="text-center">
        <p style="margin: 10px 0;">Thank you for your visit!</p>
        <p style="font-size: 10px;">Powered by HamroMenu</p>
    </div>
    
    <div class="no-print text-center" style="margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print Again</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Close</button>
    </div>
</body>
</html>
