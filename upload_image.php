<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  die(json_encode(['error' => 'Not authenticated']));
}

if (!isset($_FILES['image'])) {
  die(json_encode(['error' => 'No image uploaded']));
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['image']['type'], $allowedTypes)) {
  die(json_encode(['error' => 'Invalid file type']));
}

$uploadDir = 'uploads/story_images/';
if (!file_exists($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

$fileName = uniqid() . '_' . basename($_FILES['image']['name']);
$targetPath = $uploadDir . $fileName;

if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
  echo json_encode(['url' => $targetPath]);
} else {
  echo json_encode(['error' => 'Upload failed']);
}
?>
