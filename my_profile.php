<?php
// Inialize session
session_start();
//Import Function
include 'functions/functions.php'; //require 'functions/function_php.php';
// Connects to Database 
include "db.php";
global $link;
//Login Checking
if (!isset($_SESSION['login'])) {
    echo "<script type=\"text/javascript\">alert('Please Login First.')</script><meta http-equiv='refresh' content='0;URL=index.php'>";
} else
if (!$_SESSION['login'])
    echo "<script type=\"text/javascript\">alert('Please Login First.')</script><meta http-equiv='refresh' content='0;URL=index.php'>";
$login = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>My Contact Info.</title>
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

        <!-- Profile 
        ================================================== -->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2"><img src="img/booktree1.jpg" alt="tree1" style="margin: 10px;"></div>
                <div class="span8">
                    <legend><h3>My Profile</h3></legend>

                    <?php
                    //when we get the id, we address to the function ‘printContact($id)’
                    //in site_functions.php.
                    if (isset($_SESSION['id'])) {
                        global $link;
                        //assign the id
                        $id = $_SESSION['id'];
                        //we select fields such as username, first name, last name, e-mail, phone,
                        //facebook, and twitter by $id.
                        $query = "SELECT uname, fname, lname, email, phone, facebook, twitter    FROM users WHERE id=$id";
                        $result = mysqli_query($link, $query);
                        //we draw a table with named fields.
                        //we can modify and delete contact information with Modify and Delete links.
                        echo "<table class='table table-striped'>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr><td>User Name</td><td>" . $row[0] . "&nbsp;</td></tr>
                                <tr><td>First Name</td><td>" . $row[1] . "&nbsp;</td></tr>
                                <tr><td>Last Name</td><td>" . $row[2] . "&nbsp;</td></tr>
                                <tr><td>Email</td><td>" . $row[3] . "&nbsp;</td></tr>
                                <tr><td>Phone Number</td><td>" . $row[4] . "&nbsp;</td></tr>
                                <tr><td>Facebook</td><td>" . $row[5] . "&nbsp;</td></tr>
                                <tr><td>Twitter</td><td>" . $row[6] . "&nbsp;</td></tr>
                                <tr><td>Modify</td><td>
                                <a href='modify_contact.php?id=$id&uname=$row[0]&fname=$row[1]&lname=$row[2]&email=$row[3]&phone=$row[4]&facebook=$row[5]&twitter=$row[6]'>
                                    Modify</a></td></tr>
                                <tr><td>Delete</td><td>
                                <a href='delete_contact.php?id=$id' onclick=\"return confirm('Are you sure you want to delete?\\nIf you delete your account, your books info will also be deleted!')\" class='btn btn-mini btn-danger'>
                                    Delete</a></td></tr>";
                        }
                        echo "</table>";
                    } else {
                        //if we do not get the id, we return to the main page.
                        header('location: index.php');
                        exit();
                    }
                    ?>
                </div>
                <div class="span2"><img src="img/booktree2.jpg" alt="tree2" style="margin: 10px;"></div>
            </div>
        </div>
        <!-- Profile END
        ================================================== -->
    </body>
</html>