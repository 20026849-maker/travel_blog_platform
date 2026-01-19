<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";
require_login();

$userName = $_SESSION["full_name"] ?? "User";

$res = $conn->query("
  SELECT p.post_id, p.title, p.destination, p.created_at, u.full_name
  FROM blog_posts p
  JOIN users u ON u.user_id = p.user_id
  ORDER BY p.created_at DESC
");
$posts = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blog Posts | Travel Blog Platform</title>
  <meta name="description" content="Browse travel blog posts and destinations. Create posts and read reviews on the Travel Blog Platform.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <span class="pill">👋 <?php echo e($userName); ?></span>
      <a class="pill" href="privacy.php">Privacy</a>
      <?php if (is_admin()): ?>
        <a class="pill" href="../admin/dashboard.php">Admin</a>
      <?php endif; ?>
      <a class="pill" href="logout.php">Logout</a>
    </div>
  </div>

  <div class="hero">
    <h1>Travel Blog Posts</h1>
    <p>Explore destinations, read stories, and add your own experiences.</p>
  </div>

  <div class="grid">
    <div class="card">
      <div style="display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap; align-items:center;">
        <h2 style="margin:0;">Latest Posts</h2>
        <a class="btn" href="blog_add.php">➕ Add New Blog Post</a>
      </div>
      <hr>

      <?php if (count($posts) === 0): ?>
        <div class="alert warn">No blog posts yet. Create your first post!</div>
      <?php else: ?>
        <table class="table" aria-label="Blog posts list">
          <thead>
            <tr>
              <th>Title</th>
              <th>Destination</th>
              <th>Author</th>
              <th>Posted</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($posts as $p): ?>
            <tr>
              <td><?php echo e($p["title"]); ?></td>
              <td><span class="badge"><?php echo e($p["destination"]); ?></span></td>
              <td><?php echo e($p["full_name"]); ?></td>
              <td><?php echo e(date("Y-m-d", strtotime($p["created_at"]))); ?></td>
              <td><a class="btn secondary" href="blog_view.php?post_id=<?php echo (int)$p["post_id"]; ?>">View</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="card">
      <h3>Quick Tips</h3>
      <p class="muted">To get High Distinction:</p>
      <ul class="muted">
        <li>Use validation + error messages</li>
        <li>Use admin access control</li>
        <li>Add SEO: meta + robots + sitemap</li>
        <li>Include privacy policy</li>
      </ul>
    </div>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
