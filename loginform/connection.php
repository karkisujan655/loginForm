<?php
$server= 'localhost';
$na='root';
$pa='';
$db='login';
$connection=mysqli_connect($server, $na, $pa, $db);
if($connection){
    //echo 'success';
}
else{
    echo 'failed';
}

?>