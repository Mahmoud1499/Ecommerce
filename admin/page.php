<?php

$do = '';

if (isset($_GET['do'])) {
    $do = $_GET['do'];
} else {
    $do = 'Manage';
}

//main page

if ($do == 'Manage') {
    echo 'Manage Category';
    echo '<a href="page.php?do=Insert">Add New Category +</a>';
} elseif ($do == 'Add') {
    echo 'Add Category';
} elseif ($do == 'Insert') {
    echo 'Insert Category';
} else {
    echo 'Error ';
}
