<?php
/*
Cookie Test Script
Version 1.0 Mike Challis 08/30/2009
http://www.642weather.com/weather/scripts.php

Upload this PHP script to your web server and call it from the browser.
The script will tell you if your browser meets the cookie requirements for running Securimage.

cookie test code from:
http://www.coderemix.com/tutorials/php-cookies-enabled-check
*/
//error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE warnings
error_reporting(E_ALL); // Report all errors and warnings (very strict, use for testing only)
ini_set('display_errors', 1); // turn error reporting on

// start a session cookie
if( !isset( $_SESSION ) ) {
    session_start();
}

$disabled_help = '
<b><a href="cookie_test.php">Try the Cookie Test again</a> just to be sure</b><br />
If the CAPTCHA is giving you a cookie error, this can be the cause.
The Captcha will not validate the phrase. The contact form will display an error:
"ERROR: Could not read CAPTCHA cookie. Make sure you have cookies enabled."
<br /><br />
Solution: Please configure your browser to allow cookies.
<br /><br />
Web browsers have a setting to enable/disable cookies.
They also have a setting to block/unblock cookies per each web site.
For instructions on how to enable cookies or unblock cookies in your browser, use a search engine.
Different internet browsers have different sets of instructions on how to change this setting.

';

$enabled_help = '
If the CAPTCHA is giving you a session error, this rules out your web browser as the cause.

<br /><br />
Solution: Try all 3 tests below.
If all 3 pass and the WordPress forms do not work properly,
the problem could be another WordPress plugin is conflicting.
Look on the Admin - Plugins - menu.
Temporarily Disable (not uninstall) all your other plugins.
Do your WordPress forms work now? If yes, Activate the plugins one by one to determine
which one conflicts. Notify that plugin author of the conflict.
';

// Define a cookie and reload the page
if(!isset($_GET['redirected']))
{
    setcookie ('mycookie', 'test', time() + 300);
    header('location:'.$_SERVER['PHP_SELF'].'?redirected=1');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Cookies Test</title>
<script type="text/javascript" language="javascript">
<!--
function toggleVisibility(id) {
   var e = document.getElementById(id);
   if(e.style.display == 'block')
       e.style.display = 'none';
   else
       e.style.display = 'block';
}
//-->
</script>
<style>
body
{
	background-color:#E6E6E6;
	font-family:"Courier New", Arial, sans-serif, monospace;
	font-size:1em;
	color:#333333;
}
.group
{
	background-color:#FFFFFF;
	border:1px #CCCCCC solid;
	margin-top:25px;
	margin-bottom:50px;
	text-align:left;
}
</style>
</head>

<body>

<div class="group" style="margin-left:20%; margin-right:20%; padding:20px;">
<h2>Cookies Test</h2>

<p>
This script will test your web browser to see if it can read a cookie needed by the CAPTCHA.
You should see a message below letting you know if cookies are properly enabled in your browser.
</p>

Note: If you see any errors or warnings at the top of the page<br />
<a href="#" style="cursor:pointer;" title="Click for Help!" onclick="toggleVisibility('session_tip');">Click for Help!</a>

<div style="text-align:left; display:none" id="session_tip">
<br />
<b>If you see an error "Warning: session_start..."</b><br />
There is a problem with
your PHP server that will prevent the CAPTCHA from working with PHP sessions.
Sometimes PHP session do not work because of a file permissions problem.
The solution is to make a trouble ticket with your web host,
send them a URL link to this page so they can see the error and fix it.
Alternatively, you can enable the setting "Use CAPTCHA without PHP Session",
then temporary files will be used for storing the CAPTCHA phrase.
This allows the CAPTCHA to function without using PHP Sessions.
You can find this setting on the plugin admin settings page.
</div>


<?php
// Check if the cookie just defined is there
$cookie_message = '';
if(isset($_GET['redirected']) and $_GET['redirected']==1) {
    if(!isset($_COOKIE['mycookie'])) {
        $cookie_message = '<p style="background-color:#FFCCCC; color:black; padding:10px;">
        Test Failed: Problem found: Cookies are NOT enabled on your browser.<br />
        '.$disabled_help.'
        </p>';
    }
    else{
        $cookie_message = '<p style="background-color:#99CC99; padding:10px;">
        Test Passed: Cookies are enabled on your browser.
        <br /><br />
        '.$enabled_help.'
        </p>';
    }
} else {
      $cookie_message = '<p style="background-color:#FFCCCC; padding:10px;">
        The test failed to check for cookies because of a PHP server error.
        <br /><br />
        The error message will indicate the cause of the problem.
        You may have to contact your web host support department.
        </p>';


}
echo $cookie_message;
?>

<p>
<a href="index.php">Try the PHP Requirements Test</a><br />
<b><a href="cookie_test.php">Try the Cookie Test again</a></b><br />
<a href="captcha_test.php">Try the CAPTCHA Test</a><br />
</p>

<p>PHP Scripts and WordPress plugins by Mike Challis<br />
<a href="http://www.642weather.com/weather/scripts.php">Free PHP Scripts</a><br />
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=6105441">Donate</a>, even small amounts are appreciated<br />
Contact Mike Challis for support: <a href="http://www.642weather.com/weather/wxblog/support/">(Mike Challis)</a>
</p>
</div>

</body>
</html>