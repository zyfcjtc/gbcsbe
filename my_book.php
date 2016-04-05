<?php
//未加navigation
session_start();
include 'functions/functions.php';
//checks to see if user is logged in and grabs the user id 
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $book_list = get_books_by_user_id($_SESSION['id']);
    $book_count = get_book_count($_SESSION['id']);
    $login = $_SESSION['id'];
} else {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>My Book List</title>
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
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2"></div>
                <div class="span8">
                    <legend><h3>My Book List</h3></legend>
                    <?php echo "<h4> You have <b>$book_count</b> Books</h4>"; ?> 
                    <table class="table table-bordered table-condensed table-striped">
                        <tr><th>Course</th><th>Title</th><th>Author</th><th>Price</th><th>Edit</th><th>Delete</th></tr>
                        <?php
                        foreach ($book_list as $book_id => $book) { //using both the key and the value i.e. key=>value
                            echo "<tr>";
                            echo "<td>" . $book['course'] . "</td>";
                            echo "<td>" . $book['title'] . "</td>";
                            echo "<td>" . $book['author'] . "</td>";
                            echo "<td>" . $book['price'] . "</td>";
                            echo "<td><a class='btn' href='edit_book.php?book_id=$book_id'>Edit book</a></td>";
                            echo "<td><a class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete?')\" href='delete_book.php?book_id=$book_id'>Delete book</a></td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <div class="span2"><img src="img/books.jpg" alt="books"></div>
            </div>
        </div>
    </body>
</html>
