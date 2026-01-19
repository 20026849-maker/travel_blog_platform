<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";
require_login();

$post_id = (int)($_GET["post_id"] ?? 0);
if ($post_id <= 0) { echo "Invalid post."; exit; }

$stmt = $conn->prepare("
  SELECT p.post_id, p.title, p.destination, p.content, p.created_at, u.full_name
  FROM blog_posts p
  JOIN users u ON u.user_id = p.user_id
  WHERE p.post_id=?
  LIMIT 1
");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
if (!$post) { echo "Post not found."; exit; }

$stmt2 = $conn->prepare("
  SELECT r.review_id, r.rating, r.comment, r.created_at, u.full_name
  FROM reviews r
  JOIN users u ON u.user_id = r.user_id
  WHERE r.post_id=?
  ORDER BY r.created_at DESC
");
$stmt2->bind_param("i", $post_id);
$stmt2->execute();
$reviews = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

$metaDesc = substr(strip_tags($post["content"]), 0, 160);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo e($post["title"]); ?> | Travel Blog Platform</title>
  <meta name="description" content="<?php echo e($metaDesc); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <a class="pill" href="blog_list.php">← Back</a>
      <a class="pill" href="privacy.php">Privacy</a>
      <a class="pill" href="logout.php">Logout</a>
    </div>
  </div>

  <div class="hero">
    <h1><?php echo e($post["title"]); ?></h1>
    <p>
      <span class="badge"><?php echo e($post["destination"]); ?></span>
      <span class="muted"> • by <?php echo e($post["full_name"]); ?> • <?php echo e(date("Y-m-d", strtotime($post["created_at"]))); ?></span>
    </p>
  </div>

  <div class="grid">
    <div class="card">
      <h2>Story</h2>
      <p><?php echo nl2br(e($post["content"])); ?></p>
      <hr>
      <a class="btn" href="review_add.php?post_id=<?php echo (int)$post_id; ?>">➕ Add a Review</a>
    </div>

    <div class="card">
      <h3>Reviews</h3>
      <?php if (count($reviews) === 0): ?>
        <div class="alert warn">No reviews yet. Be the first!</div>
      <?php else: ?>
        <?php foreach ($reviews as $r): ?>
          <div class="alert">
            <strong><?php echo e($r["full_name"]); ?></strong>
            <span class="muted">— Rating: <?php echo (int)$r["rating"]; ?>/5</span>
            <div class="muted" style="margin-top:6px;"><?php echo e($r["comment"]); ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
