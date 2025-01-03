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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .hero-section {
            background: url('https://source.unsplash.com/1600x400/?library,books') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 2rem 1rem;
            box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.5);
        }

        .hero-section h1 {
            font-size: 3rem;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: none;
            border-radius: 10px;
        }

        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <h1>Borrow or Reserve Your Favorite Books</h1>
        <p class="lead">Browse our extensive collection and enjoy reading.</p>
    </div>

    <div class="container mt-5">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"> <?php echo $message; ?> </div>
        <?php endif; ?>

        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="https://source.unsplash.com/300x200/?book,<?php echo $row['title']; ?>" alt="Book Image" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo $row['title']; ?> </h5>
                                <p class="card-text"> Author: <?php echo $row['author'] ?? 'Unknown'; ?> </p>
                                <p class="card-text"> Quantity Available: <?php echo $row['quantity']; ?> </p>
                                <form method="POST" action="BorrowReservation.php">
                                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                    <button type="submit" name="action" value="borrow" class="btn btn-primary"> Borrow </button>
                                    <button type="submit" name="action" value="reserve" class="btn btn-secondary"> Reserve </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center">No books available for borrowing or reservation.</div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="text-center bg-dark text-light py-3 mt-4">
        <p>&copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
