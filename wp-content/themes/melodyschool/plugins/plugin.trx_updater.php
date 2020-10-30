<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('melodyschool_trx_updater_theme_setup')) {
    add_action( 'melodyschool_action_before_init_theme', 'melodyschool_trx_updater_theme_setup', 1 );
    function melodyschool_trx_updater_theme_setup() {
        if (is_admin()) {
            add_filter( 'melodyschool_filter_required_plugins',		'melodyschool_trx_updater_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_trx_updater_required_plugins' ) ) {
    function melodyschool_trx_updater_required_plugins($list=array()) {
        if (in_array('trx_updater', (array)melodyschool_storage_get('required_plugins'))) {
            $list[] = array(
                'name' 		=> esc_html__('Themerex Updater', 'melodyschool'),
                'slug' 		=> 'trx_updater',
                'version'   => '1.4.1',
                'source'	=> melodyschool_get_file_dir('plugins/install/trx_updater.zip'),
                'required' 	=> false
            );
        }
        return $list;
    }
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'melodyschool_exists_trx_updater' ) ) {
    function melodyschool_exists_trx_updater() {
        return defined('TRX_UPDATER_VERSION');
    }
}