<?php
include "connection.php";
include "navbar.php";

// Check if the student is logged in
if (!isset($_SESSION['login_user'])) {
    header('Location: student_login.php');
    exit;
}

if (isset($_GET['bid'])) {
    $bid = $_GET['bid'];
    $studentId = $_SESSION['login_user'];

    // Check if the book is available
    $stmt = $db->prepare("SELECT quantity FROM books WHERE bid = ?");
    $stmt->bind_param("i", $bid);
    $stmt->execute();
    $stmt->bind_result($quantity);
    $stmt->fetch();
    $stmt->close();

    if ($quantity > 0) {
        // Update the books table to reduce the quantity
        $stmt = $db->prepare("UPDATE books SET quantity = quantity - 1 WHERE bid = ?");
        $stmt->bind_param("i", $bid);
        $stmt->execute();
        $stmt->close();

        // Insert the borrowing record into the borrowed_books table
        $dborrowing = date('Y-m-d');
        $dreturn = date('Y-m-d', strtotime('+14 days'));

        $stmt = $db->prepare("INSERT INTO borrowed_books (studentId, bookid, dborrowing, dreturn) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $studentId, $bid, $dborrowing, $dreturn);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Book borrowed successfully!'); window.location.href = 'books.php';</script>";
    } else {
        echo "<script>alert('Sorry, this book is currently unavailable.'); window.location.href = 'books.php';</script>";
    }
} else {
    echo "<script>alert('Invalid book selection.'); window.location.href = 'books.php';</script>";
}
?>
