<?php
$options = get_option('pps_options');
global $wp_version;

?>
<div class="wrap">
	<!-- Display Plugin Icon and Header -->
	<?php screen_icon('settings'); ?>
	<h2 <?php if(version_compare($wp_version, "3.8", ">=" )) echo 'class="title-settings"';?>><?php _e( PPS_PLUGIN_NAME . ' Settings', 'PPS' );?></h2>

    <?php
		if ( ! isset( $_REQUEST['settings-updated'] ) )
			$_REQUEST['settings-updated'] = false;
		?>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="message updated" style="width:80%"><p><strong><?php _e( 'Options saved', 'PPS' ); ?></strong></p></div>
	<?php endif; ?>

<h2 id="pps-tabs" class="nav-tab-wrapper">
    <a class="nav-tab" href="#pps-tab1"><?php _e('Popup Configuration', 'PPS');?></a>
    <a class="nav-tab" href="#pps-tab2"><?php _e('Popup Button', 'PPS');?></a>
    <a class="nav-tab" href="#pps-tab3"><?php _e('Popup Slider', 'PPS');?></a>
    <a class="nav-tab" href="#pps-tab4"><?php _e('General', 'PPS');?></a>
    <a class="nav-tab" href="#pps-tab5"><?php _e('How to Create a Popup', 'PPS');?></a>
</h2>
<form id="pps-form" action="<?php echo admin_url('options.php');?>" method="post" >
	<?php settings_fields('pps_group_options'); ?>
    <div class="pps-tab-container">
        <div id="pps-tab1" class="pps-tab-content">

        	<!-- Popup Style -->
            <fieldset class="pps-option-group pps-option-select">
                <div class="pps-option-name">
                    <label><?php _e( 'Popup Style', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">

                	<div class="pps-option-item">
                        <select name="pps_options[popup_style]">
                            <option value='light' <?php selected('light', $options['popup_style']); ?>><?php _e( 'Light', 'PPS' ); ?></option>
                            <option value='dark' <?php selected('dark', $options['popup_style']); ?>><?php _e( 'Dark', 'PPS' ); ?></option>
						</select>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Show Transparent Border -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Show Transparent Border', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-border_t-true" name="pps_options[transparent_border]" type="radio" value="true" <?php checked('true', $options['transparent_border']); ?> />
						<label for="pps-border_t-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-border_t-false" name="pps_options[transparent_border]" type="radio" value="false" <?php checked('false', $options['transparent_border']); ?> />
						<label for="pps-border_t-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Shows a transparent outline around the Popup', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Border Radius -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-border-radius"><?php _e( 'Border Radius', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-border-radius" type="text" name="pps_options[border_radius]" value="<?php echo $options['border_radius']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add value rounded corners to popup. 0 = no rounded corners.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Popup Width -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-width"><?php _e( 'Popup Width', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-width" type="text" name="pps_options[popup_width]" value="<?php echo $options['popup_width']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the width of the popup box', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Popup Height -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-width"><?php _e( 'Popup Height', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-height" type="text" name="pps_options[popup_height]" value="<?php echo $options['popup_height']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the height of the popup box', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Auto Height -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Auto Height', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-auto-height-true" name="pps_options[auto_height]" type="radio" value="true" <?php checked('true', $options['auto_height']); ?> />
						<label for="pps-auto-height-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-auto-height-false" name="pps_options[auto_height]" type="radio" value="false" <?php checked('false', $options['auto_height']); ?> />
						<label for="pps-auto-height-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Adjust height automatically', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Show Title -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Show Title', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-show-title-true" name="pps_options[show_title]" type="radio" value="true" <?php checked('true', $options['show_title']); ?> />
						<label for="pps-show-title-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-show-title-false" name="pps_options[show_title]" type="radio" value="false" <?php checked('false', $options['show_title']); ?> />
						<label for="pps-show-title-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Displays the title of the popup', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Background Overlay -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-bg-overlay"><?php _e( 'Background Overlay', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input class="pps-colorpicker" id="pps-bg-overlay" type="text" name="pps_options[bg_overlay]" value="<?php echo $options['bg_overlay']; ?>" />
                       <p class="pps-option-info"><?php _e( 'Select a background color', 'PPS' ); ?></p>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Opacity Overlay -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-opacity-overlay"><?php _e( 'Opacity Overlay', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-opacity-overlay" type="text" name="pps_options[opacity_overlay]" value="<?php echo $options['opacity_overlay']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Transparency, from 0.1 to 1', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Position Type -->
            <fieldset class="pps-option-group pps-option-select">
                <div class="pps-option-name">
                    <label><?php _e( 'Position Type', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">

                	<div class="pps-option-item">
                        <select name="pps_options[position_type]">
                            <option value='absolute' <?php selected('absolute', $options['position_type']); ?>><?php _e( 'Absolute', 'PPS' ); ?></option>
                            <option value='fixed' <?php selected('fixed', $options['position_type']); ?>><?php _e( 'Fixed', 'PPS' ); ?></option>
						</select>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Position X -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-position-x"><?php _e( 'Position X', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-position-x" type="text" name="pps_options[position_x]" value="<?php echo $options['position_x']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Position horizontal the popup. auto=center', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Position Y -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-position-y"><?php _e( 'Position Y', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-position-y" type="text" name="pps_options[position_y]" value="<?php echo $options['position_y']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Position vertical the popup. auto=center', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Speed Open/Close -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-speed"><?php _e( 'Speed Open/Close', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-speed" type="text" name="pps_options[popup_speed]" value="<?php echo $options['popup_speed']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Animation speed on open/close, in milliseconds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Popup z-index -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-zindex"><?php _e( 'Popup z-index', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-zindex" type="text" name="pps_options[popup_zindex]" value="<?php echo $options['popup_zindex']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Set the z-index for Popup', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Close Click Overlay -->
            <fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Close Click Overlay', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-close-overlay-true" name="pps_options[close_overlay]" type="radio" value="true" <?php checked('true', $options['close_overlay']); ?> />
						<label for="pps-close-overlay-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-close-overlay-false" name="pps_options[close_overlay]" type="radio" value="false" <?php checked('false', $options['close_overlay']); ?> />
						<label for="pps-close-overlay-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <p class="pps-option-info"><?php _e( 'Should the popup close on click on overlay?', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Popup Transition -->
            <fieldset class="pps-option-group pps-option-select">
                <div class="pps-option-name">
                    <label><?php _e( 'Transition Effect', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">

                	<div class="pps-option-item">
                        <select name="pps_options[popup_transition]">
                            <option value='fadeIn' <?php selected('fadeIn', $options['popup_transition']); ?>><?php _e( 'fadeIn', 'PPS' ); ?></option>
                            <option value='slideDown' <?php selected('slideDown', $options['popup_transition']); ?>><?php _e( 'slideDown', 'PPS' ); ?></option>
                            <option value='slideIn' <?php selected('slideIn', $options['popup_transition']); ?>><?php _e( 'slideIn', 'PPS' ); ?></option>
						</select>
                        <span class="pps-option-info"><?php _e( 'The transition of the popup when it opens.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>


            <!-- Popup Easing -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-popup-easing"><?php _e( 'Easing Effect', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-popup-easing" type="text" name="pps_options[popup_easing]" value="<?php echo $options['popup_easing']; ?>" />
                       <span class="pps-option-info"><?php echo sprintf(__( 'The easing of the popup when it opens. "swing" and "linear". More in %sjQuery Easing%s', 'PPS' ), '<a href="http://jqueryui.com/resources/demos/effect/easing.html" target="_blank">','</a>'); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>




            <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>
            <fieldset class="pps-option-group pps-option-reset">
                <div class="pps-option-name">
                    <label for="pps-defaults"><?php _e( 'Reset options to default', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content">
                    <input id="pps-defaults" name="pps_options[default_options]" type="checkbox" value="true" <?php if (isset($options['default_options'])) { checked('true', $options['default_options']); } ?> />
                    <label for="pps-defaults"><span style="color:#333333;margin-left:3px;"><?php _e( 'Restore to default values', 'PPS' ); ?></span></label>
                    <p class="pps-option-info"><?php _e( 'Mark this option only if you want to return to the original settings of the plugin.', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>
        </div><!--.pps-tab1-->

        <div id="pps-tab2" class="pps-tab-content">
        	<!-- Button Text -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-button-text"><?php _e( 'Button Text', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-m">
                       <input id="pps-button-text" type="text" name="pps_options[button_text]" value="<?php echo $options['button_text']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Text for the button that opens the popup', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Button Title -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-button-title"><?php _e( 'Button Title', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-m">
                       <input id="pps-button-title" type="text" name="pps_options[button_title]" value="<?php echo $options['button_title']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Button text on hover', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>

            <!-- Button Class -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-button-class"><?php _e( 'Button Style Class', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-m">
                       <input id="pps-button-class" type="text" name="pps_options[button_class]" value="<?php echo $options['button_class']; ?>" />
                       <span class="pps-option-info"><?php _e( 'Add a Class to customize your button using CSS Styles. Use "pps-plain-text" to leave the button without format.', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->
                </div><!--.pps-option-content-->
			</fieldset>



        </div><!--.pps-tab2-->

        <div id="pps-tab3" class="pps-tab-content adds">
            <p>These features are available in the paid version. <a target="_blank" href="http://bitly.com/popuppress2">PopupPress Pro</a> <p>
            <img src="<?php echo PPS_URL."/css/images/add_slider.png"; ?>" />
        </div><!--.pps-tab3-->

        <div id="pps-tab4" class="pps-tab-content">

        	<!-- Prevent on mobile -->
        	<fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Disable for logged users', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-disable-logged-user-true" name="pps_options[disable_logged_user]" type="radio" value="true" <?php checked('true', $options['disable_logged_user']); ?> />
						<label for="pps-disable-logged-user-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-disable-logged-user-false" name="pps_options[disable_logged_user]" type="radio" value="false" <?php checked('false', $options['disable_logged_user']); ?> />
						<label for="pps-disable-logged-user-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <spam class="pps-option-info"><?php _e( 'The popups will be deactivated for the logged users', 'PPS' ); ?></spam>
                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Prevent on mobile -->
        	<fieldset class="pps-option-group pps-option-radio">
                <div class="pps-option-name">
                    <label><?php _e( 'Disable on mobile', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-prevent-mobile-true" name="pps_options[prevent_mobile]" type="radio" value="true" <?php checked('true', $options['prevent_mobile']); ?> />
						<label for="pps-prevent-mobile-true"><?php _e( 'Yes', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                	<div class="pps-option-item pps-boxs-6">
                        <input id="pps-prevent-mobile-false" name="pps_options[prevent_mobile]" type="radio" value="false" <?php checked('false', $options['prevent_mobile']); ?> />
						<label for="pps-prevent-mobile-false"><?php _e( 'Not', 'PPS' ); ?></label>
                    </div><!--.pps-option-item-->
                    <spam class="pps-option-info"><?php _e( 'Disable popups on mobile devices.', 'PPS' ); ?></spam>
                </div><!--.pps-option-content-->
            </fieldset>

        	<!-- Embeds Width -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-embed-width"><?php _e( 'Embeds Max Width', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-embed-width" type="text" name="pps_options[embed_width]" value="<?php echo $options['embed_width']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the max width of the embeds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <!-- Embeds Height -->
            <fieldset class="pps-option-group pps-option-text">
                <div class="pps-option-name">
                    <label for="pps-embed-width"><?php _e( 'Embeds Height', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content pps-clearfix">
                	<div class="pps-option-item pps-input-s">
                       <input id="pps-embed-height" type="text" name="pps_options[embed_height]" value="<?php echo $options['embed_height']; ?>" />
                       <span class="pps-option-info"><?php _e( '(px). Add the height of the embeds', 'PPS' ); ?></span>
                    </div><!--.pps-option-item-->

                </div><!--.pps-option-content-->
            </fieldset>

            <fieldset class="pps-option-group">
                <div class="pps-option-name">
                    <label for="pps-fix-jquery"><?php _e( 'Fix jQuery problem', 'PPS' ); ?></label>
                </div><!--.pps-option-name-->
                <div class="pps-option-content">
                    <input id="pps-fix-jquery" name="pps_options[fix_jquery]" type="checkbox" value="true" <?php if (isset($options['fix_jquery'])) { checked('true', $options['fix_jquery']); } ?> />
                    <label for="pps-fix-jquery"><span style="color:#333333;margin-left:3px;"><?php _e( 'Fix', 'PPS' ); ?></span></label>
                    <p class="pps-option-info"><?php _e( 'Some wordpress themes uploaded incorrectly the jQuery library and that causes incompatibility with this plugin. Check this option only if you are having these problems.', 'PPS' ); ?></p>
                </div><!--.pps-option-content-->
            </fieldset>

        </div><!--.pps-tab4-->

        <div id="pps-tab5" class="pps-tab-content">
            <h2>CCreate a new popup easily<h2>
            <img src="<?php echo PPS_URL."/documentation/documentation.jpg"; ?>" />
        </div><!--.pps-tab5-->

    </div><!--.pps-tab-container-->

    <div class="adds-pro">
    	<p><a target="_blank" href="http://bitly.com/popuppress"><img src="<?php echo PPS_URL."/css/images/get_popuppress_pro.png"; ?>" /></a><p>
    </div>

    <fieldset id="pps-item-submit" class="pps-option-group" style="padding:0">
        <div class="pps-option-name">
            <p class="submit">
                <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </div><!--.pps-option-name-->
        <div class="pps-option-content">
        </div><!--.pps-option-content-->
    </fieldset>

	</form>

</div><!--.wrap-->
<?php
?>