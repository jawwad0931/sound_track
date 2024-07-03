<?php 
    include('config/db_connection.php');

    // Function to sanitize and validate input
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Initialize variables for form validation
    $username = $email = $password = $age = $hobbies = '';
    $username_err = $email_err = $password_err = $age_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate username
        if (empty($_POST['username'])) {
            $username_err = "Please enter a username.";
        } else {
            $username = clean_input($_POST['username']);
        }

        // Validate email
        if (empty($_POST['email'])) {
            $email_err = "Please enter an email.";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } else {
            $email = clean_input($_POST['email']);
        }

        // Validate password
        if (empty($_POST['password'])) {
            $password_err = "Please enter a password.";
        } else {
            $password = clean_input($_POST['password']);
        }

        // Validate age
        if (empty($_POST['age'])) {
            $age_err = "Please enter your age.";
        } elseif (!is_numeric($_POST['age']) || $_POST['age'] < 18 || $_POST['age'] > 100) {
            $age_err = "Age must be between 18 and 100.";
        } else {
            $age = clean_input($_POST['age']);
        }

        // Validate hobbies
        if (empty($_POST['hobby'])) {
            $hobbies = ''; // No hobbies selected
        } else {
            $hobbies = implode(",", $_POST['hobby']); // Convert array to comma-separated string
        }

        // If no errors, proceed with database insertion
        if (empty($username_err) && empty($email_err) && empty($password_err) && empty($age_err)) {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL statement to insert user into database
            $sql = "INSERT INTO users (username, email, password, age, hobby) VALUES (?, ?, ?, ?, ?)";

            // Use prepared statement for security
            if ($stmt = $mysqli->prepare($sql)) {
                // Bind parameters
                $stmt->bind_param("sssis", $username, $email, $hashed_password, $age, $hobbies);

                // Execute statement
                if ($stmt->execute()) {
                    header("location: index.php");
                    echo "<p>Registration successful!</p>";
                } else {
                    echo "<p>Registration failed. Please try again later.</p>";
                    exit;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "<p>Database error. Please try again later.</p>";
            }
        }
        
        // Close database connection
        $mysqli->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
        <span><?php echo $username_err; ?></span><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <span><?php echo $email_err; ?></span><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <span><?php echo $password_err; ?></span><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
        <span><?php echo $age_err; ?></span><br><br>

        <label for="hobby">Hobby:</label><br>
        <select id="hobby" name="hobby[]">
            <option value="reading" <?php if (strpos($hobbies, 'reading') !== false) echo 'selected'; ?>>Reading</option>
            <option value="sports" <?php if (strpos($hobbies, 'sports') !== false) echo 'selected'; ?>>Sports</option>
            <option value="music" <?php if (strpos($hobbies, 'music') !== false) echo 'selected'; ?>>Music</option>
            <option value="travel" <?php if (strpos($hobbies, 'travel') !== false) echo 'selected'; ?>>Travel</option>
            <!-- Add more options as needed -->
        </select><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
