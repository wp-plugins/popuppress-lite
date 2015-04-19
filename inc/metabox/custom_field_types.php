<?php

/* --------------------------------------------------------------------
   Campo Personalizado: Vista Previa
-------------------------------------------------------------------- */

add_action( 'cpmb_render_popup_preview', 'popup_preview_field_PPS', 10, 1 );
function popup_preview_field_PPS( $field ) {
	// Get the current ID
	if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
	elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
	echo '<p style="color:#888; margin: 3px 0 0;">';
	if( !isset( $post_id ) ) {
		echo 'Save to see the preview';
	}
	else {
		echo do_shortcode('[popuppress id="'.$post_id.'"]');
		echo get_popup_PPS($post_id);
	}
	echo '</p>';
}

/* --------------------------------------------------------------------
   Campo Personalizado: Texto Plano
-------------------------------------------------------------------- */

add_action( 'cpmb_render_plain_text', 'plain_text_field_PPS', 10, 1 );
function plain_text_field_PPS( $field ) {
	if($field['std'])
		echo $field['std'];
	if($field['desc'])
		echo '<p class="cpmb_metabox_description">', $field['desc'], '</p>';
}




?>