<?php
/*
 * Jason
 */

// Inialize session
session_start();

//Import Function
include 'functions/functions.php'; //require 'functions/function_php.php';
// Connects to Database 
include "db.php";
global $link;

$login = false;
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $login = $_SESSION['login'];
    //$user_id = $_SESSION['id'];
}

//login start
$error = '';
if ((isset($_POST['login'])) && ((empty($_POST['uname'])) || empty($_POST['password']))) {
    $error = "<script>empty()</script>";
} else if ((isset($_POST['uname'])) && (isset($_POST['password'])) && (isset($_POST['login']))) {
    $username = _get('uname');
    $password = _get('password');
    $error = login($username, $password);
}
//login end
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>George Brown Student Book Exchange</title>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Import java script function -->
        <script src="functions/function_js.js" type="text/javascript"></script>

        <!-- Import Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

        <!-- Import CSS -->
        <link href="css/cssCoding.css" rel="stylesheet">

        <!-- Import unslider -->
        <script src="//code.jquery.com/jquery-latest.min.js"></script>
        <script src="js/src/unslider.js"></script>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- Navbar
        ================================================== -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="">
                    <a class="brand" href="index.php">GBCSBE</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class=""><img src="img/George_Brown_College.png" alt="gbc" width="58"></li>
                            <li class="active">
                                <a href="student_index.php">Home</a>
                            </li>
                            <li class="" >
                                <a href="student_index.php" class="bootstro"
                                   data-bootstro-placement="bottom"  data-bootstro-step="0">About Us</a>
                            </li>
                            <li class="">
                                <a href="student_index.php" class="bootstro"
                                   data-bootstro-placement="bottom"  data-bootstro-step="1">Contact Us</a>
                            </li>
                            <li class="">
                                <a href="student_index.php" class="bootstro"
                                   data-bootstro-placement="bottom"  data-bootstro-step="2">FAQ</a>
                            </li>
                        </ul>
                    </div>
                    <?php echo status_navbar($login) ?>
                </div>
            </div>
        </div>
        <!-- Navbar END
        ================================================== -->
        <!-- Search Book 
        ================================================== -->
        <div class="container">
            <form style="text-align:center; vertiscal-align:middle;" class="form-search">
                <input style="height: 40px; font-size:18px;" type="text" name="search_val" placeholder="All books" class="span5 input-medium search-query">
                <button style="height: 40px; font-size:18px;" type="submit" class="btn btn-info">Search Book</button>
            </form>
        </div>
        <!-- Search Book END
        ================================================== -->
        <!-- Welcome
        ================================================== -->
        <div class="banner" >
            <ul class="ban">
                <li style="background-image: url('img/pic4.jpeg');">
                    <div class="inner">
                        <h1>Welcome!</h1>
                        <p>This is George Brown College Student Book Exchange Web Side</p>
                    </div>
                </li>
                <li style="background-image: url('img/pic5.jpg');">
                    <div class="inner">
                        <h1>Let's find a book!</h1>
                        <p>Using Search bar can help you to find books</p>
                    </div>
                </li>
                <li style="background-image: url('img/pic7.jpg');">
                    <div class="inner">
                        <h1>Register Now!</h1>
                        <p>After registered, you can post your books for sell.</p>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Welcome END
        ================================================== -->
        <!-- banner Javascript for banner
        ================================================== -->
        <script>
            if(window.chrome) {
                $('.banner li').css('background-size', '100% 100%');
            }

            $('.banner').unslider({
                fluid: true,
                dots: true
            });
        </script>
        <!-- banner END
        ================================================== -->
        <!-- login 
        ================================================== -->
        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="myModalLabel">User Login</h3>
            </div>
            <div class="modal-body">
                <?php echo $error; ?>
                <form method='post'>
                    Username:<input type="text" name="uname"><br />
                    Password:<input type="password" name="password"><br />
                    <input type="submit" name="login" value="Sign in" class="btn btn-primary">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><br />
                    <hr />
                    <a href="#myForgot" role="button" class="btn" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Forgot your password?</a>
                </form>
            </div>
        </div>
        <div id="myForgot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myForgotLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="myForgotLabel">Forgot Password</h3>
            </div>
            <div class="modal-body">
                <form action='forgotpw.php' method='post'>
                    Username:<input type="text" name="forgot_name"><br />
                    <br />
                    Your password will be sent to your email address<br />
                    <hr />
                    <input class="btn btn-primary" type='submit' value='Send'>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                </form>
            </div>
        </div>
    </body>
</html>