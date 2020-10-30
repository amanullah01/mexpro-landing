<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_contact_form_7_theme_setup')) {
    add_action( 'melodyschool_action_before_init_theme', 'melodyschool_contact_form_7_theme_setup', 1 );
    function melodyschool_contact_form_7_theme_setup() {
        if (is_admin()) {
            add_filter( 'melodyschool_filter_required_plugins', 'melodyschool_contact_form_7_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'melodyschool_exists_contact_form_7' ) ) {
    function melodyschool_exists_contact_form_7() {
        return defined( 'Contact Form 7' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_contact_form_7_required_plugins' ) ) {
    function melodyschool_contact_form_7_required_plugins($list=array()) {
        if (in_array('contact_form_7', (array)melodyschool_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Contact Form 7', 'melodyschool'),
                'slug'         => 'contact-form-7',
                'required'     => false
            );
        return $list;
    }
}
