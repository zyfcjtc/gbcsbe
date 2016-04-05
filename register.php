<?php
//navigation需要改
include 'functions/functions.php';
?>
<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="utf-8">
        <title>Register Page</title>
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
        <div class="navbar navbar-fixed-top">
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
        
        
        <div class="container">
            <?php
            $uname = '';
            $password = '';
            $fname = '';
            $lname = '';
            $email = '';
            $phone = '';
            $facebook = '';
            $twitter = '';

            $error = "<font color='red'>*</font>";
            $error_info = '';
            $check1 = "";
            $check2 = "";
            $check3 = "";
            //if we press the button Register, the program reads information from the following fields.
            if (isset($_REQUEST['add']) && $_REQUEST['add']) {
                $uname = $_POST['uname'];
                $password = $_POST['password'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $facebook = $_POST['facebook'];
                $twitter = $_POST['twitter'];
                //checking entered information for errors.
                //if some errors are found, they are shown in the form.
                if (empty($_POST['uname']) || empty($_POST['password']) || empty($_POST['email'])) {
                    $error_info = "<font color='red'><p class='text-error'>* This is a mandatory field.</p></font>";
                    if (empty($_POST['uname']))
                        $check1 = $error;
                    if (empty($_POST['password']))
                        $check2 = $error;
                    if (empty($_POST['email']))
                        $check3 = $error;
                }else {
                    //otherwise, we connect to the database
                    $link = mysqli_connect('localhost', 'j3pteam6_admin', 'fZ5V_uZ(2Hu(', 'j3pteam6_gbsbe');
                    if (mysqli_connect_error()) {
                        print "cannot connect to database";
                        die();
                    }

                    //define variables and hash the password to make it more strong
                    define("SALT", 'abcdefg');
                    $uname = mysqli_real_escape_string($link, $_REQUEST['uname']);
                    $password = hash('sha512', mysqli_real_escape_string($link, $_REQUEST['password']) . "SALT");
                    $fname = mysqli_real_escape_string($link, $_REQUEST['fname']);
                    $lname = mysqli_real_escape_string($link, $_REQUEST['lname']);
                    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
                    $phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
                    $facebook = mysqli_real_escape_string($link, $_REQUEST['facebook']);
                    $twitter = mysqli_real_escape_string($link, $_REQUEST['twitter']);
                    //checking username if it is repeting.
                    $uname_checking = "SELECT uname FROM users
                                   WHERE '$uname' = `uname`";
                    if (@mysqli_num_rows(mysqli_query($link, $uname_checking)) == 1) {
                        //if username is taken, it will show the error.
                        $error_info = "<font color='red'><p class='text-error'>* The user name is already taken.</p></font>";
                    } else {
                        //if username does not repeat, we insert his/her information into the table 'users' into database 'gbsbe'
                        $query = "INSERT INTO users SET uname = '$uname', password = '$password',
                                   fname = '$fname', lname = '$lname', email = '$email',
                                   phone = '$phone', facebook = '$facebook', twitter = '$twitter'";

                        mysqli_query($link, $query);
                        //returning to the index.php page and can login.
                        echo "<meta http-equiv='refresh' content='0;URL=student_index.php'>";
                    }
                }
            }
            ?>
            <legend><h3>Register</h3></legend>
            <?php echo $error_info; ?>
            <!-- form to fill in with fields such as username, password, first name, last name, e-mail, phone, facebook, twitter -->
            <!-- username, password, e-mail are mandatory fields -->
            <!-- if the user did not not fill all information in mandatory fields, and pressed the button Register, -->
            <!-- it shows the error messages where the user forgot to fill information, and saves the information that he/she already filled. -->
            <div>
                <form action="" method="post">  
                    <!-- id and status are hidden fields. -->		
                    <input  type="hidden" name="id" value="" /><br /><br />
                    <table class='table table-striped'>
                        <tr>
                            <td><?php echo $check1; ?>Username: </td><td><input type="text" name="uname" value="<?php echo $uname; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $check2; ?>Password: </td><td><input type="password" name="password" value="<?php echo $password; ?>" /></td>
                        </tr>
                        <tr>
                            <td>First Name: </td><td><input type="text" name="fname" value="<?php echo $fname; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Last Name: </td><td><input type="text" name="lname" value="<?php echo $lname; ?>"  /></td>
                        </tr>
                        <tr>
                            <td><?php echo $check3; ?>E-mail: </td><td><input type="text" name="email" value="<?php echo $email; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Phone: </td><td><input type="text" name="phone" value="<?php echo $phone; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>FaceBook: </td><td><input type="text" name="facebook" value="<?php echo $facebook; ?>"  /></td>
                        </tr>
                        <tr>
                            <td>Twitter: </td><td><input type="text" name="twitter" value="<?php echo $twitter; ?>"  /></td>
                        </tr>
                    </table>
                    <!-- status can be: pending, active, or decline. Default value is pending. -->
                    <input type="hidden" name="status" value=""  /><br />
                    <!-- the user finish the registration by clicking the button -->
                    <input type='submit' name='add' value="Register" class="btn btn-primary" />
                    <!-- the user can cancel the registration by pressing the link. -->
                    <a href='index.php' class="btn">Cancel</a><br /><br />
                </form> 
            </div>
        </div>
    </body>
</html>

