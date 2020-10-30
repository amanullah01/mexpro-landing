<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_vc_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_vc_theme_setup', 1 );
	function melodyschool_vc_theme_setup() {
		if (melodyschool_exists_visual_composer()) {
			add_action('melodyschool_action_add_styles',		 				'melodyschool_vc_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'melodyschool_filter_required_plugins',					'melodyschool_vc_required_plugins' );
		}
	}
}

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'melodyschool_exists_visual_composer' ) ) {
	function melodyschool_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'melodyschool_vc_is_frontend' ) ) {
	function melodyschool_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_vc_required_plugins' ) ) {
	//Handler of add_filter('melodyschool_filter_required_plugins',	'melodyschool_vc_required_plugins');
	function melodyschool_vc_required_plugins($list=array()) {
		if (in_array('visual_composer', melodyschool_storage_get('required_plugins'))) {
			$path = melodyschool_get_file_dir('plugins/install/js_composer.zip');
			if (file_exists($path)) {
				$list[] = array(
                    'name' 		=> esc_html__('WPBakery PageBuilder', 'melodyschool'),
					'slug' 		=> 'js_composer',
                    'version'   => '6.4.1',
					'source'	=> $path,
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Enqueue VC custom styles
if ( !function_exists( 'melodyschool_vc_frontend_scripts' ) ) {
	//Handler of add_action( 'melodyschool_action_add_styles', 'melodyschool_vc_frontend_scripts' );
	function melodyschool_vc_frontend_scripts() {
		if (file_exists(melodyschool_get_file_dir('css/plugin.visual-composer.css')))
			wp_enqueue_style( 'melodyschool-plugin-visual-composer-style',  melodyschool_get_file_url('css/plugin.visual-composer.css'), array(), null );
	}
}
?>