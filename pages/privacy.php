<?php
require_once __DIR__ . "/../includes/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Privacy Policy | Travel Blog Platform</title>
  <meta name="description" content="Privacy policy for Travel Blog Platform describing data collection, storage, and user rights.">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <div class="brand"><div class="logo"></div> TravelBlog</div>
    <div class="nav-links">
      <a class="pill" href="login.php">Login</a>
      <a class="pill" href="register.php">Register</a>
      <a class="pill" href="blog_list.php">Blog List</a>
    </div>
  </div>

  <div class="hero">
    <h1>Privacy Policy</h1>
    <p>This website is an academic project for ICT726 (KOI). It demonstrates privacy, ethics and secure handling of user data.</p>
  </div>

  <div class="card">
    <h2>What we collect</h2>
    <ul class="muted">
      <li>Account data: full name, email, password (stored as hashed password)</li>
      <li>User content: blog posts and reviews (rating + comment)</li>
    </ul>

    <h2>How we use data</h2>
    <ul class="muted">
      <li>Authentication (login) and access control (admin role)</li>
      <li>Displaying posts and reviews to users</li>
      <li>Basic moderation through admin dashboard</li>
    </ul>

    <h2>Security measures</h2>
    <ul class="muted">
      <li>Passwords are stored using hashing (password_hash)</li>
      <li>Session-based authentication</li>
      <li>Prepared statements are used to reduce SQL injection risk</li>
    </ul>

    <h2>User rights (GDPR-style)</h2>
    <p class="muted">Users can request deletion of their content by contacting the administrator (project demo scope).</p>

    <hr>
    <p class="muted"><strong>Note:</strong> This is a demo site hosted locally. No real third-party tracking is used.</p>
  </div>

  <div class="footer">© 2026 TravelBlog • Built for ICT726</div>
</div>
</body>
</html>
