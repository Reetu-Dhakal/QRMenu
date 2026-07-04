<?php
session_start();
require '../config/db.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 1. Check QR Code
if (isset($_GET['qr'])) {
    $qr = $_GET['qr'];
    $stmt = $pdo->prepare("SELECT t.id as table_id, t.restaurant_id, r.name as restaurant_name, t.table_number FROM tables t JOIN restaurants r ON t.restaurant_id = r.id WHERE t.qr_code = ?");
    $stmt->execute([$qr]);
    $table = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($table) {
        // Save to session
        $_SESSION['table_id'] = $table['table_id'];
        $_SESSION['restaurant_id'] = $table['restaurant_id'];
        $_SESSION['restaurant_name'] = $table['restaurant_name'];
        $_SESSION['table_number'] = $table['table_number'];
    } else {
        die("Invalid QR Code.");
    }
}

if (!isset($_SESSION['table_id']) || !isset($_SESSION['restaurant_id'])) {
    die("Please scan a valid table QR code to view the menu.");
}

$restaurant_id = $_SESSION['restaurant_id'];

// 2. Handle Cart Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_to_cart') {
        $item_id = (int)$_POST['item_id'];
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]++;
        } else {
            $_SESSION['cart'][$item_id] = 1;
        }
        header("Location: menu.php");
        exit;
    }
    elseif ($_POST['action'] === 'remove_from_cart') {
        $item_id = (int)$_POST['item_id'];
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]--;
            if ($_SESSION['cart'][$item_id] <= 0) {
                unset($_SESSION['cart'][$item_id]);
            }
        }
        header("Location: menu.php");
        exit;
    }
    elseif ($_POST['action'] === 'place_order') {
        if (!empty($_SESSION['cart'])) {
            // Calculate total and get items
            $total_amount = 0;
            $items_to_insert = [];
            
            $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
            $stmt = $pdo->prepare("SELECT id, price FROM menu_items WHERE id IN ($placeholders)");
            $stmt->execute(array_keys($_SESSION['cart']));
            $prices = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            foreach ($_SESSION['cart'] as $id => $quantity) {
                if (isset($prices[$id])) {
                    $price = $prices[$id];
                    $total_amount += ($price * $quantity);
                    $items_to_insert[] = ['id' => $id, 'qty' => $quantity, 'price' => $price];
                }
            }
            
            // Insert Order
            $stmt = $pdo->prepare("INSERT INTO orders (restaurant_id, table_id, status, total_amount) VALUES (?, ?, 'pending', ?)");
            $stmt->execute([$restaurant_id, $_SESSION['table_id'], $total_amount]);
            $order_id = $pdo->lastInsertId();
            
            // Insert Order Items
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($items_to_insert as $item) {
                $stmt->execute([$order_id, $item['id'], $item['qty'], $item['price']]);
            }
            
            // Clear cart
            $_SESSION['cart'] = [];
            
            // Redirect to confirm
            header("Location: order_confirm.php?order_id=$order_id");
            exit;
        }
    }
}

// 3. Fetch Menu Items Grouped by Category
$stmt = $pdo->prepare("SELECT * FROM menu_items WHERE restaurant_id = ? AND is_available = 1 ORDER BY category, name");
$stmt->execute([$restaurant_id]);
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped_menu = [];
foreach ($menu_items as $item) {
    $grouped_menu[$item['category']][] = $item;
}

// Fetch Cart Details for Display
$cart_items = [];
$cart_total = 0;
if (!empty($_SESSION['cart'])) {
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $stmt = $pdo->prepare("SELECT id, name, price FROM menu_items WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $cart_db_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($cart_db_items as $db_item) {
        $qty = $_SESSION['cart'][$db_item['id']];
        $cart_items[] = [
            'id' => $db_item['id'],
            'name' => $db_item['name'],
            'price' => $db_item['price'],
            'qty' => $qty,
            'subtotal' => $db_item['price'] * $qty
        ];
        $cart_total += ($db_item['price'] * $qty);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($_SESSION['restaurant_name']) ?> - Menu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .menu-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .category-title {
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
            padding-bottom: 5px;
            color: var(--text-main);
        }
        .cart-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--card-bg);
            box-shadow: 0 -4px 6px -1px rgba(0,0,0,0.1);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <div class="menu-hero">
            <div style="display:flex; justify-content:center; align-items:center; gap:12px; margin-bottom:8px; flex-wrap:wrap;">
                <img src="../assets/images/hamromenu-logo.png" alt="HamroMenu logo" style="width: 56px; height: 56px; border-radius: 16px; background: rgba(255,255,255,0.16); padding: 4px;">
                <h1><?= htmlspecialchars($_SESSION['restaurant_name']) ?></h1>
            </div>
            <div class="menu-chip">Table <?= htmlspecialchars($_SESSION['table_number']) ?> • Fresh picks ready to order</div>
        </div>

        <?php foreach ($grouped_menu as $category => $items): ?>
            <h2 class="category-title"><?= htmlspecialchars($category) ?></h2>
            <div class="grid grid-cols-2">
                <?php foreach ($items as $item): ?>
                    <div class="menu-item-card">
                        <div>
                            <h3 style="margin-bottom: 5px;"><?= htmlspecialchars($item['name']) ?></h3>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 10px;"><?= htmlspecialchars($item['description']) ?></p>
                            <span style="font-weight: 700; color: var(--text-main);">$<?= number_format($item['price'], 2) ?></span>
                        </div>
                        <div>
                            <form method="POST">
                                <input type="hidden" name="action" value="add_to_cart">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">Add</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <!-- Bottom Spacing for Cart -->
        <div style="height: 100px;"></div>
    </div>

    <!-- Floating Cart -->
    <?php if (!empty($cart_items)): ?>
    <div class="cart-fixed">
        <div>
            <h3 style="margin:0;">Your Cart</h3>
            <p style="margin:0; color: var(--text-muted);"><?= array_sum($_SESSION['cart']) ?> items | Total: $<?= number_format($cart_total, 2) ?></p>
        </div>
        <div style="display:flex; gap:10px;">
            <button onclick="document.getElementById('cartModal').style.display='block'" class="btn btn-secondary">View Cart</button>
            <form method="POST" style="margin:0;">
                <input type="hidden" name="action" value="place_order">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
    </div>

    <!-- Cart Modal (Simple) -->
    <div id="cartModal" class="cart-modal">
        <div class="modal-body">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; border-bottom:1px solid var(--border-color); padding-bottom:10px;">
                <h2>Your Order</h2>
                <button onclick="document.getElementById('cartModal').style.display='none'" style="border:none; background:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            
            <?php foreach ($cart_items as $c_item): ?>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:1px solid var(--border-color); padding-bottom:15px;">
                    <div>
                        <strong><?= htmlspecialchars($c_item['name']) ?></strong><br>
                        <span style="color:var(--text-muted)">$<?= number_format($c_item['price'], 2) ?></span>
                    </div>
                    <div style="display:flex; align-items:center; gap:15px;">
                        <form method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="remove_from_cart">
                            <input type="hidden" name="item_id" value="<?= $c_item['id'] ?>">
                            <button type="submit" class="btn btn-danger" style="padding:5px 10px;">-</button>
                        </form>
                        <span style="font-weight:bold;"><?= $c_item['qty'] ?></span>
                        <form method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="add_to_cart">
                            <input type="hidden" name="item_id" value="<?= $c_item['id'] ?>">
                            <button type="submit" class="btn btn-success" style="padding:5px 10px; background-color: var(--secondary-color); color:white; border:none; border-radius:var(--border-radius);">+</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div style="text-align:right; margin-top:20px;">
                <h3>Total: $<?= number_format($cart_total, 2) ?></h3>
                <form method="POST" style="margin-top:15px;">
                    <input type="hidden" name="action" value="place_order">
                    <button type="submit" class="btn btn-primary" style="width:100%;">Confirm & Place Order</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
