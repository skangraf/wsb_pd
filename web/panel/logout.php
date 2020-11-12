<?php
// min requirements
include_once '../../vendor/feelcom/wsb/minequirements.php';
include_once '../../vendor/feelcom/wsb/Auth.php';
use feelcom\wsb as wsb;

//New auth object
$auth= new wsb\Auth();

//logout action
$auth->logout();

//redirect to login form
header('Location: login.php');

?>