<?php
    session_start();
    include('config/db_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = clean_input($_POST['username']);
        $password = clean_input($_POST['password']);

        // Prepare SQL statement to fetch user from database
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("s", $username);

            // Execute statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password, $role);

                    // Fetch stored hashed password
                    if ($stmt->fetch()) {
                        // Verify password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION['role'] = $role;

                            // Redirect based on role
                            if ($role == 'admin') {
                                header("Location: admin.php"); // Redirect to admin page
                            } else {
                                header("Location: user.php"); // Redirect to user page
                            }
                            exit;
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "<p>Error executing SQL statement.</p>";
            }

            // Close statement
            $stmt->close();
        } else {
            echo "<p>Error preparing SQL statement.</p>";
        }

        // Close database connection
        $mysqli->close();
    }

    // Function to sanitize and validate input
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <?php
    if (!empty($login_err)) {
        echo "<p>$login_err</p>";
    }
    ?>
</body>
</html>
