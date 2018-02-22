<?php
session_start();
include('connection.php');
setcookie("uname", '', time() - 4200);
setcookie("paswd", '', time() - 4200);
session_destroy();
 
header("location:index.php");
?>
