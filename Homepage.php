<?php
session_start();

// Check if user is logged in, if not redirect to Login page
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
    <title>Library Management System - Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         /* Root Variables for Colors */
         :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }

        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: url('images/Homepage.jpeg') no-repeat center center fixed; /* Replace with your image */
            background-size: cover;
            color: #fff;
        }

        /* Navbar with Gradient */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* Jumbotron */
        .jumbotron {
            background: rgba(0, 0, 0, 0.7); /* Transparent black background */
            padding: 30px;
            border-radius: 10px;
            margin-top: 3rem;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        footer {
            background: var(--primary-color);
            color: white;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 0.5rem 0; /* Reduced padding for lower height */
            font-size: 0.9rem; /* Adjusted font size for compact appearance */
        }

        footer .p-3 {
            margin: 0;
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

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Your Dashboard</h1>
            <p class="lead">
                Explore the Library Management System! From browsing the catalog to managing your account and reserving books, everything is at your fingertips.
            </p>
            <hr class="my-4">
            <p>
                Use the navigation menu above to access the system's features.
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="text-center p-3">
            &copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
