
<?php
session_start();

// Check if user is logged in and has the appropriate role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit;
}

// Check if an 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Include database connection
    include('config/db_connection.php');
    
    // Sanitize and retrieve user id from URL
    $user_id = $_GET['id'];

    // Prepare SQL statement to delete user
    $sql = "DELETE FROM users WHERE id = ?";
    
    // Use prepared statement to execute the delete query
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Close statement and database connection
    $stmt->close();
    $mysqli->close();
}

// Redirect back to manage_users.php after deletion
header("Location: admin_userlist_table.php");
exit;
?>
