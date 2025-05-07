<?php
// src/found.php
require_once __DIR__ . '/db.php';
$stmt = $pdo->prepare("SELECT * FROM items WHERE status = 'found' ORDER BY created_at DESC");
$stmt->execute();
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Found Items</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Found Items</h1>
  <a href="lost.php">View Lost Items</a> |
  <a href="upload_form.php">Report an Item</a>
  <div class="grid">
    <?php foreach ($items as $item): ?>
      <div class="card">
        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="">
        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
        <small>Reported on <?php echo date('M j, Y', strtotime($item['created_at'])); ?></small>
      </div>
    <?php endforeach; ?>
    <?php if (empty($items)): ?>
      <p>No found items reported yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
