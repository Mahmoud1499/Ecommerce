<?php

//get cat 
function getCat()
{
    global $con;
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    $getCat->execute();
    $cats = $getCat->fetchAll();
    return $cats;
}

//get items 
function getItems($where, $value, $approve = NULL)
{
    if ($approve == NUll) {
        $sql = "AND Approve = 1 ";
    } else {
        $sql = NULL;
    }
    global $con;
    $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");
    $getItems->execute(array($value));
    $items = $getItems->fetchAll();
    return $items;
}


// check users statues
function checkUserStatus($user)
{
    global $con;

    $stmtx = $con->prepare("SELECT  UserName ,RegStatus From users WHERE UserName = ? AND RegStatus =0 ;");
    $stmtx->execute(array($user));
    $status = $stmtx->rowCount();
    return $status;
}














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
}

// to count number of items for dashboaed
function countsItems($item, $table)
{
    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();

    return $stmt2->fetchColumn();
}

// to get latest records function

function getLatest($select, $table,   $order, $limit = 5)
{
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order desc LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}
