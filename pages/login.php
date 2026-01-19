<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";

$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";

  if ($email === "" || $password === "") {
    $err = "Please enter both email and password.";
  } else {
    $stmt = $conn->prepare("SELECT user_id, full_name, email, password_hash, role FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if (!$user || !password_verify($password, $user["password_hash"])) {
      $err = "Invalid email or password.";
    } else {
      $_SESSION["user_id"] = (int)$user["user_id"];
      $_SESSION["full_name"] = $user["full_name"];
      $_SESSION["email"] = $user["email"];
      $_SESSION["role"] = $user["role"];

      header("Location: blog_list.php");
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Travel Blog Platform</title>
  <meta name="description" content="Login to Travel Blog Platform to read blogs, publish posts, and share reviews about destinations.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <div class="nav">
      <div class="brand"><div class="logo"></div> TravelBlog</div>
      <div class="nav-links">
        <a class="pill" href="register.php">Create account</a>
        <a class="pill" href="privacy.php">Privacy</a>
      </div>
    </div>

    <div class="hero">
      <h1>Welcome back 👋</h1>
      <p>Sign in to create blogs, explore destinations, and leave reviews.</p>
    </div>

    <div class="card">
      <h2>Login</h2>

      <?php if ($err): ?>
        <div class="alert err"><?php echo e($err); ?></div>
      <?php endif; ?>

      <form class="form" method="POST">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required minlength="6">

        <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
          <button class="btn" type="submit">Login</button>
          <a class="btn secondary" href="register.php">Register</a>
        </div>
      </form>
    </div>

    <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
  </div>
</body>
</html>
