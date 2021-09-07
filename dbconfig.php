<?php
define('HOST','localhost');
define('USER','Adduser');
define('PASS','Addpassword');
define('DB','Adddatabase');


$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');
?>
