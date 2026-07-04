<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'owner']) || !isset($_SESSION['restaurant_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$restaurant_id = $_SESSION['restaurant_id'];

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $stmt = $pdo->prepare("INSERT INTO menu_items (restaurant_id, name, description, price, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$restaurant_id, $_POST['name'], $_POST['description'], $_POST['price'], $_POST['category']]);
    } 
    elseif ($_POST['action'] === 'edit') {
        $stmt = $pdo->prepare("UPDATE menu_items SET name=?, description=?, price=?, category=? WHERE id=? AND restaurant_id=?");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['id'], $restaurant_id]);
    }
    elseif ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id=? AND restaurant_id=?");
        $stmt->execute([$_POST['id'], $restaurant_id]);
    }
    elseif ($_POST['action'] === 'toggle') {
        $stmt = $pdo->prepare("UPDATE menu_items SET is_available = NOT is_available WHERE id=? AND restaurant_id=?");
        $stmt->execute([$_POST['id'], $restaurant_id]);
    }
    header('Location: menu.php');
    exit;
}

// Fetch Menu Items
$stmt = $pdo->prepare("SELECT * FROM menu_items WHERE restaurant_id = ? ORDER BY category, name");
$stmt->execute([$restaurant_id]);
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch restaurant name for header
$stmt = $pdo->prepare("SELECT name FROM restaurants WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant_name = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - <?= htmlspecialchars($restaurant_name) ?></title>
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
                <a href="menu.php" style="background-color: var(--sidebar-hover); color: #fff;">Menu Management</a>
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
                <h1>Menu Management</h1>
            </div>

            <div class="grid grid-cols-3">
                <!-- Add Form -->
                <div class="card" style="grid-column: span 1;">
                    <div class="card-header">
                        <h2>Add Menu Item</h2>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Add Item</button>
                    </form>
                </div>

                <!-- List Items -->
                <div class="card" style="grid-column: span 2;">
                    <div class="card-header">
                        <h2>Menu Items</h2>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menu_items as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                                        <small style="color: var(--text-muted)"><?= htmlspecialchars($item['description']) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($item['category']) ?></td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td>
                                        <span class="badge <?= $item['is_available'] ? 'badge-success' : 'badge-danger' ?>">
                                            <?= $item['is_available'] ? 'Available' : 'Out of Stock' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex; gap:5px;">
                                            <form method="POST">
                                                <input type="hidden" name="action" value="toggle">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn <?= $item['is_available'] ? 'btn-warning' : 'btn-success' ?>" style="padding: 5px; font-size: 0.75rem;">
                                                    Toggle
                                                </button>
                                            </form>
                                            <button onclick="editItem(<?= htmlspecialchars(json_encode($item)) ?>)" class="btn btn-info" style="padding: 5px; font-size: 0.75rem; background-color: var(--info); color: white; border: none; cursor: pointer; border-radius: var(--border-radius);">Edit</button>
                                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-danger" style="padding: 5px; font-size: 0.75rem;">Del</button>
                                            </form>
                                        </div>
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

    <!-- Edit Modal Script (Simple implementation) -->
    <script>
    function editItem(item) {
        let newName = prompt("Edit Item Name:", item.name);
        if (newName === null) return;
        let newCat = prompt("Edit Category:", item.category);
        if (newCat === null) return;
        let newPrice = prompt("Edit Price:", item.price);
        if (newPrice === null) return;
        let newDesc = prompt("Edit Description:", item.description);
        if (newDesc === null) return;

        let form = document.createElement('form');
        form.method = 'POST';
        
        let actions = { action: 'edit', id: item.id, name: newName, category: newCat, price: newPrice, description: newDesc };
        for (let key in actions) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = actions[key];
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
    }
    </script>
</body>
</html>
