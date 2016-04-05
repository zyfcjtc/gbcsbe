<?php
// Inialize session
session_start();

// Delete certain session
unset($_SESSION['id']);
unset($_SESSION['login']);
unset($_SESSION['admin']);
unset($_SESSION['uname']);
unset($_SESSION['password']);
// Jump to login page
//echo '<script>parent.window.location.reload(true);</script>';
header('Location: index.php');
exit();
