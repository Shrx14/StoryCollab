<?php
session_start();
require_once 'db.php';
require_once 'auth.php';

$pdo = get_db_connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['username']; // Assuming username is email for compatibility
    $password = $_POST['password'];

    if (login($pdo, $email, $password)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <main class="container fade-in" style="
            max-width: 500px;
            padding: 40px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            border: 3px solid cyan;
            box-shadow: 0px 0px 5px cyan, 0px 0px 5px cyan inset;
            transform: translateY(20px);
            animation: slideInUp 0.5s ease-out forwards;">
            <h2>Login</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST" class="form-box">
                <input type="text" name="username" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Login</button>
            </form>
                <p>Don't have an account? <a href="register.php">Register here</a>.</p>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
