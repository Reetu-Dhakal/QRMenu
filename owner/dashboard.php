<?php
session_start();
require '../config/db.php';

// Check if user is logged in and is an owner
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header('Location: ../auth/login.php');
    exit;
}

// Handle adding a new restaurant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_restaurant') {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    
    if ($name && $address && $phone) {
        $stmt = $pdo->prepare("INSERT INTO restaurants (name, address, phone) VALUES (?, ?, ?)");
        $stmt->execute([$name, $address, $phone]);
        header('Location: dashboard.php?msg=added');
        exit;
    }
}

// Handle login as admin for a specific restaurant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'manage_restaurant') {
    $restaurant_id = $_POST['restaurant_id'] ?? null;
    if ($restaurant_id) {
        $_SESSION['restaurant_id'] = $restaurant_id; // Set context to this restaurant
        header('Location: ../admin/dashboard.php');
        exit;
    }
}

// Fetch all restaurants with total orders and revenue
$query = "
    SELECT r.id, r.name, r.address, r.phone, r.is_active,
           COUNT(o.id) as total_orders,
           COALESCE(SUM(o.total_amount), 0) as total_revenue
    FROM restaurants r
    LEFT JOIN orders o ON r.id = o.restaurant_id AND o.status = 'completed'
    GROUP BY r.id
    ORDER BY r.created_at DESC
";
$stmt = $pdo->query($query);
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - HamroMenu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                HamroMenu
            </div>
            <div class="sidebar-nav">
                <a href="dashboard.php">Restaurants</a>
                <a href="../auth/logout.php" style="color: #FCA5A5; margin-top: auto;">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="topbar">
                <h1>Owner Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
                </div>
            </div>

            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'added'): ?>
                <div style="background-color: #D1FAE5; color: #065F46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    Restaurant added successfully!
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-3">
                <!-- Add New Restaurant Form -->
                <div class="card" style="grid-column: span 1;">
                    <div class="card-header">
                        <h2>Add New Restaurant</h2>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_restaurant">
                        <div class="form-group">
                            <label>Restaurant Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Add Restaurant</button>
                    </form>
                </div>

                <!-- Restaurants List -->
                <div class="card" style="grid-column: span 2;">
                    <div class="card-header">
                        <h2>All Restaurants</h2>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address/Phone</th>
                                    <th>Total Orders</th>
                                    <th>Total Revenue</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($restaurants) > 0): ?>
                                    <?php foreach ($restaurants as $restaurant): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($restaurant['name']) ?></strong></td>
                                        <td>
                                            <?= htmlspecialchars($restaurant['address']) ?><br>
                                            <small style="color: #6B7280;"><?= htmlspecialchars($restaurant['phone']) ?></small>
                                        </td>
                                        <td><span class="badge badge-info"><?= $restaurant['total_orders'] ?></span></td>
                                        <td><strong>$<?= number_format($restaurant['total_revenue'], 2) ?></strong></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="manage_restaurant">
                                                <input type="hidden" name="restaurant_id" value="<?= $restaurant['id'] ?>">
                                                <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.8rem;">Manage</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center;">No restaurants found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>