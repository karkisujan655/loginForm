<?php
     require "connection.php";

   if(isset($_GET['email']) && isset($_GET['token_check'])) {
       $query = "SELECT * FROM `signup` WHERE `email`='{$_GET['email']}' AND `token`='{$_GET['token_check']}'";
       $result_query=mysqli_query($connection, $query);
       if($result_query)
       {
           if(mysqli_num_rows($result_query)==1)
           {
               $fetch_res=mysqli_fetch_assoc($result_query);
               if($fetch_res['is_token']==0)
               {
                   $result_update="UPDATE `signup` SET `is_token`='1' WHERE `email`='$fetch_res[email]'";
                   if(mysqli_query($connection, $result_update))
                   {
                     echo "<script>alert('Email Successfully Verified!');
                      window.location.href='index.php';</script>";
                
                   }
                   else{
                   echo "<script>alert('Can't run query!');
                       window.location.href='index.php';</script>";
                    
                   }
               }
               else
               {
                   echo "<script>alert('Email already verified!');
                   window.location.href='index.php';</script>";
                    
                                    
               }
           }
       }

       else{
           echo "<script>alert('Can't run query!');
                           window.location.href='index.php';</script>";
       }
   }
?> 


