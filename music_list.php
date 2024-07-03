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

// Fetch filtered music records from the database based on the search query
$sql_select = "SELECT * FROM music WHERE name LIKE '%$search%' OR artist LIKE '%$search%' OR album LIKE '%$search%' OR genre LIKE '%$search%' OR language LIKE '%$search%'";
$result = $mysqli->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Library</title>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 16px;
            margin: 16px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            height: auto;
        }
        .card h3 {
            margin: 0;
            font-size: 1.5em;
        }
        .card p {
            margin: 8px 0;
        }
        .card a {
            display: block;
            margin-top: 8px;
            text-decoration: none;
            color: #0066cc;
        }
        .search-container {
            margin: 20px;
        }
    </style>
</head>
<body>
    <h2>Music Library</h2>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="cards-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                // echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p><strong>Artist:</strong> " . htmlspecialchars($row['artist']) . "</p>";
                echo "<p><strong>Album:</strong> " . htmlspecialchars($row['album']) . "</p>";
                echo "<p><strong>Year:</strong> " . htmlspecialchars($row['year']) . "</p>";
                echo "<p><strong>Genre:</strong> " . htmlspecialchars($row['genre']) . "</p>";
                echo "<p><strong>Language:</strong> " . htmlspecialchars($row['language']) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                echo "<audio controls><source src='" . htmlspecialchars($row['file_path']) . "' type='audio/mpeg'></audio>";
                echo "</div>";
            }
        } else {
            echo "<p>No music found.</p>";
        }
        ?>
    </div>

</body>
</html>

<?php
$mysqli->close(); // Close database connection
?>
