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

if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $login = $_SESSION['login'];
    $user_id = $_SESSION['id'];
    if (!$login) {
        header('location: index.php');
        exit();
    }
} else {
    header('location: index.php');
    exit();
}
$user_sql = "SELECT * 
                         FROM  `users` 
                         where uname='" . $_SESSION['uname'] . "'";
$user_result = mysqli_query($link, $user_sql);
$user_line = mysqli_fetch_row($user_result);
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
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="">
                    <a class="brand" href="./index.html">GBCSBE</a>
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
                                   data-bootstro-placement="bottom"  data-bootstro-step="4">FAQ</a>
                            </li>
                            <li class="">
                                <a href="student_index.php" class="bootstro"
                                   data-bootstro-placement="bottom"  data-bootstro-step="5">Search Book</a>
                            </li>
                        </ul>
                    </div>
                    <?php echo status_navbar($login) ?>
                    
                    <div class="btn-group navbar-right">
                          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo $_SESSION['uname']; ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <ul>
                                <li><a href="my_profile.php">Personal Info.</a></li>
                                <li><a href="my_book.php">My book</a></li>
                                <li><a href="add_book.php">Add book</a></li>
                                <li><a href="message.php">Message</a></li>
                            </ul>
                        </ul>
                    </div>
                    <p class="navbar-right">Welcome back! </p> 
                </div>
            </div>
        </div>

        <!-- Welcome
        ================================================== -->
        <div class="banner">
            <ul>
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

        <!-- banner Javascript 
        ================================================== -->
        <script>
            if (window.chrome) {
                $('.banner li').css('background-size', '100% 100%');
            }

            $('.banner').unslider({
                fluid: true,
                dots: true
            });
        </script>

        <!-- login -->
        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="myModalLabel"></h3>
            </div>
            <div class="modal-body">
                <legend>User Login</legend>
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
                <h3 id="myForgotLabel"></h3>
            </div>
            <div class="modal-body">
                <form action='forgotpw.php' method='post'>
                    <legend>Forgot Password</legend>
                    Username:<input type="text" name="forgot_name"><br />
                    <br />
                    Your password will be sent to your email address<br />
                    <br />
                    <br />
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <input class="btn btn-primary" type='submit' value='Send'>
                </form>
            </div>
        </div>
    </body>
</html>