<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <title>E-library management system</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>

            <?php

            if (isset($_SESSION['login_user']))
             {
            
               
                

            	
            ?>
                <nav>
                    <ul><li ><a href="">
                          <div style="color:white">
                    <?php
                     echo "WELCOME ".$_SESSION['login_user'];
                     ?>
                         
                     </div></a></li>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="books.php">BOOKS</a></li>
                        <li><a href="logout.php">LOGOUT</a></li>
                        <li><a href="feedback.php">FEEDBACK</a></li>                    
                    </ul>
                </nav>
            <?php
            } else {
            ?>
                <nav>
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="student_login.php">STUDENT-LOGIN</a></li> 
                        <li><a href="feedback.php">FEEDBACK</a></li>                    
                    </ul>
                </nav>
            <?php
            }
            ?>
        </header>
        
        <section>
            
            	<div class="sec_img">
			<br><br><br>
			<div class="box">
				<br><br><br><br>
				<h1 style="text-align: center; font-size:35px;">Welcome To E-Library</h1><wbr><br>
				<h1 style="text-align: center; font-size:25px;">Opens at 08:00 hrs</h1><br>
				<h1 style="text-align: center;font-size:25px;">Closes at 16:00 hrs</h1><br><br><br>
                 <h1 style="text-align: center;font-size:25px;"><a style="color: white;" href="../Admin/index.php" class="button">Go to Admin Page</a></h1><br>
				</div>
			</div>
                
            </div>
        </section>

        <footer>
            <p style="color: white;text-align: center;">
                <br><br>
                Email: library.online@outlook.com<br><br>
                Mobile: +254713615000
            </p>
        </footer>
    </div>
</body>
</html>
