<?php
ob_start();
/// Manage member page 
session_start();

if (isset($_SESSION['username'])) {
    // echo "welcome admin " . $_SESSION['username'];
    $pageTitle = 'Members';

    include 'init.php';

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Manage';
    }

    if ($do == 'Manage') {

        // <!-- WELCOME TO MANAGE PAGE  -->
        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            $query = 'AND RegStatus = 0';
        }

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {

?>

            <h1 class="text-center">Mange Members</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registerd Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['UserID'] . "</td>";
                            echo "<td>" . $row['UserName'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['FullName'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo " <td> <a class='btn btn-success' href='members.php?do=Edit&userid=" . $row['UserID'] . "'> <i class='fa fa-edit ' > Edit </i> </a>
                        <a class='btn btn-danger confirm' href='members.php?do=Delete&userid=" . $row['UserID'] . "'>  <i class='fa fa-close ' > Delete </i> </a>";
                            if ($row['RegStatus'] == 0) {
                                echo    "<a class='btn btn-info activate' href='members.php?do=Activate&userid=" . $row['UserID'] . "'>  <i class='fa fa-check ' > Activate </i> </a>";
                            }
                            echo    "</td>";

                            echo "</tr>";
                        }

                        ?>

                    </table>
                </div>

                <a class="btn btn-primary" href="members.php?do=Add"> <i class="fa fa-plus"> Add New Member</i> </a>
            </div>
        <?php } else {
            echo '<div class="container">';
            echo '<div class="nice-massage"> There os no Member to show  </div>';
            echo '<a class="btn btn-primary" href="members.php?do=Add"> <i class="fa fa-plus"> Add New Member</i> </a>';



            echo '</div>';
        }
        ?>
    <?php

    } elseif ($do == 'Add') {
        //add members page
        // echo 'add page';
    ?>
        <h1 class="text-center">Add Member</h1>

        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <div class="form-group form-group-lg"">
        <label class=" col-sm-2 col-md-6 control-label" for="Username"> Username </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="Username" autocomplete="off" required="required" placeholder="Username to Login Into Shop">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 col-md-6 control-label" for="Password"> Password </label>
                    <div class="col-sm-10">
                        <input class="password form-control" type="password" name="password" autocomplete="new-password" required="required" placeholder="Password Must Be Hard & Complex ">
                        <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="Email"> Email </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" name="Email" " required=" required" placeholder="Email Must Be Valid">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class=" col-sm-2 col-md-6 control-label" for="Fullname"> Full-Name </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="Fullname" " required=" required" placeholder="Full Name Appear In your Profile Page">
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <div class=" col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary btn-lg " type="submit" value="Add Member">
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
            echo   '<h1 class="text-center">Add New Member</h1> ';
            echo   '<div class="container">';


            $username = $_POST['Username'];
            $pass = $_POST['password'];
            $email = $_POST['Email'];
            $name = $_POST['Fullname'];

            $hashPass = sha1($_POST['password']);

            //validate
            $formErrors = array();

            if (strlen($username) < 4) {
                $formErrors[] = ' username cant be less than <strong> 4 character </strong>  ';
            }
            if (strlen($username) > 20) {
                $formErrors[] =  'username cant be more than <strong> 20 character  </strong>';
            }

            if (empty($username)) {
                $formErrors[] =  'username cant be  <strong> Empty  </strong> ';
            }
            if (empty($name)) {
                $formErrors[] =   'full name cant be <strong> Empty  </strong>';
            }
            if (empty($email)) {
                $formErrors[] =  ' email cant be <strong> Empty  </strong> ';
            }
            if (empty($pass)) {
                $formErrors[] =  ' password cant be <strong> Empty  </strong> ';
            }

            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger"> ' . $error . '</div>';
            }
            // no error
            if (empty($formErrors)) {
                //check

                $check = checkItem("Username", "users", "$username");
                if ($check == 1) {
                    $theMsg = " <div class='alert alert-danger'> sorry this user is exist </div> ";
                    redirectHome($theMsg, 'back');
                } else {

                    $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName , RegStatus, Date) VALUES(?,?,?,?,1,now()) ");

                    $stmt->execute(array($username, $hashPass, $email, $name));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  ONE RECOED INSERTED </div>';

                    redirectHome("$theMsg");
                }
                //insert user in db
            }

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
        // echo 'welcome to edit page ur ID is ' . $_GET['userid'];
        if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
            $userid = intval($_GET['userid']);
        } else {
            $userid = 0;
        }
        //check if user exist in db
        $stmt = $con->prepare("SELECT * From users WHERE UserID = ? LIMIT 1;");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        // var_dump($row);
        $count = $stmt->rowCount();
        // var_dump($row);

        if ($count > 0) {

        ?>
            <h1 class="text-center">Edit Member</h1>

            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="userid" value="<?= $userid ?>">
                    <div class="form-group form-group-lg"">
                    <label class=" col-sm-2 col-md-6 control-label" for="Username"> Username </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="Username" value="<?= $row['UserName'] ?>" autocomplete="off" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 col-md-6 control-label" for="Password"> Password </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="hidden" name="oldPassword" autocomplete="new-password" value="<?= $row['Password'] ?>">
                            <input class="form-control" type="password" name="newPassword" autocomplete="new-password" placeholder="Leave Blank If You Don't Want To Change Password">
                        </div>
                    </div>

                    <div class="form-group form-group-lg"">
                    <label class=" col-sm-2 col-md-6 control-label" for="Email"> Email </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email" name="Email" value="<?= $row['Email'] ?> " required="required">
                        </div>
                    </div>

                    <div class="form-group form-group-lg"">
                    <label class=" col-sm-2 col-md-6 control-label" for="Fullname"> Full-Name </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="Fullname" value="<?= $row['FullName'] ?>" required="required">
                        </div>
                    </div>

                    <div class="form-group form-group-lg"">
                    <div class=" col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary btn-lg " type="submit" value="save">
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
        echo   '<h1 class="text-center">Update  Member</h1> ';
        echo   '<div class="container">';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);

            $id = $_POST['userid'];
            $username = $_POST['Username'];
            $email = $_POST['Email'];
            $name = $_POST['Fullname'];



            //password
            $pass = '';
            if (empty($_POST['newPassword'])) {
                $pass = $_POST['oldPassword'];
            } else {
                $pass = sha1($_POST['newPassword']);
            }

            //validate
            $formErrors = array();

            if (strlen($username) < 4) {
                $formErrors[] = ' username cant be less than <strong> 4 character </strong>  ';
            }
            if (strlen($username) > 20) {
                $formErrors[] =  'username cant be more than <strong> 20 character  </strong>';
            }

            if (empty($username)) {
                $formErrors[] =  'username cant be  <strong> Empty  </strong> ';
            }
            if (empty($name)) {
                $formErrors[] =   'full name cant be <strong> Empty  </strong>';
            }
            if (empty($email)) {
                $formErrors[] =  ' email cant be <strong> Empty  </strong> ';
            }

            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger"> ' . $error . '</div>';
            }
            // no error
            if (empty($formErrors)) {

                $stmt2 = $con->prepare("SELECT * FROM `users` WHERE UserName =? AND UserID != ?");
                $stmt2->execute(array($username, $id));
                $count = $stmt2->rowCount();

                if ($count == 1) {
                    echo '<div class="alert alert-danger"> Sorry This User is exist</div>';
                    redirectHome($theMsg, 'back');
                } else {
                    $stmt = $con->prepare("UPDATE users SET username= ?, Email= ?,FullName= ?,Password= ? WHERE UserID= ? ");

                    $stmt->execute(array($username, $email, $name, $pass, $id));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' RECOED UPDATED </div>';

                    redirectHome("$theMsg", 'back');
                }
            }
        } else {
            echo '<div class="container">';
            $theMsg = '<div class="alert">Sorry cant access this page directly</div>';
            redirectHome($theMsg);
            echo '</div>';
        }
        echo "</div>";
    } elseif ($do == "Delete") {
        //delete member page 
        echo '<h1 class="text-center">Delete Member</h1>';
        echo '<div class="container">';
        // echo "welcome to delet page ";
        if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
            $userid = intval($_GET['userid']);
        } else {
            $userid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From users WHERE UserID = ? LIMIT 1;");
        $check = checkItem("userid", "users", "$userid");
        // echo $check;

        // $stmt->execute(array($userid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("DELETE  From users WHERE UserID = ? LIMIT 1;");
            $stmt->execute(array($userid));
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
    } elseif ($do == "Activate") {
        //activate page
        echo '<h1 class="text-center">Activate Member</h1>';
        echo '<div class="container">';
        // echo "welcome to Activate page ";
        if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
            $userid = intval($_GET['userid']);
        } else {
            $userid = 0;
        }
        //check if user exist in db
        // $stmt = $con->prepare("SELECT * From users WHERE UserID = ? LIMIT 1;");
        $check = checkItem("userid", "users", "$userid");
        // echo $check;

        // $stmt->execute(array($userid));
        // $row = $stmt->fetch();
        // var_dump($row);
        // $count = $stmt->rowCount();
        // var_dump($row);
        if ($check > 0) {
            // echo 'esixt';
            $stmt = $con->prepare("UPDATE users SET RegStatus =1 WHERE UserID = ?;");
            $stmt->execute(array($userid));
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Activated</div>';
            redirectHome($theMsg);
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
