<?php
/*
Securimage Test Script
Version 1.0m Mike Challis 08/29/2009
http://www.642weather.com/weather/scripts.php

Upload this PHP script to your web server and call it from the browser.
The script will tell you if you meet the requirements for running Securimage.

http://www.phpcaptcha.org
*/
//error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE warnings
//error_reporting(E_ALL); // Report all errors and warnings (very strict, use for testing only)
//ini_set('display_errors', 1); // turn error reporting on

// start a session cookie
if( !isset( $_SESSION ) ) {
    session_start();
}

if (isset($_GET['testimage']) && $_GET['testimage'] == '1') {
  $im = imagecreate(225, 225);
  $white = imagecolorallocate($im, 255, 255, 255);
  $black = imagecolorallocate($im, 0, 0, 0);

  $red   = imagecolorallocate($im, 255,   0,   0);
  $green = imagecolorallocate($im,   0, 255,   0);
  $blue  = imagecolorallocate($im,   0,   0, 255);

  // draw the head
  imagearc($im, 100, 120, 200, 200,  0, 360, $black);
  // mouth
  imagearc($im, 100, 120, 150, 150, 25, 155, $red);
  // left and then the right eye
  imagearc($im,  60,  95,  50,  50,  0, 360, $green);
  imagearc($im, 140,  95,  50,  50,  0, 360, $blue);

  imagestring($im, 5, 15, 1, 'PHP can make images!', $blue);
  imagestring($im, 2, 5, 20, ':) :) :)', $black);
  imagestring($im, 2, 5, 30, ':) :)', $black);
  imagestring($im, 2, 5, 40, ':)', $black);

  imagestring($im, 2, 150, 20, '(: (: (:', $black);
  imagestring($im, 2, 168, 30, '(: (:', $black);
  imagestring($im, 2, 186, 40, '(:', $black);

  imagepng($im, null, 3);
  exit;
}

function print_status($supported)
{
  if ($supported) {
    echo "<span style=\"color:green;\">Yes!</span>";
  } else {
    echo "<span style=\"color:red; font-weight: bold;\">No</span>";
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CAPTCHA PHP Requirements Test</title>
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
<style type="text/css" media="all">
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

.errors {
         color: #ff0000;
}
</style>
</head>

<body>

<div class="group" style="margin-left:20%; margin-right:20%; padding:20px;">
<h2>CAPTCHA PHP Requirements Test</h2>
<p>
  This script will test your PHP installation to see if (Securimage) CAPTCHA will run on your server.
  Make sure to perform all 3 tests using the links below.
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
   // Check for safe mode
    $safe_mode_is_on = ((boolean)@ini_get('safe_mode') === false) ? 0 : 1;
    if($safe_mode_is_on){
      echo '<p><span style="color:red;">Warning: Your web host has PHP safe_mode turned on.</span> PHP safe_mode can cause problems like sending mail failures and file permission errors.'."\n";
      echo 'PHP safe_mode is better turned off, relying on this feature might work, but is highly discouraged. Contact your web host for support.</p>'."\n";
    }

    // Check for older than PHP5
   if (phpversion() < 5) {
      echo '<p><span style="color:red;">Warning: Your web host has not upgraded from PHP4 to PHP5.</span> PHP4 was officially discontinued August 8, 2008 and is no longer considered safe.'."\n";
      echo 'PHP5 is faster, has more features, and is and safer. Using PHP4 might still work, but is highly discouraged. Contact your web host for support.</p>'."\n";
    }
  ?>


<ul>
  <li>
    <strong>PHP Version:</strong>
    <?php echo phpversion(); ?>
  </li>
  <li>
    <strong>System:</strong>
    <?php echo PHP_OS; ?>
  </li>
  <li>
    <strong>GD Support:</strong>
    <?php print_status($gd_support = extension_loaded('gd')); ?>
  </li>
  <?php if ($gd_support) $gd_info = gd_info(); else $gd_info = array(); ?>
  <?php if ($gd_support): ?>
  <li>
    <strong>GD Version:</strong>
    <?php echo $gd_info['GD Version']; ?>
  </li>
  <?php endif; ?>
  <li>
    <strong>TTF Support (FreeType):</strong>
    <?php print_status($gd_support && $gd_info['FreeType Support']); ?>
    <?php if ($gd_support && $gd_info['FreeType Support'] == false): ?>
    <br />No FreeType support.  Cannot use TTF fonts, but it will use GD fonts instead.
    <?php endif; ?>
  </li>
  
  <li>
    <strong>imagettftext Support:</strong>
    <?php print_status( function_exists('imagettftext') ); ?>
  </li>

  <li>
    <strong>imagettfbbox Support:</strong>
    <?php print_status( function_exists('imagettfbbox') ); ?>
  </li>

   <li>
    <strong>imagecreatetruecolor Support:</strong>
    <?php print_status( function_exists('imagecreatetruecolor') ); ?>
  </li>

  <li>
    <strong>imagefilledrectangle Support:</strong>
    <?php print_status( function_exists('imagefilledrectangle') ); ?>
  </li>

  <li>
    <strong>imagecolorallocatealpha Support:</strong>
    <?php print_status( function_exists('imagecolorallocatealpha') ); ?>
  </li>

  <li>
    <strong>JPEG Support:</strong>
    <?php

     if ( isset($gd_info['JPG Support']) ) {
         print_status($gd_support && $gd_info['JPG Support']);
     } else if ( isset($gd_info['JPEG Support']) ) {
         print_status($gd_support && $gd_info['JPEG Support']);
     }

    ?>
  </li>
  <li>
    <strong>PNG Support:</strong>
    <?php print_status($gd_support && $gd_info['PNG Support']); ?>
  </li>
  <li>
    <strong>GIF Read Support:</strong>
    <?php print_status($gd_support && $gd_info['GIF Read Support']); ?>
  </li>
  <li>
    <strong>GIF Create Support:</strong>
    <?php print_status($gd_support && $gd_info['GIF Create Support']); ?>
  </li>
</ul>

<?php if ($gd_support): ?>
Since you can see this...<br /><br />
<img src="index.php?testimage=1" alt="Test Image" align="bottom" />
<?php else: ?>
Based on the requirements, you do not have what it takes to run (Securimage) CAPTCHA :(
<?php endif; ?>

<p>
<b><a href="index.php">Try the PHP Requirements Test again</a></b><br />
<a href="cookie_test.php">Try the Cookie Test</a><br />
<a href="captcha_test.php">Try the CAPTCHA Test</a><br />
</p>

<p>PHP Scripts and WordPress plugins by Mike Challis<br />
<a href="http://www.642weather.com/weather/scripts.php">Free PHP Scripts</a><br />
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=6105441">Donate</a>, even small amounts are appreciated<br />
Contact Mike Challis for support: <a href="http://www.642weather.com/weather/wxblog/support/">(Mike Challis)</a>
</p>
</div>
<?php
//if( isset($_GET['phpinfo']) ) { phpinfo();}
?>
</body>
</html>
