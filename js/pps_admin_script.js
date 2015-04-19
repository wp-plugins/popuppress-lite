jQuery(document).ready(function($){
	
	// Tabs del Panel de Opciones
	$(".pps-tab-content").hide(); //Hide all content
	$("#pps-tabs a:first").addClass("nav-tab-active").show(); //Activate first tab
	$(".pps-tab-content:first").show(); //Show first tab content
	
	$("#pps-tabs a").click(function() {
		$("#pps-tabs a").removeClass("nav-tab-active"); //Remove any "active" class
		$(this).addClass("nav-tab-active"); //Add "active" class to selected tab
		$(".pps-tab-content").removeClass("active").hide(); //Remove any "active" class and Hide all tab content
		var activeTab = $(this).attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn().addClass("active"); //Fade in the active content
		return false;
	});
	
	
	// Elimina elementos no deseados
	if($('.wp-list-table tr.type-popuppress').length){
		$('tr.type-popuppress').find('td .row-actions span.view').remove();
	}
	if($('.pps_metabox').length) {
		$('#edit-slug-box, #preview-action').remove();
	}
	
	
	/*// Oculta y Muestra Opciones Avanzadas del MetaBox
	$(".pps-toggle-fields").toggle(function (){
    	$(this).closest('.pps-row').nextAll().css('visibility', 'visible');
		$(this).text("Hide");
    }, function(){
    	$(this).closest('.pps-row').nextAll().css('visibility', 'collapse');
		$(this).text("Show");
	});*/
	
	// OCULTA/MUESTRA CAMPOS SEGÚN BUTTON TYPE
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type2', '.cpmb_id_pps_button_image');
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type2', '.cpmb_id_pps_img_width_button');
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type2', '.cpmb_id_pps_n_columns');
	hideFieldBox_pps('input#pps_button_type1, input#pps_button_type2, input#pps_button_type3', '.cpmb_id_pps_class_thumbnail');
	//hideFieldBox_pps('input#pps_button_type2', '.cpmb_id_pps_button_text');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_button_class');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_n_columns');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_button_text');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_button_title');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_button_class_run');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_button_image');
	hideFieldBox_pps('input#pps_button_type3', '.cpmb_id_pps_img_width_button');

	$('input#pps_button_type1, input#pps_button_type2').click(function() {
		$(this).closest('.cpmb-row').siblings().hide();
		$('.cpmb_id_pps_button_text, .cpmb_id_pps_button_title, .cpmb_id_pps_button_class, .cpmb_id_pps_button_class_run').fadeIn('slow');
	});
	
	$('input#pps_button_type3').click(function() {
		$(this).closest('.cpmb-row').siblings().hide();
	});

	// OCULTA/MUESTRA CAMPO "Open Delay"
	showHideFieldBox_pps('input#pps_auto_open1', '.cpmb_id_pps_delay');

	$('input[name="pps_auto_open"]').click(function() {
		showHideFieldBox_pps('input#pps_auto_open1', '.cpmb_id_pps_delay');
	});

	//Oculta los Metaboxes
	//$('#side-sortables > div[id*=_cpmb]').addClass('closed');

	// Activa ColorPicker en la Página de Opciones
	if(typeof jQuery.fn.wpColorPicker == 'function') {
		$('.pps-colorpicker').wpColorPicker();
	}

	// TOOLTIP
	$('p.cpmb_metabox_description sub').hover(
		function(){
			var title = $(this).parent().text();

			$(this).data('tipText', title);
			$('<div class="cpmb-tip-wrap"><div class="cpmb-tip-arrow"></div><div class="cpmb-tip-text"></div></div>').appendTo('body');
			$('.cpmb-tip-text').text(title).parent().fadeIn(500);
		},
		function() {
			$('.cpmb-tip-wrap').remove();
		}
	).mousemove(function(w) {
		var widthTip = $('.cpmb-tip-wrap').innerWidth();
        var mousex = w.pageX - widthTip - 15;
        var mousey = w.pageY - 3;
        $('.cpmb-tip-wrap').css({
			top: mousey,
			left: mousex
		});
	});

	function showHideFieldBox_pps(radioItem, box ){
		if( $(radioItem).is(':checked') )
			$(box).fadeIn();
		else
			$(box).fadeOut();
	}
	function hideFieldBox_pps(radioItem, box ){
		if( $(radioItem).is(':checked'))
			$(box).fadeOut();
		//else
			//$(box).fadeIn();
	}
	
});

