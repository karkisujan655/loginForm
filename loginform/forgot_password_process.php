<?php
  require "connection.php";
  session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;


  function MailForgotSend($email, $token_reset)
  {
   
    require 'mail/Exception.php';
    require 'mail/PHPMailer.php';
    require 'mail/SMTP.php';
    

    $mail = new PHPMailer(true);

    try {
      
      
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'karkisujan655@gmail.com';                     //SMTP username
      $mail->Password   = 'gyhsnikktqjppofa';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
      //Recipients
      $mail->setFrom('karkisujan655@gmail.com', 'SUJAN');
      $mail->addAddress($email);     //Add a recipient
  
      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Password Reset Link';
      $mail->Body = "Click the link below to reset your password: <b><a href='http://localhost/loginform/change.php?email=$email&reset_token=$token_reset'>Password Reset link Here!</a></b>";



        
      $mail->send();
      return true;
  } catch (Exception $e) {
      return false;
  }
  }

  if(isset($_POST['reset']))
  {
    $email = $_POST['email'];
    $query = "SELECT * FROM `signup` WHERE `email`='$email'";
    $result_query = mysqli_query($connection, $query);
    if($result_query){
      if(mysqli_num_rows($result_query)==1)
      {
        $token_reset = bin2hex(random_bytes(18));
        date_default_timezone_set('Asia/kathmandu');
        $date=date("Y-m-d");
        $update_query="UPDATE `signup` SET `reset_token`='$token_reset', `token_expire`='$date' WHERE `email`= '$email'";
        if(mysqli_query($connection, $update_query) && MailForgotSend($email, $token_reset)){
          echo "<script>alert('reset link sent successfully!') ; window.location.href='index.php'</script>";
        }
        else{
          echo "<script>alert('server down!')</script>";
        }
      }
      else{
        echo "<script>alert('invalid email')</script>";
      }
    }
    else{
      echo "<script>alert('something error occured!')</script>";
    }
  }
?>


