<?php
session_start();
// $_SESSION['user_id'] = "1";
include 'config/DB.php';
include 'include/header.php';


// autoload the all classes
spl_autoload_register(function ($class) {
    require_once 'model/' . $class . '.php';
   
});

//include all function
include 'functions/Input.php';
include 'functions/validate.php';
include 'functions/Token.php';
include 'functions/Session.php';
include 'functions/Redirct.php';