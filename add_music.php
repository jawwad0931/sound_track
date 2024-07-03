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
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $language = $_POST['language'];
    $description = $_POST['description'];
    // $user_id = $_SESSION['user_id']; 

    $target_dir = "uploads/music/";
    $file_path = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

    // Check if file is a actual music file
    if ($fileType != "mp3" && $fileType != "wav" && $fileType != "flac") {
        echo "Sorry, only MP3, WAV, & FLAC files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO music (name, artist, album, year, genre, language, description, file_path, created_at, user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssssssssi", $name, $artist, $album, $year, $genre, $language, $description, $file_path, $user_id);
            if ($stmt->execute()) {
                echo "Music uploaded successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    $mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Music</title>
</head>
<body>
    <h2>Upload Music</h2>
    <form action="add_music.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="artist">Artist:</label>
        <input type="text" id="artist" name="artist" required><br><br>
        
        <label for="album">Album:</label>
        <input type="text" id="album" name="album" required><br><br>
        
        <label for="year">Year:</label>
        <input type="text" id="year" name="year" required><br><br>
        
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required><br><br>
        
        <label for="language">Language:</label>
        <input type="text" id="language" name="language" required><br><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>
        
        <label for="file">Music File:</label>
        <input type="file" id="file" name="file" required><br><br>
        
        <button type="submit">Upload Music</button>
    </form>
</body>
</html>
