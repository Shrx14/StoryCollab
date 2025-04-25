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
    <h2>Create a New Story</h2>
    <form action="save_story.php" method="POST" class="form-box">
      <input type="text" name="title" placeholder="Story Title" required />
      <textarea name="content" placeholder="Start your story..." rows="10" required></textarea>
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <button type="submit" class="btn">Save Story</button>
    </form>
  </main>

<?php include 'footer.php'; ?>
</body>
</html>
