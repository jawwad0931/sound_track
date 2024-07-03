<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

$sql = "SELECT id, name, artist, album, year, genre, language, description, file_path, created_at, user_id FROM video";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Videos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Manage Videos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Artist</th>
            <th>Album</th>
            <th>Year</th>
            <th>Genre</th>
            <th>Language</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['artist']) . "</td>";
                echo "<td>" . htmlspecialchars($row['album']) . "</td>";
                echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['language']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>
                        <a href='add_video.php?id=" . $row['id'] . "'>Add Video</a>
                        <a href='delete_video.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this video?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No video records found.</td></tr>";
        }
        ?>
         <a href='add_video.php?id=" . $row['id'] . "'>Add Video</a>
    </table>
</body>
</html>

<?php
$mysqli->close();
?>
