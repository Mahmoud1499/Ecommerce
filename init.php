<?php
//error report 
ini_set('display_errors', 'on');



// ----------------------------------------------------------------
include 'admin/connect.php';

//sessions
$sessionsUser = '';

if (isset($_SESSION['user'])) {
    $sessionsUser = $_SESSION['user'];
}

//routes

$tpl = 'includes/templates/'; //wlecome to index
$css = 'layout/css/';
$js = 'layout/js/';
$lang = 'includes/languages/';
$func = 'includes/functions/';

//include the important files
include $func . 'function.php';
include $lang . "english.php";
include $tpl . "header.php";
