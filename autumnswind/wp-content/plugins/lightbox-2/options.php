<?php
$location = $options_page; // Form Action URI

/* Check for admin Options submission and update options*/
if ('process' == $_POST['stage']) {
    update_option('lightbox_2_theme', $_POST['lightbox_2_theme']);
    update_option('lightbox_2_automate', $_POST['lightbox_2_automate']);
    update_option('lightbox_2_resize_on_demand', $_POST['lightbox_2_resize_on_demand']);
}
/*Get options for form fields*/
$lightbox_2_theme = stripslashes(get_option('lightbox_2_theme'));

//print_r($_POST);
?>

<div class="wrap">
  <h2><?php _e('Lightbox 2 Options', 'lightbox_2') ?></h2>
  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
    <table width="100%" cellspacing="2" cellpadding="5" class="form-table">
        <tr valign="baseline">
        <th scope="row"><?php _e('Lightbox Appearance', 'lightbox_2') ?></th> 
        <td>

<?php
/* Check if there are themes: */
$lightbox_2_theme_path =  get_option('lightbox_2_theme_path');
//print_r($lightbox_2_theme_path);
if ($handle = opendir($lightbox_2_theme_path)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".DS_Store") {
            $theme_dirs[$file] = $lightbox_2_theme_path."/".$file."/";
        }   
    }
    closedir($handle);
}
//print_r($theme_dirs);

/* Create a drop-down menu of the valid themes: */
echo("\n<select name=\"lightbox_2_theme\">\n");
$current_theme = get_option('lightbox_2_theme');
foreach($theme_dirs as $shortname => $fullpath) {
    if((file_exists($fullpath."/lightbox.css")) && (file_exists($fullpath."/lightbox.css"))) {
        if($current_theme == urlencode($shortname)) {
            echo("<option value=\"".urlencode($shortname)."\" selected=\"selected\">".$shortname."</option>\n");
        } else {
            echo("<option value=\"".urlencode($shortname)."\">".$shortname."</option>\n");
  
        }
    }
}
echo("\n</select>");
?>
<p><small><?php _e('If in doubt, try the Black theme', 'lightbox_2') ?></small></p>
        </td>
        </tr>
		<tr valign="baseline">
        <th scope="row"><?php _e('Auto-lightbox image links', 'lightbox_2') ?></th> 
        <td>
        <?php
        $lightbox_2_automate = get_option('lightbox_2_automate');
         if($lightbox_2_automate == 1) {
         	echo("\n<input type=\"checkbox\" name=\"lightbox_2_automate\" value=\"1\" checked=\"checked\" />\n");
        } else {
			echo("\n<input type=\"checkbox\" name=\"lightbox_2_automate\" value=\"1\" />\n");
        }
        ?>
        <p><small><?php _e('Let the plugin add necessary html to image links', 'lightbox_2') ?></small></p>
        </td>
        <tr valign="baseline">
        <th scope="row"><?php _e('Shrink large images to fit smaller screens', 'lightbox_2') ?></th> 
        <td>
        <?php
        $lightbox_2_resize_on_demand = get_option('lightbox_2_resize_on_demand');
         if($lightbox_2_resize_on_demand == 1) {
         	echo("\n<input type=\"checkbox\" name=\"lightbox_2_resize_on_demand\" value=\"1\" checked=\"checked\" />\n");
        } else {
			echo("\n<input type=\"checkbox\" name=\"lightbox_2_resize_on_demand\" value=\"1\" />\n");
        }
        ?>
        <p><small><?php _e('Note: <u>Excessively large images</u> waste bandwidth and slow browsing!', 'lightbox_2') ?></small></p>
        </td>
        </tr>
     </table>

    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes', 'lightbox_2') ?>" />
    </p>
  </form>
</div>
