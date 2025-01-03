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
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Borrow or Reserve Books</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                <p class="card-text">Author: <?php echo $row['author']; ?></p>
                                <p class="card-text">Quantity: <?php echo $row['quantity']; ?></p>
                                <form method="POST" action="BorrowReservation.php">
                                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                    <button type="submit" name="action" value="borrow" class="btn btn-primary">Borrow</button>
                                    <button type="submit" name="action" value="reserve" class="btn btn-secondary">Reserve</button>
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
</body>
</html>
