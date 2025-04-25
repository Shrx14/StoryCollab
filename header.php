<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'register.php') {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StoryCollab - Collaborative Storytelling Platform</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <header class="header fade-in">
    <div class="container">
      <div class="logo-container">
        <img src="Logo.png" alt="StoryCollab Logo" class="logo-img" height = "50px">
        <h1>StoryCollab</h1>
      </div>
      <nav>
        <a href="index.html" <?php echo basename($_SERVER['PHP_SELF']) == 'index.html' ? 'class="active"' : ''; ?> class="nav-link">
          <i class="fas fa-home"></i> Home
        </a>
        <a href="dashboard.php" <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'class="active"' : ''; ?> class="nav-link">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="create_story.php" <?php echo basename($_SERVER['PHP_SELF']) == 'create_story.php' ? 'class="active"' : ''; ?> class="nav-link">
          <i class="fas fa-pen-fancy"></i> Create Story
        </a>
        <a href="stories.php" <?php echo basename($_SERVER['PHP_SELF']) == 'stories.php' ? 'class="active"' : ''; ?> class="nav-link">
          <i class="fas fa-book-open"></i> Explore
        </a>
        <a href="profile.php" <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'class="active"' : ''; ?> class="nav-link">
          <i class="fas fa-user"></i> Profile
        </a>
        <a href="logout.php" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </nav>
    </div>
  </header>
