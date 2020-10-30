<?php
/**
 * MelodySchool Framework: Registered Users
 *
 * @package	melodyschool
 * @since	melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('melodyschool_users_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_users_theme_setup' );
	function melodyschool_users_theme_setup() {

		if ( !is_admin() ) {
            // Social Login support
            add_filter( 'trx_utils_filter_social_login', 'melodyschool_social_login');
        }

	}
}
// Return Social Login layout (if present)
if (!function_exists('melodyschool_social_login')) {
    function melodyschool_social_login($sc) {
        return melodyschool_get_theme_option('social_login');
    }
}

// Return (and show) user profiles links
if (!function_exists('melodyschool_show_user_socials')) {
	function melodyschool_show_user_socials($args) {
		$args = array_merge(array(
			'author_id' => 0,										// author's ID
			'allowed' => array(),									// list of allowed social
			'size' => 'small',										// icons size: tiny|small|big
			'shape' => 'square',									// icons shape: square|round
			'style' => melodyschool_get_theme_setting('socials_type')=='images' ? 'bg' : 'icons',	// style for show icons: icons|images|bg
			'echo' => true											// if true - show on page, else - only return as string
			), is_array($args) ? $args 
				: array('author_id' => $args));						// If send one number parameter - use it as author's ID
		$output = '';
		$upload_info = wp_upload_dir();
		$upload_url = $upload_info['baseurl'];
		$social_list = melodyschool_get_theme_option('social_icons');
		$list = array();
		if (is_array($social_list) && count($social_list) > 0) {
			foreach ($social_list as $soc) {
				if ($args['style'] == 'icons') {
					$parts = explode('-', $soc['icon'], 2);
					$sn = isset($parts[1]) ? $parts[1] : $soc['icon'];
				} else {
					$sn = basename($soc['icon']);
					$sn = melodyschool_substr($sn, 0, melodyschool_strrpos($sn, '.'));
					if (($pos=melodyschool_strrpos($sn, '_'))!==false)
						$sn = melodyschool_substr($sn, 0, $pos);
				}
				if (count($args['allowed'])==0 || in_array($sn, $args['allowed'])) {
					$link = get_the_author_meta('user_' . ($sn), $args['author_id']);
					if ($link) {
						$icon = $args['style']=='icons' || melodyschool_strpos($soc['icon'], $upload_url)!==false ? $soc['icon'] : melodyschool_get_socials_url(basename($soc['icon']));
						$list[] = array(
							'icon'	=> $icon,
							'url'	=> $link
						);
					}
				}
			}
		}
		if (count($list) > 0) {
			$output = '<div class="sc_socials sc_socials_size_'.esc_attr($args['size']).' sc_socials_shape_'.esc_attr($args['shape']).' sc_socials_type_' . esc_attr($args['style']) . '">' 
							. trim(melodyschool_prepare_socials($list, $args['style'])) 
						. '</div>';
			if ($args['echo']) melodyschool_show_layout($output);
		}
		return $output;
	}
}
?>