<?php
/**
 * Single post
 */
get_header(); 

$single_style = melodyschool_storage_get('single_style');
if (empty($single_style)) $single_style = melodyschool_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	melodyschool_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !melodyschool_param_is_off(melodyschool_get_custom_option('show_sidebar_main')),
			'content' => melodyschool_get_template_property($single_style, 'need_content'),
			'terms_list' => melodyschool_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>