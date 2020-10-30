<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('melodyschool_sc_reviews_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_sc_reviews_theme_setup' );
	function melodyschool_sc_reviews_theme_setup() {
		add_action('melodyschool_action_shortcodes_list', 		'melodyschool_sc_reviews_reg_shortcodes');
		if (function_exists('melodyschool_exists_visual_composer') && melodyschool_exists_visual_composer())
			add_action('melodyschool_action_shortcodes_list_vc','melodyschool_sc_reviews_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_reviews]
*/

if (!function_exists('melodyschool_sc_reviews')) {	
	function melodyschool_sc_reviews($atts, $content = null) {
		if (melodyschool_in_shortcode_blogger()) return '';
		extract(melodyschool_html_decode(shortcode_atts(array(
			// Individual params
			"align" => "right",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . melodyschool_get_css_position_as_classes($top, $right, $bottom, $left);
		$output = melodyschool_param_is_off(melodyschool_get_custom_option('show_sidebar_main'))
			? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_reviews'
							. ($align && $align!='none' ? ' align'.esc_attr($align) : '')
							. ($class ? ' '.esc_attr($class) : '')
							. '"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
						. (!melodyschool_param_is_off($animation) ? ' data-animation="'.esc_attr(melodyschool_get_animation_classes($animation)).'"' : '')
						. '>'
					. trim(melodyschool_get_reviews_placeholder())
					. '</div>'
			: '';
		return apply_filters('melodyschool_shortcode_output', $output, 'trx_reviews', $atts, $content);
	}
	add_shortcode("trx_reviews", "melodyschool_sc_reviews");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'melodyschool_sc_reviews_reg_shortcodes' ) ) {
	//add_action('melodyschool_action_shortcodes_list', 'melodyschool_sc_reviews_reg_shortcodes');
	function melodyschool_sc_reviews_reg_shortcodes() {
	
		melodyschool_sc_map("trx_reviews", array(
			"title" => esc_html__("Reviews", 'trx_utils'),
			"desc" => wp_kses_data( __("Insert reviews block in the single post", 'trx_utils') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"align" => array(
					"title" => esc_html__("Alignment", 'trx_utils'),
					"desc" => wp_kses_data( __("Align counter to left, center or right", 'trx_utils') ),
					"divider" => true,
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => melodyschool_get_sc_param('align')
				), 
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
if ( !function_exists( 'melodyschool_sc_reviews_reg_shortcodes_vc' ) ) {
	//add_action('melodyschool_action_shortcodes_list_vc', 'melodyschool_sc_reviews_reg_shortcodes_vc');
	function melodyschool_sc_reviews_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_reviews",
			"name" => esc_html__("Reviews", 'trx_utils'),
			"description" => wp_kses_data( __("Insert reviews block in the single post", 'trx_utils') ),
			"category" => esc_html__('Content', 'trx_utils'),
			'icon' => 'icon_trx_reviews',
			"class" => "trx_sc_single trx_sc_reviews",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'trx_utils'),
					"description" => wp_kses_data( __("Align counter to left, center or right", 'trx_utils') ),
					"class" => "",
					"value" => array_flip(melodyschool_get_sc_param('align')),
					"type" => "dropdown"
				),
				melodyschool_get_vc_param('id'),
				melodyschool_get_vc_param('class'),
				melodyschool_get_vc_param('animation'),
				melodyschool_get_vc_param('css'),
				melodyschool_get_vc_param('margin_top'),
				melodyschool_get_vc_param('margin_bottom'),
				melodyschool_get_vc_param('margin_left'),
				melodyschool_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Reviews extends MELODYSCHOOL_VC_ShortCodeSingle {}
	}
}
?>