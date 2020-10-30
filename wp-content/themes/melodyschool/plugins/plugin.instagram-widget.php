<?php
/* Instagram Widget support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_instagram_widget_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_instagram_widget_theme_setup', 1 );
	function melodyschool_instagram_widget_theme_setup() {
		if (melodyschool_exists_instagram_widget()) {
			add_action( 'melodyschool_action_add_styles', 						'melodyschool_instagram_widget_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'melodyschool_filter_required_plugins',					'melodyschool_instagram_widget_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'melodyschool_exists_instagram_widget' ) ) {
	function melodyschool_exists_instagram_widget() {
		return function_exists('zoom_instagram_widget_register');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_instagram_widget_required_plugins' ) ) {
	//Handler of add_filter('melodyschool_filter_required_plugins',	'melodyschool_instagram_widget_required_plugins');
	function melodyschool_instagram_widget_required_plugins($list=array()) {
		if (in_array('instagram_widget', melodyschool_storage_get('required_plugins')))
			$list[] = array(
                    'name' 		=> esc_html__('Instagram Widget', 'melodyschool'),
					'slug' 		=> 'instagram-widget-by-wpzoom',
					'required' 	=> false
				);
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'melodyschool_instagram_widget_frontend_scripts' ) ) {
	//Handler of add_action( 'melodyschool_action_add_styles', 'melodyschool_instagram_widget_frontend_scripts' );
	function melodyschool_instagram_widget_frontend_scripts() {
		if (file_exists(melodyschool_get_file_dir('css/plugin.instagram-widget.css')))
			wp_enqueue_style( 'melodyschool-plugin-instagram-widget-style',  melodyschool_get_file_url('css/plugin.instagram-widget.css'), array(), null );
	}
}
?>