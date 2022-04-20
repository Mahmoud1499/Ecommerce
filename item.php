<?php
session_start();
$pageTitle = 'show Item';
include "init.php";
// echo $sessionsUser;
if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
    $itemid = intval($_GET['itemid']);
} else {
    $itemid = 0;
}
//check if user exist in db
$stmt = $con->prepare("SELECT items.*, categories.Name AS category_name, 	users.Username 
                        FROM items INNER JOIN categories ON 	categories.ID = items.Cat_ID 
                        INNER JOIN 	users ON 	users.UserID = items.Member_ID 
                        WHERE 	Item_ID = ? AND Approve = 1");
$stmt->execute(array($itemid));
// var_dump($item);
$count = $stmt->rowCount();
if ($count > 0) {

    $item = $stmt->fetch();
    // var_dump($item);
?>
    <h1 class="text-center"><?= $item['Name'] ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img class='rounded img-fluid img-thumbnail center-block' src='https://th.bing.com/th/id/OIP.2RR4RuG1NyW5PsfzQN_sKgHaE8?pid=ImgDet&rs=1' alt="">
            </div>
            <div class="col-md-9 item-info">
                <h2><?= $item['Name'] ?></h2>
                <p><?= $item['Description'] ?></p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-calendar fa-fw"></i>
                        <span>Added Date</span> : <?php echo $item['Add_Date'] ?>
                    </li>
                    <li>
                        <i class="fa fa-money fa-fw"></i>
                        <span>Price</span> : <?php echo $item['Price'] ?>
                    </li>
                    <li>
                        <i class="fa fa-building fa-fw"></i>
                        <span>Made In</span> : <?php echo $item['Country_Made'] ?>
                    </li>
                    <li>
                        <i class="fa fa-tags fa-fw"></i>
                        <span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name'] ?></a>
                    </li>
                    <li>
                        <i class="fa fa-user fa-fw"></i>
                        <span>Added By</span> : <a href="#"><?php echo $item['Username'] ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="custom-hr">
        <div class="row">
            <div class="col-md-3">
                User Image
            </div>
            <div class="col-md-9">
                User Comment
            </div>
        </div>
    </div>





<?php
} else {
    echo '<div class="alert alert-danger">There Is  No Such ID </div>';
}


include $tpl . "footer.php";
