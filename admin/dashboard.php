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

            <div class="col-md-3">
                <div class="stat"> Total Members
                    <span><?= countsItems('UserID', 'users'); ?></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat">Pending Members
                    <span><?= countsItems('UserID', 'users'); ?></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat"> Total Items
                    <span><?= countsItems('UserID', 'users'); ?></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat"> Total Comments
                    <span><?= countsItems('UserID', 'users'); ?></span>
                </div>
            </div>

        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest Registerd Users
                    </div>
                    <div class="panel-body">
                        Test
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
