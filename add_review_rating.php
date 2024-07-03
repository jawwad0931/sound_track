<?php
include('config/db_connection.php'); // Include your database connection script

// Initialize variables to hold form data
$category_id = $review = $rating = '';
$review_err = $rating_err = '';

// Get the category_id from the URL
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
} else {
    echo "No category ID provided.";
    exit;
}

// Fetch artist information
$sql_select_artist = "SELECT artist, image_path FROM categories WHERE id = ?";
$stmt_artist = $mysqli->prepare($sql_select_artist);
$stmt_artist->bind_param("i", $category_id);
$stmt_artist->execute();
$result_artist = $stmt_artist->get_result();

if ($result_artist->num_rows > 0) {
    $artist = $result_artist->fetch_assoc();
    $artist_name = htmlspecialchars($artist['artist']);
    $artist_image_path = htmlspecialchars($artist['image_path']);
} else {
    echo "Artist not found.";
    exit;
}

$stmt_artist->close();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $review = trim($_POST['review']);
    $rating = trim($_POST['rating']);

    // Validate inputs
    if (empty($review)) {
        $review_err = "Please enter a review.";
    }
    if (empty($rating)) {
        $rating_err = "Please enter a rating.";
    }

    // If no errors, proceed to insert into database
    if (empty($review_err) && empty($rating_err)) {
        // Prepare SQL statement to insert review and rating
        $sql_insert = "INSERT INTO reviews_ratings (category_id, review, rating) VALUES (?, ?, ?)";
        $stmt_insert = $mysqli->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $category_id, $review, $rating);

        // Execute the insert statement
        if ($stmt_insert->execute()) {
            echo "Review and rating added successfully.";
        } else {
            echo "Error adding review and rating: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }
}

// Retrieve existing reviews and ratings for the artist
$sql_select_reviews = "SELECT * FROM reviews_ratings WHERE category_id = ?";
$stmt_reviews = $mysqli->prepare($sql_select_reviews);
$stmt_reviews->bind_param("i", $category_id);
$stmt_reviews->execute();
$result_reviews = $stmt_reviews->get_result();

// Close prepared statement for reviews
$stmt_reviews->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Review and Rating</title>
    <style>
    .error { color: red; }
    .review-list {
        margin-top: 20px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
    .review-item {
        margin-bottom: 10px;
    }
    .review-item p {
        margin: 5px 0;
    }
    .stars {
        display: inline-block;
        font-size: 18px;
        color: #d3d3d3; /* Default color for stars */
    }
    .stars-filled {
        color: #ffb400; /* Yellow color for filled stars */
    }
    .stars-empty {
        color: #d3d3d3; /* Default color for unfilled stars */
    }
</style>

</head>
<body>
    <h2>Add Review and Rating for Artist: <?php echo $artist_name; ?></h2>
    <?php if (!empty($artist_image_path)) : ?>
        <img src="<?php echo $artist_image_path; ?>" alt="<?php echo $artist_name; ?>" style="max-width: 200px;">
    <?php endif; ?>

    <form action="add_review_rating.php?id=<?php echo htmlspecialchars($category_id); ?>" method="POST">
        <div>
            <label for="review">Review:</label>
            <input type="text" id="review" name="review" value="<?php echo htmlspecialchars($review); ?>">
            <span class="error"><?php echo $review_err; ?></span>
        </div>
        <div>
            <label for="rating">Rating:</label>
            <input type="text" id="rating" name="rating" value="<?php echo htmlspecialchars($rating); ?>">
            <span class="error"><?php echo $rating_err; ?></span>
        </div>
        <div>
            <button type="submit">Add Review and Rating</button>
        </div>
    </form>

    <!-- Display existing reviews and ratings -->
    <div class="review-list">
        <h3>Existing Reviews and Ratings</h3>
        <?php
if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $rating = $row['rating'];
        $rating_percentage = $rating * 20;
        echo "<div class='review-item'>";
        echo "<p>Review: " . htmlspecialchars($row['review']) . "</p>";
        echo "<p>Rating: ";
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                echo "<span class='stars stars-filled'>&#9733;</span>";
            } else {
                echo "<span class='stars stars-empty'>&#9734;</span>";
            }
        }
        echo "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No reviews found.</p>";
}
?>

    </div>

</body>
</html>

<?php
$mysqli->close(); // Close database connection
?>
