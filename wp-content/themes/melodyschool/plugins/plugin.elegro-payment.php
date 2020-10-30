<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('melodyschool_elegro_payment_theme_setup')) {
    add_action( 'melodyschool_action_before_init_theme', 'melodyschool_elegro_payment_theme_setup', 1 );
    function melodyschool_elegro_payment_theme_setup() {
        if (is_admin()) {
            add_filter( 'melodyschool_filter_required_plugins',		'melodyschool_elegro_payment_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_elegro_payment_required_plugins' ) ) {
    function melodyschool_elegro_payment_required_plugins($list=array()) {
        if (in_array('elegro-payment', (array)melodyschool_storage_get('required_plugins'))) {
            $list[] = array(
                'name' 		=> esc_html__('Elegro Payment', 'melodyschool'),
                'slug' 		=> 'elegro-payment',
                'required' 	=> false
            );
        }
        return $list;
    }
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'melodyschool_exists_elegro_payment' ) ) {
    function melodyschool_exists_elegro_payment() {
        return function_exists('init_Elegro_Payment');
    }
}