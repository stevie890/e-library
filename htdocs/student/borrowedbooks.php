<?php
include "connection.php";
include "navbar.php";

// Check if user is logged in
if (!isset($_SESSION['login_user'])) {
    header('Location: student_login.php');
    exit;
}

// Handle book return
if (isset($_GET['return_id'])) {
    $return_id = intval($_GET['return_id']);

    // Retrieve the book ID from the borrowed_books table
    $stmt = $db->prepare("SELECT bookid FROM borrowed_books WHERE borrowed_books_id = ?");
    $stmt->bind_param("i", $return_id);
    $stmt->execute();
    $stmt->bind_result($book_id);
    $stmt->fetch();
    $stmt->close();

    if ($book_id) {
        // Update the books table to increase the quantity
        $stmt = $db->prepare("UPDATE books SET quantity = quantity + 1 WHERE bid = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $stmt->close();

        // Update the borrowed_books table to set the return date
        $stmt = $db->prepare("UPDATE borrowed_books SET dreturn = NOW() WHERE borrowed_books_id = ?");
        $stmt->bind_param("i", $return_id);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Book returned successfully!'); window.location.href='borrowed_books.php';</script>";
    } else {
        echo "<script>alert('Error: Book not found.'); window.location.href='borrowed_books.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Borrowed Books</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: white;
        }

        .button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1 style="font-size: 20px;">List of Borrowed Books</h1>
    <?php
    // Fetch borrowed books data
    $stmt = $db->prepare("SELECT * FROM borrowed_books");
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Query failed: " . $db->error);
    }

    echo "<table>";
    echo "<tr>";
    // Table header
    echo "<th>Borrowed Books ID</th>";
    echo "<th>Student ID</th>";
    echo "<th>Book ID</th>";
    echo "<th>Date of Borrowing</th>";
    echo "<th>Date of Return</th>";
    echo "<th>Action</th>"; // New column for actions
    echo "</tr>";

    // Table data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['borrowed_books_id']}</td>";
        echo "<td>{$row['studentId']}</td>";
        echo "<td>{$row['bookid']}</td>";
        echo "<td>{$row['dborrowing']}</td>";
        echo "<td>" . ($row['dreturn'] ? $row['dreturn'] : 'Not Returned') . "</td>";
        echo "<td>";
        if (!$row['dreturn']) { // Check if the book is not yet returned
            echo "<a href='?return_id={$row['borrowed_books_id']}' class='button'>Return</a>";
        } else {
            echo "Returned";
        }
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    $stmt->close();
    ?>
</body>
</html>
