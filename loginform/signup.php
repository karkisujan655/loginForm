<?php
    include 'connection.php';
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    function phpMailSend($email, $token_check){
    require 'mail/Exception.php';
    require 'mail/PHPMailer.php';
    require 'mail/SMTP.php';
    
      $mail = new PHPMailer(true);
      try {
        $mail->SMTPDebug = 0;                     
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'karkisujan655@gmail.com';                    
        $mail->Password   = 'gyhsnikktqjppofa';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
        $mail->Port       = 465;  
        $mail->setFrom('karkisujan655@gmail.com', 'SUJAN');
        $mail->addAddress($email);
        $mail->isHTML(true);                                 
        $mail->Subject = 'Verify Your Email';
        $mail->Body    = "<a href='http://localhost/loginform/emailverification.php?email=$email&token_check=$token_check'>Click Here To Verify Your Email!</a>";
        $mail->send();  
        return true;                          
    }
    catch (Exception $e) {
      return false;
  }
}

    if(isset($_POST['submit'])){
        $user=mysqli_real_escape_string($connection, $_POST['user']);
        $email=mysqli_real_escape_string($connection, $_POST['email']);
        $pass=mysqli_real_escape_string($connection, $_POST['pass']);
        $cpass=mysqli_real_escape_string($connection, $_POST['cpass']);
       
        $has_pass=password_hash("$pass", PASSWORD_DEFAULT);

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/", $pass)) {
            echo "<script>alert('password must contain at least 1 uppercase letter, 1 number, and 1 special character!')</script>";
         } else {
             $has_pass=password_hash("$pass", PASSWORD_DEFAULT);
           
         

        $equery="select * from signup where email='$email'";
        $query=mysqli_query($connection, $equery);
        $ecount=mysqli_num_rows($query);
        if($ecount>0)
        {
            echo "<script>alert('email already exists!')</script>";
        }        
        else{
            if($pass!=$cpass)
            {
                echo "<script>alert('password not matched!')</script>";
            }
            else{
                $token_check=bin2hex(random_bytes(18));
                $insertq="INSERT INTO `signup` (`user`, `email`, `pass`, `token`, `is_token`) VALUES ('$user', '$email', '$has_pass', '$token_check', '0')" or die('failed');
                $insertquery=mysqli_query($connection, $insertq);
                if($insertquery && phpMailSend($_POST['email'], $token_check))
                {
                    echo "<script>alert('registered! please check your email'); window.location.href='index.php'</script>";
                }
                else
                {
                    echo "<script>alert('not registered!')</script>";
                }
            }
        }

    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to SignUp page</title>
	<link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
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
	<div class="box1" >
		<form autocomplete="off" action="" method="POST">
			<h2>Sign Up Here!</h2>
			<div class="inputBox">
				<input type="text" name="user" required>
				<span>Username</span>
				<i></i>
			</div>

            <div class="inputBox">
				<input type="email" id="email" name="email" required>
				<span>Email</span>
				<i></i>
			</div>
			

			<div class="inputBox">
				<input oninput="PasswordChange()" type="password" id="password" name="pass" required >
				<span>Password</span>
				<i></i>
			</div>

            <button type="button" id="toggle" onclick="showHidePassword()" style=" margin-top: 10px;" >Show Password</button>

            
            <p class="message" id="message">Password is <span id="msg"> </span> </p>

            <div class="inputBox y">
				<input type="password" name="cpass" required>
				<span>Confirm   Password</span>
				<i></i>
			</div>

            <div class="g-recaptcha" data-sitekey="6LchLyAlAAAAAHv8oiDkzF8VmYSb6E3BxUMTbgU0"></div>
			

			<div class="links">
				<a href="index.php">Already have an account? Login</a>
			</div>
			
			<input id="sujan" type="submit" name="submit" value="submit"></input>
		</form>
	</div>

    <script type="text/javascript">
    $(document).on('click', '#sujan', function(){
        var response = grecaptcha.getResponse();
        if(response.length==0)
        {
            alert("please verify you are not a robot!!");
            return false;
        }
    });

    </script>
    

<script src="js/strength.js"></script>
</body>
</html>
