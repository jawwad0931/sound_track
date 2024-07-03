<?php
include('config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $target_dir = "uploads/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert artist data into database
            $sql = "INSERT INTO categories (artist, album, year, genre, image_path) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssiss", $artist, $album, $year, $genre, $target_file);
                if ($stmt->execute()) {
                    echo "Artist added successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: " . $mysqli->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Categories</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Add Artist</h2>
    
<form action="add_artist.php" method="POST" enctype="multipart/form-data">
    <label for="artist">Artist Name:</label>
    <input type="text" id="artist" name="artist" required><br><br>

    <label for="album">Album:</label>
    <input type="text" id="album" name="album" required><br><br>

    <label for="year">Year:</label>
    <input type="text" id="year" name="year" required><br><br>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required><br><br>

    <label for="image">Artist Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required><br><br>

    <button type="submit">Add Artist</button>
</form>
</body>
</html>



