<?php
/* The GDPR Framework support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_gdpr_framework_theme_setup')) {
    add_action( 'melodyschool_action_before_init_theme', 'melodyschool_gdpr_framework_theme_setup', 1 );
    function melodyschool_gdpr_framework_theme_setup() {
        if (is_admin()) {
            add_filter( 'melodyschool_filter_required_plugins', 'melodyschool_gdpr_framework_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'melodyschool_exists_gdpr_framework' ) ) {
    function melodyschool_exists_gdpr_framework() {
        return defined( 'GDPR_FRAMEWORK_VERSION' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_gdpr_framework_required_plugins' ) ) {
    //Handler of add_filter('melodyschool_filter_required_plugins',    'melodyschool_gdpr_framework_required_plugins');
    function melodyschool_gdpr_framework_required_plugins($list=array()) {
        if (in_array('gdpr_framework', (array)melodyschool_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('The GDPR Framework', 'melodyschool'),
                'slug'         => 'gdpr-framework',
                'required'     => false
            );
        return $list;
    }
}