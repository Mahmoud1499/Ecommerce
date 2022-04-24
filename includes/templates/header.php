<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getTitle() ?></title>
    <!-- bootstrap scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- foontawasomr -->
    <script src="https://use.fontawesome.com/a1981b0d6b.js"></script>
    <!-- jquery ui -->
    <script src="<?= $js ?>jquery-ui.min.js"></script>
    <!-- jquery boxit -->
    <script src="<?= $js ?>jquery.selectBoxIt.min.js"></script>
    <!-- my own javascript -->
    <script src="layout/js/frontend.js"></script>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- jquery ui -->
    <link rel="stylesheet" href="<?= $css; ?>jquery-ui.css" />
    <!-- jquery boxlt -->
    <link rel="stylesheet" href="<?= $css; ?>jquery.selectBoxIt.css" />
    <!-- my css -->
    <link rel="stylesheet" href="layout/css/frontend.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <?php
            // var_dump($_SESSION['user']);
            // var_dump($_GET);
            if (isset($_SESSION['user'])) { ?>

                <img class="my-image img-fluid  rounded-circle pull-left " src='https://th.bing.com/th/id/OIP.2RR4RuG1NyW5PsfzQN_sKgHaE8?pid=ImgDet&rs=1' alt="" />
                <div class="btn-group my-info">
                    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <?php echo '<span class="text-white pull-left">' .  $_SESSION['user'] . '</span>' ?>
                        <span class="caret "></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="newad.php">New Item</a></li>
                        <li><a href="profile.php#my-ads">My Items</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>

            <?php

            } else {
            ?>
                <a href="login.php">
                    <span class="pull-right">Login/Signup</span>
                </a>
            <?php } ?>
            <a class="nav-link text-white" href="index.php"><?= lang('HOME PAGE') ?> <span class="sr-only"></span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <?php
                    $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
                    foreach ($allCats as $cat) {
                        // echo $cat['ID'];
                        echo "<li class='nav-item '> <a class='nav-link'  href='categories.php?pageid=" . $cat['ID'] . '&pagename=' . str_replace(' ', '-', $cat['Name']) . "' >" . $cat['Name'] . "</a> </li>";
                    }
                    ?>


                </ul>

            </div>
        </div>

    </nav>