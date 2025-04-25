<?php
require_once 'auth.php';
require_once 'db.php';

header('Content-Type: application/json');

$pdo = get_db_connection();

function isAdmin($userId, $pdo) {
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    return $user && $user['is_admin'];
}

if (!isLoggedIn() || !isAdmin($_SESSION['user_id'], $pdo)) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

$userId = $_POST['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['error' => 'User ID is required']);
    exit();
}

try {
    // Ban user by setting banned flag or deleting user
    $stmt = $pdo->prepare("UPDATE users SET banned = 1 WHERE id = ?");
    $stmt->execute([$userId]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
