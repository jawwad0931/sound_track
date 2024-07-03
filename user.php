<?php
include("config/db_connection.php");
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['id'];
// echo $user_id;
$sql = "SELECT username FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error fetching user data.";
    exit;
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>This is user page</h1>
    <nav>
        <a href="home.php">Home</a>
        <a href="music_list.php">Music List</a>
        <a href="video_list.php">Video List</a>
        <a href="artist_list.php">Artist List</a>
        <a href="feedback.php">Feedback</a>
        <!-- <a href="add_review_rating.php">Review & Rating</a> -->
    </nav>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <a href="edit_user.php?id=<?php echo $user_id; ?>">Edit Profile</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>
