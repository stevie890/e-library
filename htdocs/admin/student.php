<?php
include "connection.php";
include "navbar.php";

// Add Student
if (isset($_POST['add_student'])) {
    $studentid = isset($_POST['studentid']) ? mysqli_real_escape_string($db, $_POST['studentid']) : '';
    $fname = isset($_POST['fname']) ? mysqli_real_escape_string($db, $_POST['fname']) : '';
    $lname = isset($_POST['lname']) ? mysqli_real_escape_string($db, $_POST['lname']) : '';
    $username = isset($_POST['username']) ? mysqli_real_escape_string($db, $_POST['username']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : '';
    $contact = isset($_POST['contact']) ? mysqli_real_escape_string($db, $_POST['contact']) : '';

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO student (studentid, fname, lname, username, password, email, contact) VALUES ('$studentid', '$fname', '$lname', '$username', '$hashed_password', '$email', '$contact')";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Student added successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error adding student: " . mysqli_error($db) . "</div>";
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Remove Student
if (isset($_POST['remove_student'])) {
    $studentid = isset($_POST['studentid']) ? mysqli_real_escape_string($db, $_POST['studentid']) : '';

    $query = "DELETE FROM student WHERE studentid='$studentid'";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Student removed successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error removing student: " . mysqli_error($db) . "</div>";
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Approve Student Registration
if (isset($_POST['approve_student'])) {
    $studentid = isset($_POST['studentid']) ? mysqli_real_escape_string($db, $_POST['studentid']) : '';

    $query = "UPDATE student SET is_approved=1 WHERE studentid='$studentid'";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Student approved successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error approving student: " . mysqli_error($db) . "</div>";
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch Students
$student_query = "SELECT * FROM student";
$student_result = mysqli_query($db, $student_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Student Management</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 2em;
            color: #333;
        }

        .student_management {
            text-align: center;
        }

        .student_management h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #555;
        }

        form {
            margin-bottom: 60px;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 40%;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Admin - Student Management</h1>
        </header>
        <section>
            <div class="student_management">
                <div class="box3">
                <h2>Manage Students</h2>
                <form method="post" action="">
                    <input type="text" name="studentid" placeholder="Student ID" required>
                    <input type="text" name="fname" placeholder="First Name" required>
                    <input type="text" name="lname" placeholder="Last Name" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="contact" placeholder="Contact" required>
                    <input type="submit" name="add_student" value="Add Student">
                </form>

                <h3>Remove Student</h3>
                <form method="post" action="">
                    <input type="text" name="studentid" placeholder="Student ID" required>
                    <input type="submit" name="remove_student" value="Remove Student">
                </form>

                <h3>Approve Student Registrations</h3>
                <form method="post" action="">
                    <input type="text" name="studentid" placeholder="Student ID" required>
                    <input type="submit" name="approve_student" value="Approve Student">
                </form>
                </div>

                <h3>Registered Students</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($student = mysqli_fetch_assoc($student_result)): ?>
                            <tr>
                                <td><?php echo $student['studentid']; ?></td>
                                <td><?php echo $student['fname']; ?></td>
                                <td><?php echo $student['lname']; ?></td>
                                <td><?php echo $student['username']; ?></td>
                                <td><?php echo $student['is_approved'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
