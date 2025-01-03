<?php
// Start session and include database connection
session_start();
include 'db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get submitted data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'user'; // Default role for new users

    // Validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if username already exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username already taken. Please choose another.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            if ($stmt->execute()) {
                // Redirect to login page after successful signup
                header("Location: Login.php");
                exit();
            } else {
                $error_message = "Error creating account. Please try again.";
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent; /* Fallback color */
            overflow: hidden;
        }
        video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .signup-container {
            background-color: rgb(255, 255, 255); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            z-index: 1;
            text-align: center;
        }
        .signup-container img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .signup-container h2 {
            margin-bottom: 20px;
        }
        .signup-container .form-label {
            font-weight: bold;
        }
        .signup-container .btn {
            width: 100%;
        }
        .signup-container p {
            margin-top: 20px;
        }
        .text-danger {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Video background -->
    <video autoplay loop muted>
        <source src="videos/login_background.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Signup form -->
    <div class="signup-container">
        <img src="/LibrarySystem/images/logo.png" alt="Library Logo">
        <h2>Library Management System - Signup</h2>
        <form method="POST" action="Signup.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>

        <?php if (!empty($error_message)): ?>
            <p class="text-danger"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Back to Login Button -->
        <div class="text-center mt-3">
            <a href="Login.php" class="btn btn-secondary">Back to Login</a>
        </div>
    </div>
</body>
</html>
