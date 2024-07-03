
<?php
session_start();
if ($_SESSION['role'] !== 'user' && 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    include('config/db_connection.php');
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}

header("Location: manage_users.php");
exit;
?>
