<?php

// title function 

function getTitle()
{
    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}

// redirect fynction (error and secondes)

function redirectHome($theMsg,  $url = null, $secondes = 3)
{
    if ($url == null) {
        $url = 'index.php';
        $link = 'Home Page';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        } else {
            $url = 'index.php';
            $link = 'Home Page';
        }
    }

    echo $theMsg;
    // echo "<div class='alert alert-danger '> $theMsg </div>";
    echo "<div class='alert alert-info '> We Will Be Redirected to $link After $secondes Secondes... </div>";
    header("refresh:$secondes;url=$url ");
    exit();
}

// to check Item In database0
function checkItem($select, $from, $value)
{
    global $con;
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?  ");
    $statment->execute(array($value));
    $count = $statment->rowCount();

    return $count;

    // if($count>1){

    // }
}