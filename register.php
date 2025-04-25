<?php
session_start();
require_once 'db.php';
require_once 'auth.php';

$pdo = get_db_connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email']; // Fixed to get email from email input
    $password = $_POST['password'];

    // Check if username/email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $error = "Username or email already taken.";
    } else {
        if (register($pdo, $username, $email, $password)) {
            // Get the new user's id
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
            animation: slideInUp 0.5s ease-out forwards;" >
            <h2>Create an Account</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST" class="form-box">
              <input type="text" name="username" placeholder="Username" required>
              <input type="email" name="email" placeholder="Email" required>
              <input type="password" name="password" placeholder="Password" required>
              <button type="submit" class="btn">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
