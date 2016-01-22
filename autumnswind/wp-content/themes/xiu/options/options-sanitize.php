<?php

/* Text */

add_filter( 'hui_sanitize_text', 'sanitize_text_field' );

/* Textarea */

function hui_sanitize_textarea($input) {
	/*global $allowedposttags;
	$custom_allowedtags["link"] = array(
		"href" => array(),
		"type" => array(),
		"rel" => array()
	);
	$custom_allowedtags["script"] = array(
		"src" => array(),
		"type" => array(),
		"charset" => array()
	);

	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $custom_allowedtags);
	return $output;*/
	return $input;
}

add_filter( 'hui_sanitize_textarea', 'hui_sanitize_textarea' );

/* Select */

add_filter( 'hui_sanitize_select', 'hui_sanitize_enum', 10, 2);

/* Radio */

add_filter( 'hui_sanitize_radio', 'hui_sanitize_enum', 10, 2);

/* Images */

add_filter( 'hui_sanitize_images', 'hui_sanitize_enum', 10, 2);
add_filter( 'hui_sanitize_colorradio', 'hui_sanitize_enum', 10, 2);

/* Checkbox */

function hui_sanitize_checkbox( $input ) {
	if ( $input ) {
		$output = '1';
	} else {
		$output = false;
	}
	return $output;
}
add_filter( 'hui_sanitize_checkbox', 'hui_sanitize_checkbox' );

/* Multicheck */

function hui_sanitize_multicheck( $input, $option ) {
	$output = '';
	if ( is_array( $input ) ) {
		foreach( $option['options'] as $key => $value ) {
			$output[$key] = "0";
		}
		foreach( $input as $key => $value ) {
			if ( array_key_exists( $key, $option['options'] ) && $value ) {
				$output[$key] = "1";
			}
		}
	}
	return $output;
}
add_filter( 'hui_sanitize_multicheck', 'hui_sanitize_multicheck', 10, 2 );

/* Color Picker */

add_filter( 'hui_sanitize_color', 'hui_sanitize_hex' );

/* Uploader */

function hui_sanitize_upload( $input ) {
	$output = '';
	$filetype = wp_check_filetype($input);
	if ( $filetype["ext"] ) {
		$output = $input;
	}
	return $output;
}
add_filter( 'hui_sanitize_upload', 'hui_sanitize_upload' );

/* Editor */

function hui_sanitize_editor($input) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedtags;
		$output = wpautop(wp_kses( $input, $allowedtags));
	}
	return $output;
}
add_filter( 'hui_sanitize_editor', 'hui_sanitize_editor' );

/* Allowed Tags */

function hui_sanitize_allowedtags($input) {
	global $allowedtags;
	$output = wpautop(wp_kses( $input, $allowedtags));
	return $output;
}

/* Allowed Post Tags */

function hui_sanitize_allowedposttags($input) {
	global $allowedposttags;
	$output = wpautop(wp_kses( $input, $allowedposttags));
	return $output;
}

add_filter( 'hui_sanitize_info', 'hui_sanitize_allowedposttags' );


/* Check that the key value sent is valid */

function hui_sanitize_enum( $input, $option ) {
	$output = '';
	if ( array_key_exists( $input, $option['options'] ) ) {
		$output = $input;
	}
	return $output;
}

/* Background */

function hui_sanitize_background( $input ) {
	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );

	$output['color'] = apply_filters( 'hui_sanitize_hex', $input['color'] );
	$output['image'] = apply_filters( 'hui_sanitize_upload', $input['image'] );
	$output['repeat'] = apply_filters( 'hui_background_repeat', $input['repeat'] );
	$output['position'] = apply_filters( 'hui_background_position', $input['position'] );
	$output['attachment'] = apply_filters( 'hui_background_attachment', $input['attachment'] );

	return $output;
}
add_filter( 'hui_sanitize_background', 'hui_sanitize_background' );

function hui_sanitize_background_repeat( $value ) {
	$recognized = hui_recognized_background_repeat();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'hui_default_background_repeat', current( $recognized ) );
}
add_filter( 'hui_background_repeat', 'hui_sanitize_background_repeat' );

function hui_sanitize_background_position( $value ) {
	$recognized = hui_recognized_background_position();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'hui_default_background_position', current( $recognized ) );
}
add_filter( 'hui_background_position', 'hui_sanitize_background_position' );

function hui_sanitize_background_attachment( $value ) {
	$recognized = hui_recognized_background_attachment();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'hui_default_background_attachment', current( $recognized ) );
}
add_filter( 'hui_background_attachment', 'hui_sanitize_background_attachment' );


/* Typography */

function hui_sanitize_typography( $input, $option ) {

	$output = wp_parse_args( $input, array(
		'size'  => '',
		'face'  => '',
		'style' => '',
		'color' => ''
	) );

	if ( isset( $option['options']['faces'] ) && isset( $input['face'] ) ) {
		if ( !( array_key_exists( $input['face'], $option['options']['faces'] ) ) ) {
			$output['face'] = '';
		}
	}
	else {
		$output['face']  = apply_filters( 'hui_font_face', $output['face'] );
	}

	$output['size']  = apply_filters( 'hui_font_size', $output['size'] );
	$output['style'] = apply_filters( 'hui_font_style', $output['style'] );
	$output['color'] = apply_filters( 'hui_sanitize_color', $output['color'] );
	return $output;
}
add_filter( 'hui_sanitize_typography', 'hui_sanitize_typography', 10, 2 );

function hui_sanitize_font_size( $value ) {
	$recognized = hui_recognized_font_sizes();
	$value_check = preg_replace('/px/','', $value);
	if ( in_array( (int) $value_check, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'hui_default_font_size', $recognized );
}
add_filter( 'hui_font_size', 'hui_sanitize_font_size' );


function hui_sanitize_font_style( $value ) {
	$recognized = hui_recognized_font_styles();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'hui_default_font_style', current( $recognized ) );
}
add_filter( 'hui_font_style', 'hui_sanitize_font_style' );


function hui_sanitize_font_face( $value ) {
	$recognized = hui_recognized_font_faces();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'hui_default_font_face', current( $recognized ) );
}
add_filter( 'hui_font_face', 'hui_sanitize_font_face' );

/**
 * Get recognized background repeat settings
 *
 * @return   array
 *
 */
function hui_recognized_background_repeat() {
	$default = array(
		'no-repeat' => __('No Repeat', 'haoui'),
		'repeat-x'  => __('Repeat Horizontally', 'haoui'),
		'repeat-y'  => __('Repeat Vertically', 'haoui'),
		'repeat'    => __('Repeat All', 'haoui'),
		);
	return apply_filters( 'hui_recognized_background_repeat', $default );
}

/**
 * Get recognized background positions
 *
 * @return   array
 *
 */
function hui_recognized_background_position() {
	$default = array(
		'top left'      => __('Top Left', 'haoui'),
		'top center'    => __('Top Center', 'haoui'),
		'top right'     => __('Top Right', 'haoui'),
		'center left'   => __('Middle Left', 'haoui'),
		'center center' => __('Middle Center', 'haoui'),
		'center right'  => __('Middle Right', 'haoui'),
		'bottom left'   => __('Bottom Left', 'haoui'),
		'bottom center' => __('Bottom Center', 'haoui'),
		'bottom right'  => __('Bottom Right', 'haoui')
		);
	return apply_filters( 'hui_recognized_background_position', $default );
}

/**
 * Get recognized background attachment
 *
 * @return   array
 *
 */
function hui_recognized_background_attachment() {
	$default = array(
		'scroll' => __('Scroll Normally', 'haoui'),
		'fixed'  => __('Fixed in Place', 'haoui')
		);
	return apply_filters( 'hui_recognized_background_attachment', $default );
}

/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param    string    The value that this function should return if it cannot be recognized as a color.
 * @return   string
 *
 */

function hui_sanitize_hex( $hex, $default = '' ) {
	if ( hui_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 * Get recognized font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return   array
 */

function hui_recognized_font_sizes() {
	$sizes = range( 12, 24 );
	$sizes = apply_filters( 'hui_recognized_font_sizes', $sizes );
	$sizes = array_map( 'absint', $sizes );
	return $sizes;
}

/**
 * Get recognized font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function hui_recognized_font_faces() {
	$default = array(
		'custom'	=> '- Add Custom Font -',
		'yahei'     => 'Microsoft Yahei',
		'simsun'     => 'Simsun',
		'arial'     => 'Arial',
		'verdana'   => 'Verdana, Geneva',
		'times'     => 'Times New Roman',
		'tahoma'    => 'Tahoma, Geneva',
		'helvetica' => 'Helvetica*'
		);
	return apply_filters( 'hui_recognized_font_faces', $default );
}

/**
 * Get recognized font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function hui_recognized_font_styles() {
	$default = array(
		'normal'      => __('Normal', 'haoui'),
		'italic'      => __('Italic', 'haoui'),
		'bold'        => __('Bold', 'haoui'),
		'bold italic' => __('Bold Italic', 'haoui')
		);
	return apply_filters( 'hui_recognized_font_styles', $default );
}

/**
 * Is a given string a color formatted in hexidecimal notation?
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return   bool
 *
 */

function hui_validate_hex( $hex ) {
	$hex = trim( $hex );
	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	}
	elseif ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	}
	else {
		return true;
	}
}