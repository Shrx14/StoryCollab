<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
?>
<?php include 'header.php'; ?>

  <main class="container fade-in">
    <h2>Your Profile</h2>
    <div class="user-avatar">
        <img src="uploads/avatars/<?php echo $_SESSION['user_id']; ?>.jpg" alt="Profile Picture">
    </div>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <a href="logout.php" class="btn">Logout</a>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
