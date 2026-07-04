<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$pdo) {
        $error = 'The database server is currently unavailable. Please try again later.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['restaurant_id'] = $user['restaurant_id'];
                $_SESSION['name'] = $user['name'];

                if ($user['role'] === 'owner') {
                    header('Location: ../owner/dashboard.php');
                } elseif ($user['role'] === 'admin') {
                    header('Location: ../admin/dashboard.php');
                } else {
                    header('Location: ../staff/dashboard.php');
                }
                exit;
            } else {
                $error = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            error_log('Login query failed: ' . $e->getMessage());
            $error = 'Unable to sign in right now. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HamroMenu Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="brand-badge">
                <img src="../assets/images/hamromenu-logo.png" alt="HamroMenu logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <p class="eyebrow">Restaurant Management</p>
            <h2>Welcome back</h2>
            <p>Sign in to manage menus, tables, and orders effortlessly.</p>
            <?php if (isset($error)) echo "<p style='color:#dc2626; text-align:center; margin-bottom: 15px; font-weight:600;'>$error</p>"; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">Login</button>
            </form>
        </div>
    </div>
</body>
</html>