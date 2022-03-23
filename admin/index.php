<?php
session_start();
$nonavbar = '';
$pageTitle = 'Login';

if (isset($_SESSION['username'])) {
    header('location: dashboard.php'); // redirect dashboard

}

include "init.php";


// check if user come from http post request 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // hash password
    $hashedpass = sha1($password);
    // echo $username . ' ' . $hashedpass;

    //check if user exist in db
    $stmt = $con->prepare("SELECT UserID, username , password From users WHERE username = ? AND password =?  AND GroupID =1 LIMIT 1;");
    $stmt->execute(array($username, $hashedpass));
    $row = $stmt->fetch();
    // var_dump($row);
    $count = $stmt->rowCount();
    // echo $count;
    // check if count > 1 ,dv contan username
    if ($count > 0) {
        // echo "welcome $username";
        $_SESSION['username'] = $username; //session name
        $_SESSION['ID'] = $row['UserID']; //session ID


        header('location: dashboard.php'); // redirect dashboard
        exit();
    } else {
        echo "no name like ($username) in db";
    }
}

?>

<!-- welcome to index -->
<!-- test bootstrap and font awasoem -->
<!-- <i class="fa fa-home fa-5x "></i>
<div class="btn btn-danger btn-block">test bootstrap</div> -->


<form class="login" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">admin login</h4>
    <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
    <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
    <input class="btn btn-primary btn-block btn-lg" type="submit" name="Login" value="Login" />

</form>

<?php
// echo lang('massage') . ' ' . lang('admin')

?>

<?php
include $tpl . "footer.php";
?>