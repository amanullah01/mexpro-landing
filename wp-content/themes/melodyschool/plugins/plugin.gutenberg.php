<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_gutenberg_theme_setup')) {
    add_action( 'melodyschool_action_before_init_theme', 'melodyschool_gutenberg_theme_setup', 1 );
    function melodyschool_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'melodyschool_filter_required_plugins', 'melodyschool_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'melodyschool_exists_gutenberg' ) ) {
    function melodyschool_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_gutenberg_required_plugins' ) ) {
    //Handler of add_filter('melodyschool_filter_required_plugins',    'melodyschool_gutenberg_required_plugins');
    function melodyschool_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)melodyschool_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'melodyschool'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}