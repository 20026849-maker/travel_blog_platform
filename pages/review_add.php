<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";
require_login();

$post_id = (int)($_GET["post_id"] ?? 0);
if ($post_id <= 0) { echo "Invalid post."; exit; }

$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $rating = (int)($_POST["rating"] ?? 0);
  $comment = trim($_POST["comment"] ?? "");

  if ($rating < 1 || $rating > 5) {
    $err = "Rating must be between 1 and 5.";
  } elseif ($comment === "") {
    $err = "Comment is required.";
  } elseif (strlen($comment) < 5) {
    $err = "Comment should be at least 5 characters.";
  } else {
    $uid = (int)$_SESSION["user_id"];
    $stmt = $conn->prepare("INSERT INTO reviews (post_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $post_id, $uid, $rating, $comment);
    $stmt->execute();

    header("Location: blog_view.php?post_id=" . $post_id);
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Review | Travel Blog Platform</title>
  <meta name="description" content="Add a rating and review for a travel blog post on Travel Blog Platform.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <a class="pill" href="blog_view.php?post_id=<?php echo (int)$post_id; ?>">← Back to post</a>
      <a class="pill" href="logout.php">Logout</a>
    </div>
  </div>

  <div class="hero">
    <h1>Add Review</h1>
    <p>Leave a helpful rating + short comment for other travelers.</p>
  </div>

  <div class="card">
    <?php if ($err): ?><div class="alert err"><?php echo e($err); ?></div><?php endif; ?>

    <form class="form" method="POST">
      <label for="rating">Rating (1 to 5)</label>
      <select id="rating" name="rating" required>
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
      </select>

      <label for="comment">Comment</label>
      <textarea id="comment" name="comment" required></textarea>

      <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
        <button class="btn" type="submit">Submit Review</button>
        <a class="btn secondary" href="blog_view.php?post_id=<?php echo (int)$post_id; ?>">Cancel</a>
      </div>
    </form>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
