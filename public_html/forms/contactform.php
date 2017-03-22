<?php
if( !isset($_POST['g-recaptcha-response']) || trim($_POST['g-recaptcha-response']) === '' ){
echo "Please complete the reCAPTCHA";
die();
}

session_start();
$msg='';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$recaptcha=$_POST['g-recaptcha-response'];
if(!empty($recaptcha))
{
include("getCurlData.php");
$google_url="https://www.google.com/recaptcha/api/siteverify";
$secret='6LfBLxUTAAAAAG0rIDs5NMtrmwLfEXHxs-LlFCnO';
$ip=$_SERVER['REMOTE_ADDR'];
$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
$res=getCurlData($url);
$res= json_decode($res, true);
//reCaptcha success check
if($res['success'])
{
//Include login check code
}
else
{
$msg="Please re-enter your reCAPTCHA.";
}
}
else
{
$msg="Please re-enter your reCAPTCHA.";
}
}
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
echo("$email is a valid email address");
} else {
exit("Error: $email is not a valid email address please go back and try again");
}
$utf8 = $_POST['message'];
$message = mb_convert_encoding($utf8, 'HTML-ENTITIES', 'UTF-8');
$formcontent=" From: $email \n Message: $message";
$recipient = "hey@alexnagel.me";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";
echo '<script language="javascript">';
echo 'alert("Message Sent")';
echo '</script>';
$success =mail($recipient, $subject, $formcontent, $mailheader) or exit("Error: message not sent correctly please go back and try again!");
?>