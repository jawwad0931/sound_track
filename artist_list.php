<?php
include('config/db_connection.php'); // Include your database connection script

$search = "";
if (isset($_GET['search'])) {
    $search = $mysqli->real_escape_string($_GET['search']);
}

// Fetch filtered artists from the database based on the search query
$sql_select_artists = "SELECT id, year, artist, album, genre, image_path FROM categories 
                       WHERE artist LIKE '%$search%' OR album LIKE '%$search%' OR genre LIKE '%$search%' OR year LIKE '%$search%'";
$result_artists = $mysqli->query($sql_select_artists);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Page</title>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
            width: 300px;
            display: inline-block;
            vertical-align: top;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card h3 {
            margin-top: 0;
        }
        .card p {
            margin: 8px 0;
        }
        .card-actions {
            margin-top: 16px;
        }
        .card-actions a {
            text-decoration: none;
            color: #007bff;
            margin-right: 16px;
        }
        .card-actions a:hover {
            text-decoration: underline;
        }
        .review {
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
            padding: 8px;
            margin-top: 8px;
        }
        .stars {
            display: inline-block;
            font-size: 18px;
            color: #d3d3d3;
        }
        .stars span {
            color: #ffb400; /* Yellow color for stars */
        }
        .search-container {
            margin: 20px;
        }
    </style>
</head>
<body>
    <h2>User Page</h2>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php
    if ($result_artists->num_rows > 0) {
        while ($artist = $result_artists->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h3>" . htmlspecialchars($artist['artist']) . "</h3>";
            echo "<p>ID: " . $artist['id'] . "</p>";
            echo "<p>Year: " . $artist['year'] . "</p>";
            echo "<p>Album: " . htmlspecialchars($artist['album']) . "</p>";
            echo "<p>Genre: " . htmlspecialchars($artist['genre']) . "</p>";
            echo "<img src='" . htmlspecialchars($artist['image_path']) . "' alt='" . htmlspecialchars($artist['artist']) . "' style='max-width: 100%;'>";
            echo "<div class='card-actions'>";
            echo "<a href='add_review_rating.php?id=" . $artist['id'] . "'>View Artist</a>";
            echo "</div>";

            // Fetch reviews and ratings for this artist
            $sql_select_reviews = "SELECT * FROM reviews_ratings WHERE category_id = ?";
            $stmt_reviews = $mysqli->prepare($sql_select_reviews);
            $stmt_reviews->bind_param("i", $artist['id']);
            $stmt_reviews->execute();
            $result_reviews = $stmt_reviews->get_result();

            if ($result_reviews->num_rows > 0) {
                echo "<h4>Reviews and Ratings:</h4>";
                while ($review = $result_reviews->fetch_assoc()) {
                    $rating = $review['rating'];
                    $rating_percentage = $rating * 20;
                    echo "<div class='review'>";
                    echo "<p>Review: " . htmlspecialchars($review['review']) . "</p>";
                    echo "<p>Rating: <span class='stars' style='width: " . $rating_percentage . "%;'>&#9733;&#9733;&#9733;&#9733;&#9733;</span></p>"; // Convert rating to stars
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews found.</p>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No artists found.</p>";
    }

    $stmt_reviews->close(); // Close prepared statement
    $mysqli->close(); // Close database connection
    ?>
</body>
</html>
