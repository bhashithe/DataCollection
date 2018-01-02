<?php
session_start();
require 'classes/Database.php';
require 'classes/User.php';
require 'classes/Admin.php';
require 'classes/bcrypt.php';
require 'classes/general.php';

if(isset($_SESSION['id']))
{
    $user = new User($_SESSION['id']);
    if($user->isAdmin())
    {
        $user = new Admin($_SESSION['id']);
    }
}
else
{
    $user = new User();    
}
$bcrypt = new Bcrypt(12);
$general = new General();

ob_start();//stack overflow headers sent error answer