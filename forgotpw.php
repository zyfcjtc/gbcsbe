<?php
session_start();

include 'functions/functions.php';
include 'db.php';
global $link;
//First part of html
echo "<html>\n";
echo "    <head>\n";
echo "        <title>Password forgot</title>\n";
echo "        <script src=\"functions/function_js.js\" type=\"text/javascript\"></script>\n";
//first part end
$user_sql = "SELECT * 
               FROM  `users` 
               WHERE UNAME =  '" . $_POST['forgot_name'] . "'";
$user_line = mysqli_fetch_row(mysqli_query($link, $user_sql));
if (empty($_POST['forgot_name'])) {
    echo "<script type='text/javascript'>empty_uname()</script>";
} else if ($_POST['forgot_name'] != $user_line[2]) {
    echo "<script type='text/javascript'>ck_uname()</script>";
}
$forgot_name = $_POST['forgot_name'];
$password = rand(10000, 99999);
$se_password = hash('sha512', mysqli_real_escape_string($link, $password) . "SALT");
$reset_sql = "UPDATE  users SET  password =  '$se_password' where uname='" . $forgot_name . "'";
mysqli_query($link, $reset_sql);
$forgot_sql = "SELECT * 
               FROM  `users` 
               WHERE UNAME =  '" . $forgot_name . "'";
$forgot_result = mysqli_query($link, $forgot_sql);
$forgot_line = mysqli_fetch_row($forgot_result);

include("mailer/class.phpmailer.php");
include("mailer/class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$mail = new PHPMailer();

//$body             = $mail->getFile('contents.html');
//$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port = 465;                   // set the SMTP port

$mail->Username = "gbsbe0408@gmail.com";  // GMAIL username
$mail->Password = "GBcollege";            // GMAIL password

$mail->From = "gbsbe0408@gmail.com";
$mail->FromName = "George Brown 2nd book seller";
$mail->Subject = "George Brown student book exchange";
$mail->Body = 'Hello ' . $forgot_line[2] . ',<br />  this is a email from George Brown student book exchange.<br />
                   Your current password is <h3>' . $password . '</h3><br />
                   Please login the George Brown student book exchange website and change your password asap';
//$mail->AltBody    = "This is the body when user views in plain text format"; //Text Body
$mail->WordWrap = 50; // set word wrap
//$mail->MsgHTML($body);

$mail->AddReplyTo("gbsbe0408@gmail.com", "George Brown 2nd book seller");


$mail->AddAddress($forgot_line[6], $forgot_line[2]);

$mail->IsHTML(true); // send as HTML

if (!$mail->Send()) {
    // echo $mail->ErrorInfo;
} else {
    echo "Message has been sent to " . $forgot_line[6];
}
//second part of html
echo "            <script type='text/javascript'>email_send()</script>\n";
echo "        </script>  \n";
echo "    </head>\n";
echo "    <body>\n";
echo "    </body>\n";
echo "</html>";