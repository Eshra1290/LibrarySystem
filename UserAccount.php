<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

// Fetch user profile information
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch borrowed books
$borrowed_sql = "
    SELECT bb.borrowing_id, bb.borrow_date, bb.return_date, bb.status, b.title AS book_title 
    FROM book_borrowings bb
    JOIN books b ON bb.book_id = b.book_id 
    WHERE bb.user_id = ? AND bb.status = 'borrowed'
";
$stmt = $conn->prepare($borrowed_sql);
$stmt->bind_param('i', $user['user_id']);
$stmt->execute();
$borrowed_books = $stmt->get_result();

// Fetch reserved books
$reserved_sql = "
    SELECT bb.borrowing_id, bb.borrow_date, bb.status, b.title AS book_title 
    FROM book_borrowings bb
    JOIN books b ON bb.book_id = b.book_id 
    WHERE bb.user_id = ? AND bb.status = 'reserved'
";
$stmt = $conn->prepare($reserved_sql);
$stmt->bind_param('i', $user['user_id']);
$stmt->execute();
$reserved_books = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - User Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <li class="nav-item">
                        <a class="nav-link" href="Catalog.php">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="UserAccount.php">User Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="BookDetails.php">Book Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="BorrowReservation.php">Borrow/Reserve</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4">User Account</h1>
        <div class="row">
            <!-- Profile Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Profile Information
                    </div>
                    <div class="card-body text-center">
                        <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'default.jpg'); ?>" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
                        <form action="UploadProfilePicture.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profile_picture" class="form-control mb-2">
                            <button type="submit" class="btn btn-primary">Update Profile Picture</button>
                        </form>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <a href="EditProfile.php" class="btn btn-secondary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <!-- Borrowed Books Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Borrowed Books
                    </div>
                    <div class="card-body">
                        <?php if ($borrowed_books->num_rows > 0): ?>
                            <ul class="list-group">
                                <?php while ($row = $borrowed_books->fetch_assoc()): ?>
                                    <li class="list-group-item">
                                        <strong>Book Title:</strong> <?php echo htmlspecialchars($row['book_title']); ?><br>
                                        <strong>Borrowed On:</strong> <?php echo htmlspecialchars($row['borrow_date']); ?><br>
                                        <strong>Return By:</strong> <?php echo htmlspecialchars($row['return_date'] ?? 'Not Returned'); ?><br>
                                        <strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?><br>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>No borrowed books.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reserved Books Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        Reserved Books
                    </div>
                    <div class="card-body">
                        <?php if ($reserved_books->num_rows > 0): ?>
                            <ul class="list-group">
                                <?php while ($row = $reserved_books->fetch_assoc()): ?>
                                    <li class="list-group-item">
                                        <strong>Book Title:</strong> <?php echo htmlspecialchars($row['book_title']); ?><br>
                                        <strong>Reserved On:</strong> <?php echo htmlspecialchars($row['borrow_date']); ?><br>
                                        <strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?><br>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>No reserved books.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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
