<?php
session_start();

// Check if the user is logged in as admin, if not, redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: Login.php");
    exit();
}

// Include database connection
include('db_connect.php'); // Include the connection file

// Handle book deletion
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        header("Location: Admin.php"); // Redirect to Admin page after deletion
        exit();
    } else {
        echo "Error deleting book: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: Admin.php"); // Redirect if no ID is set
    exit();
}

$conn->close();
?>
