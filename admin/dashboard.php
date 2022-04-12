<?php
ob_start();

session_start();
// $nonavbar = '';

if (isset($_SESSION['username'])) {
    $pageTitle = 'Dashboard';

    include 'init.php';
    //start dashboard

    // echo "welcome admin " . $_SESSION['username'];
?>

    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">

            <div class="col-md-3 ">
                <div class="stat st-members">
                    <i class="fa fa-users"></i>
                    <div class="info">
                        Total Members
                        <span> <a href="members.php"> <?= countsItems('UserID', 'users'); ?> </a> </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="stat st-pending">
                    <i class="fa fa-user-plus"></i>
                    <div class="info">
                        Pending Members
                        <span><a href="members.php?do=Manage&page=Pending"> <?= checkItem('RegStatus', 'users', 0); ?></a></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="stat st-items">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                        Total Items
                        <span> <a href="items.php"> <?= countsItems('Item_ID', 'items'); ?> </a> </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="stat st-comments">
                    <i class="fa fa-comments"></i>
                    <div class="info">
                        Total Comments
                        <span><?= countsItems('UserID', 'users'); ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestUser = 6 ?>
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?= $latestUser ?> Registerd Users
                        <span class="pull-right toggle-info ">
                            <i class="fa fa-minus"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users ">
                            <?php
                            $theLatestUsers = getLatest("*", 'users', 'UserID', $latestUser);
                            foreach ($theLatestUsers as $user) {
                                echo '<li>';
                                echo $user['UserName'];
                                echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                echo '<span class="btn btn-success pull-right">';
                                echo '<i class="fa fa-edit"></i> Edit';
                                if ($user['RegStatus'] == 0) {
                                    echo    "<a class='btn btn-info pull-right activate' href='members.php?do=Activate&userid=" . $user['UserID'] . "'>  <i class='fa fa-check ' > Activate </i> </a>";
                                }
                                echo '</span>';
                                echo '</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestItems = 6 ?>

                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest <?= $latestItems ?> Added Items
                        <span class="pull-right toggle-info ">
                            <i class="fa fa-minus"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users ">

                            <?php
                            $theLatestItems = getLatest("*", 'items', 'Item_ID', $latestItems);
                            foreach ($theLatestItems as $item) {
                                echo '<li>';
                                echo $item['Name'];
                                echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                                echo '<span class="btn btn-success pull-right">';
                                echo '<i class="fa fa-edit"></i> Edit';
                                if ($item['Approve'] == 0) {
                                    echo    "<a class='btn btn-info pull-right activate' href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "'>  <i class='fa fa-check ' > Approve </i> </a>";
                                }
                                echo '</span>';
                                echo '</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>

                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments-o"></i> Latest <?= $latestUser ?> Comments
                        <span class="pull-right toggle-info ">
                            <i class="fa fa-minus"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <?php
                        $latestUser = 6;

                        $stmt = $con->prepare("SELECT comments.*  , users.UserName
                    FROM comments
                    INNER JOIN users ON users.UserID = comments.user_id 
                    ");

                        $stmt->execute();
                        $comments = $stmt->fetchAll();
                        if (!empty($comments)) {
                            foreach ($comments as $comment) {
                                echo '<div class="comment-box">';
                                echo '<span class="member-n">
                                        <a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
                                            ' . $comment['UserName'] . '</a></span>';
                                // echo '<p class="member-c">' . $comment['comment'] . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo 'There\'s No Comments To Show';
                        }
                        ?>

                    </div>
                </div>
            </div>


        </div>

    </div>



<?php
    //end dashboard
    include $tpl . 'footer.php';
} else {
    // echo 'not authoraized';
    header('location: index.php');
    exit();
}
ob_end_flush();
