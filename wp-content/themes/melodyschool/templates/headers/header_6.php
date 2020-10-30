<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'melodyschool_template_header_6_theme_setup' ) ) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_template_header_6_theme_setup', 1 );
	function melodyschool_template_header_6_theme_setup() {
		melodyschool_add_template(array(
			'layout' => 'header_6',
			'mode'   => 'header',
			'title'  => esc_html__('Header 6', 'melodyschool'),
			'icon'   => melodyschool_get_file_url('templates/headers/images/6.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'melodyschool_template_header_6_output' ) ) {
	function melodyschool_template_header_6_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_6 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_6 top_panel_position_<?php echo esc_attr(melodyschool_get_custom_option('top_panel_position')); ?>">

			<div class="top_panel_middle" <?php melodyschool_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="contact_logo">
						<?php melodyschool_show_logo(true, true); ?>
					</div>
					<div class="menu_main_wrap">
						<nav class="menu_main_nav_area">
							<?php
							$menu_main = melodyschool_get_nav_menu('menu_main');
							if (empty($menu_main)) $menu_main = melodyschool_get_nav_menu();
							melodyschool_show_layout($menu_main);
							?>
						</nav>
						<?php
						if (function_exists('melodyschool_exists_woocommerce') && melodyschool_exists_woocommerce() && (melodyschool_is_woocommerce_page() && melodyschool_get_custom_option('show_cart')=='shop' || melodyschool_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) { 
							?>
							<div class="menu_main_cart top_panel_icon">
								<?php do_action('trx_utils_show_contact_info_cart'); ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>

			</div>
		</header>

		<?php
		melodyschool_storage_set('header_mobile', array(
				 'open_hours' => false,
				 'login' => false,
				 'socials' => false,
				 'bookmarks' => false,
				 'contact_address' => false,
				 'contact_phone_email' => false,
				 'woo_cart' => false,
				 'search' => false
			)
		);
	}
}
?>