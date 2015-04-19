<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cpmb_meta_boxes', 'cpmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cpmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'pps_';

	// Get the current ID
	$post_id = 0;
	if( isset( $_GET['post'] ) )
		$post_id = $_GET['post'];

	// Default Options
	$std = get_option('pps_options');
	$values = get_post_custom($post_id);


	$meta_boxes[] = array(
		'id' => 'preview_mbox_cpmb',
		'title' => __('Popup Preview', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Preview', 'cpmb'),
				'id' => $prefix. 'popup_preview',
				'type' => 'popup_preview',
				'desc' => __('Save to view preview', 'cpmb'),
			),
			array(
				'name' => __('Shortcode', 'cpmb'),
				'id' => '',
				'type' => 'plain_text',
				'std' => '<p style="margin: 5px 0 0; font-size:14px;">[popuppress id="'.$post_id.'"]</p>',
				'desc' => __('Use this Shortcode to display your Popup', 'cpmb'),
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'button_mbox_cpmb',
		'title'      => __( 'Popup Button', 'cpmb' ),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		// 'cpmb_styles' => true, // Enqueue the CPMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __('Button Type', 'cpmb'),
				'id' => $prefix. 'button_type',
				'type' => 'radio',
				'std' => 'button',
				'options' => array(
					array('name' => __('Button','cpmb'), 'value' => 'button'),
					array('name' => __('Plain Text','cpmb'), 'value' => 'plain-text'),
					array('name' => __('No Button','cpmb'), 'value' => 'no-button'),
				),
				'desc' => __('Select the type of button that runs the popup. Choose "Thumbnails" If you want to show thumbnails as buttons for each image of your slider. <sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Button Text', 'cpmb'),
				'id' => $prefix. 'button_text',
				'type' => 'text',
				'std' => $std['button_text'],
				'desc' => __('Text for the button that opens the popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Button Title', 'cpmb'),
				'id' => $prefix. 'button_title',
				'type' => 'text',
				'std' => $std['button_title'],
				'desc' => __('Button text on hover<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Button Style Class', 'cpmb'),
				'id' => $prefix. 'button_class',
				'type' => 'text',
				'std' => $std['button_class'],
				'desc' => __('Add a Class to customize your button using CSS Styles.<sub></sub>', 'cpmb'),
			),
		),
	);

	/*
	Soluciona incompatibilidad con la opción
	"Open on Hover" de la versión anterior
	*/
	$run_method = 'click';
	if(isset($values[$prefix.'run_on_hover'][0])) {
		if($values[$prefix.'run_on_hover'][0] == 'yes') {
			$run_method = 'mouseover';
		}
	}


	$meta_boxes[] = array(
		'id' => 'open_mbox_cpmb',
		'title' => __('Open Settings', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Open hook', 'cpmb'),
				'id' => $prefix. 'open_hook',
				'type' => 'radio',
				'std' => $run_method,
				'options' => array(
					array('name' => __('Click','cpmb'), 'value' => 'click'),
				),
				'desc' => __('Action that will trigger the popup<sub></sub>', 'cpmb'),
			),


			array(
				'name' => __('Open in', 'cpmb'),
				'id' => $prefix. 'open_in',
				'type' => 'radio',
				'std' => 'pages',
				'options' => array(
					array('name' => __('Specific pages','cpmb'), 'value' => 'pages'),
					array('name' => __('Home','cpmb'), 'value' => 'home'),
				),
				'desc' => __('Choose where to run the popup.<sub></sub>', 'cpmb'),
			),
		)
	);
	$meta_boxes[] = array(
		'id' => 'auto_open_mbox_cpmb',
		'title' => __('Automatically Open Settings', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Auto Open', 'cpmb'),
				'id' => $prefix. 'auto_open',
				'type' => 'radio_inline',
				'std' => 'false',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Opens automatically on page load<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Auto Open Delay (ms)', 'cpmb'),
				'id' => $prefix. 'delay',
				'type' => 'text',
				'std' => '2000',
				'desc' => __('Delay time to run the popup<sub></sub>', 'cpmb'),
			),




		)
	);

	$meta_boxes[] = array(
		'id' => 'settings_mbox_cpmb',
		'title' => __('Popup Configuration', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(

			array(
				'name' => __('Popup Style', 'cpmb'),
				'id' => $prefix. 'popup_style',
				'type' => 'select',
				'std' => $std['popup_style'],
				'options' => array(
					array('name' => __('Light', 'cpmb'), 'value' => 'light'),
					array('name' => __('Dark', 'cpmb'), 'value' => 'dark'),
				),
				'desc' => __('Choose the style of the Popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Show Transparent Border', 'cpmb'),
				'id' => $prefix. 'transparent_border',
				'type' => 'radio_inline',
				'std' => $std['transparent_border'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Shows a transparent outline around the Popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Border Radius (px)', 'cpmb'),
				'id' => $prefix. 'border_radius',
				'type' => 'text',
				'std' => $std['border_radius'],
				'desc' => __('Add value rounded corners to popup. 0 = no rounded corners.<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Show Title', 'cpmb'),
				'id' => $prefix. 'show_title',
				'type' => 'radio_inline',
				'std' => $std['show_title'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Displays the title of the popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Show Close X', 'cpmb'),
				'id' => $prefix. 'show_close',
				'type' => 'radio_inline',
				'std' => 'true',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Displays the X icon close of the popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Popup Width', 'cpmb'),
				'id' => $prefix. 'width',
				'type' => 'text_small',
				'std' => $std['popup_width'],
				'desc' => __('', 'cpmb'),
			),
			array(
				'name' => __('Width units', 'cpmb'),
				'id' => $prefix. 'width_units',
				'type' => 'radio_inline',
				'std' => 'px',
				'options' => array(
					array('name' => __('px','cpmb'), 'value' => 'px'),
					array('name' => __('%','cpmb'), 'value' => '%'),
				),
				'desc' => __('Units of measure for the width<sub></sub>', 'cpmb'),
			),
			/*
			array(
				'name' => __('Auto Width', 'cpmb'),
				'id' => $prefix. 'auto_width',
				'type' => 'radio_inline',
				'std' => 'false',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Adjust width automatically<sub></sub>', 'cpmb'),
			),
			*/
			array(
				'name' => __('Popup Height', 'cpmb'),
				'id' => $prefix. 'height',
				'type' => 'text_small',
				'std' => $std['popup_height'],
				'desc' => __('', 'cpmb'),
			),
			array(
				'name' => __('Height units', 'cpmb'),
				'id' => $prefix. 'height_units',
				'type' => 'radio_inline',
				'std' => 'px',
				'options' => array(
					array('name' => __('px','cpmb'), 'value' => 'px'),
					array('name' => __('%','cpmb'), 'value' => '%'),
				),
				'desc' => __('Units of measure for the height<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Auto Height', 'cpmb'),
				'id' => $prefix. 'auto_height',
				'type' => 'radio_inline',
				'std' => $std['auto_height'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Adjust height automatically<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Background Overlay', 'cpmb'),
				'id' => $prefix. 'bg_overlay',
				'type' => 'colorpicker',
				'std' => $std['bg_overlay'],
				'desc' => __('Select a background color', 'cpmb'),
			),

			/*array(
				'name' => __('Advanced Settings', 'cpmb'),
				'id' => $prefix. 'more-fields',
				'type' => 'more_fields',
			),*/

			array(
				'name' => __('Opacity Overlay', 'cpmb'),
				'id' => $prefix. 'opacity',
				'type' => 'text',
				'std' => $std['opacity_overlay'],
				'desc' => __('Transparency, from 0.1 to 1<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Position Type', 'cpmb'),
				'id' => $prefix. 'position_type',
				'type' => 'select',
				'std' => $std['position_type'],
				'options' => array(
					array('name' => __('Absolute', 'cpmb'), 'value' => 'absolute'),
					array('name' => __('Fixed', 'cpmb'), 'value' => 'fixed'),
				),
				'desc' => '',
			),
			array(
				'name' => __('Position X (px)', 'cpmb'),
				'id' => $prefix. 'position_x',
				'type' => 'text',
				'std' => $std['position_x'],
				'desc' => __('Position horizontal the popup. auto=center<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Position Y (px)', 'cpmb'),
				'id' => $prefix. 'position_y',
				'type' => 'text',
				'std' => $std['position_y'],
				'desc' => __('Position vertical the popup. auto=center<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Popup Speed (ms)', 'cpmb'),
				'id' => $prefix. 'speed',
				'type' => 'text',
				'std' => $std['popup_speed'],
				'desc' => __('Animation speed on open/close, in milliseconds<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Popup z-index', 'cpmb'),
				'id' => $prefix. 'zindex',
				'type' => 'text',
				'std' => $std['popup_zindex'],
				'desc' => __('Set the z-index for Popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Disable for logged users', 'cpmb'),
				'id' => $prefix. 'disable_logged_user',
				'type' => 'radio_inline',
				'std' => $std['disable_logged_user'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('The popups will be deactivated for the logged users<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Open Delay (ms)', 'cpmb'),
				'id' => $prefix. 'open_delay',
				'type' => 'text',
				'std' => '0',
				'desc' => __('Delay time to run the popup<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Close Click Overlay', 'cpmb'),
				'id' => $prefix. 'close_overlay',
				'type' => 'radio_inline',
				'std' => $std['close_overlay'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Should the popup close on click on overlay?<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Transition Effect', 'cpmb'),
				'id' => $prefix. 'popup_transition',
				'type' => 'select',
				'std' => $std['popup_transition'],
				'options' => array(
					array('name' => __('fadeIn', 'cpmb'), 'value' => 'fadeIn'),
					array('name' => __('slideDown', 'cpmb'), 'value' => 'slideDown'),
					array('name' => __('slideIn', 'cpmb'), 'value' => 'slideIn'),
				),
				'desc' => __('The transition of the popup when it opens.<sub></sub>', 'cpmb'),
			),

			array(
				'name' => __('Easing Effect', 'cpmb'),
				'id' => $prefix. 'popup_easing',
				'type' => 'text',
				'std' => $std['popup_easing'],
				'desc' => sprintf(__( 'The easing of the popup when it opens. "swing" and "linear". More in %sjQuery Easing%s <sub></sub>', 'cpmb' ), '<a href="http://jqueryui.com/resources/demos/effect/easing.html" target="_blank">','</a>'),
			),


		)
	);

	return $meta_boxes;
}

add_action( 'init', 'cpmb_initialize_cpmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cpmb_initialize_cpmb_meta_boxes() {

	if ( ! class_exists( 'cpmb_Meta_Box' ) )
		require_once 'init.php';

}

include_once('custom_field_types.php');