<?php
// src/lost.php
require_once __DIR__ . '/db.php';

// Fetch all lost items
$stmt = $pdo->prepare("SELECT * FROM items WHERE status = 'lost' ORDER BY created_at DESC");
$stmt->execute();
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Lost Items</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Lost Items</h1>
  <a href="found.php">View Found Items</a> |
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
      <p>No lost items reported yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
