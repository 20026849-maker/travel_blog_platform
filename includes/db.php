<?php
// includes/db.php
// ✅ Update these if needed
$DB_HOST = "127.0.0.1";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "travel_blog_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
  $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  $conn->set_charset("utf8mb4");
} catch (Exception $e) {
  http_response_code(500);
  echo "Database connection failed.";
  exit;
}
