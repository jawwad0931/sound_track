<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
$user_id = $_SESSION['id'];
// echo $user_id;
// $sql = "SELECT username FROM users WHERE user_id = ?";
// if ($stmt = $mysqli->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result($username);
//     $stmt->fetch();
//     $stmt->close();
// } else {
//     echo "Error fetching user data.";
//     exit;
// }

// $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>This is admin page</h1>
    <h1>Welcome, Admin</h1>
    <a href="admin_music_table.php">Music Page</a> | 
    <a href="admin_videos_table.php">Video Page</a> | 
    <a href="admin_artist_table.php">View Artists</a> | 
    <a href="admin_userlist_table.php">Users Account</a> | 
    <a href="admin_feedback_table.php">Feedback</a> | 
    <!-- <a href="manage_users.php">Manage Users</a> |  -->
    <a href="logout.php">Logout</a>
</body>
</html>
