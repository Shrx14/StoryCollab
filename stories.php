<?php include 'db.php'; ?>
<?php include 'header.php'; ?>

<div class="page-banner">
  <div class="container">
    <h2>Explore Stories</h2>
    <p>Discover incredible stories from writers around the world</p>
  </div>
</div>

<main class="container slide-up">
  
  <div class="stories-grid">
    <?php
    $result = mysqli_query($conn, "SELECT s.*, u.username FROM stories s JOIN users u ON s.user_id = u.id ORDER BY s.id DESC");
    
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $colors = array('#FF6B6B', '#4ECDC4', '#45B7D1', '#FCBF49', '#7B68EE', '#98D8C8');
        $randomColor = $colors[array_rand($colors)];
        $wordCount = str_word_count($row['content']);
        
        echo '<div class="story-card fade-in" style="border-top: 5px solid ' . $randomColor . '">
                <div class="story-cover">
                  <img src="uploads/covers/' . $row['id'] . '.jpg" alt="Story Cover">
                </div>
                <div class="story-card-content">
                  <h3>' . htmlspecialchars($row['title']) . '</h3>
                  <p class="story-excerpt">' . htmlspecialchars(substr($row['content'], 0, 150)) . '...</p>
                  <div class="story-meta">
                    <span><i class="fas fa-user"></i> ' . htmlspecialchars($row['username']) . '</span>
                    <span><i class="fas fa-file-alt"></i> ' . $wordCount . ' words</span>
                  </div>
                  <a href="view_story.php?id=' . $row['id'] . '" class="btn-subtle">Read Story</a>
                </div>
              </div>';
      }
    } else {
      echo '<div class="no-stories">
              <i class="fas fa-book fa-3x"></i>
              <h3>No stories found</h3>
              <p>Be the first to add a story!</p>
              <a href="create_story.php" class="btn">Create Story</a>
            </div>';
    }
    ?>
  </div>

  <div class="pagination">
    <a href="#" class="page-link disabled"><i class="fas fa-chevron-left"></i></a>
    <a href="#" class="page-link active">1</a>
    <a href="#" class="page-link">2</a>
    <a href="#" class="page-link">3</a>
    <span class="page-dots">...</span>
    <a href="#" class="page-link">10</a>
    <a href="#" class="page-link"><i class="fas fa-chevron-right"></i></a>
  </div>
</main>

<section class="cta-create slide-up">
  <div class="container">
    <h2>Have a story to tell?</h2>
    <p>Share your creative writing with our community of storytellers.</p>
    <a href="create_story.php" class="btn"><i class="fas fa-pen"></i> Start Writing</a>
  </div>
</section>
<?php include 'footer.php'; ?>


