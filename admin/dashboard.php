<?php
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
                <div class="stat st-members"> Total Members
                    <span> <a href="members.php"> <?= countsItems('UserID', 'users'); ?> </a> </span>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="stat st-pending">Pending Members
                    <span><a href="members.php?do=Manage&page=Pending"> <?= checkItem('RegStatus', 'users', 0); ?></a></span>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="stat st-items"> Total Items
                    <span><?= countsItems('UserID', 'users'); ?></span>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="stat st-comments"> Total Comments
                    <span><?= countsItems('UserID', 'users'); ?></span>
                </div>
            </div>

        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestUser = 5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?= $latestUser ?> Registerd Users
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users ">
                            <?php
                            $theLatest = getLatest("*", 'users', 'UserID', $latestUser);
                            foreach ($theLatest as $user) {
                                echo '<li>';
                                echo $user['UserName'];
                                echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                echo '<span class="btn btn-success pull-right">';
                                echo '<i class="fa fa-edit"></i> Edit';
                                if ($user['RegStatus'] == 0) {
                                    echo    "<a class='btn btn-info pull-right activate' href='members.php?do=Activate&userid=" . $user['UserID'] . "'>  <i class='fa fa-close ' > Activate </i> </a>";
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
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest Items
                    </div>
                    <div class="panel-body">
                        Test
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
