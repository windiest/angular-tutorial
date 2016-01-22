<?php

/**
 * Backend Class for use in all Yoast plugins
 * Version 0.2
 */

if (!class_exists('Yoast_GA_Plugin_Admin')) {
	class Yoast_GA_Plugin_Admin {

		var $hook 		= '';
		var $filename	= '';
		var $longname	= '';
		var $shortname	= '';
		var $ozhicon	= '';
		var $optionname = '';
		var $homepage	= '';
		var $accesslvl	= 'edit_users';
		
		function Yoast_GA_Plugin_Admin() {
			add_action( 'admin_menu', array(&$this, 'register_settings_page') );
			add_filter( 'plugin_action_links', array(&$this, 'add_action_link'), 10, 2 );
			add_filter( 'ozh_adminmenu_icon', array(&$this, 'add_ozh_adminmenu_icon' ) );				
			
			add_action('admin_print_scripts', array(&$this,'config_page_scripts'));
			add_action('admin_print_styles', array(&$this,'config_page_styles'));	
			
			add_action('wp_dashboard_setup', array(&$this,'widget_setup'));	
		}
		
		function add_ozh_adminmenu_icon( $hook ) {
			if ($hook == $this->hook) 
				return plugin_dir_url( __FILE__ ).$this->ozhicon;
			return $hook;
		}
		
		function config_page_styles() {
			if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
				wp_enqueue_style('dashboard');
				wp_enqueue_style('thickbox');
				wp_enqueue_style('global');
				wp_enqueue_style('wp-admin');
				wp_enqueue_style('gawp-css', plugin_dir_url( __FILE__ ). 'yst_plugin_tools.css');
			}
		}

		function register_settings_page() {
			add_options_page($this->longname, $this->shortname, $this->accesslvl, $this->hook, array(&$this,'config_page'));
		}
		
		function plugin_options_url() {
			return admin_url( 'options-general.php?page='.$this->hook );
		}
		
		/**
		 * Add a link to the settings page to the plugins list
		 */
		function add_action_link( $links, $file ) {
			static $this_plugin;
			if( empty($this_plugin) ) $this_plugin = $this->filename;
			if ( $file == $this_plugin ) {
				$settings_link = '<a href="' . $this->plugin_options_url() . '">' . __('Settings', 'gawp_yoast') . '</a>';
				array_unshift( $links, $settings_link );
			}
			return $links;
		}
		
		function config_page() {
			
		}
		
		function config_page_scripts() {
			if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
				wp_enqueue_script('postbox');
				wp_enqueue_script('dashboard');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('media-upload');
			}
		}

		/**
		 * Create a Checkbox input field
		 */
		function checkbox($id) {
			$options = get_option( $this->optionname );
			$checked = false;
			if ( isset($options[$id]) && $options[$id] == 1 )
				$checked = true;
			return '<input type="checkbox" id="'.$id.'" name="'.$id.'"'. checked($checked,true,false).'/>';
		}

		/**
		 * Create a Text input field
		 */
		function textinput($id) {
			$options = get_option( $this->optionname );
			$val = '';
			if ( isset( $options[$id] ) )
				$val = $options[$id];
			return '<input class="text" type="text" id="'.$id.'" name="'.$id.'" size="30" value="'.$val.'"/>';
		}

		/**
		 * Create a dropdown field
		 */
		function select($id, $options, $multiple = false) {
			$opt = get_option($this->optionname);
			$output = '<select class="select" name="'.$id.'" id="'.$id.'">';
			foreach ($options as $val => $name) {
				$sel = '';
				if ($opt[$id] == $val)
					$sel = ' selected="selected"';
				if ($name == '')
					$name = $val;
				$output .= '<option value="'.$val.'"'.$sel.'>'.$name.'</option>';
			}
			$output .= '</select>';
			return $output;
		}
		
		/**
		 * Create a potbox widget
		 */
		function postbox($id, $title, $content) {
		?>
			<div id="<?php echo $id; ?>" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php echo $title; ?></span></h3>
				<div class="inside">
					<?php echo $content; ?>
				</div>
			</div>
		<?php
		}	


		/**
		 * Create a form table from an array of rows
		 */
		function form_table($rows) {
			$content = '<table class="form-table">';
			$i = 1;
			foreach ($rows as $row) {
				$class = '';
				if ($i > 1) {
					$class .= 'yst_row';
				}
				if ($i % 2 == 0) {
					$class .= ' even';
				}
				$content .= '<tr id="'.$row['id'].'_row" class="'.$class.'"><th valign="top" scrope="row">';
				if (isset($row['id']) && $row['id'] != '')
					$content .= '<label for="'.$row['id'].'">'.$row['label'].':</label>';
				else
					$content .= $row['label'];
				$content .= '</th><td valign="top">';
				$content .= $row['content'];
				$content .= '</td></tr>'; 
				if ( isset($row['desc']) && !empty($row['desc']) ) {
					$content .= '<tr class="'.$class.'"><td colspan="2" class="yst_desc"><small>'.$row['desc'].'</small></td></tr>';
				}
					
				$i++;
			}
			$content .= '</table>';
			return $content;
		}

		/**
		 * Create a "plugin like" box.
		 */
		function plugin_like($hook = '') {
			if (empty($hook)) {
				$hook = $this->hook;
			}
			$content = '<p>'.__('Why not do any or all of the following:', 'gawp_yoast' ).'</p>';
			$content .= '<ul>';
			$content .= '<li><a href="'.$this->homepage.'">'.__('Link to it so other folks can find out about it.', 'gawp_yoast' ).'</a></li>';
			$content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Give it a 5 star rating on WordPress.org.', 'gawp_yoast' ).'</a></li>';
			$content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Let other people know that it works with your WordPress setup.', 'gawp_yoast' ).'</a></li>';
			$content .= '</ul>';
			$this->postbox($hook.'like', __( 'Like this plugin?', 'gawp_yoast' ), $content);
		}	
		
		/**
		 * Info box with link to the bug tracker.
		 */
		function plugin_support($hook = '') {
			if (empty($hook)) {
				$hook = $this->hook;
			}
			$content = '<p>'.sprintf( __( 'If you\'ve found a bug in this plugin, please submit it in the <a href="%s">Yoast Bug Tracker</a> with a clear description.', 'gawp_yoast' ), 'http://yoast.com/bugs/google-analytics/').'</p>';
			$this->postbox($this->hook.'support', __('Found a bug?', 'gawp_yoast' ), $content);
		}

		/**
		 * Box with latest news from Yoast.com
		 */
		function news() {
			include_once(ABSPATH . WPINC . '/feed.php');
			$rss = fetch_feed('http://feeds.feedburner.com/joostdevalk');
			$rss_items = $rss->get_items( 0, $rss->get_item_quantity(5) );
			$content = '<ul>';
			if ( !$rss_items ) {
			    $content .= '<li class="yoast">'.__( 'No news items, feed might be broken...', 'gawp_yoast' ).'</li>';
			} else {
				foreach ( $rss_items as $item ) {
					$url = preg_replace( '/#.*/', '', esc_url( $item->get_permalink(), $protocolls=null, 'display' ) );
					$content .= '<li class="yoast">';
					$content .= '<a class="rsswidget" href="'.$url.'#utm_source=wpadmin&utm_medium=sidebarwidget&utm_term=newsitem&utm_campaign=wpgaplugin">'. esc_html( $item->get_title() ) .'</a> ';
					$content .= '</li>';
				}
			}						
			$content .= '<li class="facebook"><a href="https://www.facebook.com/yoastcom">'.__( 'Like Yoast on Facebook', 'gawp_yoast' ).'</a></li>';
			$content .= '<li class="twitter"><a href="http://twitter.com/yoast">'.__( 'Follow Yoast on Twitter', 'gawp_yoast' ).'</a></li>';
			$content .= '<li class="googleplus"><a href="https://plus.google.com/115369062315673853712/posts">'.__( 'Circle Yoast on Google+', 'gawp_yoast' ).'</a></li>';
			$content .= '<li class="rss"><a href="http://yoast.com/feed/">'.__( 'Subscribe with RSS', 'gawp_yoast' ).'</a></li>';
			$content .= '<li class="email"><a href="http://yoast.com/email-blog-updates/#utm_source=wpadmin&utm_medium=sidebarwidget&utm_term=emailsubscribe&utm_campaign=wpgaplugin">'.__( 'Subscribe by email', 'gawp_yoast' ).'</a></li>';
			$content .= '</ul>';
			$this->postbox('yoastlatest', __( 'Latest news from Yoast', 'gawp_yoast' ), $content);
		}

		function text_limit( $text, $limit, $finish = ' [&hellip;]') {
			if( strlen( $text ) > $limit ) {
		    	$text = substr( $text, 0, $limit );
				$text = substr( $text, 0, - ( strlen( strrchr( $text,' ') ) ) );
				$text .= $finish;
			}
			return $text;
		}

	}
}

