<?php
/**
 * MelodySchool Framework
 *
 * @package melodyschool
 * @since melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'MELODYSCHOOL_FW_DIR' ) )		define( 'MELODYSCHOOL_FW_DIR',		'fw' );
if ( ! defined( 'MELODYSCHOOL_THEME_PATH' ) )	define( 'MELODYSCHOOL_THEME_PATH',	trailingslashit( get_template_directory() ) );
if ( ! defined( 'MELODYSCHOOL_FW_PATH' ) )		define( 'MELODYSCHOOL_FW_PATH',		MELODYSCHOOL_THEME_PATH . MELODYSCHOOL_FW_DIR . '/' );

// Include theme variables storage
require_once MELODYSCHOOL_FW_PATH . 'core/core.storage.php';

// Theme variables storage
melodyschool_storage_set('options_prefix', 'melodyschool');	// Prefix for the theme options in the postmeta and wp options
melodyschool_storage_set('page_template', '');			// Storage for current page template name (used in the inheritance system)
melodyschool_storage_set('widgets_args', array(			// Arguments to register widgets
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget_title">',
		'after_title'   => '</h5>',
	)
);
melodyschool_storage_set('tag_open', 'script');
melodyschool_storage_set('tag_close', '/script');
/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'melodyschool_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'melodyschool_loader_theme_setup', 20 );
	function melodyschool_loader_theme_setup() {

		// Before init theme
		do_action('melodyschool_action_before_init_theme');

		// Load current values for main theme options
		melodyschool_load_main_options();

		// Theme core init - only for admin side. In frontend it called from action 'wp'
		if ( is_admin() ) {
			melodyschool_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */

// String utilities. core.strings must be first - we use themerex_str...() in the themerex_get_file_dir()
require_once MELODYSCHOOL_FW_PATH . 'core/core.strings.php';
// File utilities. core.files must be first - we use themerex_get_file_dir() to include all rest parts
require_once MELODYSCHOOL_FW_PATH . 'core/core.files.php';
// Debug utilities
require_once MELODYSCHOOL_FW_PATH . 'core/core.debug.php';

// Include custom theme files
require_once MELODYSCHOOL_THEME_PATH . 'includes/theme.options.php';
require_once MELODYSCHOOL_THEME_PATH . 'includes/theme.styles.php';

// Include core files
require_once MELODYSCHOOL_FW_PATH . 'core/core.admin.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.arrays.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.date.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.html.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.http.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.ini.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.less.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.lists.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.media.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.messages.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.storage.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.templates.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.theme.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.users.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.wp.php';
require_once MELODYSCHOOL_FW_PATH . 'core/support.attachment.php';
require_once MELODYSCHOOL_FW_PATH . 'core/support.post.php';
require_once MELODYSCHOOL_FW_PATH . 'core/support.post_type.php';
require_once MELODYSCHOOL_FW_PATH . 'core/support.taxonomy.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.customizer/core.customizer.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.customizer.wp/core.customizer.wp.php';
require_once MELODYSCHOOL_FW_PATH . 'core/core.options/core.options.php';

// Include theme-specific plugins and post types
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.essgrids.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.elegro-payment.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.instagram-widget.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.learndash.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.revslider.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.visual-composer.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.woocommerce.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.wpml.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.trx_updater.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.gutenberg.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.gdpr-framework.php';
require_once MELODYSCHOOL_THEME_PATH . 'plugins/plugin.contact-form-7.php';


// Include theme templates.
// Using get_template_part(), because templates can be replaced in the child theme
get_template_part('templates/404');
get_template_part('templates/attachment');
get_template_part('templates/excerpt');
get_template_part('templates/gallery');
get_template_part('templates/masonry');
get_template_part('templates/no-articles');
get_template_part('templates/no-search');
get_template_part('templates/portfolio');
get_template_part('templates/related');
get_template_part('templates/single-matches');
get_template_part('templates/single-players');
get_template_part('templates/single-portfolio');
get_template_part('templates/single-standard');
get_template_part('templates/single-team');
get_template_part('templates/headers/header_5');
get_template_part('templates/headers/header_6');
get_template_part('templates/trx_blogger/accordion');
get_template_part('templates/trx_blogger/date');
get_template_part('templates/trx_blogger/list');
get_template_part('templates/trx_blogger/plain');
get_template_part('templates/trx_blogger/polaroid');
get_template_part('templates/trx_clients/clients-1');
get_template_part('templates/trx_clients/clients-2');
get_template_part('templates/trx_form/form_1');
get_template_part('templates/trx_form/form_2');
get_template_part('templates/trx_form/form_custom');
get_template_part('templates/trx_recent_news/news-announce');
get_template_part('templates/trx_recent_news/news-excerpt');
get_template_part('templates/trx_recent_news/news-magazine');
get_template_part('templates/trx_recent_news/news-portfolio');
get_template_part('templates/trx_services/services-1');
get_template_part('templates/trx_services/services-2');
get_template_part('templates/trx_team/team-1');
get_template_part('templates/trx_testimonials/testimonials-1');

?>