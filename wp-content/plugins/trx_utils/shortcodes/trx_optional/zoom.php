<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('melodyschool_sc_zoom_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_sc_zoom_theme_setup' );
	function melodyschool_sc_zoom_theme_setup() {
		add_action('melodyschool_action_shortcodes_list', 		'melodyschool_sc_zoom_reg_shortcodes');
		if (function_exists('melodyschool_exists_visual_composer') && melodyschool_exists_visual_composer())
			add_action('melodyschool_action_shortcodes_list_vc','melodyschool_sc_zoom_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_zoom id="unique_id" border="none|light|dark"]
*/

if (!function_exists('melodyschool_sc_zoom')) {	
	function melodyschool_sc_zoom($atts, $content=null){	
		if (melodyschool_in_shortcode_blogger()) return '';
		extract(melodyschool_html_decode(shortcode_atts(array(
			// Individual params
			"effect" => "zoom",
			"src" => "",
			"url" => "",
			"over" => "",
			"align" => "",
			"bg_image" => "",
			"bg_top" => '',
			"bg_bottom" => '',
			"bg_left" => '',
			"bg_right" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		wp_enqueue_script( 'melodyschool-elevate-zoom-script', melodyschool_get_file_url('js/jquery.elevateZoom.js'), array(), null, true );
	
		$class .= ($class ? ' ' : '') . melodyschool_get_css_position_as_classes($top, $right, $bottom, $left);
		$css_dim = melodyschool_get_css_dimensions_from_values($width, $height);
		$css_bg = melodyschool_get_css_paddings_from_values($bg_top, $bg_right, $bg_bottom, $bg_left);
		$width  = melodyschool_prepare_css_value($width);
		$height = melodyschool_prepare_css_value($height);
		if (empty($id)) $id = 'sc_zoom_'.str_replace('.', '', mt_rand());
		$src = $src!='' ? $src : $url;
		if ($src > 0) {
			$attach = wp_get_attachment_image_src( $src, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$src = $attach[0];
		}
		if ($over > 0) {
			$attach = wp_get_attachment_image_src( $over, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$over = $attach[0];
		}
		if ($effect=='lens' && ((int) $width > 0 && melodyschool_substr($width, -2, 2)=='px') || ((int) $height > 0 && melodyschool_substr($height, -2, 2)=='px')) {
			if ($src)
				$src = melodyschool_get_resized_image_url($src, (int) $width > 0 && melodyschool_substr($width, -2, 2)=='px' ? (int) $width : null, (int) $height > 0 && melodyschool_substr($height, -2, 2)=='px' ? (int) $height : null);
			if ($over)
				$over = melodyschool_get_resized_image_url($over, (int) $width > 0 && melodyschool_substr($width, -2, 2)=='px' ? (int) $width : null, (int) $height > 0 && melodyschool_substr($height, -2, 2)=='px' ? (int) $height : null);
		}
		if ($bg_image > 0) {
			$attach = wp_get_attachment_image_src( $bg_image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$bg_image = $attach[0];
		}
		if ($bg_image) {
			$css_bg .= $css . 'background-image: url('.esc_url($bg_image).');';
			$css = $css_dim;
		} else {
			$css .= $css_dim;
		}
		$output = empty($src) 
				? '' 
				: (
					(!empty($bg_image) 
						? '<div class="sc_zoom_wrap'
								. (!empty($class) ? ' '.esc_attr($class) : '')
								. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
								. '"'
							. (!melodyschool_param_is_off($animation) ? ' data-animation="'.esc_attr(melodyschool_get_animation_classes($animation)).'"' : '')
							. ($css_bg!='' ? ' style="'.esc_attr($css_bg).'"' : '') 
							. '>' 
						: '')
					.'<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_zoom' 
								. (empty($bg_image) && !empty($class) ? ' '.esc_attr($class) : '') 
								. (empty($bg_image) && $align && $align!='none' ? ' align'.esc_attr($align) : '')
								. '"'
							. (empty($bg_image) && !melodyschool_param_is_off($animation) ? ' data-animation="'.esc_attr(melodyschool_get_animation_classes($animation)).'"' : '')
							. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
							. '>'
							. '<img src="'.esc_url($src).'"' . ($css_dim!='' ? ' style="'.esc_attr($css_dim).'"' : '') . ' data-zoom-image="'.esc_url($over).'" alt="" />'
					. '</div>'
					. (!empty($bg_image) 
						? '</div>' 
						: '')
				);
		return apply_filters('melodyschool_shortcode_output', $output, 'trx_zoom', $atts, $content);
	}
	add_shortcode('trx_zoom', 'melodyschool_sc_zoom');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'melodyschool_sc_zoom_reg_shortcodes' ) ) {
	//add_action('melodyschool_action_shortcodes_list', 'melodyschool_sc_zoom_reg_shortcodes');
	function melodyschool_sc_zoom_reg_shortcodes() {
	
		melodyschool_sc_map("trx_zoom", array(
			"title" => esc_html__("Zoom", 'trx_utils'),
			"desc" => wp_kses_data( __("Insert the image with zoom/lens effect", 'trx_utils') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"effect" => array(
					"title" => esc_html__("Effect", 'trx_utils'),
					"desc" => wp_kses_data( __("Select effect to display overlapping image", 'trx_utils') ),
					"value" => "lens",
					"size" => "medium",
					"type" => "switch",
					"options" => array(
						"lens" => esc_html__('Lens', 'trx_utils'),
						"zoom" => esc_html__('Zoom', 'trx_utils')
					)
				),
				"url" => array(
					"title" => esc_html__("Main image", 'trx_utils'),
					"desc" => wp_kses_data( __("Select or upload main image", 'trx_utils') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"over" => array(
					"title" => esc_html__("Overlaping image", 'trx_utils'),
					"desc" => wp_kses_data( __("Select or upload overlaping image", 'trx_utils') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"align" => array(
					"title" => esc_html__("Float zoom", 'trx_utils'),
					"desc" => wp_kses_data( __("Float zoom to left or right side", 'trx_utils') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => melodyschool_get_sc_param('float')
				), 
				"bg_image" => array(
					"title" => esc_html__("Background image", 'trx_utils'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site for zoom block background. Attention! If you use background image - specify paddings below from background margins to zoom block in percents!", 'trx_utils') ),
					"divider" => true,
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"bg_top" => array(
					"title" => esc_html__("Top offset", 'trx_utils'),
					"desc" => wp_kses_data( __("Top offset (padding) inside background image to zoom block (in percent). For example: 3%", 'trx_utils') ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"bg_bottom" => array(
					"title" => esc_html__("Bottom offset", 'trx_utils'),
					"desc" => wp_kses_data( __("Bottom offset (padding) inside background image to zoom block (in percent). For example: 3%", 'trx_utils') ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"bg_left" => array(
					"title" => esc_html__("Left offset", 'trx_utils'),
					"desc" => wp_kses_data( __("Left offset (padding) inside background image to zoom block (in percent). For example: 20%", 'trx_utils') ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"bg_right" => array(
					"title" => esc_html__("Right offset", 'trx_utils'),
					"desc" => wp_kses_data( __("Right offset (padding) inside background image to zoom block (in percent). For example: 12%", 'trx_utils') ),
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"width" => melodyschool_shortcodes_width(),
				"height" => melodyschool_shortcodes_height(),
				"top" => melodyschool_get_sc_param('top'),
				"bottom" => melodyschool_get_sc_param('bottom'),
				"left" => melodyschool_get_sc_param('left'),
				"right" => melodyschool_get_sc_param('right'),
				"id" => melodyschool_get_sc_param('id'),
				"class" => melodyschool_get_sc_param('class'),
				"animation" => melodyschool_get_sc_param('animation'),
				"css" => melodyschool_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'melodyschool_sc_zoom_reg_shortcodes_vc' ) ) {
	//add_action('melodyschool_action_shortcodes_list_vc', 'melodyschool_sc_zoom_reg_shortcodes_vc');
	function melodyschool_sc_zoom_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_zoom",
			"name" => esc_html__("Zoom", 'trx_utils'),
			"description" => wp_kses_data( __("Insert the image with zoom/lens effect", 'trx_utils') ),
			"category" => esc_html__('Content', 'trx_utils'),
			'icon' => 'icon_trx_zoom',
			"class" => "trx_sc_single trx_sc_zoom",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "effect",
					"heading" => esc_html__("Effect", 'trx_utils'),
					"description" => wp_kses_data( __("Select effect to display overlapping image", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"std" => "zoom",
					"value" => array(
						esc_html__('Lens', 'trx_utils') => 'lens',
						esc_html__('Zoom', 'trx_utils') => 'zoom'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Main image", 'trx_utils'),
					"description" => wp_kses_data( __("Select or upload main image", 'trx_utils') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "over",
					"heading" => esc_html__("Overlaping image", 'trx_utils'),
					"description" => wp_kses_data( __("Select or upload overlaping image", 'trx_utils') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'trx_utils'),
					"description" => wp_kses_data( __("Float zoom to left or right side", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(melodyschool_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "bg_image",
					"heading" => esc_html__("Background image", 'trx_utils'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for zoom background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", 'trx_utils') ),
					"group" => esc_html__('Background', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "bg_top",
					"heading" => esc_html__("Top offset", 'trx_utils'),
					"description" => wp_kses_data( __("Top offset (padding) from background image to zoom block (in percent). For example: 3%", 'trx_utils') ),
					"group" => esc_html__('Background', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_bottom",
					"heading" => esc_html__("Bottom offset", 'trx_utils'),
					"description" => wp_kses_data( __("Bottom offset (padding) from background image to zoom block (in percent). For example: 3%", 'trx_utils') ),
					"group" => esc_html__('Background', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_left",
					"heading" => esc_html__("Left offset", 'trx_utils'),
					"description" => wp_kses_data( __("Left offset (padding) from background image to zoom block (in percent). For example: 20%", 'trx_utils') ),
					"group" => esc_html__('Background', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_right",
					"heading" => esc_html__("Right offset", 'trx_utils'),
					"description" => wp_kses_data( __("Right offset (padding) from background image to zoom block (in percent). For example: 12%", 'trx_utils') ),
					"group" => esc_html__('Background', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				melodyschool_get_vc_param('id'),
				melodyschool_get_vc_param('class'),
				melodyschool_get_vc_param('animation'),
				melodyschool_get_vc_param('css'),
				melodyschool_vc_width(),
				melodyschool_vc_height(),
				melodyschool_get_vc_param('margin_top'),
				melodyschool_get_vc_param('margin_bottom'),
				melodyschool_get_vc_param('margin_left'),
				melodyschool_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Zoom extends MELODYSCHOOL_VC_ShortCodeSingle {}
	}
}
?>