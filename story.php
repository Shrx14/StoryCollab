<?php
require_once 'auth.php';
require_once 'db.php';

$pdo = get_db_connection();

if (!isset($_GET['id'])) {
    header("Location: /");
    exit();
}

$storyId = $_GET['id'];

// Record view
if (isLoggedIn()) {
    $stmt = $pdo->prepare("INSERT INTO views (story_id, user_id) VALUES (?, ?)");
    $stmt->execute([$storyId, $_SESSION['user_id']]);
} else {
    $stmt = $pdo->prepare("INSERT INTO views (story_id) VALUES (?)");
    $stmt->execute([$storyId]);
}

// Get story details
$stmt = $pdo->prepare("
    SELECT s.*, u.username, u.profile_pic, 
    COUNT(DISTINCT v.id) as views,
    COUNT(DISTINCT b.id) as bookmarks,
    COUNT(DISTINCT ch.id) as chapters
    FROM stories s
    JOIN users u ON s.user_id = u.id
    LEFT JOIN views v ON s.id = v.story_id
    LEFT JOIN bookmarks b ON s.id = b.story_id
    LEFT JOIN chapters ch ON s.id = ch.story_id
    WHERE s.id = ?
    GROUP BY s.id
");
$stmt->execute([$storyId]);
$story = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$story) {
    header("Location: /");
    exit();
}

// Get root chapters (those with no parent)
$chapters = $pdo->prepare("
    SELECT c.*, u.username, COUNT(l.id) as likes
    FROM chapters c
    JOIN users u ON c.user_id = u.id
    LEFT JOIN likes l ON c.id = l.chapter_id
    WHERE c.story_id = ? AND c.parent_chapter_id IS NULL
    GROUP BY c.id
    ORDER BY c.order_num, c.created_at
");
$chapters->execute([$storyId]);
$rootChapters = $chapters->fetchAll(PDO::FETCH_ASSOC);

// Check if bookmarked
$isBookmarked = false;
if (isLoggedIn()) {
    $stmt = $pdo->prepare("SELECT id FROM bookmarks WHERE story_id = ? AND user_id = ?");
    $stmt->execute([$storyId, $_SESSION['user_id']]);
    $isBookmarked = $stmt->fetch() !== false;
}

$pageTitle = $story['title'];
include 'header.php';
?>

<div class="story-header">
    <img src="uploads/cover_images/<?php echo htmlspecialchars($story['cover_image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($story['title']); ?>" class="story-cover">
    <div class="story-meta">
        <h1><?php echo htmlspecialchars($story['title']); ?></h1>
        <p class="author">by <a href="profile.php?id=<?php echo $story['user_id']; ?>"><?php echo htmlspecialchars($story['username']); ?></a></p>
        <p class="description"><?php echo htmlspecialchars($story['description']); ?></p>
        <div class="stats">
            <span><i class="fas fa-eye"></i> <?php echo $story['views']; ?></span>
            <span><i class="fas fa-bookmark"></i> <?php echo $story['bookmarks']; ?></span>
            <span><i class="fas fa-file-alt"></i> <?php echo $story['chapters']; ?></span>
        </div>
        <div class="actions">
            <?php if (isLoggedIn()): ?>
                <button id="bookmarkBtn" class="<?php echo $isBookmarked ? 'bookmarked' : ''; ?>">
                    <?php echo $isBookmarked ? 'Bookmarked' : 'Bookmark'; ?>
                </button>
                <a href="create_chapter.php?story_id=<?php echo $storyId; ?>" class="btn">Continue Story</a>
            <?php endif; ?>
            <?php if (isLoggedIn() && $_SESSION['user_id'] == $story['user_id']): ?>
                <a href="edit_story.php?id=<?php echo $storyId; ?>" class="btn">Edit Story</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="story-content">
    <div class="chapter-list">
        <h2>Chapters</h2>
        <ul>
            <?php foreach ($rootChapters as $chapter): ?>
                <li>
                    <a href="chapter.php?id=<?php echo $chapter['id']; ?>">
                        <?php echo htmlspecialchars($chapter['title']); ?>
                    </a>
                    <span class="chapter-meta">
                        by <?php echo htmlspecialchars($chapter['username']); ?>
                        <i class="fas fa-heart"></i> <?php echo $chapter['likes']; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="chapter-tree" id="chapterTree">
        <h2>Story Tree</h2>
        <svg width="100%" height="400"></svg>
    </div>
</div>

<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Bookmark functionality
    $('#bookmarkBtn').click(function() {
        $.ajax({
            url: 'toggle_bookmark.php',
            method: 'POST',
            data: { story_id: <?php echo $storyId; ?> },
            success: function(response) {
                if (response.status === 'bookmarked') {
                    $('#bookmarkBtn').addClass('bookmarked').text('Bookmarked');
                } else {
                    $('#bookmarkBtn').removeClass('bookmarked').text('Bookmark');
                }
            }
        });
    });
    
    // Draw chapter tree with D3.js
    drawChapterTree(<?php echo $storyId; ?>);
});
</script>

<?php include 'footer.php'; ?>
