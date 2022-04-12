<?php
ob_start();
/// Manage comment page 
session_start();

if (isset($_SESSION['username'])) {
    // echo "welcome admin " . $_SESSION['username'];
    $pageTitle = 'comments';

    include 'init.php';

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Manage';
    }

    if ($do == 'Manage') {

        // <!-- WELCOME TO COMMENTS PAGE  -->


        $stmt = $con->prepare("SELECT comments.* , items.Name AS Item_Name , users.UserName
                               FROM comments
                               INNER JOIN items on items.Item_ID = comments.item_id
                               INNER JOIN users on users.UserID = comments.user_id
                               ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        // var_dump($rows);
?>

        <h1 class="text-center">Mange Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item Name </td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['c_id'] . "</td>";
                        echo "<td>" . $row['comment'] . "</td>";
                        echo "<td>" . $row['Item_Name'] . "</td>";
                        echo "<td>" . $row['UserName'] . "</td>";
                        echo "<td>" . $row['comment_date'] . "</td>";
                        echo " <td> <a class='btn btn-success' href='comments.php?do=Edit&comid=" . $row['c_id'] . "'> <i class='fa fa-edit ' > Edit </i> </a>
                                     <a class='btn btn-danger confirm' href='comments.php?do=Delete&comid=" . $row['c_id'] . "'>  <i class='fa fa-close ' > Delete </i> </a>";
                        if ($row['status'] == 0) {
                            echo    "<a class='btn btn-info activate' href='comments.php?do=Approve&comid=" . $row['c_id'] . "'>  <i class='fa fa-check ' > Approve </i> </a>";
                        }
                        echo    "</td>";

                        echo "</tr>";
                    }

                    ?>

                </table>
            </div>


        </div>
        <?php

    } elseif ($do == 'Edit') {
        // echo 'welcome to edit page ur ID is ' . $_GET['comid'];
        if (isset($_GET['comid']) && is_numeric($_GET['comid'])) {
            $comid = intval($_GET['comid']);
        } else {
            $comid = 0;
        }
        //check if user exist in db
        $stmt = $con->prepare("SELECT * From comments WHERE c_id = ? LIMIT 1;");
        $stmt->execute(array($comid));
        $row = $stmt->fetch();
        // var_dump($row);
        $count = $stmt->rowCount();
        // var_dump($row);

        if ($count > 0) {

        ?>
            <h1 class="text-center">Edit Comment</h1>

            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="comid" value="<?= $comid ?>">

                    <div class="form-group form-group-lg"">
                    <label class=" col-sm-2 col-md-6 control-label" for="comment"> Comment </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="comment" required="required"> <?= $row['comment']; ?> </textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-lg"">
                    <div class=" col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary btn-m " type="submit" value="save">
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
        echo   '<h1 class="text-center">Update  Comment</h1> ';
        echo   '<div class="container">';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);

            $comid = $_POST['comid'];
            $comment = $_POST['comment'];


            $stmt = $con->prepare("UPDATE comments SET comment= ? WHERE c_id= ? ");

            $stmt->execute(array($comment, $comid));

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
        echo '<h1 class="text-center">Delete Comment</h1>';
        echo '<div class="container">';
        // echo "welcome to delet page ";
        if (isset($_GET['comid']) && is_numeric($_GET['comid'])) {
            $comid = intval($_GET['comid']);
        } else {
            $comid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From comments WHERE comid = ? LIMIT 1;");
        $check = checkItem("c_id", "comments", "$comid");
        // echo $check;

        // $stmt->execute(array($comid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("DELETE  From comments WHERE c_id = ? LIMIT 1;");
            $stmt->execute(array($comid));
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
    } elseif ($do == "Approve") {
        //activate page
        echo '<h1 class="text-center">Activate Comment</h1>';
        echo '<div class="container">';
        // echo "welcome to Activate page ";
        if (isset($_GET['comid']) && is_numeric($_GET['comid'])) {
            $comid = intval($_GET['comid']);
        } else {
            $comid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From comments WHERE comid = ? LIMIT 1;");
        $check = checkItem("c_id", "comments", "$comid");
        // echo $check;

        // $stmt->execute(array($comid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("UPDATE comments SET Status =1 WHERE c_id = ?;");
            $stmt->execute(array($comid));
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Activated</div>';
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>there is no ID  like this exist </div>";
            redirectHome($theMsg);
            echo '</div>';
        }
        echo '</div>';
    }
    include $tpl . 'footer.php';
} else {

    header('location: index.php');
    exit();
}
ob_end_flush();
