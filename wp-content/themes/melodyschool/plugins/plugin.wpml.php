<?php
/* WPML support functions
------------------------------------------------------------------------------- */

// Check if WPML installed and activated
if ( !function_exists( 'melodyschool_exists_wpml' ) ) {
	function melodyschool_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_wpml_required_plugins' ) ) {
	//Handler of add_filter('melodyschool_filter_required_plugins',	'melodyschool_wpml_required_plugins');
	function melodyschool_wpml_required_plugins($list=array()) {
		if (in_array('wpml', melodyschool_storage_get('required_plugins'))) {
			$path = melodyschool_get_file_dir('plugins/install/wpml.zip');
			if (file_exists($path)) {
				$list[] = array(
                    'name' 		=> esc_html__('WPML', 'melodyschool'),
					'slug' 		=> 'wpml',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}
?>