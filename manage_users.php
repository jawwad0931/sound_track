<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit;
}

include('config/db_connection.php');

$user_id = null;
$username = "";
$role = "";

// Fetch user data based on user ID from the database
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure user_id is an integer
    $sql = "SELECT username, role FROM users WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username, $role);
        if (!$stmt->fetch()) {
            // echo "No user found";
            exit;
        }
        $stmt->close();
    } else {
        // echo "Error preparing statement: " . $mysqli->error;
        exit;
    }
} else {
    // echo "User ID not provided or invalid request method.";
    exit;
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
</head>
<body>
    <h2>User Details</h2>
    <p>User ID: <?php echo $user_id; ?></p>
    <p>Username: <?php echo htmlspecialchars($username); ?></p>
    <p>Role: <?php echo htmlspecialchars($role); ?></p>
    <!-- You can add more fields as needed -->
</body>
</html>
