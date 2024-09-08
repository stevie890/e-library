<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>

            <?php

            if (isset($_SESSION['login_user']))
             { 
            	
            ?>
                <nav>
                    <ul>
                    	<li><a href="">
                          <div style="color:white">
                    <?php
                     echo "WELCOME ".$_SESSION['login_user'];
                     ?>
                         
                     </div></a></li>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="books.php">BOOKS</a></li>
                         <li><a href="borrowedbooks.php">BORROWED-BOOKS</a></li>
                        <li><a href="registration.php">REGISTRATION</a></li>
                        <li><a href="feedback.php">FEEDBACK</a></li> 
                        <li><a href="logout.php">LOGOUT</a></li>                   
                    </ul>
                </nav>
            <?php
            } else {
            ?>
                <nav>
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="student_login.php">STUDENT-LOGIN</a></li>
                        <li><a href="registration.php">REGISTRATION</a></li>
                        <li><a href="feedback.php">FEEDBACK</a></li>                    
                    </ul>
                </nav>
            <?php
            }
            ?>
        </header>
</body>
</html>
