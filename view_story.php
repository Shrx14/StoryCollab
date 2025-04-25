<?php
include 'db.php';
if(!isset($_GET['id'])) {
  header('Location: stories.php');
  exit;
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT s.*, u.username FROM stories s JOIN users u ON s.user_id = u.id WHERE s.id = $id");

if(mysqli_num_rows($result) === 0) {
  header('Location: stories.php');
  exit;
}

$story = mysqli_fetch_assoc($result);
?>
<?php include 'header.php'; ?>

  <div class="story-hero fade-in">
    <div class="story-hero-bg" style="background-image: url('uploads/hero/<?php echo $id; ?>.jpg')"></div>
    <div class="story-hero-content">
      <h1><?php echo htmlspecialchars($story['title']); ?></h1>
      <div class="story-meta-info">
        <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($story['username']); ?></span>
        <span><i class="fas fa-clock"></i> Published</span>
      </div>
    </div>
  </div>

  <div class="story-content-container fade-in">
    <div class="story-content">
      <?php 
        $paragraphs = explode("\n", $story['content']);
        foreach ($paragraphs as $para) {
          echo "<p>" . nl2br(htmlspecialchars($para)) . "</p>";
        }
      ?>
    </div>

  </div>

<?php include 'footer.php'; ?>
</body>
</html>
