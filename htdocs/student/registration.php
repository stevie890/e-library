<?php
include "connection.php";
include "navbar.php";

if(isset($_POST['submit'])) {
    // Initialize error flag
    $error = false;

    // Retrieve and sanitize inputs
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $studentid = isset($_POST['studentid']) ? $_POST['studentid'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';

    // Basic validation
    if(empty($fname) || empty($lname) || empty($username) || empty($password) || empty($studentid) || empty($email) || empty($contact)) {
        $error = true;
        $message = "All fields are required.";
    }

    // Validate email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $message = "Invalid email format.";
    }

    // Validate contact number format (assuming 10 digits)
    if(!preg_match("/^\d{10}$/", $contact)) {
        $error = true;
        $message = "Invalid contact number format.";
    }

    // If no errors, proceed with database operations
    if(!$error) {
        // Prepare statements to avoid SQL injection
        $stmt = $db->prepare("SELECT username FROM student WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $message = "The username already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the insert query
            $stmt = $db->prepare("INSERT INTO student (fname, lname, username, password, studentid, email, contact) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $fname, $lname, $username, $hashed_password, $studentid, $email, $contact);
            $stmt->execute();
            $stmt->close();

            $message = "Registration successful.";
        }

        // Show message
        echo '<script type="text/javascript">alert("' . $message . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="logo"></div>
        </header>
        <section>
            <div class="reg_img">
                <br>
                <div class="box2" style="height: 600px; width: 500px;">
                    <h1 style="text-align:center; font-size:20px;">User Registration Form</h1>
                    <form name="Registration" action="" method="post" style="text-align: center;">
                        <input type="text" name="fname" placeholder="First Name" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="lname" placeholder="Last Name" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="username" placeholder="Username" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="password" name="password" placeholder="Password" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
                        <input type="text" name="studentid" placeholder="Student Number" required style="width: 300px; padding: 8px; margin: 5px;"><br><br>
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
