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
        $get = $stmt->fetch();
        // var_dump($get);
        $count = $stmt->rowCount();
        // echo $count;
        // check if count > 1 ,dv contan username
        if ($count > 0) {
            // echo "welcome $user";
            $_SESSION['user'] = $user; //session name
            $_SESSION['uid'] = $get['UserID']; //session ID


            header('location: index.php'); // redirect 
            exit();
        }
    } else {
        // $test = $_POST['username'];
        $formErrors = array();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $email = $_POST['email'];

        if (isset($username)) {
            $filterUser = filter_var($username, FILTER_SANITIZE_STRING);
            // echo $filterUser;
            if (strlen($filterUser) < 4) {
                $formErrors[] = 'UserName Must be at least 4 characters';
            }
        }

        if (isset($password) &&   $password2) {

            if (empty($password)) {
                $formErrors[] = 'Please Enter a password';
            }
            $pass1 = sha1($password);
            $pass2 = sha1($password2);

            if ($pass1 !== $pass2) {
                $formErrors[] = ' Password mismatch';
            }
        }


        if (isset($email)) {
            $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            // echo $filterEmail;
            if (filter_var($filterEmail, FILTER_SANITIZE_EMAIL) != true) {
                $formErrors[] = 'Email is not a valid Email ';
            }
        }
        // Check If There's No Error 
        if (empty($formErrors)) {
            // Check If User Exist 
            $check = checkItem("Username", "users", $username);
            if ($check == 1) {
                $formErrors[] = 'Sorry This User Is Exists';
            } else {

                // Insert Userinfo 
                $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus, Date)
									    	VALUES(?, ?, ?, 0, now())");
                $stmt->execute(array($username, sha1($password), $email));

                $succesMsg = 'Congrats You Are Now Registerd User';
            }
        }
    }
}
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class=" selected" data-class="login"> LogIn</span> | <span data-class="signup">SignUp</span>
    </h1>
    <form class="login" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

        <div class="input-container">
            <input class="form-control" type="text" name="username" pattern=".{4,}" title='Username Muste be More tahn 4 characters' placeholder='Enter Your username' required="required" autocomplete="off">
        </div>

        <div class="input-container">
            <input class="form-control" type="password" name="password" placeholder='Enter your password' required="required" autocomplete="new-password">
        </div>
        <div class="input-container">
            <input class="btn- btn-primary btn-block" type="submit" name='login' value="Login">
        </div>

    </form>

    <form class="signup" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
            <input class="form-control" type="text" name="username" pattern=".{4,}" title='Username Muste be More tahn 4 characters' placeholder='Enter Your useraname' required="required" autocomplete="off">
        </div>

        <div class="input-container">
            <input class="form-control" type="password" name="password" minlength="4" placeholder='Enter a complex password' required="required" autocomplete="new-password">
        </div>

        <div class="input-container">
            <input class="form-control" type="password" name="password2" minlength="4" placeholder='Enter the password again' required="required" autocomplete="new-password">
        </div>

        <div class="input-container">
            <input class="form-control" type="email" name="email" placeholder='Enter your email' required="required" autocomplete="off">
        </div>


        <input class="btn- btn-success btn-block" type="submit" name='signup' value="Sign up">
    </form>


    <div class="the-error text-center">
        <?php
        if (!empty($formErrors)) {

            foreach ($formErrors as $error) {
                echo '<div class="msg error">' . $error . '</div>';
            }
        }

        if (isset($succesMsg)) {
            echo '<div class="msg success">' . $succesMsg . '</div>';
        }

        ?>
    </div>


</div>





<?php


include $tpl . "footer.php";
