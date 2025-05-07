<!DOCTYPE html>
<html>
<head>
  <title>Report Lost/Found Item</title>
</head>
<body>
  <h1>Report an Item</h1>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <label>
      Title:<br>
      <input type="text" name="title" required>
    </label><br><br>
    <label>
      Description:<br>
      <textarea name="description" rows="4" cols="50" required></textarea>
    </label><br><br>
    <label>
      Status:<br>
      <select name="status">
        <option value="lost">Lost</option>
        <option value="found">Found</option>
      </select>
    </label><br><br>
    <label>
      Image:<br>
      <input type="file" name="image" accept="image/*" required>
    </label><br><br>
    <button type="submit">Submit</button>
  </form>
  <p><a href="lost.php">View Lost Items</a> | <a href="found.php">View Found Items</a></p>
</body>
</html>
