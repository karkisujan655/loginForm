<?php
    require("connection.php");
    if(isset($_GET['email']) && isset($_GET['token_reset']))
    {
        date_default_timezone_set('Asia/kathmandu');
        $date=date("Y-m-d");

        $email = mysqli_real_escape_string($connection, $_GET['email']);
        $reset_token = mysqli_real_escape_string($connection, $_GET['token_reset']);

        $sql="SELECT * FROM `signup` WHERE `email`='$email' AND `reset_token`='$reset_token' AND `token_expire`='$date'";
        $result=mysqli_query($connection, $sql);
        if ($result) 
        {
            if (mysqli_num_rows($result) == 1) 
            {
                if(isset($_POST['change']))
                {
                    $pass = mysqli_real_escape_string($connection, $_POST['pass']);
                    $confirm_pass = mysqli_real_escape_string($connection, $_POST['cpass']);

                    if(strlen($pass) >= 8 && $pass == $confirm_pass) {
                        // Add more secure password policy here
                        $password_hash = password_hash($pass, PASSWORD_BCRYPT);
                        $update_query = "UPDATE `signup` SET `password`='$password_hash', `reset_token`=NULL, `token_expire`=NULL WHERE `email`='$email'";
                        $result = mysqli_query($connection, $update_query);
                    
                        if($result) {
                            echo "<script>alert('New Password Updated Successfully🎉');</script>";
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
