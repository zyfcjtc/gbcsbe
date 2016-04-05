<?php
//from login page pass user id**
session_start();

//Login Checking
$login = '';
$everything_okay = '';
$form_error = '';

if (!isset($_SESSION['login'])) {
    echo "<script type=\"text/javascript\">alert('Please Login First.')</script><meta http-equiv='refresh' content='0;URL=student_index.php'>";
} else {
    if (!$_SESSION['login'])
        echo "<script type=\"text/javascript\">alert('Please Login First.')</script><meta http-equiv='refresh' content='0;URL=student_index.php'>";
    else {
        $login = $_SESSION['id'];
    }
}

include 'functions/functions.php';

if (sizeof($_POST) > 0) {
    if (isset($_POST['cancel'])) {
        redirect();
    }

    $title = get_post('title');
    $author = get_post('author');
    $price = get_post('price');
    $course = get_post('course');
    $description = get_post('description');

    $everything_okay = true;


    if (empty($course)) {
        $everything_okay = false;
        $form_error = '*book course is empty';
    }
    if (empty($price)) {
        $everything_okay = false;
        $form_error = '*book price is empty';
    }
    if (empty($author)) {
        $everything_okay = false;
        $form_error = '*book author is empty';
    }
    if (empty($title)) {
        $everything_okay = false;
        $form_error = '*book title is empty';
    }
    if (!scrubber($title)) {
        $everything_okay = false;
        $form_error = "*restricted word in title";
    }
    if (!scrubber($author)) {
        $everything_okay = false;
        $form_error = "*restricted word in author";
    }
    if (!scrubber($price)) {
        $everything_okay = false;
        $form_error = "*restricted word in price";
    }

    if (!scrubber($course)) {
        $everything_okay = false;
        $form_error = "*restricted word in course";
    }

    if (!scrubber($description)) {
        $everything_okay = false;
        $form_error = "*restricted word in description";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add a book</title>
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
        <!-- Welcome
        ================================================== -->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2"></div>
                <div class="span8">
                    <legend><h3>Add a Book</h3></legend>
                    <?php
                    if ($everything_okay) {
                        $user_id = $_SESSION['id'];
                        $book_id = add_book($title, $author, $price, $course, $description, $user_id);
                        if ($book_id > 0) {
                            //Book is added
                            print "<script type=\"text/javascript\">";
                            print "alert('Book is added.')";
                            print "</script>";
                            echo"Book is added";
                            echo '<meta http-equiv="refresh" content="0;URL=my_book.php">';
                        } else {
                            echo 'book was not added';
                        }
                    } else {
                        echo "<p class='text-error'>$form_error</p>"; // will print out error
                    }
                    ?>
                    <form action="add_book.php" method="post">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" />
                        <br />

                        <label for="author">Author</label>
                        <input type="text" name="author" id="author" />
                        <br />
                        <label for="price">Price</label>
                        <input type="number" step="any" min ="1" max="999.99" name="price" id="price" />
                        <br />
                        <label for="course">Course the book is for (Ex:ABCD1234)</label>
                        <input type="text" name="course" id="course" />
                        <br />
                        <label for="description">Short Description of book condition</label>
                        <textarea rows="5" cols="20" name="description" id="description" ></textarea>
                        <br /><br />
                        <button type="submit" class="btn btn-primary">Add!</button>
                    </form>
                </div>
                <div class="span2"><img src="img/books.jpg" alt="books"></div>
            </div>
        </div>
    </body>
</html>
