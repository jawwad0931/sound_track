<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

include('config/db_connection.php');

$search = "";
if (isset($_GET['search'])) {
    $search = $mysqli->real_escape_string($_GET['search']);
}

// Fetch filtered videos from the database based on the search query
$sql_select = "SELECT * FROM video WHERE name LIKE '%$search%' OR artist LIKE '%$search%' OR album LIKE '%$search%' OR genre LIKE '%$search%' OR language LIKE '%$search%'";
$result = $mysqli->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Library</title>
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 16px;
            margin: 16px;
            width: 300px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 100%;
            height: auto;
        }
        .card h3 {
            margin-top: 0;
        }
        .search-container {
            margin: 20px;
        }
    </style>
</head>
<body>
    <h2>Video Library</h2>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p><strong>Artist:</strong> " . htmlspecialchars($row['artist']) . "</p>";
                echo "<p><strong>Album:</strong> " . htmlspecialchars($row['album']) . "</p>";
                echo "<p><strong>Year:</strong> " . htmlspecialchars($row['year']) . "</p>";
                echo "<p><strong>Genre:</strong> " . htmlspecialchars($row['genre']) . "</p>";
                echo "<p><strong>Language:</strong> " . htmlspecialchars($row['language']) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                echo "<video width='100%' controls>
                        <source src='" . htmlspecialchars($row['file_path']) . "' type='video/mp4'>
                        Your browser does not support the video tag.
                      </video>";
                echo "</div>";
            }
        } else {
            echo "<p>No videos found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$mysqli->close(); // Close database connection
?>
