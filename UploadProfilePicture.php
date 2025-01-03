<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

// Check if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $username = $_SESSION['username'];

    // File upload configuration
    $uploadDir = "uploads/profile_pictures/";
    $fileName = basename($_FILES['profile_picture']['name']);
    $targetFilePath = $uploadDir . $fileName;

    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (in_array(strtolower($fileType), $allowedTypes)) {
        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFilePath)) {
            // Update the database with the new file path
            $query = "UPDATE users SET profile_picture = ? WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $targetFilePath, $username);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Profile picture updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update the database.";
            }
        } else {
            $_SESSION['error'] = "Failed to upload the file.";
        }
    } else {
        $_SESSION['error'] = "Invalid file type. Allowed types: jpg, jpeg, png, gif.";
    }
} else {
    $_SESSION['error'] = "No file uploaded.";
}

header("Location: UserAccount.php");
exit();
?>
