<?php
include "connection.php";
include "navbar.php";

// Check if the admin is logged in
if (!isset($_SESSION['login_user'])) {
    header('Location: admin_login.php');
    exit;
}

// Add Book
if (isset($_POST['add_book'])) {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($db, $_POST['name']) : '';
    $bid = isset($_POST['bid']) ? mysqli_real_escape_string($db, $_POST['bid']) : '';
    $author = isset($_POST['author']) ? mysqli_real_escape_string($db, $_POST['author']) : '';
    $isbn = isset($_POST['isbn']) ? mysqli_real_escape_string($db, $_POST['isbn']) : '';
    $quantity = isset($_POST['quantity']) ? mysqli_real_escape_string($db, $_POST['quantity']) : '';
    $status = isset($_POST['status']) ? mysqli_real_escape_string($db, $_POST['status']) : '';
    $department = isset($_POST['department']) ? mysqli_real_escape_string($db, $_POST['department']) : '';

    $query = "INSERT INTO books (name, bid, author, isbn, quantity, status, department) VALUES ('$name', '$bid', '$author', '$isbn', '$quantity', '$status', '$department')";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Book added successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error adding book: " . mysqli_error($db) . "</div>";
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Remove Book
if (isset($_POST['remove_book'])) {
    $bid = isset($_POST['bid']) ? mysqli_real_escape_string($db, $_POST['bid']) : '';

    $query = "DELETE FROM books WHERE bid='$bid'";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Book removed successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error removing book: " . mysqli_error($db) . "</div>";
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books</title>
    <style>
         /* Style for the search bar */
        .srch {
            padding-left: 20px; 
            padding-right: 20px; 
        }

        /* Style for the form container */
        .navbar-form {
            display: flex;
            align-items: center;
            margin-bottom: 20px; 
        }

        /* Style for the search input */
        .navbar-form input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
        }

        /* Style for the submit button */
        .navbar-form button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Hover effect for the submit button */
        .navbar-form button:hover {
            background-color: #45a049;
        }

        /* Style for the wrapper */
        .wrapper {
            height: auto;
        }

        /* Style for the books list */
        .books-list {
            margin-top: 20px;
        }

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; 
        }

        /* Style for table header */
        th {
            padding: 8px;
            border: 1px solid #ddd;
            background-color: #10c1c7e8;
        }

        /* Style for table data cells */
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="wrapper" style="height: auto;">
        <header>
            <div class="logo">
            </div>
        </header>
    </div>

    <!-- Add Book Form -->
    <div class="srch">
        <form class="navbar-form" method="post">
            <br><br><br>
            <div class="add_book"> <h2 style="font-size: 30px; text-align: left;">Add Book</h2>

                <br>
            <input type="text" name="name" placeholder="Book Name" required><br>
            <input type="text" name="bid" placeholder="Book ID" required><br>
            <input type="text" name="author" placeholder="Author" required><br>
            <input type="text" name="isbn" placeholder="ISBN" required><br>
            <input type="text" name="quantity" placeholder="Quantity" required><br>
            <input type="text" name="status" placeholder="Status" required><br>
            <input type="text" name="department" placeholder="Department" required><br><br><br>
            <button type="submit" name="add_book">Add Book</button>
            </div>
        </form>
    </div>

    <!-- Remove Book Form -->
    <div class="srch">
        <form class="navbar-form" method="post">
            <h3>Remove Book</h3>
            <input type="text" name="bid" placeholder="Book ID" required>
            <button type="submit" name="remove_book">Remove Book</button>
        </form>
    </div>

    <!-- Existing Search Bar -->
    <div class="srch">
        <form class="navbar-form" method="post" name="form1">
            <input type="text" name="search" placeholder="Search books..." required="">
            <button type="submit" name="submit">Search</button>
        </form>
    </div>

    <!-- Books List -->
    <div class="books-list">
        <h2 style="font-size: 30px; text-align: left;">List of books</h2>

               <?php
      if(isset($_POST['submit'])) {
    // prepared statement to avoid SQL injection
    $searchTerm = "%{$_POST['search']}%";
    $stmt = $db->prepare("SELECT * FROM books WHERE name LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0) {
        echo "Sorry! no books found. Try searching again";
    } else {
        echo "<table class='table table-bordered table-hover' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #10c1c7e8;'>";
        // table header
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>Name</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>Book id</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>Author</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>ISBN</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>Quantity</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>Status</th>";
        echo "<th style='padding: 8px; border: 1px solid #ddd;'>Department</th>";
        echo "</tr>";

        // table data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['name']}</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['bid']}</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['author']}</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['isbn']}</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['quantity']}</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['status']}</td>";
            echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['department']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    $stmt->close();
}
 else {
            $res = mysqli_query($db, "SELECT * FROM `books`;");

            echo "<table class='table table-bordered table-hover' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background-color: #10c1c7e8;'>";
            // table header
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>Name</th>";
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>Book id</th>";
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>Author</th>";
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>ISBN</th>";
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>Quantity</th>";
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>Status</th>";
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>Department</th>";
            echo "</tr>";

            // table data
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['name']}</td>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['bid']}</td>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['author']}</td>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['isbn']}</td>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['quantity']}</td>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['status']}</td>";
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$row['department']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        ?>
    </div>
</body>
</html>
