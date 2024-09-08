<?php
include "connection.php";
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books</title>
    <style>
        .srch {
            padding-left: 20px;
            padding-right: 20px;
        }
        .navbar-form {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .navbar-form input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
        }
        .navbar-form button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .navbar-form button:hover {
            background-color: #45a049;
        }
        .wrapper {
            height: auto;
        }
        .books-list {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            padding: 8px;
            border: 1px solid #ddd;
            background-color: #10c1c7e8;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="wrapper" style="height: auto;">
        <header>
            <div class="logo"></div>
        </header>
    </div>
    <!-- Search bar -->
    <div class="srch">
        <form class="navbar-form" method="post" name="form1">
            <input type="text" name="search" placeholder="Search books......" required="">
            <button type="submit" name="submit">Search</button>
        </form>
    </div>

    <div class="books-list">
        <h2 style="font-size: 30px; text-align: left;">List of books</h2>

        <?php
        if (isset($_POST['submit'])) {
            // Use prepared statement to avoid SQL injection
            $searchTerm = "%{$_POST['search']}%";
            $stmt = $db->prepare("SELECT * FROM books WHERE name LIKE ?");
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                echo "Sorry! no books found. Try searching again";
            } else {
                echo "<table class='table table-bordered table-hover' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr style='background-color: #10c1c7e8;'>";
                // table header
                echo "<th>Name</th>";
                echo "<th>Book id</th>";
                echo "<th>Author</th>";
                echo "<th>ISBN</th>";
                echo "<th>Quantity</th>";
                echo "<th>Status</th>";
                echo "<th>Department</th>";
                echo "<th>Action</th>"; // New column for actions
                echo "</tr>";

                // table data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['bid']}</td>";
                    echo "<td>{$row['author']}</td>";
                    echo "<td>{$row['isbn']}</td>";
                    echo "<td>{$row['quantity']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['department']}</td>";
                    echo "<td><a href='borrow.php?bid={$row['bid']}' class='button'>Borrow</a></td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

            $stmt->close();
        } else {
            $res = mysqli_query($db, "SELECT * FROM `books`;");

            echo "<table class='table table-bordered table-hover' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background-color: #10c1c7e8;'>";
            // table header
            echo "<th>Name</th>";
            echo "<th>Book id</th>";
            echo "<th>Author</th>";
            echo "<th>ISBN</th>";
            echo "<th>Quantity</th>";
            echo "<th>Status</th>";
            echo "<th>Department</th>";
            echo "<th>Action</th>"; // New column for actions
            echo "</tr>";

            // table data
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['bid']}</td>";
                echo "<td>{$row['author']}</td>";
                echo "<td>{$row['isbn']}</td>";
                echo "<td>{$row['quantity']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>{$row['department']}</td>";
                echo "<td><a href='borrow.php?bid={$row['bid']}' class='button'>Borrow</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        ?>

    </div>
</body>
</html>
