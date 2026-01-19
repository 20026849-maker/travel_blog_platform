<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";

$err = "";
$ok = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $full_name = trim($_POST["full_name"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";

  if ($full_name === "" || $email === "" || $password === "") {
    $err = "Please fill in all fields.";
  } elseif (strlen($password) < 6) {
    $err = "Password must be at least 6 characters.";
  } else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = "user";

    try {
      $stmt = $conn->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $full_name, $email, $hash, $role);
      $stmt->execute();
      $ok = "Account created! You can login now.";
    } catch (Exception $e) {
      $err = "Email already exists. Try another.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | Travel Blog Platform</title>
  <meta name="description" content="Create an account on Travel Blog Platform to publish travel stories and write reviews about destinations.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <a class="pill" href="login.php">Login</a>
      <a class="pill" href="privacy.php">Privacy</a>
    </div>
  </div>

  <div class="hero">
    <h1>Create your account ✨</h1>
    <p>Start publishing travel posts and helping others with honest reviews.</p>
  </div>

  <div class="card">
    <h2>Register</h2>

    <?php if ($err): ?><div class="alert err"><?php echo e($err); ?></div><?php endif; ?>
    <?php if ($ok): ?><div class="alert ok"><?php echo e($ok); ?></div><?php endif; ?>

    <form class="form" method="POST">
      <label for="full_name">Full Name</label>
      <input id="full_name" name="full_name" type="text" required>

      <label for="email">Email</label>
      <input id="email" name="email" type="email" required>

      <label for="password">Password</label>
      <input id="password" name="password" type="password" required minlength="6">

      <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
        <button class="btn" type="submit">Register</button>
        <a class="btn secondary" href="login.php">Back to login</a>
      </div>
    </form>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
