<?php
require_once 'db.php';

if (!isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    header('Location: register.php');
    exit;
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$pdo = get_db_connection();

$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $password]);

header("Location: login.php");
exit;
?>
