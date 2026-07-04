<?php
require 'config/db.php';

// Check if users exist
$stmt = $pdo->query("SELECT id, email, password, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Users in database:</h3>";
foreach ($users as $user) {
    echo "ID: " . $user['id'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Role: " . $user['role'] . "<br>";
    echo "Password hash: " . $user['password'] . "<br>";
    
    // Test password verify
    $test = password_verify('password123', $user['password']);
    echo "Does 'password123' match? " . ($test ? 'YES' : 'NO') . "<br>";
    echo "---<br>";
}

// Generate a fresh working hash
$fresh_hash = password_hash('password123', PASSWORD_DEFAULT);
echo "<h3>Fresh hash to use:</h3>";
echo $fresh_hash;

// Update all users with this fresh hash
$pdo->prepare("UPDATE users SET password = ? WHERE id IN (1,2,3)")
    ->execute([$fresh_hash]);
echo "<br><br>All user passwords updated to 'password123'";
?>