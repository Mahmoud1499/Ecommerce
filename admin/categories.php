<?php

ob_start();

session_start();

$pageTitle = 'Categories';

if (isset($_SESSION['username'])) {

    include 'init.php';

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Manage';
    }

    if ($do == 'Manage') {
        // echo 'Welcome to Manage page';
        $sort = 'ASC';
        $sort_array = array('ASC', 'DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
            $sort = $_GET['sort'];
        }

        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY ordering $sort  ");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
?>
        <h1 class="text-center">Manage Category</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading"> <i class="fa fa-edit"></i> Manege Categories
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i> Ordering:[
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="?sort=ASC">ASC</a> |
                        <a class="<?php if ($sort == 'DESC') {
                                        echo 'active';
                                    } ?>" href="?sort=DESC">DESC</a>]
                        <i class="fa fa-eye"></i> View: [<span class="" data-view="full">Full</span> | <span class="" data-view="classic">Classic</span>]
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    foreach ($cats as $cat) {
                        echo "<div class='cat'>";
                        echo "<div class='hidden-buttons'>";
                        echo "<a href='categories.php?do=Edit&catid= " . $cat['ID'] . " ' class=' btn btn-sm btn-primary'> <i class='fa fa-edit'> </i>Edit </a>";
                        echo "<a href='categories.php?do=Delete&catid= " . $cat['ID'] . "  ' class='confirm btn btn-sm btn-danger'> <i class='fa fa-close'> </i>Delet </a>";

                        echo "</div>";
                        echo "<h3>" . $cat['Name'] . '</h3>';
                        echo "<div class='full-view'>";
                        echo '<p>';
                        if ($cat['Description'] == '') {
                            echo 'This category has no description ';
                        } else {
                            echo $cat['Description'];
                        }
                        echo '<p/>';
                        if ($cat['Visibility'] == 1) {
                            echo '<span class="Visibility"> <i class="fa fa-eye"></i> Hidden </span>';
                        }
                        if ($cat['Allow_Comment'] == 1) {
                            echo '<span class="commenting"> <i class="fa fa-close"></i> Comment disapled </span>';
                        }
                        if ($cat['Allow_Ads'] == 1) {
                            echo '<span class="ads"> <i class="fa fa-close"></i> Ads disapled </span>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<hr> ';
                    }
                    ?>


                </div>
            </div>
            <a class="add-category btn btn-primary" href="categories.php?do=Add"> <i class="fa fa-plus"></i>Add New Category</a> </a>
        </div>
    <?php
    } elseif ($do == 'Add') {
        // echo 'Welcome to Add page';

    ?>
        <h1 class="text-center">Add New Category</h1>

        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <div class="form-group form-group-lg"">
<label class=" col-sm-2 col-md-6 control-label" for="name"> Name </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" autocomplete="off" required="required" placeholder="Name of Category">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 col-md-6 control-label" for="description"> Description </label>
                    <div class="col-sm-10">
                        <input class=" form-control" type="text" name="description" placeholder="Describe the category ">

                    </div>
                </div>

                <div class="form-group form-group-lg"">
<label class=" col-sm-2 col-md-6 control-label" for="ordering"> ordering </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="ordering" " placeholder=" Number to arrange the category">
                    </div>
                </div>

                <div class="form-group form-group-lg"">
<label class=" col-sm-2 control-label" for="Visable"> Visable </label>
                    <div class="col-sm-10">
                        <div>
                            <input id="visable-yes" type="radio" name="visability" value="0" checked />
                            <label for="visable-yes">Yes </label>
                        </div>
                        <div>
                            <input id="visable-no" type="radio" name="visability" value="1" />
                            <label for="visable-no">No </label>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-lg"">
<label class=" col-sm-2 control-label" for="commenting"> Allow commenting </label>
                    <div class="col-sm-10">
                        <div>
                            <input id="comment-yes" type="radio" name="commenting" value="0" checked />
                            <label for="comment-yes">Yes </label>
                        </div>
                        <div>
                            <input id="comment-no" type="radio" name="commenting" value="1" />
                            <label for="comment-no">No </label>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-lg"">
<label class=" col-sm-2 control-label" for="ads"> Allow Ads </label>
                    <div class="col-sm-10">
                        <div>
                            <input id="Ads-yes" type="radio" name="ads" value="0" checked />
                            <label for="Adsyes">Yes </label>
                        </div>
                        <div>
                            <input id="Ads-no" type="radio" name="ads" value="1" />
                            <label for="Ads-no">No </label>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-lg"">
<div class=" col-sm-offset-2 col-sm-10">
                    <input class="btn btn-primary btn-lg " type="submit" value="Add Category">
                </div>
        </div>
        </form>
        </div>
        <?php
    } elseif ($do == 'Insert') {
        //Insert page
        // var_dump($_POST);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);
            echo   '<h1 class="text-center">Add New Category</h1> ';
            echo   '<div class="container">';


            $name = $_POST['name'];
            $desc = $_POST['description'];
            $oder = $_POST['ordering'];
            $visible = $_POST['visability'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];



            //check

            $check = checkItem("Name", "Categories", $name);
            if ($check == 1) {
                $theMsg = " <div class='alert alert-danger'> sorry this category is exist </div> ";
                redirectHome($theMsg, 'back');
            } else {

                $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility , Allow_Comment, Allow_Ads) VALUES(?,?,?,?,?,?) ");

                $stmt->execute(array($name, $desc, $oder, $visible, $comment, $ads));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  ONE RECOED INSERTED </div>';

                redirectHome("$theMsg", 'back', 3);
            }
            //insert category in db


            // update db 

        } else {
            echo ' <div class="container"></div>';
            $theMsg = "<div class='alert alert-danger '>Sorry cant access this page directly </div>";

            // $errorMsg = 'cant access this page directly';
            redirectHome("$theMsg", 'back', 3);
            echo "</div>";
        }
        echo "</div>";
    } elseif ($do == 'Edit') {
        // echo 'welcome to edit page catID is ' . $_GET['catid'];
        if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
            $catid = intval($_GET['catid']);
        } else {
            $catid = 0;
        }
        //check if user exist in db
        $stmt = $con->prepare("SELECT * From categories WHERE ID = ? ;");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        // var_dump($row);
        $count = $stmt->rowCount();
        // var_dump($row);

        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit Category</h1>

            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="catid" value="<?= $catid; ?>" <div class="form-group form-group-lg"">

                    <div class=" form-group form-group-lg"">
                    <label class=" col-sm-2 col-md-6 control-label" for="name"> Name </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" required="required" placeholder="Name of Category" value="<?= $cat['Name'] ?>">
                    </div>
            </div>

            <div class="form-group form-group-lg">
                <label class="col-sm-2 col-md-6 control-label" for="description"> Description </label>
                <div class="col-sm-10">
                    <input class=" form-control" type="text" name="description" placeholder="Describe the category " value="<?= $cat['Description'] ?>">

                </div>
            </div>

            <div class="form-group form-group-lg"">
<label class=" col-sm-2 col-md-6 control-label" for="ordering"> ordering </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="ordering" " placeholder=" Number to arrange the category" value="<?= $cat['Ordering'] ?>">
                </div>
            </div>

            <div class="form-group form-group-lg"">
<label class=" col-sm-2 control-label" for="Visable"> Visable </label>
                <div class="col-sm-10">
                    <div>
                        <input id="visable-yes" type="radio" name="visability" value="0" <?php if ($cat['Visibility'] == 0) {
                                                                                                echo "checked";
                                                                                            } ?> />
                        <label for="visable-yes">Yes </label>
                    </div>
                    <div>
                        <input id="visable-no" type="radio" name="visability" value="1" <?php if ($cat['Visibility'] == 1) {
                                                                                            echo "checked";
                                                                                        } ?> />
                        <label for="visable-no">No </label>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-lg"">
<label class=" col-sm-2 control-label" for="commenting"> Allow commenting </label>
                <div class="col-sm-10">
                    <div>
                        <input id="comment-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) {
                                                                                                echo "checked";
                                                                                            } ?> />
                        <label for="comment-yes">Yes </label>
                    </div>
                    <div>
                        <input id="comment-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) {
                                                                                            echo "checked";
                                                                                        } ?> />
                        <label for="comment-no">No </label>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-lg"">
<label class=" col-sm-2 control-label" for="ads"> Allow Ads </label>
                <div class="col-sm-10">
                    <div>
                        <input id="Ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0) {
                                                                                    echo "checked";
                                                                                } ?> />
                        <label for="Adsyes">Yes </label>
                    </div>
                    <div>
                        <input id="Ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) {
                                                                                    echo "checked";
                                                                                } ?> />
                        <label for="Ads-no">No </label>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-lg"">
<div class=" col-sm-offset-2 col-sm-10">
                <input class="btn btn-primary btn-lg " type="submit" value="Save">
            </div>
            </div>
            </form>
            </div>

<?php
        } else {
            echo ' <div class="container"></div>';
            $theMsg = '<div class="alert alert-danger">There is no ID like that</div>';
            redirectHome($theMsg);
            echo '</div>';
        }
    } elseif ($do == "Update") {
        //update page 
        echo   '<h1 class="text-center">Update  Category</h1> ';
        echo   '<div class="container">';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);

            $id = $_POST['catid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $visable = $_POST['visability'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];


            $stmt = $con->prepare("UPDATE categories SET Name= ?, Description= ?,Ordering= ?,Visibility= ? ,Allow_Comment=?, Allow_Ads=? WHERE ID= ? ");

            $stmt->execute(array($name, $desc, $order, $visable, $comment, $ads, $id));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' RECOED UPDATED </div>';

            redirectHome("$theMsg", 'back');
        } else {
            echo '<div class="container">';
            $theMsg = '<div class="alert">Sorry cant access this page directly</div>';
            redirectHome($theMsg);
            echo '</div>';
        }
        echo "</div>";
    } elseif ($do == "Delete") {
        //delete member page 
        echo '<h1 class="text-center">Delete Category </h1>';
        echo '<div class="container">';
        // echo "welcome to delet page ";
        if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
            $catid = intval($_GET['catid']);
        } else {
            $catid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From categories WHERE UserID = ? LIMIT 1;");
        $check = checkItem("ID", "categories", "$catid");
        // echo $check;

        // $stmt->execute(array($catid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("DELETE  From categories WHERE ID = ? LIMIT 1;");
            $stmt->execute(array($catid));
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>there is no ID  like this exist </div>";
            redirectHome($theMsg);
            echo '</div>';
        }
        echo '</div>';

        include $tpl . 'footer.php';
    } else {

        header('location: index.php');
        exit();
    }
}
ob_end_flush();
