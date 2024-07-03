<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $year = intval($_POST['year']);
    $genre = $_POST['genre'];
    $language = $_POST['language'];
    $description = $_POST['description'];
    // $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    // Handle file upload
    $target_dir = "uploads/videos/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a actual video
    $check = mime_content_type($_FILES["file"]["tmp_name"]);
    if (strpos($check, 'video') !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not a video.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 500000000) { // 500MB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array("mp4", "avi", "mkv", "mov");
    if (!in_array($videoFileType, $allowed_types)) {
        echo "Sorry, only MP4, AVI, MKV, & MOV files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert video data into database
            $sql = "INSERT INTO video (name, artist, album, year, genre, language, description, file_path, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("sssissssi", $name, $artist, $album, $year, $genre, $language, $description, $target_file, $user_id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "The video has been uploaded successfully.";
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
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Video</title>
</head>
<body>
    <h2>Add Video</h2>
    <form action="add_video.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="artist">Artist:</label>
        <input type="text" id="artist" name="artist" required><br><br>

        <label for="album">Album:</label>
        <input type="text" id="album" name="album" required><br><br>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required><br><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required><br><br>

        <label for="language">Language:</label>
        <input type="text" id="language" name="language" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="file">Video File:</label>
        <input type="file" id="file" name="file" accept="video/*" required><br><br>

        <button type="submit">Add Video</button>
    </form>
</body>
</html>
