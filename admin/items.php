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
        // echo "Items Manage page";
        // <!-- WELCOME TO MANAGE PAGE  -->

        $stmt = $con->prepare("SELECT items.* , categories.Name AS category_name, users.UserName  FROM items INNER JOIN users ON items.Member_ID = users.UserID INNER  JOIN categories ON items.Cat_ID = categories.ID ORDER BY Item_ID DESC ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        // var_dump($rows);
        if (!empty($items)) {

?>

            <h1 class="text-center">Mange Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Category </td>
                            <td>Owner</td>
                            <td>Adding Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                        foreach ($items as $item) {
                            echo "<tr>";
                            echo "<td>" . $item['Item_ID'] . "</td>";
                            echo "<td>" . $item['Name'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['Price'] . "</td>";
                            echo "<td>" . $item['category_name'] . "</td>";
                            echo "<td>" . $item['UserName'] . "</td>";
                            echo "<td>" . $item['Add_Date'] . "</td>";
                            echo " <td> <a class='btn btn-success' href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "'> <i class='fa fa-edit ' > Edit </i> </a>
                        <a class='btn btn-danger confirm' href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "'>  <i class='fa fa-close ' > Delete </i> </a>";
                            if ($item['Approve'] == 0) {
                                echo    "<a class='btn btn-info activate' href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "'>  <i class='fa fa-check ' > Approve </i> </a>";
                            }
                            echo    "</td>";

                            echo "</tr>";
                        }

                        ?>

                    </table>
                </div>

                <a class="btn btn-primary" href="items.php?do=Add"> <i class="fa fa-plus"> Add New Item</i> </a>
            </div>
        <?php
        } else {
            echo '<div class="container">';
            echo '<div class="nice-massage"> There os no Items to show  </div>';
            echo ' <a class="btn btn-primary" href="items.php?do=Add"> <i class="fa fa-plus"> Add New Item</i> </a>';
        }
    } elseif ($do == 'Add') {
        ?>
        <h1 class="text-center">Add New Item</h1>

        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="name"> Name </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" required="required" placeholder="Name of Item">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="name"> Description </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="description" required="required" placeholder="Description of Item">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="name"> Price </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="price" required="required" placeholder="Price of Item">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="name"> Country </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="country" name="country" required="required" placeholder=" Country of Made ">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="name"> Status </label>
                    <div class="col-sm-10">
                        <select class="" name="status" id="">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class=" col-sm-2 col-md-6 control-label" for="name"> Members </label>
                        <div class="col-sm-10">
                            <select class="" name="member" id="" required=" required">
                                <option value="0">...</option>
                                <?php
                                $allMembers = getAllFrom("*", "users", "", "", "UserID");
                                foreach ($allMembers as $user) {
                                    echo "<option value='" . $user['UserID'] . "'>" . $user['UserName'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group form-group-lg">
                            <label class=" col-sm-2 col-md-6 control-label" for="name"> Category </label>
                            <div class="col-sm-10">
                                <select class="" name="category" id="" required="required">
                                    <option value="0">...</option>
                                    <?php
                                    $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
                                    foreach ($allCats as $cat) {
                                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                        $childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
                                        foreach ($childCats as $child) {
                                            echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Tags</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma (,)" />
                                </div>
                            </div>

                            <div class="form-group form-group-lg mt-3">
                                <div class=" col-sm-offset-2 col-sm-10">
                                    <input class="btn btn-primary btn-sm " type="submit" value="Add Item">
                                </div>
                            </div>
            </form>
        </div>
        <?php
    } elseif ($do == 'Insert') {
        //Insert page


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);
            echo   '<h1 class="text-center">Add New Member</h1> ';
            echo   '<div class="container">';


            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $category = $_POST['category'];
            $tags = $_POST['tags'];


            $formErrors = array();


            if (empty($name)) {
                $formErrors[] =  'name Can\'t be  <strong> Empty  </strong> ';
            }
            if (empty($desc)) {
                $formErrors[] =   'description Can\'t be <strong> Empty  </strong>';
            }
            if (empty($price)) {
                $formErrors[] =  ' price Can\'t be <strong> Empty  </strong> ';
            }
            if (empty($country)) {
                $formErrors[] =  ' country Can\'t be <strong> Empty  </strong> ';
            }
            if ($status === 0) {
                $formErrors[] =  ' You must choose the <strong> status  </strong> ';
            }
            if ($member === 0) {
                $formErrors[] =  ' You must choose the <strong> member  </strong> ';
            }
            if ($category === 0) {
                $formErrors[] =  ' You must choose the <strong> category  </strong> ';
            }

            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger"> ' . $error . '</div>';
            }
            // no error
            if (empty($formErrors)) {
                //check

                $stmt = $con->prepare("INSERT INTO Items(Name, Description, Price, Country_Made , Status ,Member_ID  ,Cat_ID  ,Add_Date , tags) 
                VALUES(?,?,?,?,?,?,?,now(),?) ");

                $stmt->execute(array($name, $desc, $price, $country, $status, $member, $category, $tags));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  ONE RECOED INSERTED </div>';

                redirectHome("$theMsg");
            }
            //insert user in db
        }

        // update db 
    } elseif ($do == 'Edit') {
        // echo 'welcome to edit page ur ID is ' . $_GET['userid'];
        if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
            $itemid = intval($_GET['itemid']);
        } else {
            $itemid = 0;
        }
        //check if user exist in db
        $stmt = $con->prepare("SELECT * From items WHERE Item_ID = ?");
        $stmt->execute(array($itemid));
        $item = $stmt->fetch();
        // var_dump($item);
        $count = $stmt->rowCount();
        // var_dump($row);

        if ($count > 0) {

        ?>
            <h1 class="text-center">Edit Item</h1>

            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">

                    <input type="hidden" name="itemid" value="<?= $itemid ?>">


                    <div class="form-group form-group-lg">
                        <label class=" col-sm-2 col-md-6 control-label" for="name"> Name </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" required="required" placeholder="Name of Item" value="<?= $item['Name'] ?>">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class=" col-sm-2 col-md-6 control-label" for="name"> Description </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="description" required="required" placeholder="Description of Item" value="<?= $item['Description'] ?>">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class=" col-sm-2 col-md-6 control-label" for="name"> Price </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="price" required="required" placeholder="Price of Item" value="<?= $item['Price'] ?>">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class=" col-sm-2 col-md-6 control-label" for="name"> Country </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="country" name="country" required="required" placeholder=" Country of Made" value="<?= $item['Country_Made'] ?>">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class=" col-sm-2 col-md-6 control-label" for="name"> Status </label>
                        <div class="col-sm-10">
                            <select class="" name="status" id="">

                                <option value="1" <?php if ($item['Status'] == 1) {
                                                        echo 'selected';
                                                    } ?>>New</option>
                                <option value="2" <?php if ($item['Status'] == 2) {
                                                        echo 'selected';
                                                    } ?>>Like New</option>
                                <option value="3" <?php if ($item['Status'] == 3) {
                                                        echo 'selected';
                                                    } ?>>Used</option>
                                <option value="4" <?php if ($item['Status'] == 4) {
                                                        echo 'selected';
                                                    } ?>>Very Old</option>
                            </select>
                        </div>

                        <div class="form-group form-group-lg">
                            <label class=" col-sm-2 col-md-6 control-label" for="name"> Members </label>
                            <div class="col-sm-10">
                                <select class="" name="member" id="" required=" required">

                                    <?php
                                    $stmt = $con->prepare("Select * from users ");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                        echo "<option value='" . $user['UserID'] . "' ";
                                        if ($item['Member_ID'] == $user['UserID']) {
                                            echo 'selected';
                                        }
                                        echo ">" . $user['UserName'] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class=" col-sm-2 col-md-6 control-label" for="name"> Category </label>
                                <div class="col-sm-10">
                                    <select class="" name="category" id="" required="required">

                                        <?php
                                        $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
                                        foreach ($allCats as $cat) {
                                            echo "<option value='" . $cat['ID'] . "'";
                                            if ($item['Cat_ID'] == $cat['ID']) {
                                                echo ' selected';
                                            }
                                            echo ">" . $cat['Name'] . "</option>";
                                            $childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
                                            foreach ($childCats as $child) {
                                                echo "<option value='" . $child['ID'] . "'";
                                                if ($item['Cat_ID'] == $child['ID']) {
                                                    echo ' selected';
                                                }
                                                echo ">--- " . $child['Name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Tags</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma (,)" value="<?php echo $item['tags'] ?>" />
                                    </div>
                                </div>


                                <div class="form-group form-group-lg mt-3">
                                    <div class=" col-sm-offset-2 col-sm-10">
                                        <input class="btn btn-primary btn-sm " type="submit" value="Save Item">
                                    </div>
                                </div>
                </form>
                <?php
                $stmt = $con->prepare("SELECT comments.*  , users.UserName
                FROM comments
                INNER JOIN users on users.UserID = comments.user_id
                WHERE item_id = ?
                ");
                $stmt->execute(array($itemid));
                $rows = $stmt->fetchAll();
                // var_dump($rows);
                if (!empty($rows)) {

                ?>

                    <h1 class="text-center">Mange <?= $item['Name'] ?> Comments</h1>

                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>

                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>
                            </tr>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr>";

                                echo "<td>" . $row['comment'] . "</td>";
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

                <?php    } ?>


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
        echo   '<h1 class="text-center">Update  Item</h1> ';
        echo   '<div class="container">';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);

            $id = $_POST['itemid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $category = $_POST['category'];
            $member = $_POST['member'];
            $tags = $_POST['tags'];

            $formErrors = array();


            if (empty($name)) {
                $formErrors[] =  'name Can\'t be  <strong> Empty  </strong> ';
            }
            if (empty($desc)) {
                $formErrors[] =   'description Can\'t be <strong> Empty  </strong>';
            }
            if (empty($price)) {
                $formErrors[] =  ' price Can\'t be <strong> Empty  </strong> ';
            }
            if (empty($country)) {
                $formErrors[] =  ' country Can\'t be <strong> Empty  </strong> ';
            }
            if ($status === 0) {
                $formErrors[] =  ' You must choose the <strong> status  </strong> ';
            }
            if ($member === 0) {
                $formErrors[] =  ' You must choose the <strong> member  </strong> ';
            }
            if ($category === 0) {
                $formErrors[] =  ' You must choose the <strong> category  </strong> ';
            }

            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger"> ' . $error . '</div>';
            }
            // no error
            if (empty($formErrors)) {
                $stmt = $con->prepare("UPDATE items SET Name = ?, Description= ?, Price= ?,Country_Made= ? , Status=?, Cat_ID =?, Member_ID=?, tags = ? WHERE Item_ID= ? ");

                $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member, $tags, $id));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' RECOED UPDATED </div>';

                redirectHome("$theMsg", 'back');
            }
        } else {
            echo '<div class="container">';
            $theMsg = '<div class="alert">Sorry cant access this page directly</div>';
            redirectHome($theMsg);
            echo '</div>';
        }
        echo "</div>";
    } elseif ($do == "Delete") {
        //delete item page 
        echo '<h1 class="text-center">Delete Item</h1>';
        echo '<div class="container">';
        // echo "welcome to delet page ";
        if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
            $itemid = intval($_GET['itemid']);
        } else {
            $itemid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From users WHERE itemid = ? LIMIT 1;");
        $check = checkItem("Item_ID", "items", "$itemid");
        // echo $check;

        // $stmt->execute(array($itemid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("DELETE  From items WHERE Item_ID = ? LIMIT 1;");
            $stmt->execute(array($itemid));
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
        //Approve page
        echo '<h1 class="text-center">Approve Member</h1>';
        echo '<div class="container">';
        // echo "welcome to Approve page ";
        if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {
            $itemid = intval($_GET['itemid']);
        } else {
            $itemid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From users WHERE itemid = ? LIMIT 1;");
        $check = checkItem("Item_ID", "items", "$itemid");
        // echo $check;

        // $stmt->execute(array($itemid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("UPDATE items SET Approve =1 WHERE Item_ID = ?;");
            $stmt->execute(array($itemid));
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Approved</div>';
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>there is no ID  like this exist </div>";
            redirectHome($theMsg, 'back');
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
