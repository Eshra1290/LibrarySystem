<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

$sql = "SELECT * FROM books WHERE quantity > 0";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $action = $_POST['action'];
    $username = $_SESSION['username'];

    $user_sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($user_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    $user_id = $user['user_id'];
    $stmt->close();

    if ($action === 'borrow') {
        $borrow_sql = "INSERT INTO book_borrowings (user_id, book_id, status) VALUES (?, ?, 'borrowed')";
        $update_sql = "UPDATE books SET quantity = quantity - 1 WHERE book_id = ?";
    } elseif ($action === 'reserve') {
        $borrow_sql = "INSERT INTO book_borrowings (user_id, book_id, status) VALUES (?, ?, 'reserved')";
    }

    $stmt = $conn->prepare($borrow_sql);
    $stmt->bind_param("ii", $user_id, $book_id);

    if ($stmt->execute() && ($action === 'borrow' ? $conn->query($update_sql) : true)) {
        $message = ucfirst($action) . " successful!";
    } else {
        $message = "Error: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow or Reserve Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }

        body {
            background: url('images/Homepage.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

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

        .container {
            margin-top: 3rem;
        }

        .card {
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn-primary {
            background: var(--secondary-color);
            border: none;
        }

        .btn-secondary {
            background: var(--primary-color);
            border: none;
        }

        footer {
            background: var(--primary-color);
            color: white;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
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

    <div class="container">
        <?php if (!empty($message)): ?>
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
