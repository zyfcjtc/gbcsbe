<?php
// Inialize session
session_start();
include 'functions/functions.php';
include "db.php";
//Login Checking
$login = '';
if (!isset($_SESSION['login'])) {
    echo "<script type=\"text/javascript\">alert('Please Login First.')</script><meta http-equiv='refresh' content='0;URL=index.php'>";
} else
if (!$_SESSION['login'])
    echo "<script type=\"text/javascript\">alert('Please Login First.')</script><meta http-equiv='refresh' content='0;URL=index.php'>";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $login = $_SESSION['id'];
} else {
    echo "<script type=\"text/javascript\">alert('Error: Cannot find user id')</script><meta http-equiv='refresh' content='0;URL=index.php'>";
}

$errorMsg = "";
if (isset($_POST["reset"])) {
    if (!empty($_POST['n_pw']) && !empty($_POST['c_n_pw']) && !empty($_POST['o_pw'])) {
        $link = mysqli_connect('localhost', 'j3pteam6_admin', 'fZ5V_uZ(2Hu(', 'j3pteam6_gbsbe');
        if (mysqli_connect_error()) {
            print "cannot connect to database";
            die();
        }
        global $link;
        $user_sql = "SELECT * 
                         FROM  `users` 
                         where id='" . $_SESSION['id'] . "'";
        $user_result = mysqli_query($link, $user_sql);
        $user_line = mysqli_fetch_row($user_result);
        define("SALT", 'abcdefg');
        $oldpassword = hash('sha512', mysqli_real_escape_string($link, $_POST['o_pw']) . "SALT");
        if ($oldpassword != $user_line[3]) {
            $errorMsg = "* Current password does not match!";
        } else {
            if ($_POST['n_pw'] != $_POST['c_n_pw'])
                $errorMsg = "* Confirm password must match New password";
        }
        $newpassword = hash('sha512', mysqli_real_escape_string($link, $_POST['n_pw']) . "SALT");


        if (empty($errorMsg)){
            $query = "UPDATE users SET `password` = '$newpassword' WHERE `id`='$user_id'";
            mysqli_query($link, $query);
            echo "<script type=\"text/javascript\">alert('Reset Successful')</script><meta http-equiv='refresh' content='0;URL=index.php'>";
        }
    }else{
        $errorMsg = "* Password cannot be empty";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Reset Page</title>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Import java script function -->
        <script src="functions/function_js.js" type="text/javascript"></script>

        <!-- Import Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

        <!-- Import CSS -->
        <link href="css/cssCoding.css" rel="stylesheet">

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
                                <a href="index.php">Home</a>
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
                            <li class="">
                                <form class="form-search search-bar">
                                    <div class="input-append">
                                        <input type="text" name="search_val" placeholder="All books" class="span2 search-query">
                                        <button type="submit" class="btn btn-info">Search Book</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <?php echo status_navbar($login) ?>
                </div>
            </div>
        </div>
        <!-- Navbar END
        ================================================== -->
        <div class="container">
            <legend><h3>Reset Password</h3></legend>
            <p class="text-error"><?php echo $errorMsg; ?></p>
            <form action='' method='post'>
                <table class="table table-striped">
                    <tr>
                        <td>Current Password: </td>
                        <td><input type="password" name="o_pw"></td>
                    </tr>
                    <tr>
                        <td>New Password: </td>
                        <td><input type="password" name="n_pw"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password: </td>
                        <td><input type="password" name="c_n_pw"></td>
                    </tr>
                </table>
                <input type="submit" name="reset" value="Reset" class="btn btn-primary">
                <a href='index.php' class="btn">Back</a>
            </form>
        </div>
    </body>    
</html>