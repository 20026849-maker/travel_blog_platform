<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";
require_admin();

// delete post
if (isset($_GET["delete_post"])) {
  $pid = (int)$_GET["delete_post"];
  if ($pid > 0) {
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE post_id=?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
  }
  header("Location: dashboard.php");
  exit;
}

// delete review
if (isset($_GET["delete_review"])) {
  $rid = (int)$_GET["delete_review"];
  if ($rid > 0) {
    $stmt = $conn->prepare("DELETE FROM reviews WHERE review_id=?");
    $stmt->bind_param("i", $rid);
    $stmt->execute();
  }
  header("Location: dashboard.php");
  exit;
}

$posts = $conn->query("
  SELECT p.post_id, p.title, p.destination, u.full_name
  FROM blog_posts p
  JOIN users u ON u.user_id = p.user_id
  ORDER BY p.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

$reviews = $conn->query("
  SELECT r.review_id, r.rating, r.comment, u.full_name as reviewer, p.title
  FROM reviews r
  JOIN users u ON u.user_id = r.user_id
  JOIN blog_posts p ON p.post_id = r.post_id
  ORDER BY r.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

$name = $_SESSION["full_name"] ?? "Admin";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Travel Blog Platform</title>
  <meta name="description" content="Admin dashboard to manage blog posts and reviews with role-based access control.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <span class="pill">🛡️ <?php echo e($name); ?> (admin)</span>
      <a class="pill" href="../pages/blog_list.php">Back to posts</a>
      <a class="pill" href="../pages/logout.php">Logout</a>
    </div>
  </div>

  <div class="hero">
    <h1>Admin Dashboard</h1>
    <p>Manage posts and reviews (delete options). This shows access control + moderation.</p>
  </div>

  <div class="grid">
    <div class="card">
      <h2>Manage Blog Posts</h2>
      <hr>
      <?php if (count($posts) === 0): ?>
        <div class="alert warn">No posts available.</div>
      <?php else: ?>
        <table class="table" aria-label="Admin posts table">
          <thead><tr><th>Title</th><th>Destination</th><th>Author</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($posts as $p): ?>
            <tr>
              <td><?php echo e($p["title"]); ?></td>
              <td><span class="badge"><?php echo e($p["destination"]); ?></span></td>
              <td><?php echo e($p["full_name"]); ?></td>
              <td style="display:flex; gap:8px; flex-wrap:wrap;">
                <a class="btn secondary" href="../pages/blog_view.php?post_id=<?php echo (int)$p["post_id"]; ?>">View</a>
                <a class="btn danger" href="dashboard.php?delete_post=<?php echo (int)$p["post_id"]; ?>" onclick="return confirm('Delete this post?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="card">
      <h2>Manage Reviews</h2>
      <hr>
      <?php if (count($reviews) === 0): ?>
        <div class="alert warn">No reviews available.</div>
      <?php else: ?>
        <?php foreach ($reviews as $r): ?>
          <div class="alert">
            <strong><?php echo e($r["reviewer"]); ?></strong>
            <span class="muted"> on <em><?php echo e($r["title"]); ?></em> — <?php echo (int)$r["rating"]; ?>/5</span>
            <div class="muted" style="margin-top:6px;"><?php echo e($r["comment"]); ?></div>
            <div style="margin-top:10px;">
              <a class="btn danger" href="dashboard.php?delete_review=<?php echo (int)$r["review_id"]; ?>" onclick="return confirm('Delete this review?')">Delete Review</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
