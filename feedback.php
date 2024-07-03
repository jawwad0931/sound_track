<?php
include('config/db_connection.php'); // Include your database connection script

// Initialize variables to hold form data
$name = $email = $message = '';
$name_err = $email_err = $message_err = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (empty($name)) {
        $name_err = "Please enter your name.";
    }
    if (empty($email)) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    }
    if (empty($message)) {
        $message_err = "Please enter your feedback.";
    }

    // If no errors, proceed to insert into database
    if (empty($name_err) && empty($email_err) && empty($message_err)) {
        // Prepare SQL statement to insert feedback
        $sql_insert = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
        $stmt_insert = $mysqli->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $name, $email, $message);

        // Execute the insert statement
        if ($stmt_insert->execute()) {
            echo "Feedback submitted successfully.";
        } else {
            echo "Error submitting feedback: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    $mysqli->close(); // Close database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Submit Your Feedback</h2>
    <form action="feedback.php" method="POST">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <span class="error"><?php echo $name_err; ?></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo $email_err; ?></span>
        </div>
        <div>
            <label for="message">Feedback:</label>
            <textarea id="message" name="message"><?php echo htmlspecialchars($message); ?></textarea>
            <span class="error"><?php echo $message_err; ?></span>
        </div>
        <div>
            <button type="submit">Submit Feedback</button>
        </div>
    </form>
</body>
</html>
