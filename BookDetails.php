<?php
session_start();
require 'db_connect.php'; // Include your database connection

// Fetch all books from the database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Store the books in an array
    $books = [];
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo "No books found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
  
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="Homepage.php">Library Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="Catalog.php">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="UserAccount.php">User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="BookDetails.php">Book Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="BorrowReservation.php">Borrow/Reserve</a></li>
                    <li class="nav-item"><a class="nav-link" href="Logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="text-center">Book Details</h1>

        <!-- Display all books -->
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($book['book_cover']); ?>" class="card-img-top" alt="Book Cover" style="height: 250px; object-fit: cover;">
                        <div class="card-header bg-primary text-white">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </div>
                        <div class="card-body">
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                            <p><strong>Availability:</strong> 
                                <?php echo $book['quantity'] > 0 ? 'Available' : 'Out of Stock'; ?>
                            </p>
                            <p><strong>Quantity:</strong> <?php echo htmlspecialchars($book['quantity']); ?></p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookModal<?php echo $book['book_id']; ?>">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal for Book Details -->
                <div class="modal fade" id="bookModal<?php echo $book['book_id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $book['book_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo $book['book_id']; ?>">
                                    <?php echo htmlspecialchars($book['title']); ?> - Details
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($book['quantity']); ?></p>
                                <p><strong>Availability:</strong> 
                                    <?php echo $book['quantity'] > 0 ? 'Available' : 'Out of Stock'; ?>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-auto py-3">
        <div class="text-center p-3">
            &copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
