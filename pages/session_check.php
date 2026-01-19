<?php
require_once __DIR__ . "/../includes/auth.php";

echo "<h2>Session Check</h2>";

if (!isset($_SESSION['user'])) {
  echo "Not logged in.";
  exit;
}

echo "Logged in as: " . htmlspecialchars($_SESSION['user']['full_name']) . "<br>";
echo "Email: " . htmlspecialchars($_SESSION['user']['email']) . "<br>";
echo "Role in SESSION: <strong>" . htmlspecialchars($_SESSION['user']['role']) . "</strong><br>";
