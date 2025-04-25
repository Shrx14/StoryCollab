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
    <div class="hero">
      <div class="hero-img">
        <img src="write.png" alt="Start writing your story">
      </div>
      <div class="hero-actions">
        <a href="create_story.php" class="btn">Start Here - Create New Story</a>
      </div>
    </div>

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Here are your stories:</p>

    <div class="story-list">
      <?php
        $user_id = $_SESSION['user_id'];
        $result = mysqli_query($conn, "SELECT * FROM stories WHERE user_id = $user_id");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='story-card'>";
          echo "<h3><a href='story_editor.php?id={$row['id']}'>" . htmlspecialchars($row['title']) . "</a></h3>";
          echo "<p>" . htmlspecialchars(substr($row['content'], 0, 100)) . "...</p>";
          echo "</div>";
        }
      ?>
    </div>

  </main>
  
<?php include 'footer.php'; ?>
