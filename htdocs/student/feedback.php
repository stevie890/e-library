<?php
include "connection.php";
include "navbar.php"
?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
           body {
            background-image: url("images/1.jpg");
        }

        .wrapper {
            padding: 10px;
            margin: 20px auto;
            width: 900px;
            height: 600px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
        }

        form {
            text-align: center;
            margin: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px;
            width: 40%;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h1 {
            text-align: center;
        }

        .scroll {
            width: 100%;
            height: 400px;
            overflow: auto;
        }

        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            margin: 2px; /* Add margin to create space between cells */
        }
    </style>
</head>
<body>
    <div>
        <header>
            <div class="logo">
                <img src="">
            </div>

            <nav>
                <ul>
                    
                </ul>
            </nav>

        </header>

        <div class="wrapper">
            <h1> If you have any questions or suggestions please comment below.</h1>
            <form style="text-align: center; margin: 20px;" action="" method="post">
                <input type="text" name="comment" placeholder="Write something" style="padding: 20px; width: 500px;height: 35px; margin-right: 5px; border: 1px solid #ccc; border-radius: 5px;"><br><br>
                <input type="submit" name="submit" value="Comment" style="padding: 5px;width: 100px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 10px;">
            </form>
         <div class="scroll">
                <?php
                if (isset($_POST['submit'])) {
                    $sql = "INSERT INTO `comments` (`comment`) VALUES ('$_POST[comment]')";
                    if (mysqli_query($db, $sql)) {
                        $q = "SELECT * FROM `comments` ORDER BY `comments`.`id` DESC";
                        $res = mysqli_query($db, $q);
                        echo "<table class='table table-bordered'>";
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>";
                            echo "<td>";
                            echo $row['comment'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                } else {
                    $q = "SELECT * FROM `comments` ORDER BY `comments`.`id` DESC";
                    $res = mysqli_query($db, $q);
                    echo "<table class='table table-bordered'>";
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>";
                        echo $row['comment'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>
        </div>
    </body>
</html>