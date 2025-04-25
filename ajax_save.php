<?php
require_once 'db.php';

$pdo = get_db_connection();

if (!isset($_POST['content']) || !isset($_POST['story_id'])) {
    http_response_code(400);
    echo "Invalid request";
    exit;
}

$content = $_POST['content'];
$story_id = (int)$_POST['story_id'];

$stmt = $pdo->prepare("UPDATE stories SET content = ? WHERE id = ?");
$stmt->execute([$content, $story_id]);

echo "Saved";
?>
