<?php
//include the import files
require  'init.php';


$user=new User();

$user->logout();

Redirct::to('index.php')

?>