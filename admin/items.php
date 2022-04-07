<?php
ob_start();

session_start();

$pageTitle = 'Items';

if (isset($_SESSION['username'])) {

    include 'init.php';

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Manage';
    }

    if ($do == 'Manage') {
        echo "Items Manage page";
    } elseif ($do == 'Add') {
?>
        <h1 class="text-center">Add New Item</h1>

        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <div class="form-group form-group-lg"">
<label class=" col-sm-2 col-md-6 control-label" for="name"> Name </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" required="required" placeholder="Name of Item">
                    </div>
                </div>



                <div class="form-group form-group-lg"">
<div class=" col-sm-offset-2 col-sm-10">
                    <input class="btn btn-primary btn-sm " type="submit" value="Add Item">
                </div>
        </div>
        </form>
        </div>
<?php
    } elseif ($do == 'Insert') {
    } elseif ($do == 'Edit') {
    } elseif ($do == "Update") {
    } elseif ($do == "Delete") {
    } elseif ($do == "Approve") {
    }
    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
ob_end_flush();
