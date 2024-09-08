 <?php
 include "connection.php";
 include "navbar.php";

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	
 	<title>
 	Student Login
 </title>
 	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
 <body>
 	<div class="wrapper">
		<header>
			
			
			</header>
			<section>
				<div class="login_img">
    <br><br><br>
    <div class="box1" style=" height: 400px; width: 400px; text-align: center; font-size: 20px;">
        <h1 style="text-align: center; font-size: 25px;">User Login Form</h1><br><br>
        <form name="Login" action="" method="post">
            <br><br>
            <div class="login">
                               <input type="text" name="username" placeholder="Username" required style="width: 300px; padding: 6px; margin: 5px;"><br><br><br>
                <input type="password" name="password" placeholder="Password" required style="width: 300px; padding: 6px; margin: 5px;"><br><br>

                <input type="submit" name="submit" value="Login" style="width: 100px; height: 30px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px;">
            </div>
        </form>
        <p style="color: white; padding-left: 15px;">
            <br><br>
            <a style="color: white;" href="">Forgot password</a>&nbsp&nbsp&nbsp
            New to this website?<a style="color:white" href="registration.php"> Sign Up</a>
        </p>
    </div>
</div>

			</section>
			<?php

			if(isset($_POST['submit']))
			{

                $count=0;
				$res=mysqli_query($db,"SELECT * FROM `student` WHERE username='$_POST[username]' && password='$_POST[password]';");
				$count=mysqli_num_rows($res);

				if($count==0)
				{
					?>
					<!--
					<script type="text/javascript">
						alert("the username and password does not match")
					</script>
				-->
				<div class="alert alert-danger" style="position: absolute; width: 600px; margin-left: 370px; background-color: #de1313; color: white;"> 
					<strong> The username and password doesn't match</strong>

				</div>
					<?php
				}

				else
				{
					$_SESSION['login_user'] = $_POST['username'];
					?>
					<script type="text/javascript">
						window.location="index.php"
					</script>
					<?php

				}
			}

			?>
 
 </body>
 </html>