<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

$user_id = null;
$username = "";
$email = "";
$age = 0;

// Fetch user data based on user ID from the database
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure user_id is an integer
    $sql = "SELECT username, email, age FROM users WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username, $email, $age);
        if (!$stmt->fetch()) {
            // echo "No user found";
            exit;
        }
        $stmt->close();
    } else {
        // echo "Error preparing statement: " . $mysqli->error;
        exit;
    }
}

// Handle form submission to update user information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = intval($_POST['age']);

    // Update user
    $sql = "UPDATE users SET username = ?, email = ?, age = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssii", $username, $email, $age, $user_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            // header("Location: manage_users.php?status=success");
            // exit; 
        } else {
            // echo "No rows affected. Record might not have been updated.";
        }
        $stmt->close();
    } else {
        // echo "Error preparing update statement: " . $mysqli->error;
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form action="edit_user.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required><br><br>
        <button type="submit">Update User</button>
        <!-- Example link in manage_users.php -->
        <a href="manage_users.php?id=<?php echo $user_id; ?>">View account update</a>
    </form>
</body>
</html>
