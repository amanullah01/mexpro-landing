<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'melodyschool_template_404_theme_setup' ) ) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_template_404_theme_setup', 1 );
	function melodyschool_template_404_theme_setup() {
		melodyschool_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			)
		));
	}
}

// Template output
if ( !function_exists( 'melodyschool_template_404_output' ) ) {
	function melodyschool_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
                <img class="image_404" src="<?php echo( get_stylesheet_directory_uri()); ?>/images/404.png" alt="404">
				<h1 class="page_title"><?php esc_html_e( 'Error 404!', 'melodyschool' ); ?></h1>
				<h1 class="page_subtitle"><?php esc_html_e('Can\'t find that page', 'melodyschool'); ?></h1>
				<p class="page_description"><?php echo wp_kses_data( sprintf( __('Can\'t find what you need? Take a moment and do a search below or start from <a href="%s">our homepage</a>.', 'melodyschool'), esc_url(home_url('/')) ) ); ?></p>
				<div class="page_search"><?php if(function_exists('melodyschool_sc_search')) melodyschool_show_layout(melodyschool_sc_search(array('state'=>'fixed', 'title'=>esc_attr__('enter keyword', 'melodyschool')))); ?></div>
			</div>
		</article>
		<?php
	}
}
?>