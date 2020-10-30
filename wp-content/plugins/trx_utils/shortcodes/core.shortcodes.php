<?php
/**
 * MelodySchool Framework: shortcodes manipulations
 *
 * @package	melodyschool
 * @since	melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('melodyschool_sc_theme_setup')) {
	add_action( 'melodyschool_action_init_theme', 'melodyschool_sc_theme_setup', 1 );
	function melodyschool_sc_theme_setup() {
		// Add sc stylesheets
		add_action('melodyschool_action_add_styles', 'melodyschool_sc_add_styles', 1);
	}
}

if (!function_exists('melodyschool_sc_theme_setup2')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_sc_theme_setup2' );
	function melodyschool_sc_theme_setup2() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'melodyschool_sc_excerpt_shortcodes');
	
			// Prepare shortcodes in the content
			if (function_exists('melodyschool_sc_prepare_content')) melodyschool_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('melodyschool_shortcode_output', 'melodyschool_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_form',			'melodyschool_sc_form_send');
		add_action('wp_ajax_nopriv_send_form',	'melodyschool_sc_form_send');

        if (melodyschool_exists_revslider()) {
            add_filter( 'melodyschool_filter_shortcodes_params',			'melodyschool_revslider_shortcodes_params' );
        }

        add_action('melodyschool_action_shortcodes_list', 			'melodyschool_woocommerce_reg_shortcodes', 20);
        if (function_exists('melodyschool_exists_visual_composer') && melodyschool_exists_visual_composer())
            add_action('melodyschool_action_shortcodes_list_vc',	'melodyschool_woocommerce_reg_shortcodes_vc', 20);

		// Show shortcodes list in admin editor
		add_action('media_buttons',				'melodyschool_sc_selector_add_in_toolbar', 11);

	}
}


// Register shortcodes styles
if ( !function_exists( 'melodyschool_sc_add_styles' ) ) {
	//add_action('melodyschool_action_add_styles', 'melodyschool_sc_add_styles', 1);
	function melodyschool_sc_add_styles() {
		// Shortcodes
		wp_enqueue_style( 'melodyschool-shortcodes-style',	trx_utils_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
	}
}


// Register shortcodes init scripts
if ( !function_exists( 'melodyschool_sc_add_scripts' ) ) {
	//add_filter('melodyschool_shortcode_output', 'melodyschool_sc_add_scripts', 10, 4);
	function melodyschool_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		if (melodyschool_storage_empty('shortcodes_scripts_added')) {
			melodyschool_storage_set('shortcodes_scripts_added', true);
			wp_enqueue_script( 'melodyschool-shortcodes-script', trx_utils_get_file_url('shortcodes/theme.shortcodes.js'), array('jquery'), null, true );
		}
		
		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('melodyschool_sc_prepare_content')) {
	function melodyschool_sc_prepare_content() {
		if (function_exists('melodyschool_sc_clear_around')) {
			$filters = array(
				array('melodyschool', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (function_exists('melodyschool_exists_woocommerce') && melodyschool_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			if (is_array($filters) && count($filters) > 0) {
				foreach ($filters as $flt)
					add_filter(join('_', $flt), 'melodyschool_sc_clear_around', 1);	// Priority 1 to clear spaces before do_shortcodes()
			}
		}
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('melodyschool_sc_excerpt_shortcodes')) {
	function melodyschool_sc_excerpt_shortcodes($content) {
		if (!empty($content)) {
			$content = do_shortcode($content);
		}
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('melodyschool_sc_clear_around')) {
	function melodyschool_sc_clear_around($content) {
		if (!empty($content)) $content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// MelodySchool shortcodes load scripts
if (!function_exists('melodyschool_sc_load_scripts')) {
	function melodyschool_sc_load_scripts() {
		wp_enqueue_script( 'melodyschool-shortcodes_admin-script', trx_utils_get_file_url('shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
		wp_enqueue_script( 'melodyschool-selection-script',  melodyschool_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
		wp_localize_script( 'melodyschool-shortcodes_admin-script', 'MELODYSCHOOL_SHORTCODES_DATA', melodyschool_storage_get('shortcodes') );
	}
}

// MelodySchool shortcodes prepare scripts
if (!function_exists('melodyschool_sc_prepare_scripts')) {
	function melodyschool_sc_prepare_scripts() {
		if (!melodyschool_storage_isset('shortcodes_prepared')) {
			melodyschool_storage_set('shortcodes_prepared', true);
			?>
            <<?php echo esc_attr(melodyschool_storage_get('tag_open'));?>>
				jQuery(document).ready(function(){
					MELODYSCHOOL_STORAGE['shortcodes_cp'] = '<?php echo is_admin() ? (!melodyschool_storage_empty('to_colorpicker') ? melodyschool_storage_get('to_colorpicker') : 'wp') : 'custom'; ?>';	// wp | tiny | custom
				});
            <<?php echo esc_attr(melodyschool_storage_get('tag_close'));?>>
			<?php
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('melodyschool_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','melodyschool_sc_selector_add_in_toolbar', 11);
	function melodyschool_sc_selector_add_in_toolbar(){

		if ( !melodyschool_options_is_used() ) return;

		melodyschool_sc_load_scripts();
		melodyschool_sc_prepare_scripts();

		$shortcodes = melodyschool_storage_get('shortcodes');
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.esc_html__('- Select Shortcode -', 'trx_utils').'&nbsp;</option>';

		if (is_array($shortcodes) && count($shortcodes) > 0) {
			foreach ($shortcodes as $idx => $sc) {
				$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
			}
		}

		$shortcodes_list .= '</select>';

		melodyschool_show_layout($shortcodes_list);
	}
}

// Add RevSlider in the shortcodes params
if ( !function_exists( 'melodyschool_revslider_shortcodes_params' ) ) {
    //Handler of add_filter( 'melodyschool_filter_shortcodes_params',			'melodyschool_revslider_shortcodes_params' );
    function melodyschool_revslider_shortcodes_params($list=array()) {
        $list["revo_sliders"] = melodyschool_get_list_revo_sliders();
        return $list;
    }
}


// Register shortcodes to the internal builder
//------------------------------------------------------------------------
if ( !function_exists( 'melodyschool_woocommerce_reg_shortcodes' ) ) {
    //Handler of add_action('melodyschool_action_shortcodes_list', 'melodyschool_woocommerce_reg_shortcodes', 20);
    function melodyschool_woocommerce_reg_shortcodes() {

        // WooCommerce - Cart
        melodyschool_sc_map("woocommerce_cart", array(
                "title" => esc_html__("Woocommerce: Cart", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show Cart page", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array()
            )
        );

        // WooCommerce - Checkout
        melodyschool_sc_map("woocommerce_checkout", array(
                "title" => esc_html__("Woocommerce: Checkout", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show Checkout page", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array()
            )
        );

        // WooCommerce - My Account
        melodyschool_sc_map("woocommerce_my_account", array(
                "title" => esc_html__("Woocommerce: My Account", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show My Account page", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array()
            )
        );

        // WooCommerce - Order Tracking
        melodyschool_sc_map("woocommerce_order_tracking", array(
                "title" => esc_html__("Woocommerce: Order Tracking", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show Order Tracking page", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array()
            )
        );

        // WooCommerce - Shop Messages
        melodyschool_sc_map("shop_messages", array(
                "title" => esc_html__("Woocommerce: Shop Messages", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show shop messages", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array()
            )
        );

        // WooCommerce - Product Page
        melodyschool_sc_map("product_page", array(
                "title" => esc_html__("Woocommerce: Product Page", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: display single product page", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "sku" => array(
                        "title" => esc_html__("SKU", 'melodyschool'),
                        "desc" => wp_kses_data( __("SKU code of displayed product", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "id" => array(
                        "title" => esc_html__("ID", 'melodyschool'),
                        "desc" => wp_kses_data( __("ID of displayed product", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "posts_per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => "1",
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "post_type" => array(
                        "title" => esc_html__("Post type", 'melodyschool'),
                        "desc" => wp_kses_data( __("Post type for the WP query (leave 'product')", 'melodyschool') ),
                        "value" => "product",
                        "type" => "text"
                    ),
                    "post_status" => array(
                        "title" => esc_html__("Post status", 'melodyschool'),
                        "desc" => wp_kses_data( __("Display posts only with this status", 'melodyschool') ),
                        "value" => "publish",
                        "type" => "select",
                        "options" => array(
                            "publish" => esc_html__('Publish', 'melodyschool'),
                            "protected" => esc_html__('Protected', 'melodyschool'),
                            "private" => esc_html__('Private', 'melodyschool'),
                            "pending" => esc_html__('Pending', 'melodyschool'),
                            "draft" => esc_html__('Draft', 'melodyschool')
                        )
                    )
                )
            )
        );

        // WooCommerce - Product
        melodyschool_sc_map("product", array(
                "title" => esc_html__("Woocommerce: Product", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: display one product", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "sku" => array(
                        "title" => esc_html__("SKU", 'melodyschool'),
                        "desc" => wp_kses_data( __("SKU code of displayed product", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "id" => array(
                        "title" => esc_html__("ID", 'melodyschool'),
                        "desc" => wp_kses_data( __("ID of displayed product", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    )
                )
            )
        );

        // WooCommerce - Best Selling Products
        melodyschool_sc_map("best_selling_products", array(
                "title" => esc_html__("Woocommerce: Best Selling Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show best selling products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    )
                )
            )
        );

        // WooCommerce - Recent Products
        melodyschool_sc_map("recent_products", array(
                "title" => esc_html__("Woocommerce: Recent Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show recent products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    )
                )
            )
        );

        // WooCommerce - Related Products
        melodyschool_sc_map("related_products", array(
                "title" => esc_html__("Woocommerce: Related Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show related products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "posts_per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    )
                )
            )
        );

        // WooCommerce - Featured Products
        melodyschool_sc_map("featured_products", array(
                "title" => esc_html__("Woocommerce: Featured Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show featured products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    )
                )
            )
        );

        // WooCommerce - Top Rated Products
        melodyschool_sc_map("featured_products", array(
                "title" => esc_html__("Woocommerce: Top Rated Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show top rated products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    )
                )
            )
        );

        // WooCommerce - Sale Products
        melodyschool_sc_map("featured_products", array(
                "title" => esc_html__("Woocommerce: Sale Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: list products on sale", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    )
                )
            )
        );

        // WooCommerce - Product Category
        melodyschool_sc_map("product_category", array(
                "title" => esc_html__("Woocommerce: Products from category", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: list products in specified category(-ies)", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    ),
                    "category" => array(
                        "title" => esc_html__("Categories", 'melodyschool'),
                        "desc" => wp_kses_data( __("Comma separated category slugs", 'melodyschool') ),
                        "value" => '',
                        "type" => "text"
                    ),
                    "operator" => array(
                        "title" => esc_html__("Operator", 'melodyschool'),
                        "desc" => wp_kses_data( __("Categories operator", 'melodyschool') ),
                        "value" => "IN",
                        "type" => "checklist",
                        "size" => "medium",
                        "options" => array(
                            "IN" => esc_html__('IN', 'melodyschool'),
                            "NOT IN" => esc_html__('NOT IN', 'melodyschool'),
                            "AND" => esc_html__('AND', 'melodyschool')
                        )
                    )
                )
            )
        );

        // WooCommerce - Products
        melodyschool_sc_map("products", array(
                "title" => esc_html__("Woocommerce: Products", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: list all products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "skus" => array(
                        "title" => esc_html__("SKUs", 'melodyschool'),
                        "desc" => wp_kses_data( __("Comma separated SKU codes of products", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "ids" => array(
                        "title" => esc_html__("IDs", 'melodyschool'),
                        "desc" => wp_kses_data( __("Comma separated ID of products", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    )
                )
            )
        );

        // WooCommerce - Product attribute
        melodyschool_sc_map("product_attribute", array(
                "title" => esc_html__("Woocommerce: Products by Attribute", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show products with specified attribute", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "per_page" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    ),
                    "attribute" => array(
                        "title" => esc_html__("Attribute", 'melodyschool'),
                        "desc" => wp_kses_data( __("Attribute name", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "filter" => array(
                        "title" => esc_html__("Filter", 'melodyschool'),
                        "desc" => wp_kses_data( __("Attribute value", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    )
                )
            )
        );

        // WooCommerce - Products Categories
        melodyschool_sc_map("product_categories", array(
                "title" => esc_html__("Woocommerce: Product Categories", 'melodyschool'),
                "desc" => wp_kses_data( __("WooCommerce shortcode: show categories with products", 'melodyschool') ),
                "decorate" => false,
                "container" => false,
                "params" => array(
                    "number" => array(
                        "title" => esc_html__("Number", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many categories showed", 'melodyschool') ),
                        "value" => 4,
                        "min" => 1,
                        "type" => "spinner"
                    ),
                    "columns" => array(
                        "title" => esc_html__("Columns", 'melodyschool'),
                        "desc" => wp_kses_data( __("How many columns per row use for categories output", 'melodyschool') ),
                        "value" => 4,
                        "min" => 2,
                        "max" => 4,
                        "type" => "spinner"
                    ),
                    "orderby" => array(
                        "title" => esc_html__("Order by", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "date",
                        "type" => "select",
                        "options" => array(
                            "date" => esc_html__('Date', 'melodyschool'),
                            "title" => esc_html__('Title', 'melodyschool')
                        )
                    ),
                    "order" => array(
                        "title" => esc_html__("Order", 'melodyschool'),
                        "desc" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "value" => "desc",
                        "type" => "switch",
                        "size" => "big",
                        "options" => melodyschool_get_sc_param('ordering')
                    ),
                    "parent" => array(
                        "title" => esc_html__("Parent", 'melodyschool'),
                        "desc" => wp_kses_data( __("Parent category slug", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "ids" => array(
                        "title" => esc_html__("IDs", 'melodyschool'),
                        "desc" => wp_kses_data( __("Comma separated ID of products", 'melodyschool') ),
                        "value" => "",
                        "type" => "text"
                    ),
                    "hide_empty" => array(
                        "title" => esc_html__("Hide empty", 'melodyschool'),
                        "desc" => wp_kses_data( __("Hide empty categories", 'melodyschool') ),
                        "value" => "yes",
                        "type" => "switch",
                        "options" => melodyschool_get_sc_param('yes_no')
                    )
                )
            )
        );
    }
}

// Register shortcodes to the VC builder
//------------------------------------------------------------------------
if ( !function_exists( 'melodyschool_woocommerce_reg_shortcodes_vc' ) ) {
    //Handler of add_action('melodyschool_action_shortcodes_list_vc', 'melodyschool_woocommerce_reg_shortcodes_vc');
    function melodyschool_woocommerce_reg_shortcodes_vc() {

        if (false && function_exists('melodyschool_exists_woocommerce') && melodyschool_exists_woocommerce()) {

            // WooCommerce - Cart
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "woocommerce_cart",
                "name" => esc_html__("Cart", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show cart page", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_wooc_cart',
                "class" => "trx_sc_alone trx_sc_woocommerce_cart",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => false,
                "params" => array(
                    array(
                        "param_name" => "dummy",
                        "heading" => esc_html__("Dummy data", 'melodyschool'),
                        "description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'melodyschool') ),
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Woocommerce_Cart extends MELODYSCHOOL_VC_ShortCodeAlone {}


            // WooCommerce - Checkout
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "woocommerce_checkout",
                "name" => esc_html__("Checkout", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show checkout page", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_wooc_checkout',
                "class" => "trx_sc_alone trx_sc_woocommerce_checkout",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => false,
                "params" => array(
                    array(
                        "param_name" => "dummy",
                        "heading" => esc_html__("Dummy data", 'melodyschool'),
                        "description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'melodyschool') ),
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Woocommerce_Checkout extends MELODYSCHOOL_VC_ShortCodeAlone {}


            // WooCommerce - My Account
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "woocommerce_my_account",
                "name" => esc_html__("My Account", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show my account page", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_wooc_my_account',
                "class" => "trx_sc_alone trx_sc_woocommerce_my_account",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => false,
                "params" => array(
                    array(
                        "param_name" => "dummy",
                        "heading" => esc_html__("Dummy data", 'melodyschool'),
                        "description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'melodyschool') ),
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Woocommerce_My_Account extends MELODYSCHOOL_VC_ShortCodeAlone {}


            // WooCommerce - Order Tracking
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "woocommerce_order_tracking",
                "name" => esc_html__("Order Tracking", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show order tracking page", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_wooc_order_tracking',
                "class" => "trx_sc_alone trx_sc_woocommerce_order_tracking",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => false,
                "params" => array(
                    array(
                        "param_name" => "dummy",
                        "heading" => esc_html__("Dummy data", 'melodyschool'),
                        "description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'melodyschool') ),
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Woocommerce_Order_Tracking extends MELODYSCHOOL_VC_ShortCodeAlone {}


            // WooCommerce - Shop Messages
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "shop_messages",
                "name" => esc_html__("Shop Messages", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show shop messages", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_wooc_shop_messages',
                "class" => "trx_sc_alone trx_sc_shop_messages",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => false,
                "params" => array(
                    array(
                        "param_name" => "dummy",
                        "heading" => esc_html__("Dummy data", 'melodyschool'),
                        "description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'melodyschool') ),
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Shop_Messages extends MELODYSCHOOL_VC_ShortCodeAlone {}


            // WooCommerce - Product Page
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "product_page",
                "name" => esc_html__("Product Page", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: display single product page", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_product_page',
                "class" => "trx_sc_single trx_sc_product_page",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "sku",
                        "heading" => esc_html__("SKU", 'melodyschool'),
                        "description" => wp_kses_data( __("SKU code of displayed product", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "id",
                        "heading" => esc_html__("ID", 'melodyschool'),
                        "description" => wp_kses_data( __("ID of displayed product", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "posts_per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "post_type",
                        "heading" => esc_html__("Post type", 'melodyschool'),
                        "description" => wp_kses_data( __("Post type for the WP query (leave 'product')", 'melodyschool') ),
                        "class" => "",
                        "value" => "product",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "post_status",
                        "heading" => esc_html__("Post status", 'melodyschool'),
                        "description" => wp_kses_data( __("Display posts only with this status", 'melodyschool') ),
                        "class" => "",
                        "value" => array(
                            esc_html__('Publish', 'melodyschool') => 'publish',
                            esc_html__('Protected', 'melodyschool') => 'protected',
                            esc_html__('Private', 'melodyschool') => 'private',
                            esc_html__('Pending', 'melodyschool') => 'pending',
                            esc_html__('Draft', 'melodyschool') => 'draft'
                        ),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Product_Page extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Product
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "product",
                "name" => esc_html__("Product", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: display one product", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_product',
                "class" => "trx_sc_single trx_sc_product",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "sku",
                        "heading" => esc_html__("SKU", 'melodyschool'),
                        "description" => wp_kses_data( __("Product's SKU code", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "id",
                        "heading" => esc_html__("ID", 'melodyschool'),
                        "description" => wp_kses_data( __("Product's ID", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Product extends MELODYSCHOOL_VC_ShortCodeSingle {}


            // WooCommerce - Best Selling Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "best_selling_products",
                "name" => esc_html__("Best Selling Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show best selling products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_best_selling_products',
                "class" => "trx_sc_single trx_sc_best_selling_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Best_Selling_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Recent Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "recent_products",
                "name" => esc_html__("Recent Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show recent products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_recent_products',
                "class" => "trx_sc_single trx_sc_recent_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"

                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Recent_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Related Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "related_products",
                "name" => esc_html__("Related Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show related products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_related_products',
                "class" => "trx_sc_single trx_sc_related_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "posts_per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Related_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Featured Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "featured_products",
                "name" => esc_html__("Featured Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show featured products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_featured_products',
                "class" => "trx_sc_single trx_sc_featured_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Featured_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Top Rated Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "top_rated_products",
                "name" => esc_html__("Top Rated Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show top rated products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_top_rated_products',
                "class" => "trx_sc_single trx_sc_top_rated_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Top_Rated_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Sale Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "sale_products",
                "name" => esc_html__("Sale Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: list products on sale", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_sale_products',
                "class" => "trx_sc_single trx_sc_sale_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Sale_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Product Category
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "product_category",
                "name" => esc_html__("Products from category", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: list products in specified category(-ies)", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_product_category',
                "class" => "trx_sc_single trx_sc_product_category",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "category",
                        "heading" => esc_html__("Categories", 'melodyschool'),
                        "description" => wp_kses_data( __("Comma separated category slugs", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "operator",
                        "heading" => esc_html__("Operator", 'melodyschool'),
                        "description" => wp_kses_data( __("Categories operator", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('IN', 'melodyschool') => 'IN',
                            esc_html__('NOT IN', 'melodyschool') => 'NOT IN',
                            esc_html__('AND', 'melodyschool') => 'AND'
                        ),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Product_Category extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Products
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "products",
                "name" => esc_html__("Products", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: list all products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_products',
                "class" => "trx_sc_single trx_sc_products",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "skus",
                        "heading" => esc_html__("SKUs", 'melodyschool'),
                        "description" => wp_kses_data( __("Comma separated SKU codes of products", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "ids",
                        "heading" => esc_html__("IDs", 'melodyschool'),
                        "description" => wp_kses_data( __("Comma separated ID of products", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    )
                )
            ) );

            class WPBakeryShortCode_Products extends MELODYSCHOOL_VC_ShortCodeSingle {}




            // WooCommerce - Product Attribute
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "product_attribute",
                "name" => esc_html__("Products by Attribute", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show products with specified attribute", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_product_attribute',
                "class" => "trx_sc_single trx_sc_product_attribute",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "per_page",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many products showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "attribute",
                        "heading" => esc_html__("Attribute", 'melodyschool'),
                        "description" => wp_kses_data( __("Attribute name", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "filter",
                        "heading" => esc_html__("Filter", 'melodyschool'),
                        "description" => wp_kses_data( __("Attribute value", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    )
                )
            ) );

            class WPBakeryShortCode_Product_Attribute extends MELODYSCHOOL_VC_ShortCodeSingle {}



            // WooCommerce - Products Categories
            //-------------------------------------------------------------------------------------

            vc_map( array(
                "base" => "product_categories",
                "name" => esc_html__("Product Categories", 'melodyschool'),
                "description" => wp_kses_data( __("WooCommerce shortcode: show categories with products", 'melodyschool') ),
                "category" => esc_html__('WooCommerce', 'melodyschool'),
                'icon' => 'icon_trx_product_categories',
                "class" => "trx_sc_single trx_sc_product_categories",
                "content_element" => true,
                "is_container" => false,
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "param_name" => "number",
                        "heading" => esc_html__("Number", 'melodyschool'),
                        "description" => wp_kses_data( __("How many categories showed", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "4",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "columns",
                        "heading" => esc_html__("Columns", 'melodyschool'),
                        "description" => wp_kses_data( __("How many columns per row use for categories output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "1",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "orderby",
                        "heading" => esc_html__("Order by", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array(
                            esc_html__('Date', 'melodyschool') => 'date',
                            esc_html__('Title', 'melodyschool') => 'title'
                        ),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "order",
                        "heading" => esc_html__("Order", 'melodyschool'),
                        "description" => wp_kses_data( __("Sorting order for products output", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => array_flip(melodyschool_get_sc_param('ordering')),
                        "type" => "dropdown"
                    ),
                    array(
                        "param_name" => "parent",
                        "heading" => esc_html__("Parent", 'melodyschool'),
                        "description" => wp_kses_data( __("Parent category slug", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "date",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "ids",
                        "heading" => esc_html__("IDs", 'melodyschool'),
                        "description" => wp_kses_data( __("Comma separated ID of products", 'melodyschool') ),
                        "admin_label" => true,
                        "class" => "",
                        "value" => "",
                        "type" => "textfield"
                    ),
                    array(
                        "param_name" => "hide_empty",
                        "heading" => esc_html__("Hide empty", 'melodyschool'),
                        "description" => wp_kses_data( __("Hide empty categories", 'melodyschool') ),
                        "class" => "",
                        "value" => array("Hide empty" => "1" ),
                        "type" => "checkbox"
                    )
                )
            ) );

            class WPBakeryShortCode_Products_Categories extends MELODYSCHOOL_VC_ShortCodeSingle {}

        }
    }
}

// MelodySchool shortcodes builder settings
require_once trx_utils_get_file_dir('shortcodes/shortcodes_settings.php');

// VC shortcodes settings
if ( class_exists('WPBakeryShortCode') ) {
    require_once trx_utils_get_file_dir('shortcodes/shortcodes_vc.php');
}

// MelodySchool shortcodes implementation
// Using get_template_part(), because shortcodes can be replaced in the child theme
require_once trx_utils_get_file_dir('shortcodes/trx_basic/anchor.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/audio.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/blogger.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/br.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/call_to_action.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/chat.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/columns.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/content.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/form.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/googlemap.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/hide.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/image.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/infobox.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/line.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/list.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/price_block.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/promo.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/quote.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/reviews.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/search.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/section.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/skills.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/slider.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/socials.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/table.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/title.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/twitter.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/video.php');

require_once trx_utils_get_file_dir('shortcodes/trx_basic/support.clients.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/support.services.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/support.team.php');
require_once trx_utils_get_file_dir('shortcodes/trx_basic/support.testimonials.php');




require_once trx_utils_get_file_dir('shortcodes/trx_optional/accordion.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/button.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/countdown.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/dropcaps.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/gap.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/highlight.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/icon.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/number.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/parallax.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/popup.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/price.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/tabs.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/toggles.php');
require_once trx_utils_get_file_dir('shortcodes/trx_optional/tooltip.php');
//require_once trx_utils_get_file_dir('shortcodes/trx_optional/zoom.php);
//?>