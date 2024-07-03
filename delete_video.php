<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $video_id = intval($_GET['id']); // Ensure video_id is an integer

    // Fetch the video record to get the file path
    $sql = "SELECT file_path FROM video WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $video_id);
        $stmt->execute();
        $stmt->bind_result($file_path);
        if ($stmt->fetch()) {
            $stmt->close();

            // Delete the video record from the database
            $delete_sql = "DELETE FROM video WHERE id = ?";
            if ($delete_stmt = $mysqli->prepare($delete_sql)) {
                $delete_stmt->bind_param("i", $video_id);
                $delete_stmt->execute();
                if ($delete_stmt->affected_rows > 0) {
                    // Delete the file from the server
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    echo "Video record and file deleted successfully.";
                } else {
                    echo "No rows affected. Record might not have been deleted.";
                }
                $delete_stmt->close();
            } else {
                echo "Error preparing delete statement: " . $mysqli->error;
            }
        } else {
            echo "No video record found.";
        }
    } else {
        echo "Error preparing select statement: " . $mysqli->error;
    }
} else {
    echo "Video ID not provided or invalid request method.";
}

$mysqli->close();
?>
