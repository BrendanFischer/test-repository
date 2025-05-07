<?php
// src/upload.php
require_once __DIR__ . '/db.php';

// Ensure a POST submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method Not Allowed');
}

// Validate incoming fields
$title       = $_POST['title']       ?? '';
$description = $_POST['description'] ?? '';
$status      = $_POST['status']      ?? ''; // 'lost' or 'found'
$image       = $_FILES['image']      ?? null;

if (!$title || !$status || !$image) {
    die('Missing title, status or image.');
}

// Check upload errors
if ($image['error'] !== UPLOAD_ERR_OK) {
    die('Upload error code: ' . $image['error']);
}

// Validate image
$info = getimagesize($image['tmp_name']);
if ($info === false) {
    die('Uploaded file is not a valid image.');
}

// Enforce size/type limits (optional)
$ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','gif'];
if (!in_array($ext, $allowed)) {
    die('Unsupported image format.');
}

// Move to uploads directory
$targetDir = __DIR__ . '/../uploads/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}
$filename     = uniqid() . '.' . $ext;
$targetPath   = $targetDir . $filename;
$publicPath   = 'uploads/' . $filename;  // for HTML links

if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
    die('Failed to move uploaded file.');
}

// Insert into database
$sql = "INSERT INTO items (title, description, status, image_path, created_at)
        VALUES (:title, :description, :status, :image, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':title'       => $title,
    ':description' => $description,
    ':status'      => $status,
    ':image'       => $publicPath,
]);

// Redirect back to listing
header("Location: {$status}.php");
exit;
