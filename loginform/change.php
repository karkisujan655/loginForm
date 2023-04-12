<?php
    require("connection.php");
    if(isset($_GET['email']) && isset($_GET['reset_token']))
    {
        date_default_timezone_set('Asia/kathmandu');
        $date=date("Y-m-d");

        $email = mysqli_real_escape_string($connection, $_GET['email']);
        $reset_token = mysqli_real_escape_string($connection, $_GET['reset_token']);

        $sql="SELECT * FROM `signup` WHERE `email`='$email' AND `reset_token`='$reset_token' AND `token_expire`='$date'";
        $result=mysqli_query($connection, $sql);
        if ($result) 
        {
            if (mysqli_num_rows($result) == 1) 
            {
                if(isset($_POST['reset']))
                {
                    $pass = mysqli_real_escape_string($connection, $_POST['pass']);
                    $confirm_pass = mysqli_real_escape_string($connection, $_POST['cpass']);

                    if(strlen($pass) >= 8 && $pass == $confirm_pass) {
                        // Add more secure password policy here
                        $password_hash = password_hash($pass, PASSWORD_BCRYPT);
                        $update_query = "UPDATE `signup` SET `pass`='$password_hash', `reset_token`=NULL, `token_expire`=NULL WHERE `email`='$email'";
                        $result = mysqli_query($connection, $update_query);
                    
                        if($result) {
                            echo "<script>alert('New Password Updated Successfully🎉'); window.location.href='index.php';</script>";
                        } else {
                            echo "<script>alert('Error!!');window.location.href='change.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Password must have at least 8 characters and match the confirmation.');window.location.href='change.php';</script>";
                        exit();
                    }
                } 
            } else {
                echo "<script>alert('Invalid or expired link!');window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid email');window.location.href='index.php';</script>";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Change Password</title>
    <script>
		function showHidePassword() {
			var passwordInput = document.getElementsByName("pass")[0];
			var toggleButton = document.getElementById("toggle");
			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				toggleButton.innerHTML = "Hide Password";
			} else {
				passwordInput.type = "password";
				toggleButton.innerHTML = "Show Password";
			}
		}
	</script>
</head>
<body>
<div class="box">
        <form action="" autocomplete="off" method="POST">
            <h2>Change Password</h2>
            <!-- <div class="inputBox">
                <input type="email" name="email" required="required" placeholder="Enter your email">
                <i></i>
            </div> -->
            <!-- <div class="inputBox">
                <input type="password" name="new_password" required="required" placeholder="Enter new password">
                <i></i>
            </div> -->
            <div class="inputBox">
				<input oninput="PasswordChange()" type="password" id="password" name="pass" required >
				<span>New Password</span>
				<i></i>
			</div>
            
            <p class="message" id="message">PasswordStrength: <span id="msg"> </span> </p>

            <button type="button" id="toggle" onclick="showHidePassword()" style=" margin-top: 10px;" >Show Password</button>


            <div class="inputBox">
                <input type="password" name="cpass" required placeholder="Confirm new password">
                <i></i>
            </div>
            <input type="hidden" name="code" value=" ">
            <input type="submit" value="Confirm" name="reset">
            <div class="links">
                <a href="index.php">Cancel</a>
            </div>
        </form>
    </div>
    <script src="js/strength.js"></script>
</body>
</html>
