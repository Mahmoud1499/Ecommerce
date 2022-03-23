<?php
session_start();
// $nonavbar = '';

if (isset($_SESSION['username'])) {
    $pageTitle = 'Dashboard';

    include 'init.php';
    //start dashboard
    // echo "welcome admin " . $_SESSION['username'];
?>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat">
                    Total Members
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
