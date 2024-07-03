
<?php
include('config/db_connection.php'); // Include your database connection script

// Check if delete_id is set in the URL
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare SQL statement to delete the feedback
    $sql_delete = "DELETE FROM feedback WHERE id = ?";
    $stmt_delete = $mysqli->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    // Execute the delete statement
    if ($stmt_delete->execute()) {
        // Redirect to the admin feedback page with a success message
        header("Location: admin_feedback_table.php");
        exit;
    } else {
        echo "Error deleting feedback: " . $stmt_delete->error;
    }

    $stmt_delete->close();
} else {
    echo "No feedback ID provided.";
}

$mysqli->close(); // Close database connection
?>
