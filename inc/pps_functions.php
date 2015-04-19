<?php

/* --------------------------------------------------------------------
   Creamos Tipo de Post "PopupPress"
-------------------------------------------------------------------- */
add_action( 'init', 'create_post_type_popuppress_PPS' );

//add_filter('the_content', 'shortcode_unautop');

function create_post_type_popuppress_PPS() {
	$labels = array(
		'name' => __('PopupPress Lite', 'PPS'),
		'singular_name' => __('PopupPress', 'PPS'),
		'add_new' => __('New Popup', 'PPS'),
		'add_new_item' => __('Add New Popup', 'PPS'),
		'edit_item' => __( 'Edit Popup', 'PPS' ),
		'new_item' => __( 'New Popup', 'PPS'),
		'view_item' => __( 'View Popup', 'PPS' ),
		'search_items' => __( 'Search Popup', 'PPS' ),
		'not_found' => __( 'No Popups found', 'PPS' ),
		'not_found_in_trash' => __( 'No Popups found in Trash', 'PPS' ),
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		//'publicly_queryable' => true,
		'show_ui' => true,
		//'exclude_from_search' => false,
		'show_in_nav_menus' => false,

		'show_in_menu' => true,
		'rewrite' => false,
		'has_archive' => false,
		//'hierarchical' => false,
		'menu_position' => 20,
		'menu_icon' => PPS_URL.'/css/images/icon_plugin.png',

		'supports' => array('title','editor'),
	);
	register_post_type('popuppress',$args);
}


/* --------------------------------------------------------------------
  Filtro de Mensajes para el Tipo de Post "PopupPress"
-------------------------------------------------------------------- */
add_filter( 'post_updated_messages', 'messages_popuppress_PPS' );

function messages_popuppress_PPS( $messages ) {
	global $post, $post_ID;

	$messages['popuppress'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Popup updated. <a href="%s" class="pps-button-popup-'.$post_ID.'">View Popup</a>', 'PPS'), '#'),

		2 => __('Custom field updated.', 'PPS'),
		3 => __('Custom field deleted.', 'PPS'),
		4 => __('Popup updated.', 'PPS'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Popup restored to revision from %s', 'PPS'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Popup published. <a href="%s">View Popup</a>', 'PPS'), esc_url( get_permalink($post_ID) )),
		7 => __('Popup saved.', 'PPS'),
		8 => sprintf( __('Popup submitted. <a target="_blank" href="%s">Preview Popup</a>', 'PPS'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Popup scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Popup</a>', 'PPS'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Popup draft updated. <a target="_blank" href="%s">Preview Popup</a>', 'PPS'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
	return $messages;
}

/* --------------------------------------------------------------------
   Columnas para el Tipo de Post "PopupPress"
-------------------------------------------------------------------- */
add_filter("manage_edit-popuppress_columns", "popuppress_columns_PPS");

function popuppress_columns_PPS($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Títle",
		"shortcode" => "Shortcode",
		"preview-popup" => "Preview",
		"date" => 'Date',
	);
	return $columns;
}

/* --------------------------------------------------------------------
   Contenido de las Columnas para Popups
-------------------------------------------------------------------- */
add_action('manage_popuppress_posts_custom_column','popuppress_custom_columns_PPS', 10 , 2);

function popuppress_custom_columns_PPS($column, $post_id){
	//global $post;
	$values = get_post_custom($post_id);
	$popup = do_shortcode('[popuppress id="'.$post_id.'"]');

	switch ($column) {
		case 'shortcode':
			echo '<p style="margin: 2px 0 0; font-size:13px;">[popuppress id="'.$post_id.'"]</p>';
			break;

		case 'preview-popup':
			echo $popup;
			echo get_popup_PPS($post_id);
			break;
	}
}


/* --------------------------------------------------------------------
   Código Corto que Muestra el Popup
-------------------------------------------------------------------- */
add_shortcode('popuppress', 'shortcode_popuppress');

add_filter('widget_text', 'do_shortcode', 11);
function shortcode_popuppress( $atts = '', $content = null) {

	global $wpdb, $post;
	extract( shortcode_atts( array(
		'id' => 0,
	), $atts ) );

	if(disable_popup_PPS($id))
		return;


	$popuppress = get_post($id);
	//Si $id está vacía o es cero
	if(empty($id) || $popuppress->post_type != 'popuppress')
		return;


	$popup_id = $id;
	$button_popup = get_button_popup_PPS($popup_id);
	$scripts_popup = get_script_popup_PPS($popup_id);

	$respuesta = $button_popup.$scripts_popup;

	//Si el Shortcode se llama fuera de un Post o Página
	//if( !in_the_loop() ){
		$main_popup = get_popup_PPS($popup_id);
		$respuesta .= $main_popup;
	//}

	return $respuesta;
}

/* --------------------------------------------------------------------
   Desactiva el Popup
-------------------------------------------------------------------- */

function disable_popup_PPS($popup_id){
	$disable = false;
	$options = get_option('pps_options');
	$values = get_post_custom($popup_id);

	//Desactiva el Popup en Dispositivos Moviles
	$mobile_detect = new Mobile_Detect;
	if ($options['prevent_mobile'] == 'true') {
		if ( $mobile_detect->isMobile() || $mobile_detect->isTablet() )
			$disable = true;
	}

	//Desactiva el Popup para usuarios registrados
	$disable_logged_user = isset($values['pps_disable_logged_user'][0]) ? $values['pps_disable_logged_user'][0] : 'false';
	if($disable_logged_user == 'true' && is_user_logged_in() )
		$disable = true;

	return $disable;
}

/* --------------------------------------------------------------------
   Inserta Automáticamente un Popup al Sitio
-------------------------------------------------------------------- */

add_action( 'wp_footer', 'auto_insert_popup_PPS' );
function auto_insert_popup_PPS(){

	global $wp_query;
	$args = array(
		'post_type' 	=> 'popuppress',
		'posts_per_page' => -1, /* Get all popups */
		'meta_query' => array(
			array(
			   'key' => 'pps_open_in',
			   'value' => 'pages',
			   'compare' => '!=',
			)
		)
	);
	$query_pps = new WP_Query( $args );
	if($query_pps->have_posts()):
		while($query_pps->have_posts()) : $query_pps->the_post();
			$popup_id = get_the_ID();
			$button_popup = get_button_popup_PPS($popup_id);
			$scripts_popup = get_script_popup_PPS($popup_id);
			$main_popup = get_popup_PPS($popup_id);
			$values = get_post_custom($popup_id);
			$open_in = $values['pps_open_in'][0];
			$show_popup = false;

			switch($open_in){
				case 'home': //$open_in == 'home' && $_SERVER["REQUEST_URI"] == '/' || is_front_page()
					if( (is_home() && is_front_page())|| (is_front_page() && is_page(get_option( 'page_on_front'))) || $_SERVER["REQUEST_URI"] == '/' )
						$show_popup = true;
					break;
			}

			if($show_popup && !disable_popup_PPS($popup_id))
				echo $button_popup.$scripts_popup.$main_popup;

		endwhile;
	endif;
	wp_reset_postdata();
}

/* --------------------------------------------------------------------
   Generamos el Cuerpo del Popup
-------------------------------------------------------------------- */
function get_popup_PPS($popup_id = 0){

	$popuppress = get_post($popup_id);

	if(empty($popup_id) || $popuppress->post_type != 'popuppress')
		return '';

	// Cuerpo del Popup
	$values = get_post_custom($popup_id);
	$popup = '';
	$popup .= '<div id="popuppress-'.$popup_id.'" class="pps-popup pps-'.$values['pps_popup_style'][0].' pps-border-'.$values['pps_transparent_border'][0].'">';
		$popup .= '<div class="pps-wrap">';
			$close_x = '<div class="pps-close"><a href="#" class="pps-close-link-'.$popup_id.' pps-close-link" id="pps-close-link-'.$popup_id.'"></a></div>';
			if(isset($values['pps_show_close'][0]) and $values['pps_show_close'][0] == 'false')
				$close_x = '';

				$popup .= $close_x;
			if($values['pps_show_title'][0] == 'true')
				$popup .= '<div class="pps-header"><h3 class="pps-title">'.get_the_title($popup_id).'</h3></div>';

			$popup .= '<div class="pps-content">'.get_content_popup_PPS($popup_id).'</div>';
		$popup .= '</div><!--.pps-wrap-->';
	$popup .= '</div><!--.pps-popup-->';

	return $popup;
}



/* --------------------------------------------------------------------
   Función que Genera el Botón del Popup
-------------------------------------------------------------------- */
function get_button_popup_PPS($popup_id = 0){
	$values = get_post_custom($popup_id);
	$button_type = $values['pps_button_type'][0];
	$button_popup = '';

	switch($button_type){
		case 'button':
			$button_popup = '<a href="#" class="pps-btn pps-button-popup-'.$popup_id.' '.$values['pps_button_class'][0].'" title="'.$values['pps_button_title'][0].'">'.$values['pps_button_text'][0].'</a>';
			break;

		case 'plain-text':
			$button_popup = '<a href="#" class="pps-button-popup-'.$popup_id.' '.$values['pps_button_class'][0].'"  title="'.$values['pps_button_title'][0].'">'.$values['pps_button_text'][0].'</a>';
			break;

		default:
			//nothing
	}
	return $button_popup;
}

/* --------------------------------------------------------------------
   Generamos los Scripts y Estilos del Popup
-------------------------------------------------------------------- */

function get_script_popup_PPS($popup_id = 0){
	$modules_popups = '';
	//Default Options
	$opt = get_option('pps_options');

	//Default Values
	$values = get_post_custom($popup_id);

	//Popup Options
	$border_radius = (int) $values['pps_border_radius'][0];
	$border_radius2 = ($border_radius > 0) ? $border_radius + 2 : 0;

	//Width, Height
	$width = $values['pps_width'][0];
	//$auto_width = isset($values['pps_auto_width'][0]) ? $values['pps_auto_width'][0] : 'false';
	$width_units = $values['pps_width_units'][0] ? $values['pps_width_units'][0] : 'px';
	$width_css = $width.$width_units;

	$height_css = 'auto';
	$height_units = $values['pps_height_units'][0] ? $values['pps_height_units'][0] : 'px';
	if($values['pps_auto_height'][0] == 'false' && $values['pps_height'][0] != '') {
		$height_css = $values['pps_height'][0].$height_units;
	}

	//Porcentaje Fix
	$left_css = ($width_units != 'px') ? 'left: ' . (int)(100 - $width)/2 .'% !important; ' : '';
	$top_css = ($height_units != 'px') ? 'top: ' . (int)(100 - $values['pps_height'][0])/2 .'% !important; position: fixed !important; ' : '';


	$position_x = ( !is_numeric($values['pps_position_x'][0]) ) ? '"auto"' : $values['pps_position_x'][0];
	$position_y = ( !is_numeric($values['pps_position_y'][0]) ) ? '"auto"' : $values['pps_position_y'][0];

	$auto_open = $values['pps_auto_open'][0];

	$auto_open_delay = (int) $values['pps_delay'][0];

	$open_delay = isset($values['pps_open_delay'][0]) ? (int) $values['pps_open_delay'][0] : 0;
	
	$popup_easing = isset($values["pps_popup_easing"][0]) ? $values["pps_popup_easing"][0] : '';

	$bPopup = '
			jQuery("#popuppress-'.$popup_id.'").bPopup({
				closeClass: "pps-close-link-'.$popup_id.'",
				easing: "'.$popup_easing.'",
				modalClose: '.$values["pps_close_overlay"][0].',
				modalColor: "'.$values['pps_bg_overlay'][0].'",
				opacity: '.$values["pps_opacity"][0].',
				positionStyle: "'.$values["pps_position_type"][0].'",
				position: ['.$position_x.','.$position_y.'],
				speed: '.(int) $values['pps_speed'][0].',
				transition: "'.$values["pps_popup_transition"][0].'",
				zIndex: '.$values["pps_zindex"][0].',
				amsl : 0,
				onOpen: function(){
					onOpenPopupPress('.$popup_id.');
					restoreVideosPopupPress('.$popup_id.');
				},
				onClose: function(){
					pauseVideosPopupPress('.$popup_id.');
				},
			});
			';
	$function_popup = $bPopup;

	$style_popup = '
	<style type="text/css">
		#popuppress-'.$popup_id.' {
			width: '.$width_css.';
			height: '.$height_css.'
		}
		#popuppress-'.$popup_id.'.pps-border-true {
			-webkit-border-radius: '.$border_radius2.'px;
			-moz-border-radius: '.$border_radius2.'px;
			border-radius: '.$border_radius2.'px;
		}
		#popuppress-'.$popup_id.' .pps-wrap {
			-webkit-border-radius: '.$border_radius.'px;
			-moz-border-radius: '.$border_radius.'px;
			border-radius: '.$border_radius.'px;
		}

		@media screen and (min-width: 768px){
			#popuppress-'.$popup_id.' {
				'.$left_css.';
				'.$top_css.';
			}
			#popuppress-'.$popup_id.' iframe {
				width: '.$opt['embed_width'].'px !important;
				height: '.$opt['embed_height'].'px !important;
			}
		}
	</style>';
	$script_popup = '
<script type="text/javascript">
jQuery(document).ready(function($){
	';
	$script_popup .= '
	jQuery(document).delegate(".pps-button-popup-'.$popup_id.', a[href=pps-button-popup-'.$popup_id.']", "click", function(e) {
		e.preventDefault();
		setTimeout(function(){'.$function_popup.'}, '.$open_delay.');';
	$script_popup .= '});';
	
	if( $auto_open == 'true' && !strstr($_SERVER['REQUEST_URI'],'/edit.php?post_type=popuppress')   ){
		$script_popup .= '
		setTimeout( function(){
			'.$function_popup.'
		}, '.$auto_open_delay.');';
	}

	$script_popup .= '
});
</script>';

	$modules_popups .= $style_popup.$script_popup;

	return $modules_popups;

}

/* --------------------------------------------------------------------
   Generamos el Contenido del Popup
-------------------------------------------------------------------- */
function get_content_popup_PPS($popup_id = 0){
	$values = get_post_custom($popup_id);
	$opt = get_option('pps_options');

	//$popup = get_post($popup_id);
	//$content_popup = $popup->post_content;
	//$content_editor = apply_filters('the_content', $content_popup);//Formatea correctamente el contenido
	//$content_editor = wpautop($content_popup);//Formatea el contenido, pero desactiva los shortcodes :/

	//Obtenemos el Contenido del Editor
	$query_pps = new WP_Query( array('post_type' => 'popuppress', 'p'=> $popup_id) );
	if($query_pps->have_posts()):
		while($query_pps->have_posts()) : $query_pps->the_post();
			ob_start();
			the_content();
			$content_editor  = ob_get_contents();
			ob_end_clean();
		endwhile;
	endif;
	wp_reset_postdata();

	$content_pps = '<div class="pps-content-wp-editor">';

	// Contenido de "Editor Wordpress"
	if(!empty($content_editor)){
		$content_pps .= $content_editor;
	}

	$content_popup = $content_pps.'</div>';

	return $content_popup;
}

/* --------------------------------------------------------------------
   Función que Actualiza el Número de Vistas de un Popup
-------------------------------------------------------------------- */

add_action('wp_ajax_update_views_popups', 'update_views_PPS');
add_action('wp_ajax_nopriv_update_views_popups', 'update_views_PPS');
function update_views_PPS(){
	$popup_id = $_POST['id'];
	$plugin = $_POST['plugin'];
	$restore = $_POST['restore'];
	// Seguridad
	if(empty($popup_id) || $plugin != 'popuppress')
		return;

	//Si la accion es para restaurar valores
	if($restore == 'yes'){
		$views_count = 0;
		update_post_meta($popup_id, 'pps-views', 0);
	}
	else {
		//Sumamos una 'vista' al Popup
		$views_count = (int) get_post_meta($popup_id, 'pps-views', true);
		update_post_meta($popup_id, 'pps-views', ++$views_count);
	}

	$result = array(
		'success' => true,
		'views' => $views_count,
	);
	echo json_encode($result);
	exit;
}

?>