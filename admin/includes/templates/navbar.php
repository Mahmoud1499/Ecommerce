<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Ecommerce Website</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="container  ">
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item  ">
                    <a class="nav-link" href="dashboard.php"><?= lang('HOME PAGE') ?> <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php"><?= lang('CATEGORIES') ?></a>
                <li class="nav-item">
                    <a class="nav-link" href="items.php"><?= lang('ITEMS') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="members.php"><?= lang('MEMBERS') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comments.php"><?= lang('COMMENTS') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= lang('STATISTICS') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= lang('LOGS') ?></a>
                </li>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../index.php">Visit shop </a>

                        <a class="dropdown-item" href="members.php?do=Edit&userid=<?= $_SESSION['ID'] ?>"><?= lang('EDIT PROFILE') ?></a>
                        <a class="dropdown-item" href="#"><?= lang('SETTINGS') ?></a>
                        <!-- <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="logout.php"><?= lang('LOGOUT') ?></a>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    </div>

</nav>