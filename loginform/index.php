<?php
    session_start();
    include 'connection.php';

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $pass = $_POST['pass'];
    
        $query = "SELECT * FROM signup WHERE email=?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count = mysqli_num_rows($result);
    
        if($count > 0)
        {
            $row = mysqli_fetch_assoc($result);
    
            if($row['is_token'] == 1)
            {
                $db_pass = $row['pass'];
                if(password_verify($pass, $db_pass))
                {
                    $_SESSION['user'] = $row['user'];
                    header('location: home.php');
                    exit;
                }
                else{
                    echo "<script>alert('Invalid Password!')</script>";
                }
            }
            else
            {
                echo "<script>alert('email not verified, Please Verify Your Email')</script>";
            }
        }
        else{
            echo "<script>alert('Invalid Email!')</script>";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Login Page</title>
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
	<div class="box">
		<form autocomplete="off" method="post">
			<h2>Login Here!</h2>
			<div class="inputBox">
				<input name="email" type="email" required>
				<span>Email</span>
				<i></i>
			</div>
			<div class="inputBox">
				<input name="pass" type="password" required>
				<span>Password</span>
				<i></i>
			</div>
            <button type="button" id="toggle" onclick="showHidePassword()" style=" margin-top: 10px;" >Show Password</button>
            
			<div class="links">
				<a href="forgot.php">Forgot Password ?</a>
				<a href="signup.php">Signup</a>
			</div>
            <div class="g-recaptcha" data-sitekey="6LchLyAlAAAAAHv8oiDkzF8VmYSb6E3BxUMTbgU0"></div>
            <br>
			<input id="sujan"  type="submit" name="submit" value="login"></input>
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
</body>
</html>



