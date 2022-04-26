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
                    <li class="tags-items">
                        <i class="fa fa-tag fa-fw"></i>
                        <span>Tags</span> :
                        <?php
                        $allTags = explode(",", $item['tags']);
                        foreach ($allTags as $tag) {
                            $tag = str_replace(' ', '', $tag);
                            $lowertag = strtolower($tag);
                            if (!empty($tag)) {
                                echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a>';
                            }
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="custom-hr">
        <?php
        if (isset($_SESSION['user'])) {
        ?>

            <div class="row m-3">
                <div class="col-md-offset-3">
                    <h3> Add Your comment </h3>
                    <div class="add-comment ">
                        <form action="<?= $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']    ?>" method="POST">
                            <textarea class="form-control" name="comment" cols="30" rows="10" required="required"></textarea>
                            <input class="btn btn-primary  " type="submit" value="Add Comment">
                        </form>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // var_dump($_POST);
                            // echo $_POST['comment'];
                            $comment     = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $itemid     = $item['Item_ID'];
                            $userid     = $_SESSION['uid'];

                            if (!empty($comment)) {

                                $stmt = $con->prepare("INSERT INTO comments(comment, status, comment_date, item_id, user_id)
							                        	VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");

                                $stmt->execute(array('zcomment' => $comment, 'zitemid' => $itemid, 'zuserid' => $userid));

                                if ($stmt) {
                                    echo '<div class="alert alert-success">Comment Added</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger">You Must Add Comment</div>';
                            }
                        }
                        ?>
                    </div>


                </div>
            </div>
        <?php } else {

            echo '<div class=" "> <a href="login.php"> Login </a> or <a href="login.php"> register </a> to Add comment</div>';
        }
        ?>
        <hr class="custom-hr">
        <?php
        // Select All Users Except Admin 
        $stmt = $con->prepare("SELECT comments.*, users.Username AS Member  
                        FROM  comments
                        INNER JOIN  users  ON  users.UserID = comments.user_id
                        WHERE  item_id = ?AND  status = 1
                        ORDER BY c_id DESC");

        $stmt->execute(array($item['Item_ID']));

        $comments = $stmt->fetchAll();
        ?>

        <?php foreach ($comments as $comment) { ?>
            <div class="comment-box">
                <div class="row">
                    <div class="col-sm-2 text-center">
                        <img class="img-responsive mg-fluid rounded-circle  img-circle img-thumbnail center-block" alt="" src='https://th.bing.com/th/id/OIP.2RR4RuG1NyW5PsfzQN_sKgHaE8?pid=ImgDet&rs=1' alt="" />
                        <?= $comment['Member'] ?>
                    </div>
                    <div class="col-sm-10">
                        <p class="lead"><?= $comment['comment'] ?></p>
                    </div>
                </div>
            </div>
            <hr class="custom-hr">
        <?php } ?>
    </div>





<?php
} else {
    echo '<div class="alert alert-danger">There Is  No Such ID </div>';
    echo '<div class="alert alert-danger">OR watting for Approve </div>';
}


include $tpl . "footer.php";
