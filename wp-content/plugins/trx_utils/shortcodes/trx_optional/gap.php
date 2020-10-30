<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('melodyschool_sc_gap_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_sc_gap_theme_setup' );
	function melodyschool_sc_gap_theme_setup() {
		add_action('melodyschool_action_shortcodes_list', 		'melodyschool_sc_gap_reg_shortcodes');
		if (function_exists('melodyschool_exists_visual_composer') && melodyschool_exists_visual_composer())
			add_action('melodyschool_action_shortcodes_list_vc','melodyschool_sc_gap_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_gap]Fullwidth content[/trx_gap]

if (!function_exists('melodyschool_sc_gap')) {	
	function melodyschool_sc_gap($atts, $content = null) {
		if (melodyschool_in_shortcode_blogger()) return '';
		$output = melodyschool_gap_start() . do_shortcode($content) . melodyschool_gap_end();
		return apply_filters('melodyschool_shortcode_output', $output, 'trx_gap', $atts, $content);
	}
	add_shortcode("trx_gap", "melodyschool_sc_gap");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'melodyschool_sc_gap_reg_shortcodes' ) ) {
	//add_action('melodyschool_action_shortcodes_list', 'melodyschool_sc_gap_reg_shortcodes');
	function melodyschool_sc_gap_reg_shortcodes() {
	
		melodyschool_sc_map("trx_gap", array(
			"title" => esc_html__("Gap", 'trx_utils'),
			"desc" => wp_kses_data( __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", 'trx_utils') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Gap content", 'trx_utils'),
					"desc" => wp_kses_data( __("Gap inner content", 'trx_utils') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'melodyschool_sc_gap_reg_shortcodes_vc' ) ) {
	//add_action('melodyschool_action_shortcodes_list_vc', 'melodyschool_sc_gap_reg_shortcodes_vc');
	function melodyschool_sc_gap_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_gap",
			"name" => esc_html__("Gap", 'trx_utils'),
			"description" => wp_kses_data( __("Insert gap (fullwidth area) in the post content", 'trx_utils') ),
			"category" => esc_html__('Structure', 'trx_utils'),
			'icon' => 'icon_trx_gap',
			"class" => "trx_sc_collection trx_sc_gap",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"params" => array(
			)
		) );
		
		class WPBakeryShortCode_Trx_Gap extends MELODYSCHOOL_VC_ShortCodeCollection {}
	}
}
?>