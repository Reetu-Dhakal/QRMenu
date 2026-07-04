<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'owner']) || !isset($_SESSION['restaurant_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$restaurant_id = $_SESSION['restaurant_id'];

// Fetch restaurant name for header
$stmt = $pdo->prepare("SELECT name FROM restaurants WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant_name = $stmt->fetchColumn();

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Ensure email doesn't exist globally (unique constraint)
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if (!$check->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO users (restaurant_id, name, email, password, role) VALUES (?, ?, ?, ?, 'staff')");
            $stmt->execute([$restaurant_id, $name, $email, $password]);
        }
    } 
    elseif ($_POST['action'] === 'delete') {
        // Only delete staff belonging to this restaurant
        $stmt = $pdo->prepare("DELETE FROM users WHERE id=? AND restaurant_id=? AND role='staff'");
        $stmt->execute([$_POST['id'], $restaurant_id]);
    }
    header('Location: staff.php');
    exit;
}

// Fetch Staff
$stmt = $pdo->prepare("SELECT * FROM users WHERE restaurant_id = ? AND role = 'staff' ORDER BY name");
$stmt->execute([$restaurant_id]);
$staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management - <?= htmlspecialchars($restaurant_name) ?></title>
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
                <a href="staff.php" style="background-color: var(--sidebar-hover); color: #fff;">Staff Management</a>
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
                <h1>Staff Management</h1>
            </div>

            <div class="grid grid-cols-3">
                <!-- Add Form -->
                <div class="card" style="grid-column: span 1;">
                    <div class="card-header">
                        <h2>Add New Staff</h2>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Add Staff</button>
                    </form>
                </div>

                <!-- List Items -->
                <div class="card" style="grid-column: span 2;">
                    <div class="card-header">
                        <h2>Staff Members</h2>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staff_members as $staff): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($staff['name']) ?></strong></td>
                                    <td><?= htmlspecialchars($staff['email']) ?></td>
                                    <td><?= htmlspecialchars($staff['created_at']) ?></td>
                                    <td>
                                        <form method="POST" onsubmit="return confirm('Delete this staff member?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $staff['id'] ?>">
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
