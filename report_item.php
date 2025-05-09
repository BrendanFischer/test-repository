<?php
//db connection
$con = new mysqli("localhost", "root", "Sp0ngebob41913!?", "lost_found");

//check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//get form data
$name = $_POST['name'];
$email = $_POST['email'];
$item_name = $_POST['item_name'];
$description = $_POST['description'];
$lost_date = $_POST['lost_date'];
$location = $_POST['location'];

//upload image
$target_dir = "uploads/";
$image_name = basename($_FILES["item_image"]["name"]);
$target_file = $target_dir . time() . "_" . $image_name;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//validate image 
$check = getimagesize($_FILES["item_image"]["tmp_name"]);
if ($check === false) {
    die("File is not an image.");
}

if (!move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
    die("Sorry, there was an error uploading your file.");
}

//insert user info into users table
$stmt = $con->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);
$stmt->execute();
$user_id = $stmt->insert_id;
$stmt->close();

//insert item into lost_items table
$stmt = $con->prepare("INSERT INTO lost_items (user_id, item_name, description, lost_date, location, image_path) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $user_id, $item_name, $description, $lost_date, $location, $target_file);
$stmt->execute();
$stmt->close();

echo "Item reported successfully.";
$con->close();
?>
