<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'tasques';
$user = getenv('DB_USER') ?: 'user';
$pass = getenv('DB_PASS') ?: 'password';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
    $stmt = $pdo->prepare("INSERT INTO tasques (text, done) VALUES (?, 0)");
    $stmt->execute([trim($_POST['text'])]);
  }
  
  if (isset($_GET['done'])) {
    $stmt = $pdo->prepare("UPDATE tasques SET done = NOT done WHERE id = ?");
    $stmt->execute([$_GET['done']]);
  }

  $stmt = $pdo->query("SELECT * FROM tasques");
  $tasques = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $error = $e->getMessage();
  $tasques = [];
}
?>
<!DOCTYPE html>
<html>
<head><title>Task Manager</title></head>
<body>
  <h1>Tasques</h1>
  <form method="POST">
    <input type="text" name="text" placeholder="Nova tasca..." required />
    <button type="submit">Afegir</button>
  </form>
  <ul>
    <?php foreach ($tasques as $t): ?>
      <li>
        <a href="?done=<?= $t['id'] ?>">
          <?= $t['done'] ? '✅' : '⭕' ?>
        </a>
        <?= htmlspecialchars($t['text']) ?>
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
