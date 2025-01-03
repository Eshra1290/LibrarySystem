<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: rgba(44, 62, 80, 0.8);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: white;
        }

        .jumbotron {
            background: rgba(44, 62, 80, 0.85);
            padding: 3rem;
            border-radius: 8px;
            margin-top: 100px;
        }

        footer {
            background-color: rgba(44, 62, 80, 0.8);
            color: white;
            text-align: center;
            padding: 1rem;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
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
                        <a class="nav-link" href="UserAccount.php">User Account</a>
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

    <div class="container d-flex justify-content-center align-items-center">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Your Dashboard</h1>
            <p class="lead">Explore the Library Management System! From browsing the catalog to managing your account and reserving books, everything is at your fingertips.</p>
            <hr class="my-4">
            <p>Use the navigation menu above to access the system's features.</p>
        </div>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
