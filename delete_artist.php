
<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $artist_id = intval($_GET['id']); // Ensure artist_id is an integer

    // Fetch the artist record to get any necessary details
    $sql = "SELECT * FROM categories WHERE id = ? AND category = 'artist'";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $artist_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $artist = $result->fetch_assoc();
            $stmt->close();

            // Delete the artist record from the database
            $delete_sql = "DELETE FROM categories WHERE id = ?";
            if ($delete_stmt = $mysqli->prepare($delete_sql)) {
                $delete_stmt->bind_param("i", $artist_id);
                $delete_stmt->execute();
                if ($delete_stmt->affected_rows > 0) {
                    echo "Artist record deleted successfully.";

                    // Optionally, you can also delete associated files or perform any other cleanup here

                } else {
                    echo "No rows affected. Record might not have been deleted.";
                }
                $delete_stmt->close();
            } else {
                echo "Error preparing delete statement: " . $mysqli->error;
            }
        } else {
            echo "No artist record found.";
        }
    } else {
        echo "Error preparing select statement: " . $mysqli->error;
    }
} else {
    echo "Artist ID not provided or invalid request method.";
}

$mysqli->close();
?>
