<?php
require_once 'db.php';

if (!isset($_POST['title'], $_POST['content'], $_POST['user_id'])) {
    header('Location: create_story.php');
    exit;
}

$title = $_POST['title'];
$content = $_POST['content'];
$user_id = (int)$_POST['user_id'];

$pdo = get_db_connection();

$stmt = $pdo->prepare("INSERT INTO stories (title, content, user_id) VALUES (?, ?, ?)");
$stmt->execute([$title, $content, $user_id]);

header('Location: dashboard.php');
exit;
?>
