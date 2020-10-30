<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_essgrids_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_essgrids_theme_setup', 1 );
	function melodyschool_essgrids_theme_setup() {
		// Register shortcode in the shortcodes list
		if (is_admin()) {
			add_filter( 'melodyschool_filter_required_plugins',				'melodyschool_essgrids_required_plugins' );
		}
	}
}


// Check if Ess. Grid installed and activated
if ( !function_exists( 'melodyschool_exists_essgrids' ) ) {
	function melodyschool_exists_essgrids() {
		return defined('EG_PLUGIN_PATH');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_essgrids_required_plugins' ) ) {
	//Handler of add_filter('melodyschool_filter_required_plugins',	'melodyschool_essgrids_required_plugins');
	function melodyschool_essgrids_required_plugins($list=array()) {
		if (in_array('essgrids', melodyschool_storage_get('required_plugins'))) {
			$path = melodyschool_get_file_dir('plugins/install/essential-grid.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Essential Grid', 'melodyschool'),
					'slug' 		=> 'essential-grid',
					'version'   => '3.0.7',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}
?>