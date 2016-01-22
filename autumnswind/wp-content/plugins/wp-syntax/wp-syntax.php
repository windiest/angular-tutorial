<?php
/*
Plugin Name: WP-Syntax
Plugin URI: http://www.connections-pro.com
Description: Syntax highlighting using <a href="http://qbnz.com/highlighter/">GeSHi</a> supporting a wide range of popular languages.
Version: 1.0
Author: Steven A. Zahm
Author URI: http://www.connections-pro.com
License: GPL2
Text Domain: wp_syntax
Domain Path: /lang

Original Author: Ryan McGeary

Copyright 2013  Steven A. Zahm  (email : helpdesk@connections-pro.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
@todo integrate TinyMCE button support using one of these as a base:
	http://wordpress.org/extend/plugins/wp-syntax-integration/
	http://wordpress.org/extend/plugins/wp-syntax-button/
@todo Merge this add-on plugin functionality:  http://wordpress.org/extend/plugins/wp-syntax-download-extension/

Look at these:	http://wordpress.org/extend/plugins/wp-synhighlight/
				http://wordpress.org/extend/plugins/wp-codebox/
 */

if ( ! class_exists( 'WP_Syntax' ) ) {

	class WP_Syntax {

		/**
		* @var (object) WP_Syntax stores the instance of this class.
		*/
		private static $instance;

		private static $token;

		private static $matches;

		/**
		 * A dummy constructor to prevent WP_Syntax from being loaded more than once.
		 *
		 * @access private
		 * @since 1.0
		 * @see WP_Syntax::instance()
		 * @see WP_Syntax();
		 */
		private function __construct() { /* Do nothing here */ }

		/**
		 * Main WP_Syntax Instance
		 *
		 * Insures that only one instance of WP_Syntax exists in memory at any one time.
		 *
		 * @access public
		 * @since 1.0
		 * @return object WP_Syntax
		 */
		public static function getInstance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		/**
		 * Initiate the plugin.
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		private function init() {

			self::defineConstants();
			self::inludeDependencies();

			self::$token = md5( uniqid( rand() ) );

			self::$matches = array();

			// Nothing to do during activation/deactivation yet...
			// register_activation_hook( dirname(__FILE__) . '/wp-syntax.php', array( __CLASS__, 'activate' ) );
			// register_deactivation_hook( dirname(__FILE__) . '/wp-syntax.php', array( __CLASS__, 'deactivate' ) );

			// Nothing to translate presently.
			// load_plugin_textdomain( 'wp_syntax' , false , WPS__DIR_NAME . 'lang' );

			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ) );

			// Update config for WYSIWYG editor to accept the pre tag and its attributes.
			add_filter( 'tiny_mce_before_init', array( __CLASS__,'tinyMCEConfig') );

			// We want to run before other filters; hence, a priority of 0 was chosen.
			// The lower the number, the higher the priority.  10 is the default and
			// several formatting filters run at or around 6.
			add_filter( 'the_content', array( __CLASS__, 'beforeFilter' ), 0);
			add_filter( 'the_excerpt', array( __CLASS__, 'beforeFilter' ), 0);
			add_filter( 'comment_text', array( __CLASS__, 'beforeFilter' ), 0);

			// We want to run after other filters; hence, a priority of 99.
			add_filter( 'the_content', array( __CLASS__, 'afterFilter' ), 99);
			add_filter( 'the_excerpt', array( __CLASS__, 'afterFilter' ), 99);
			add_filter( 'comment_text', array( __CLASS__, 'afterFilter' ), 99);

		}

		/**
		 * Define the constants.
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		private static function defineConstants() {

			define( 'WPS_VERSION', '1.0' );

			define( 'WPS_DIR_NAME', plugin_basename( dirname( __FILE__ ) ) );
			define( 'WPS_BASE_NAME', plugin_basename( __FILE__ ) );
			define( 'WPS_BASE_PATH', plugin_dir_path( __FILE__ ) );
			define( 'WPS_BASE_URL', plugin_dir_url( __FILE__ ) );

		}

		private static function inludeDependencies() {

			include_once( 'geshi/geshi.php' );

		}

		/**
		 * Called when activating  via the activation hook.
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		public static function activate() {

		}

		/**
		 * Called when deactivating via the deactivation hook.
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		public static function deactivate() {

		}

		/**
		 * Enqueue the CSS and JavaScripts.
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		public static function enqueueScripts() {

			// If a wp-syntax.css file exists in the theme folder use it instead.
			$url = file_exists( STYLESHEETPATH . '/wp-syntax.css' ) ? get_bloginfo( 'stylesheet_directory' ) . '/wp-syntax.css' : WPS_BASE_URL . 'css/wp-syntax.css';

			// Enqueue the CSS
			wp_enqueue_style( 'wp-syntax-css', $url, array(), WPS_VERSION );

			// Enqueue the JavaScript
			// wp_enqueue_script( 'wp-syntax-js', WPS_BASE_URL . 'js/wp-syntax.js', array( 'jquery' ), WPS_VERSION, TRUE );

		}

		/**
		 * Update the TinyMCE config to add support for the pre tag and its attributes.
		 *
		 * @access private
		 * @since 0.9.13
		 * @param  (array) $init The TinyMCE config.
		 * @return (array)
		 */
		public static function tinyMCEConfig( $init ) {

			$ext = 'pre[id|name|class|style|lang|line|escaped|highlight|src]';

			if ( isset( $init['extended_valid_elements'] ) ) {
				$init['extended_valid_elements'] .= "," . $ext;
			} else {
				$init['extended_valid_elements'] = $ext;
			}

			return $init;
		}

		// special ltrim b/c leading whitespace matters on 1st line of content
		public static function trimCode( $code ) {
			$code = preg_replace("/^\s*\n/siU", '', $code);
			$code = rtrim ($code );
			return $code;
		}

		public static function substituteToken( &$match ) {
			// global $wp_syntax_token, $wp_syntax_matches;

			$i = count( self::$matches );
			self::$matches[ $i ] = $match;

			return "\n\n<p>" . self::$token . sprintf( '%03d', $i ) . "</p>\n\n";
		}

		public static function lineNumbers( $code, $start ) {

			$line_count = count( explode( "\n", $code ) );
			$output = '<pre>';

			for ( $i = 0; $i < $line_count; $i++ ) {
				$output .= ( $start + $i ) . "\n";
			}

			$output .= '</pre>';

			return $output;
		}

		public static function caption( $url ) {

			$parsed = parse_url( $url );
			$path = pathinfo( $parsed['path'] );
			$caption = '';

			if ( ! isset( $path['filename'] ) ) {
				return;
			}

			if ( isset( $parsed['scheme'] ) ) {
				$caption .= '<a href="' . $url . '">';
			}

			if ( isset( $parsed["host"] ) && $parsed["host"] == 'github.com' )
			{
				$caption .= substr( $parsed['path'], strpos( $parsed['path'], '/', 1 ) ); /* strip github.com username */
			} else {
				$caption .= $parsed['path'];
			}

			/* $caption . $path["filename"];
			if (isset($path["extension"])) {
				$caption .= "." . $path["extension"];
			}*/

			if ( isset($parsed['scheme']) ) {
				$caption .= '</a>';
			}

			return $caption;
		}

		public static function highlight( $match ) {
			// global $wp_syntax_matches;

			$i = intval( $match[1] );
			$match = self::$matches[ $i ];

			$language = strtolower( trim( $match[1] ) );
			$line = trim( $match[2] );
			$escaped = trim( $match[3] );
			$caption = self::caption( $match[5] );
			$code = self::trimCode( $match[6] );

			if ( $escaped == 'true' ) $code = htmlspecialchars_decode( $code );

			$geshi = new GeSHi( $code, $language );
			$geshi->enable_keyword_links( FALSE );

			do_action_ref_array( 'wp_syntax_init_geshi', array( &$geshi ) );

			if ( ! empty( $match[4] ) ) {

				$linespecs = strpos( $match[4], ",") == FALSE ? array( $match[4] ) : explode( ',', $match[4] );
				$lines = array();

				foreach ( $linespecs as $spec ) {
					$range = explode( '-', $spec );
					$lines = array_merge( $lines, ( count( $range ) == 2) ? range( $range[0], $range[1]) : $range );
				}

				$geshi->highlight_lines_extra( $lines );
			}

			$output = "\n" . '<div class="wp_syntax">';
			$output .= '<table>';

			if ( ! empty( $caption ) ) {
				$output .= '<caption>' . $caption . '</caption>';
			}

			$output .= '<tr>';

			if ( $line ) {
				$output .='<td class="line_numbers">' . self::lineNumbers( $code, $line ) . '</td>';
			}

			$output .= '<td class="code">';
			$output .= $geshi->parse_code();
			$output .= '</td></tr></table>';
			$output .= '</div>' . "\n";

			return $output;
		}

		public static function beforeFilter( $content ) {

			return preg_replace_callback(
				"/\s*<pre(?:lang=[\"']([\w-]+)[\"']|line=[\"'](\d*)[\"']|escaped=[\"'](true|false)?[\"']|highlight=[\"']((?:\d+[,-])*\d+)[\"']|src=[\"']([^\"']+)[\"']|\s)+>(.*)<\/pre>\s*/siU",
				array( __CLASS__, 'substituteToken' ),
				$content
			);

		}

		public static function afterFilter( $content ) {
			// global $wp_syntax_token;

			 $content = preg_replace_callback(
				 '/<p>\s*' . self::$token . '(\d{3})\s*<\/p>/si',
				 array( __CLASS__, 'highlight' ),
				 $content
			 );

			return $content;
		}

	}

	/**
	 * The main function responsible for returning the WP_Syntax instance
	 * to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $wp_syntex = WP_Syntax(); ?>
	 *
	 * @access public
	 * @since 1.0
	 * @return mixed (object)
	 */
	function WP_Syntax() {
		return WP_Syntax::getInstance();
	}

	/**
	 * Start the plugin.
	 */
	add_action( 'plugins_loaded', 'WP_Syntax' );

}