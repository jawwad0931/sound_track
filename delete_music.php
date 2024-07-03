<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $music_id = intval($_GET['id']); // Ensure music_id is an integer

    // Fetch the music record to get the file path
    $sql = "SELECT file_path FROM music WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $music_id);
        $stmt->execute();
        $stmt->bind_result($file_path);
        if ($stmt->fetch()) {
            $stmt->close();

            // Delete the music record from the database
            $delete_sql = "DELETE FROM music WHERE id = ?";
            if ($delete_stmt = $mysqli->prepare($delete_sql)) {
                $delete_stmt->bind_param("i", $music_id);
                $delete_stmt->execute();
                if ($delete_stmt->affected_rows > 0) {
                    // Delete the file from the server
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    echo "Music record and file deleted successfully.";
                } else {
                    echo "No rows affected. Record might not have been deleted.";
                }
                $delete_stmt->close();
            } else {
                echo "Error preparing delete statement: " . $mysqli->error;
            }
        } else {
            echo "No music record found.";
        }
    } else {
        echo "Error preparing select statement: " . $mysqli->error;
    }
} else {
    echo "Music ID not provided or invalid request method.";
}

$mysqli->close();
?>
