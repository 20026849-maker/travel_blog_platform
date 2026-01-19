<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";
require_login();

$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST["title"] ?? "");
  $destination = trim($_POST["destination"] ?? "");
  $content = trim($_POST["content"] ?? "");

  if ($title === "" || $destination === "" || $content === "") {
    $err = "All fields are required.";
  } elseif (strlen($title) < 5) {
    $err = "Title should be at least 5 characters.";
  } else {
    $uid = (int)$_SESSION["user_id"];
    $stmt = $conn->prepare("INSERT INTO blog_posts (user_id, title, destination, content, status) VALUES (?, ?, ?, ?, 'published')");
    $stmt->bind_param("isss", $uid, $title, $destination, $content);
    $stmt->execute();

    header("Location: blog_list.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Blog Post | Travel Blog Platform</title>
  <meta name="description" content="Create a new travel blog post with destination and story details on Travel Blog Platform.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <a class="pill" href="blog_list.php">Back to posts</a>
      <a class="pill" href="logout.php">Logout</a>
    </div>
  </div>

  <div class="hero">
    <h1>Add New Blog Post</h1>
    <p>Share your itinerary, food spots, and honest tips for travelers.</p>
  </div>

  <div class="card">
    <?php if ($err): ?><div class="alert err"><?php echo e($err); ?></div><?php endif; ?>

    <form class="form" method="POST">
      <label for="title">Title</label>
      <input id="title" name="title" type="text" required minlength="5">

      <label for="destination">Destination</label>
      <input id="destination" name="destination" type="text" required>

      <label for="content">Content</label>
      <textarea id="content" name="content" required></textarea>

      <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
        <button class="btn" type="submit">Publish</button>
        <a class="btn secondary" href="blog_list.php">Cancel</a>
      </div>
    </form>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
