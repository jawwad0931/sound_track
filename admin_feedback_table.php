<?php
include('config/db_connection.php'); // Include your database connection script

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM feedback WHERE id = ?";
    $stmt_delete = $mysqli->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    if ($stmt_delete->execute()) {
        echo "Feedback deleted successfully.";
    } else {
        echo "Error deleting feedback: " . $stmt_delete->error;
    }
    $stmt_delete->close();
}

// Fetch all feedback from the database
$sql_select_feedback = "SELECT * FROM feedback ORDER BY created_at DESC";
$result_feedback = $mysqli->query($sql_select_feedback);

$mysqli->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Feedback</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-button {
            color: red;
            text-decoration: none;
        }
        .delete-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Admin Panel - Feedback</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_feedback->num_rows > 0) {
                while ($feedback = $result_feedback->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($feedback['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['message']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['created_at']) . "</td>";
                    echo "<td><a href='delete_feedback.php?delete_id=" . $feedback['id'] . "' class='delete-button'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No feedback found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
