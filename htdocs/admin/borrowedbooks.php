<?php
include "connection.php";
include "navbar.php";

// Fetch borrowed books data along with student information
$stmt = $db->prepare("
    SELECT bb.borrowed_books_id, bb.studentId, bb.bookid, bb.dborrowing, bb.dreturn, 
           s.fname, s.lname, b.title 
    FROM borrowed_books bb
    JOIN student s ON bb.studentId = s.studentid
    JOIN books b ON bb.bookid = b.bid
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Borrowed Books - Admin</title>
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
    </style>
</head>
<body>
    <h1>List of Borrowed Books</h1>
    <table>
        <tr>
            <th>Borrowed Books ID</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Book ID</th>
            <th>Book Title</th>
            <th>Date of Borrowing</th>
            <th>Date of Return</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['borrowed_books_id']); ?></td>
            <td><?php echo htmlspecialchars($row['studentId']); ?></td>
            <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
            <td><?php echo htmlspecialchars($row['bookid']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['dborrowing']); ?></td>
            <td><?php echo $row['dreturn'] ? htmlspecialchars($row['dreturn']) : 'Not Returned'; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$stmt->close();
?>
