<?php
/**
 * Theme custom styles
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if (!function_exists('melodyschool_action_theme_styles_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_action_theme_styles_theme_setup', 1 );
	function melodyschool_action_theme_styles_theme_setup() {

		// Add theme fonts in the used fonts list
		add_filter('melodyschool_filter_used_fonts',			'melodyschool_filter_theme_styles_used_fonts');
		// Add theme fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('melodyschool_filter_list_fonts',			'melodyschool_filter_theme_styles_list_fonts');

		// Add theme stylesheets
		add_action('melodyschool_action_add_styles',			'melodyschool_action_theme_styles_add_styles');
		// Add theme inline styles
		add_filter('melodyschool_filter_add_styles_inline',		'melodyschool_filter_theme_styles_add_styles_inline');

		// Add theme scripts
		add_action('melodyschool_action_add_scripts',			'melodyschool_action_theme_styles_add_scripts');
		// Add theme scripts inline
		add_filter('melodyschool_action_add_scripts_inline',	'melodyschool_action_theme_styles_add_scripts_inline');

		// Add theme less files into list for compilation
		add_filter('melodyschool_filter_compile_less',			'melodyschool_filter_theme_styles_compile_less');

		// Add color schemes
		melodyschool_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'melodyschool'),


             // Whole block border and background
			'bd_color'				=> '#d6d7da',
			'bg_color'				=> '#ffffff',

			// Headers, text and links colors
			'text'					=> '#333745',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#333745',       //
			'text_link'				=> '#59c6bc',       //
			'text_hover'			=> '#2b6762',       //

			// Inverse colors
			'inverse_text'			=> '#ffffff',       //
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',

			// Input fields
			'input_text'			=> '#8a8a8a',
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#232a34',
			'input_bd_color'		=> '#d6d7da',       //
			'input_bd_hover'		=> '#bbbbbb',
			'input_bg_color'		=> '#f7f7f7',       //
			'input_bg_hover'		=> '#f0f0f0',

			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#54afa9',      
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#fff568',      
			'alter_hover'			=> '#ef5729',       
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#6d707a',    
			'alter_bg_color'		=> '#f7f7f7',
			'alter_bg_hover'		=> '#f0f0f0',
			)
		);

		// Add Custom fonts
		melodyschool_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> 'Lora',
			'font-size' 	=> '2.769em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.54em'
			)
		);
		melodyschool_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> 'Lora',
			'font-size' 	=> '2.3078em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.84em'
			)
		);
		melodyschool_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> 'Lora',
			'font-size' 	=> '1.8614em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.1em',
			'margin-bottom'	=> '1.3em'
			)
		);
		melodyschool_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.3845em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.4em',
			'margin-bottom'	=> '1.8em'
			)
		);
		melodyschool_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.0767em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '2.2em',
			'margin-bottom'	=> '2.1em'
			)
		);
		melodyschool_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.0767em',
			'font-weight'	=> '400',
			'font-style'	=> 'i',
			'line-height'	=> '1.3em',
			'margin-top'	=> '2.2em',
			'margin-bottom'	=> '0.65em'
			)
		);
		melodyschool_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '13px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.923em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		melodyschool_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		melodyschool_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '12px',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '',
			'margin-bottom'	=> '2.4em'
			)
		);
		melodyschool_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.07677em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '3.1em',
			'margin-bottom'	=> '3.1em'
			)
		);
		melodyschool_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.07677em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		melodyschool_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '2.7em',
			'margin-bottom'	=> '2.86em'
			)
		);
		melodyschool_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.077em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);
		melodyschool_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'melodyschool'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.077em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Theme fonts
//------------------------------------------------------------------------------

// Add theme fonts in the used fonts list
if (!function_exists('melodyschool_filter_theme_styles_used_fonts')) {
	function melodyschool_filter_theme_styles_used_fonts($theme_fonts) {
		$theme_fonts['Open Sans'] = 1;
        $theme_fonts['Lora'] = 1;
		return $theme_fonts;
	}
}

// Add theme fonts (from Google fonts) in the main fonts list (if not present).
if (!function_exists('melodyschool_filter_theme_styles_list_fonts')) {
	function melodyschool_filter_theme_styles_list_fonts($list) {

		if (!isset($list['Open Sans']))	$list['Open Sans'] = array('family'=>'sans-serif', 'link'=>'Open+Sans:400,400italic,600,700');
        if (!isset($list['Lora'])) $list['Lora'] = array('family'=>'sans-serif');


		return $list;

	}
}



//------------------------------------------------------------------------------
// Theme stylesheets
//------------------------------------------------------------------------------

// Add theme.less into list files for compilation
if (!function_exists('melodyschool_filter_theme_styles_compile_less')) {
	function melodyschool_filter_theme_styles_compile_less($files) {
		if (file_exists(melodyschool_get_file_dir('css/theme.less'))) {
		 	$files[] = melodyschool_get_file_dir('css/theme.less');
		}
		return $files;
	}
}

// Add theme stylesheets
if (!function_exists('melodyschool_action_theme_styles_add_styles')) {
	function melodyschool_action_theme_styles_add_styles() {
		// Add stylesheet files only if LESS supported
		if ( melodyschool_get_theme_setting('less_compiler') != 'no' ) {
			wp_enqueue_style( 'melodyschool-theme-style', melodyschool_get_file_url('css/theme.css'), array(), null );
			wp_add_inline_style( 'melodyschool-theme-style', melodyschool_get_inline_css() );
		}
	}
}

// Add theme inline styles
if (!function_exists('melodyschool_filter_theme_styles_add_styles_inline')) {
	function melodyschool_filter_theme_styles_add_styles_inline($custom_style) {

		// Submenu width
		$menu_width = melodyschool_get_theme_option('menu_width');
		if (!empty($menu_width)) {
			$custom_style .= "
				/* Submenu width */
				.menu_side_nav > li ul,
				.menu_main_nav > li ul {
					width: ".intval($menu_width)."px;
				}
				.menu_side_nav > li > ul ul,
				.menu_main_nav > li > ul ul {
					left:".intval($menu_width+4)."px;
				}
				.menu_side_nav > li > ul ul.submenu_left,
				.menu_main_nav > li > ul ul.submenu_left {
					left:-".intval($menu_width+1)."px;
				}
			";
		}

		// Logo height
		$logo_height = melodyschool_get_custom_option('logo_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo header height */
				.sidebar_outer_logo .logo_main,
				.top_panel_wrap .logo_main,
				.top_panel_wrap .logo_fixed {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Logo top offset
		$logo_offset = melodyschool_get_custom_option('logo_offset');
		if (!empty($logo_offset)) {
			$custom_style .= "
				/* Logo header top offset */
				.top_panel_wrap .logo {
					margin-top:".intval($logo_offset)."px;
				}
			";
		}

		// Logo footer height
		$logo_height = melodyschool_get_theme_option('logo_footer_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo footer height */
				.contacts_wrap .logo img {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Custom css from theme options
		$custom_style .= melodyschool_get_custom_option('custom_css');

		return $custom_style;
	}
}


//------------------------------------------------------------------------------
// Theme scripts
//------------------------------------------------------------------------------

// Add theme scripts
if (!function_exists('melodyschool_action_theme_styles_add_scripts')) {
	function melodyschool_action_theme_styles_add_scripts() {
		if (melodyschool_get_theme_option('show_theme_customizer') == 'yes' && file_exists(melodyschool_get_file_dir('js/theme.customizer.js')))
			wp_enqueue_script( 'melodyschool-theme-styles-customizer-script', melodyschool_get_file_url('js/theme.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('melodyschool_action_theme_styles_add_scripts_inline')) {
    //Handler of add_filter('melodyschool_action_add_scripts_inline', 'melodyschool_action_theme_styles_add_scripts_inline');
    function melodyschool_action_theme_styles_add_scripts_inline($vars=array()) {
        // Todo: add skin specific script's vars
        return $vars;
    }
}
?>