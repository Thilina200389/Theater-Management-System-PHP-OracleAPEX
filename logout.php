<?php
// logout.php
include_once 'Controller/authcontroller.php';
logoutUser();
header("Location: login.php");
exit();
?>