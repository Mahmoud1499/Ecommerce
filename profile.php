<?php
session_start();
$pageTitle = 'Profile';
include "init.php";
// echo $sessionsUser;

if (isset($_SESSION['user'])) {
    $getUser = $con->prepare('SELECT * FROM users WHERE UserName = ?');
    $getUser->execute(array($sessionsUser));
    $info = $getUser->fetch();
    // var_dump($info);

?>
    <h1 class="text-center"> My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="card  border-primary ">
                <div class="card-header bg-primary text-white">My Information</div>
                <div class="card-body">
                    <ul class="list-unstyled latest-users ">
                        <li> <i class="fa fa-unlock-alt fa-fw"></i> <span> User Name: </span> <?= $info['UserName']; ?> </li>
                        <li> <i class="fa fa-user fa-fw"></i> <span> Full Name: </span> <?= $info['FullName']; ?> </li>
                        <li> <i class="fa fa-envelope-o fa-fw"></i> <span> Email: </span> <?= $info['Email']; ?> </li>
                        <li> <i class="fa fa-calendar fa-fw"></i> <span> Registerd Date: </span> <?= $info['UserName']; ?> </li>
                        <li> <i class="fa fa-tags fa-fw"></i> <span> Favorite Categories: </span> <?= $info['UserName']; ?> </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit My Information </a>
                </div>
            </div>
        </div>
    </div>

    <div id="my-ads" class="my-ads block">
        <div class="container ">
            <div class="card border-primary  ">
                <div class="card-header bg-primary text-white">My Ads</div>
                <div class="card-body">
                    <?php
                    if (!empty(getItems('Member_ID', $info['UserID']))) {

                        foreach (getItems('Member_ID', $info['UserID'], 1) as $item) {
                            // var_dump($item);
                            echo "<div class='col-sm-6 col-md-4 float-left'>";
                            echo "<div class='img-thumbnail item-box'>";
                            if ($item['Approve'] == 0) {
                                echo "<div class='approve-status' >Wating for approval</div>";
                            }
                            echo "<span class='price-tag'>$ " . $item['Price'] . "</span>";
                            echo "<img class='rounded img-fluid' src='https://th.bing.com/th/id/OIP.2RR4RuG1NyW5PsfzQN_sKgHaE8?pid=ImgDet&rs=1' alt='' />";
                            echo "<div class='caption'>";
                            echo '<h3 > <a href="item.php?itemid=' . $item['Item_ID'] . ' ">' . $item['Name'] . "</a> </h3>";
                            echo "<p class=''> " . $item['Description'] . " </p>";
                            echo "<div class='date'>" . $item['Add_Date'] . "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        };
                    } else {
                        echo "There is no Ads to show <div class='btn'> <a href='newad.php'>Create new add </a> </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="my-comments block">
        <div class="container">
            <div class="card  border-primary  ">
                <div class="card-header bg-primary text-white">Latest comments</div>
                <div class="card-body">
                    <?php
                    $stmt = $con->prepare("SELECT comments.* , items.Name AS Item_Name 
                                FROM comments
                                INNER JOIN items on items.Item_ID = comments.item_id
                                                        WHERE user_id =? 
                    ");
                    $stmt->execute(array($info['UserID']));
                    $comments = $stmt->fetchAll();

                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            echo "<p class=''> " . $comment['comment'] . " </p>";
                        }
                    } else {
                        echo "There is no comments to show ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>






<?php
} else {
    header('location:login.php ');
    exit();
}

include $tpl . "footer.php";
