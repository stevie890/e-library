<?php
include "connection.php";
include "navbar.php";

if(isset($_POST['submit'])) {
    // Initialize error flag
    $error = false;

    // Retrieve and sanitize inputs
    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);

    // Basic validation
    if(empty($fname) || empty($lname) || empty($username) || empty($password) || empty($email) || empty($contact)) {
        echo '<script type="text/javascript">alert("All fields are required.");</script>';
        $error = true;
    }

    // Validate email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">alert("Invalid email format.");</script>';
        $error = true;
    }

    // Validate contact number format (you may need more specific validation based on your requirements)
    if(!preg_match("/^\d{10}$/", $contact)) {
        echo '<script type="text/javascript">alert("Invalid contact number format.");</script>';
        $error = true;
    }

    // Validate username length
    if(strlen($username) < 5) {
        echo '<script type="text/javascript">alert("Username must be at least 6 characters long.");</script>';
        $error = true;
    }

    // Validate password length and complexity
    if(strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[^a-zA-Z0-9]/", $password)) {
        echo '<script type="text/javascript">alert("Password must be at least 8 characters long and contain at least one number and one symbol.");</script>';
        $error = true;
    }

    if(!$error) {
        // Check if username already exists
        $sql = "SELECT username FROM Admin WHERE username = '$username'";
        $res = mysqli_query($db, $sql);

        if(mysqli_num_rows($res) > 0) {
            echo '<script type="text/javascript">alert("The username already exists.");</script>';
        } 
        else 
        {
            // Insert new admin if username is unique
            mysqli_query($db, "INSERT INTO Admin (fname, lname, username, password, email, contact) 
                               VALUES ('$fname', '$lname', '$username', '$password', '$email', '$contact')");
            echo '<script type="text/javascript">alert("Registration successful");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="logo">
            </div>
        </header>
        <section>
            <div class="reg_img">
                <br>
                <div class="box2" style="height: 600px; width: 500px;">
                    <h1 style="text-align:center; font-size:20px;">User Registration Form</h1>
                    <form name="Registration" action="" method="post" style="text-align: center;">
                        <input type="text" name="fname" placeholder="FirstName" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="lname" placeholder="LastName" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="username" placeholder="Username (min. 6 characters)" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="password" name="password" placeholder="Password (min. 8 characters, symbol, and number)" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="email" placeholder="E-Mail" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="contact" placeholder="Contact" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="submit" name="submit" value="Sign Up" style="width: 100px; height: 30px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px;">
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>

