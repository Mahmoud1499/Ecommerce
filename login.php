<?php
session_start();

$pageTitle = 'Login';

if (isset($_SESSION['user'])) {
    header('location: index.php'); // redirect 

}

include "init.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {

        $user = $_POST['username'];
        $pass = $_POST['password'];
        // hash password
        $hashedpass = sha1($pass);
        // echo $user . ' ' . $hashedpass;

        //check if user exist in db
        $stmt = $con->prepare("SELECT UserID, UserName , password From users WHERE UserName = ? AND password =? ;");
        $stmt->execute(array($user, $hashedpass));
        $row = $stmt->fetch();
        // var_dump($row);
        $count = $stmt->rowCount();
        // echo $count;
        // check if count > 1 ,dv contan username
        if ($count > 0) {
            // echo "welcome $user";
            $_SESSION['user'] = $user; //session name
            $_SESSION['ID'] = $row['UserID']; //session ID


            header('location: index.php'); // redirect 
            exit();
        }
    } else {
        $test = $_POST['username'];
    }
} else {
    echo "no name like ($user) in db";
}
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class=" selected" data-class="login"> LogIn</span> | <span data-class="signup">SignUp</span>
    </h1>
    <form class="login" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

        <div class="input-container">
            <input class="form-control" type="text" name="username" id="" placeholder='Enter Your useraname' required="required" autocomplete="off">
        </div>

        <div class="input-container">
            <input class="form-control" type="password" name="password" id="" placeholder='Enter your password' required="required" autocomplete="new-password">
        </div>
        <div class="input-container">
            <input class="btn- btn-primary btn-block" type="submit" name='login' value="Login" id="">
        </div>

    </form>

    <form class="signup" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
            <input class="form-control" type="text" name="username" id="" placeholder='Enter Your useraname' required="required" autocomplete="off">
        </div>

        <div class="input-container">
            <input class="form-control" type="password" name="password" id="" placeholder='Enter a complex password' required="required" autocomplete="new-password">
        </div>

        <div class="input-container">
            <input class="form-control" type="password" name="password2" id="" placeholder='Enter the password again' required="required" autocomplete="new-password">
        </div>

        <div class="input-container">
            <input class="form-control" type="email" name="email" id="" placeholder='Enter your email' required="required" autocomplete="off">
        </div>


        <input class="btn- btn-success btn-block" type="submit" name='signup' value="Sign up" id="">
    </form>
    <div class="the-error text-center">
        <?= $test ?>
    </div>
</div>





<?php


include $tpl . "footer.php";
