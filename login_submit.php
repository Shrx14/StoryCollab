<?php
session_start();
require_once 'db.php';

if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: login.php');
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

$pdo = get_db_connection();

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: dashboard.php");
    exit;
} else {
    echo "Invalid login credentials.";
}
?>
