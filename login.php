<?php
session_start();
include "init.php";
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class=" selected" data-class="login"> LogIn</span> | <span data-class="signup">SignUp</span>
    </h1>
    <form class="login" action="">

        <div class="input-container">
            <input class="form-control" type="text" name="username" id="" placeholder='Enter Your useraname' required="required" autocomplete="off">
        </div>

        <div class="input-container">
            <input class="form-control" type="text" name="password" id="" placeholder='Enter your password' required="required" autocomplete="new-password">
        </div>
        <div class="input-container">
            <input class="btn- btn-primary btn-block" type="submit" value="Login" id="">
        </div>

    </form>

    <form class="signup" action="">
        <div class="input-container">
            <input class="form-control" type="text" name="username" id="" placeholder='Enter Your useraname' required="required" autocomplete="off">
        </div>

        <div class="input-container">
            <input class="form-control" type="text" name="password" id="" placeholder='Enter a valid password' required="required" autocomplete="new-password">
        </div>

        <div class="input-container">
            <input class="form-control" type="text" name="password2" id="" placeholder='Enter the password again' required="required" autocomplete="new-password">
        </div>

        <div class="input-container">
            <input class="form-control" type="email" name="email" id="" placeholder='Enter complex Password' required="required" autocomplete="off">
        </div>


        <input class="btn- btn-success btn-block" type="submit" value="Sign up" id="">
    </form>
</div>





<?php


include $tpl . "footer.php";
