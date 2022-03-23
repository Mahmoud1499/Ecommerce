<?php
include 'connect.php';
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
//include in all exeppt 
if (!isset($nonavbar)) {
    include $tpl . "navbar.php";
}
