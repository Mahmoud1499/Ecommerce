<?php
session_start();

$pageTitle = 'Home';

include "init.php";
?>
<div class="information block">
    <div class="container">
        <div class="card  border-primary ">
            <div class="card-header bg-primary text-white">My Information</div>
            <div class="card-body">
                Name: <?= $_SESSION['user']; ?>
            </div>
        </div>
    </div>
</div>

<div class="my-ads block">
    <div class="container ">
        <div class="card border-primary  ">
            <div class="card-header bg-primary text-white">My Ads</div>
            <div class="card-body">
                Test: <?= $_SESSION['user']; ?>
            </div>
        </div>
    </div>
</div>

<div class="my-comments block">
    <div class="container">
        <div class="card  border-primary  ">
            <div class="card-header bg-primary text-white">Latest comments</div>
            <div class="card-body">
                Comments: <?= $_SESSION['user']; ?>
            </div>
        </div>
    </div>
</div>






<?php
include $tpl . "footer.php";
