<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */


// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'melodyschool_theme_setup' ) ) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_theme_setup', 1 );
	function melodyschool_theme_setup() {


        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

        // Add wide and full blocks support
        add_theme_support( 'align-wide' );

		// Register theme menus
		add_filter( 'melodyschool_filter_add_theme_menus',		'melodyschool_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'melodyschool_filter_add_theme_sidebars',	'melodyschool_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'melodyschool_filter_importer_options',		'melodyschool_set_importer_options' );

		// Add theme required plugins
		add_filter( 'melodyschool_filter_required_plugins',		'melodyschool_add_required_plugins' );

		// Init theme after WP is created
		add_action( 'wp',									'melodyschool_core_init_theme' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 							'melodyschool_body_classes' );

		// Add data to the head and to the beginning of the body
		add_action('wp_head',								'melodyschool_head_add_page_meta', 1);
		add_action('before',								'melodyschool_body_add_gtm');
		add_action('before',								'melodyschool_body_add_toc');
		add_action('before',								'melodyschool_body_add_page_preloader');

		// Add data to the head and to the beginning of the body
		add_action('wp_footer',								'melodyschool_footer_add_views_counter');
		add_action('wp_footer',								'melodyschool_footer_add_theme_customizer');
		add_action('wp_footer',								'melodyschool_footer_add_custom_html');
		add_action('wp_footer',								'melodyschool_footer_add_gtm2');

		// Set list of the theme required plugins
		melodyschool_storage_set('required_plugins', array(
			'essgrids',
			'revslider',
            'instagram_widget',
			'trx_utils',
			'visual_composer',
			'woocommerce',
            'elegro-payment',
            'trx_updater',
            'gdpr_framework',
            'learndash',
            'contact_form_7'
			)
		);

        melodyschool_storage_set('demo_data_url', melodyschool_get_protocol().'://demofiles.ancorathemes.com/melody/');
		
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'melodyschool_add_theme_menus' ) ) {
	function melodyschool_add_theme_menus($menus) {
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'melodyschool_add_theme_sidebars' ) ) {
	function melodyschool_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'melodyschool' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'melodyschool' )
			);
			if (function_exists('melodyschool_exists_woocommerce') && melodyschool_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'melodyschool' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'melodyschool_add_required_plugins' ) ) {
	function melodyschool_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> esc_html__('MelodySchool Utilities', 'melodyschool'),
			'version'	=> '3.2.1',					// Minimal required version
			'slug' 		=> 'trx_utils',
			'source'	=> melodyschool_get_file_dir('plugins/install/trx_utils.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'melodyschool_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'melodyschool_importer_set_options', 9 );
    function melodyschool_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file
            $options['debug'] = false;
            // Prepare demo data
            if ( is_dir( MELODYSCHOOL_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = MELODYSCHOOL_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( melodyschool_get_protocol().'://demofiles.ancorathemes.com/melody/' ); // Demo-site domain
            }

            // Required plugins
            $options['required_plugins'] =  array(
                'essential-grid',
                'revslider',
                'instagram_widget',
                'trx_utils',
                'js_composer',
                'woocommerce',
                'contact-form-7'
            );

            $options['theme_slug'] = 'melodyschool';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
            $options['regenerate_thumbnails'] = 3;
            // Default demo
            $options['files']['default']['title'] = esc_html__( 'Education Demo', 'melodyschool' );
            $options['files']['default']['domain_dev'] = esc_url('http://melody.dv.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url('http://melody.ancorathemes.com/'); // Demo-site domain

        }
        return $options;
    }
}



// Add data to the head and to the beginning of the body
//------------------------------------------------------------------------

// Add theme specified classes to the body tag
if ( !function_exists('melodyschool_body_classes') ) {
	function melodyschool_body_classes( $classes ) {

		$classes[] = 'melodyschool_body';
		$classes[] = 'body_style_' . trim(melodyschool_get_custom_option('body_style'));
		$classes[] = 'body_' . (melodyschool_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'article_style_' . trim(melodyschool_get_custom_option('article_style'));
		
		$blog_style = melodyschool_get_custom_option(is_singular() && !melodyschool_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(melodyschool_get_template_name($blog_style));
		
		$body_scheme = melodyschool_get_custom_option('body_scheme');
		if (empty($body_scheme)  || melodyschool_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = melodyschool_get_custom_option('top_panel_position');
		if (!melodyschool_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = melodyschool_get_sidebar_class();

		if (melodyschool_get_custom_option('show_video_bg')=='yes' && (melodyschool_get_custom_option('video_bg_youtube_code')!='' || melodyschool_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (melodyschool_get_theme_option('page_preloader')!='')
			$classes[] = 'preloader';

		return $classes;
	}
}


// Add page meta to the head
if (!function_exists('melodyschool_head_add_page_meta')) {
	function melodyschool_head_add_page_meta() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1<?php if (melodyschool_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
		<meta name="format-detection" content="telephone=no">
	
		<link rel="profile" href="//gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
	}
}


// Add gtm code to the beginning of the body 
if (!function_exists('melodyschool_body_add_gtm')) {
	function melodyschool_body_add_gtm() {
		melodyschool_show_layout(melodyschool_get_custom_option('gtm_code'));
	}
}

// Add TOC anchors to the beginning of the body
if (!function_exists('melodyschool_body_add_toc')) {
	function melodyschool_body_add_toc() {
		// Add TOC items 'Home' and "To top"
		if (melodyschool_get_custom_option('menu_toc_home')=='yes' && function_exists('melodyschool_sc_anchor'))
			melodyschool_show_layout(melodyschool_sc_anchor(array(
				'id' => "toc_home",
				'title' => esc_html__('Home', 'melodyschool'),
				'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'melodyschool'),
				'icon' => "icon-home",
				'separator' => "yes",
				'url' => esc_url(home_url('/'))
				)
			));
		if (melodyschool_get_custom_option('menu_toc_top')=='yes' && function_exists('melodyschool_sc_anchor'))
			melodyschool_show_layout(melodyschool_sc_anchor(array(
				'id' => "toc_top",
				'title' => esc_html__('To Top', 'melodyschool'),
				'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'melodyschool'),
				'icon' => "icon-double-up",
				'separator' => "yes")
				));
	}
}

// Add page preloader to the beginning of the body
if (!function_exists('melodyschool_body_add_page_preloader')) {
	function melodyschool_body_add_page_preloader() {
		if (($preloader=melodyschool_get_theme_option('page_preloader'))!='') {
			?><div id="page_preloader"></div><?php
		}
	}
}


/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }
}

// Add data to the footer
//------------------------------------------------------------------------

// Add post/page views counter
if (!function_exists('melodyschool_footer_add_views_counter')) {
	function melodyschool_footer_add_views_counter() {
		// Post/Page views counter
		get_template_part(melodyschool_get_file_slug('templates/_parts/views-counter.php'));
	}
}

// Add theme customizer
if (!function_exists('melodyschool_footer_add_theme_customizer')) {
	function melodyschool_footer_add_theme_customizer() {
		// Front customizer
		if (melodyschool_get_custom_option('show_theme_customizer')=='yes') {
            require_once trailingslashit( get_template_directory() ) . 'fw/core/core.customizer/front.customizer.php';
		}
	}
}

// Add custom html
if (!function_exists('melodyschool_footer_add_custom_html')) {
	function melodyschool_footer_add_custom_html() {
		?><div class="custom_html_section"><?php
        melodyschool_show_layout(melodyschool_get_custom_option('custom_code'));
		?></div><?php
	}
}

// Add gtm code
if (!function_exists('melodyschool_footer_add_gtm2')) {
	function melodyschool_footer_add_gtm2() {
		melodyschool_show_layout(melodyschool_get_custom_option('gtm_code2'));
	}
}


// Add theme required plugins
if ( !function_exists( 'melodyschool_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'melodyschool_add_trx_utils' );
    function melodyschool_add_trx_utils($enable=true) {
        return true;
    }
}


// Include framework core files
//-------------------------------------------------------------------
require_once trailingslashit( get_template_directory() ) . 'fw/loader.php';
?>