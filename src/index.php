<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'tasques';
$user = getenv('DB_USER') ?: 'user';
$pass = getenv('DB_PASS') ?: 'password';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  $stmt = $pdo->query("SELECT * FROM tasques");
  $tasques = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $tasques = [];
  $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head><title>Task Manager</title></head>
<body>
  <h1>Tasques</h1>
  <?php foreach ($tasques as $t): ?>
    <li><?= htmlspecialchars($t['text']) ?></li>
  <?php endforeach; ?>
</body>
</html>
