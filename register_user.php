<?php
include 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
mysqli_query($conn, $query);

header("Location: login.php");
?>
