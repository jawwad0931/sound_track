<?php
include('config/db_connection.php'); // Include your database connection script

// Fetch all artists from the database
$sql_select = "SELECT * FROM categories";
$result = $mysqli->query($sql_select);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
        }
    </style>
</head>
<body>
    <h2>Admin Page</h2>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Artist</th>";
            echo "<th>Year</th>";
            echo "<th>Album</th>";
            echo "<th>Genre</th>";
            echo "<th>Actions</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['artist']) . "</td>";
                echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                echo "<td>" . htmlspecialchars($row['album']) . "</td>";
                echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
                echo "<td>";
                echo "<a href='add_artist.php?id=" . $row['id'] . "'>Add Artist</a> | ";
                echo "<a href='delete_artist.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this artist?');\">Delete Artist</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No artists found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$mysqli->close(); // Close database connection
?>
