<?php

$host = "localhost";
$user = "j3pteam6_admin";
$password = "fZ5V_uZ(2Hu(";
$database = "j3pteam6_gbsbe";

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) {
    die('Connect Error (' . $mysqli->connect_error . ')' . $mysqli->connect_error);
}

function find_books($requist) {
    return "SELECT * FROM books where `title` LIKE '%$requist%'
                                OR `author` LIKE '%$requist%'
                                OR `course` LIKE '%$requist%'
                                OR `description` LIKE '%$requist%' ORDER BY `upload_date` DESC";
}

//used by admin_book.php, student_index.php

function find_users($requist) {
    return "SELECT * FROM users where `id` LIKE '%$requist%'
                                OR `type` LIKE '%$requist%'
                                OR `uname` LIKE '%$requist%'
                                OR `password` LIKE '%$requist%'
                                OR `fname` LIKE '%$requist%'
                                OR `lname` LIKE '%$requist%'
                                OR `email` LIKE '%$requist%'
                                OR `phone` LIKE '%$requist%'
                                OR `facebook` LIKE '%$requist%'
                                OR `twitter` LIKE '%$requist%'
                                OR `status` LIKE '%$requist%'";
}

//used by admin_user.php

function find_status($id) {
    return "SELECT `status` FROM users where `id` = '$id'";
}

//no one used


function new_msg($user_id) {
    $query = "SELECT `status` FROM msg where `to_id` = '$user_id' AND `status` = 'new' LIMIT 1";
    if ($login) {
        $new_msg = '';
        if (mysql_num_rows(mysql_query($query)) == 1)
            $new_msg = "";
        echo "<div class='span2'>
                    <a href='my_books.php' class='btn'><i class='icon-book'></i> My Books</a><br /><br />
                    <a href='contact_page.php?id=" . $user_id . "' class='btn'><i class='icon-user'></i> My Contact</a><br /><br />
                    <a href='add_book.php' class='btn'><i class='icon-circle-arrow-up'></i> Add Book</a><br /><br />";

        if (mysql_num_rows(mysql_query($query)) == 1)
            echo "<a href='msg_box.php' class='btn'><i class='icon-envelope'></i>Message Box</a><br />
                            <script>
                            # Want to put actions at the end of your messages?
                          msg = $.globalMessenger().post
                         message: 'Launching thermonuclear war...'
                            type: 'info'
                    actions:
                       cancel:
                          label: 'cancel launch'
                          action: ->
                             msg.update
                               message: 'Thermonuclear war averted'
                               type: 'success'
                                  actions: false</p><br /></div></script";
        else
            echo "<a href='msg_box.php' class='btn'><i class='icon-envelope'></i> Message Box</a><br /><br /></div>";
    }
}

//used by student_index.php

function msgs($link, $user_id) {
    return mysqli_query($link, "SELECT * FROM msg where `to_id` = '$user_id' ORDER BY `id` DESC");
}

//used by msg_box.php

function read_msgs($link, $user_id) {
    mysqli_query($link, "UPDATE msg SET status = 'read' where `to_id` = '$user_id'");
}

function getID() {
    $file_name = 'ids.txt';
    if (!file_exists($file_name)) {
        touch($file_name);
        $handle = fopen($file_name, 'r+');
        $id = 0;
    } else {
        $handle = fopen($file_name, 'r+');
        $id = fread($handle, filesize($file_name));
        settype($id, "integer");
    }
    rewind($handle);
    fwrite($handle, ++$id);

    fclose($handle);
    return $id;
}

function _get($name) {
    return (isset($_REQUEST[$name]) ? $_REQUEST[$name] : '');
}

function add_book($title, $author, $price, $course, $description, $user_id) {
    global $link;
    $query_text = "INSERT INTO books(`title`, `author`, `price`, `course`, `description`, `user_id`) VALUES
    ('$title','$author', '$price', '$course', '$description', $user_id);";
    //echo $query_text; 
    mysqli_query($link, $query_text);
    echo "<br />";
    echo mysqli_error($link);
    return mysqli_insert_id($link);
}

/*
  //gets the books by each user id
 */

function get_books_by_user_id($user_id) {
    global $link;
    $result = mysqli_query($link, "SELECT * FROM books WHERE user_id = $user_id;");
    $return_array = array();

    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];  //identify the book by book id
        $return_array[$id] = $row;  // go thru array searching by id
    }
    return $return_array;
}

/*
  //gets all the contents in the post and puts it in an array, and puts in code to help
  //prevent user from querying themself
 */

function get_post($key) { //gets single thing out of post
    global $link;
    $return = '';
    if (isset($_POST[$key]) && !empty($_POST[$key])) {
        $return = mysqli_real_escape_string($link, $_POST[$key]);
    }
    return $return;
}

/*
  // gets the book from the book id for the search function
 */

function get_book($id) {
    global $link;
    $result = mysqli_query($link, "SELECT * from books WHERE id = $id;");
    $return_data = array();
    if (mysqli_num_rows($link, $result) === 0) {
        return false;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $return_data = $row;  // go thru array searching by book id
    }

    return $return_data;
}

/*
  // Deletes book by grabbing the book id from the get array
 */

function delete_book($id) {
    global $link;
    $query_text = "DELETE FROM books WHERE id = $id LIMIT 1;";
    echo $query_text;
    mysqli_query($link, $query_text); //limit changes to only 1 row
    return mysqli_affected_rows() > 0;
}

/*
  // redirects from one site, using the hardcord variable from the url function
 */

function redirect($url) {
    $full_url = url($url);
    header("Location: $full_url");
}

/*
  // hardcoded variable for redirecting
 */

function url($path) {
    return 'http://j3pteam6.gblearn.com/comp1230/assignments/assignment2/' . $path;
}

/*
  // checks to make sure that their isn't any naughty words in the database
 */

function scrubber($text) {
    $bad_words = array("anus", "arse", "ass", "ballsack", "balls", "bastard", "bitch", "biatch", "bloody", "blowjob",
        "blow job", "bollock", "bollok", "boner", "boob", "bugger", "bum", "butt", "buttplug", "clitoris", "cock", "coon", "crap",
        "cunt", "damn", "dick", "dildo", "dyke", "fag", "feck", "fellate", "fellatio", "felching", "fuck", "f u c k", "fudgepacker", "fudge packer",
        "flange", "Goddamn", "God damn", "hell", "homo", "jerk", "jizz", "knobend", "knob end", "labia", "lmao", "lmfao", "muff",
        "nigger", "nigga", "omg", "penis", "piss", "poop", "prick", "pube", "pussy", "queer", "scrotum", "sex", "shit", "s hit",
        "sh1t", "slut", "smegma", "spunk", "tit", "tosser", "turd", "twat", "vagina", "wank", "whore", "wtf");

    foreach ($bad_words as $word) {
        if (stripos($text, $word))
            ; {
            return true;
        }
    }
    return true;
}

/*
  // updates the book data with the new value that the user puts in
 */

function update_book_data($id, $book_data) {
    global $link;
    $title = $book_data['title'];
    $author = $book_data['author'];
    $price = $book_data['price'];
    $course = $book_data['course'];
    $description = $book_data['description'];

    $query_text = "UPDATE books SET `title` = '$title', `author` = '$author', `price` = '$price', 
        `course` = '$course', `description` = '$description'  WHERE `id` = $id ;";
    //echo $query_text; 
    mysqli_query($link, $query_text);
    //echo "<br />"; 
    //echo mysql_error(); 

    return mysqli_affected_rows() > 0;
}

/*
  // sets field names for form data
 */

function set_value($field_name, $default) {
    return isset($_POST[$field_name]) ? $_POST[$field_name] : $default;
}

/*
  // get the book count for the user (to be displayed at the top of my_books page
 */

function get_book_count($user_id) {
    $books = get_books_by_user_id($user_id);
    return sizeof($books);
}

/* function _get($name)
  {
  return (isset($_REQUEST[$name]) ? $_REQUEST[$name] : '');
  } */

// Function in change of sending the message to the database
function send_msg($subject, $msg, $from_id, $to_id) {
    global $link;
    $query = "INSERT INTO msg SEt from_id='$from_id', to_id='$to_id',subject='$subject', msg= '$msg'";
    mysqli_query($link, $query);
}

//Function in Charge of getting from_id & to_id names and display them        
function show_user_name($id) {
    global $link;
    $query1 = "SELECT uname FROM users WHERE id = $id ";
    $results = mysqli_query($link, $query1);
    $f_id = mysqli_fetch_array($results);
    return $f_id['uname'];
}

function printContact($user_id) {
    global $link;
    //assign the id
    $id = $user_id;
    //we select fields such as username, first name, last name, e-mail, phone,
    //facebook, and twitter by $id.
    $query = "SELECT uname, fname, lname, email, phone, facebook, twitter FROM users WHERE id=$id";
    $result = mysqli_query($link, $query);
    //we draw a table with named fields.
    //we can modify and delete contact information with Modify and Delete links.
    echo "<table class='table table-bordered table-condensed' border='1'>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td>Username&nbsp;</td><td>" . $row[0] . "&nbsp;</td></tr>
	      <tr><td>First Name&nbsp;</td><td>" . $row[1] . "&nbsp;</td></tr>
		  <tr><td>Last Name&nbsp;</td><td>" . $row[2] . "&nbsp;</td></tr>
		  <tr><td>Email&nbsp;</td><td>" . $row[3] . "&nbsp;</td></tr>
		  <tr><td>Phone&nbsp;</td><td>" . $row[4] . "&nbsp;</td></tr>
		  <tr><td>Facebook&nbsp;</td><td>" . $row[5] . "&nbsp;</td></tr>
		  <tr><td>Twitter&nbsp;</td><td>" . $row[6] . "&nbsp;</td></tr>
		  <tr><td>Modify&nbsp;</td><td><a href='modify_contact.php?id=$id&uname=$row[0]&fname=$row[1]&lname=$row[2]&email=$row[3]&phone=$row[4]&facebook=$row[5]&twitter=$row[6]'>Modify</a></td></tr>
		  <tr><td>Delete&nbsp;</td><td><a href='delete_contact.php?id=$id' onclick=\"return confirm('Are you sure you want to delete? If you delete your contact info, your books info will also be deleted!')\">Delete</a></td></tr>";
    }
    echo "</table>";
    //returning to the main page index.php if we click on the Back button.
    echo "<a href='student_index.php' class='btn'>Back</a>";
}

function printContact_admin($user_id) {
    $link = mysqli_connect('localhost', 'j3pteam6_admin', 'fZ5V_uZ(2Hu(', 'j3pteam6_gbsbe');
    $id = $user_id;
    $query = "SELECT uname, fname, lname, email, phone, facebook, twitter FROM users WHERE id=$id";
    $result = mysqli_query($link, $query);

    echo "<table class='table table-bordered table-condensed' border='1'>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td>Username&nbsp;</td><td>" . $row[0] . "&nbsp;</td></tr>
	      <tr><td>First Name&nbsp;</td><td>" . $row[1] . "&nbsp;</td></tr>
		  <tr><td>Last Name&nbsp;</td><td>" . $row[2] . "&nbsp;</td></tr>
		  <tr><td>Email&nbsp;</td><td>" . $row[3] . "&nbsp;</td></tr>
		  <tr><td>Phone&nbsp;</td><td>" . $row[4] . "&nbsp;</td></tr>
		  <tr><td>Facebook&nbsp;</td><td>" . $row[5] . "&nbsp;</td></tr>
		  <tr><td>Twitter&nbsp;</td><td>" . $row[6] . "&nbsp;</td></tr>";
    }
    echo "</table>";
    echo "<a href='admin_user.php' class='btn'>Back</a>";
}

function status_navbar($login) {
    if ($login) {
        return "<a href='change_password.php' class='bootstro navbar-right' data-bootstro-step='5'>Change Password</a>
                    <a href='logout.php' class='bootstro navbar-right' data-bootstro-step='4'>Logout</a>
                    <div class='btn-group navbar-right'>
                        <a class='btn dropdown-toggle' data-toggle='dropdown' href='#'>"
                             . $_SESSION['uname'] . 
                            "<span class='caret'></span>
                        </a>
                        <ul class='dropdown-menu'>
                            <ul>
                                <li><a href='my_profile.php'>Personal Info.</a></li>
                                <li><a href='my_book.php'>My book</a></li>
                                <li><a href='add_book.php'>Add book</a></li>
                                <li><a href='message.php'>Message</a></li>
                            </ul>
                        </ul>
                    </div>
                    <a href='' class='bootstro navbar-right'>Welcome back! </a>";
    } else {
        return '<a href="register.php" class="bootstro navbar-right" data-bootstro-step="5">Register</a>
                    <!-- Button to trigger modal -->
                    <a href="#myModal" role="button" class="bootstro navbar-right" data-toggle="modal" data-bootstro-step="4">Login</a>';
    }
}

function login($username, $password){
    global $link;
    $user_sql = "SELECT * 
                         FROM  `users` 
                         where uname='" . $username . "'";
    $user_result = mysqli_query($link, $user_sql);
    $user_line = mysqli_fetch_row($user_result);
    
    define("SALT", 'abcdefg');
    $se_password = hash("sha512", $password . "SALT");
    if (($se_password == $user_line[3]) && (isset($_POST['login']))) {
        // create the session
        //redidrect to admin page

        $_SESSION['uname'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['id'] = $user_line[0];
        $_SESSION['login'] = true;
        $_SESSION['admin'] = false;
        
        if ($user_line[1] == 'admin') {
            $_SESSION['admin'] = true;
            header('location:admin_book.php');
            exit;
        } else {
            header('location:index.php');
            exit;
        }
    } else {
        return "<script>check()</script>";
    }
}