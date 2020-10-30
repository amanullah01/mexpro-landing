<?php
/**
 * MelodySchool Framework: return lists
 *
 * @package melodyschool
 * @since melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'melodyschool_get_list_styles' ) ) {
	function melodyschool_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'melodyschool'), $i);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'melodyschool_get_list_margins' ) ) {
	function melodyschool_get_list_margins($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'melodyschool'),
				'tiny'		=> esc_html__('Tiny',		'melodyschool'),
				'small'		=> esc_html__('Small',		'melodyschool'),
				'medium'	=> esc_html__('Medium',		'melodyschool'),
				'large'		=> esc_html__('Large',		'melodyschool'),
				'huge'		=> esc_html__('Huge',		'melodyschool'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'melodyschool'),
				'small-'	=> esc_html__('Small (negative)',	'melodyschool'),
				'medium-'	=> esc_html__('Medium (negative)',	'melodyschool'),
				'large-'	=> esc_html__('Large (negative)',	'melodyschool'),
				'huge-'		=> esc_html__('Huge (negative)',	'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_margins', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'melodyschool_get_list_animations' ) ) {
	function melodyschool_get_list_animations($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'melodyschool'),
				'bounced'		=> esc_html__('Bounced',		'melodyschool'),
				'flash'			=> esc_html__('Flash',		'melodyschool'),
				'flip'			=> esc_html__('Flip',		'melodyschool'),
				'pulse'			=> esc_html__('Pulse',		'melodyschool'),
				'rubberBand'	=> esc_html__('Rubber Band',	'melodyschool'),
				'shake'			=> esc_html__('Shake',		'melodyschool'),
				'swing'			=> esc_html__('Swing',		'melodyschool'),
				'tada'			=> esc_html__('Tada',		'melodyschool'),
				'wobble'		=> esc_html__('Wobble',		'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_animations', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'melodyschool_get_list_line_styles' ) ) {
	function melodyschool_get_list_line_styles($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'melodyschool'),
				'dashed'=> esc_html__('Dashed', 'melodyschool'),
				'dotted'=> esc_html__('Dotted', 'melodyschool'),
				'double'=> esc_html__('Double', 'melodyschool'),
				'image'	=> esc_html__('Image', 'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_line_styles', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'melodyschool_get_list_animations_in' ) ) {
	function melodyschool_get_list_animations_in($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'melodyschool'),
				'bounceIn'			=> esc_html__('Bounce In',			'melodyschool'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'melodyschool'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'melodyschool'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'melodyschool'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'melodyschool'),
				'fadeIn'			=> esc_html__('Fade In',			'melodyschool'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'melodyschool'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'melodyschool'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'melodyschool'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'melodyschool'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'melodyschool'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'melodyschool'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'melodyschool'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'melodyschool'),
				'flipInX'			=> esc_html__('Flip In X',			'melodyschool'),
				'flipInY'			=> esc_html__('Flip In Y',			'melodyschool'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'melodyschool'),
				'rotateIn'			=> esc_html__('Rotate In',			'melodyschool'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','melodyschool'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'melodyschool'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'melodyschool'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','melodyschool'),
				'rollIn'			=> esc_html__('Roll In',			'melodyschool'),
				'slideInUp'			=> esc_html__('Slide In Up',		'melodyschool'),
				'slideInDown'		=> esc_html__('Slide In Down',		'melodyschool'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'melodyschool'),
				'slideInRight'		=> esc_html__('Slide In Right',		'melodyschool'),
				'zoomIn'			=> esc_html__('Zoom In',			'melodyschool'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'melodyschool'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'melodyschool'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'melodyschool'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_animations_in', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'melodyschool_get_list_animations_out' ) ) {
	function melodyschool_get_list_animations_out($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',	'melodyschool'),
				'bounceOut'			=> esc_html__('Bounce Out',			'melodyschool'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'melodyschool'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',		'melodyschool'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',		'melodyschool'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'melodyschool'),
				'fadeOut'			=> esc_html__('Fade Out',			'melodyschool'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',			'melodyschool'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'melodyschool'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'melodyschool'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'melodyschool'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',		'melodyschool'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'melodyschool'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'melodyschool'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'melodyschool'),
				'flipOutX'			=> esc_html__('Flip Out X',			'melodyschool'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'melodyschool'),
				'hinge'				=> esc_html__('Hinge Out',			'melodyschool'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',		'melodyschool'),
				'rotateOut'			=> esc_html__('Rotate Out',			'melodyschool'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'melodyschool'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',		'melodyschool'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'melodyschool'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'melodyschool'),
				'rollOut'			=> esc_html__('Roll Out',		'melodyschool'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'melodyschool'),
				'slideOutDown'		=> esc_html__('Slide Out Down',	'melodyschool'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',	'melodyschool'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'melodyschool'),
				'zoomOut'			=> esc_html__('Zoom Out',			'melodyschool'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'melodyschool'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',	'melodyschool'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'melodyschool'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',	'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_animations_out', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('melodyschool_get_animation_classes')) {
	function melodyschool_get_animation_classes($animation, $speed='normal', $loop='none') {
		return melodyschool_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!melodyschool_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of categories
if ( !function_exists( 'melodyschool_get_list_categories' ) ) {
	function melodyschool_get_list_categories($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'melodyschool_get_list_terms' ) ) {
	function melodyschool_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = melodyschool_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = melodyschool_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'melodyschool_get_list_posts_types' ) ) {
	function melodyschool_get_list_posts_types($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('melodyschool_filter_list_post_types', array());
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'melodyschool_get_list_posts' ) ) {
	function melodyschool_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = melodyschool_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'melodyschool');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set($hash, $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'melodyschool_get_list_pages' ) ) {
	function melodyschool_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return melodyschool_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'melodyschool_get_list_users' ) ) {
	function melodyschool_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = melodyschool_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'melodyschool');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_users', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'melodyschool_get_list_sliders' ) ) {
	function melodyschool_get_list_sliders($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_list_sliders', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'melodyschool_get_list_slider_controls' ) ) {
	function melodyschool_get_list_slider_controls($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'melodyschool'),
				'side'		=> esc_html__('Side', 'melodyschool'),
				'bottom'	=> esc_html__('Bottom', 'melodyschool'),
				'pagination'=> esc_html__('Pagination', 'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_slider_controls', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'melodyschool_get_slider_controls_classes' ) ) {
	function melodyschool_get_slider_controls_classes($controls) {
		if (melodyschool_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'melodyschool_get_list_popup_engines' ) ) {
	function melodyschool_get_list_popup_engines($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'melodyschool'),
				"magnific"	=> esc_html__("Magnific popup", 'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_popup_engines', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_menus' ) ) {
	function melodyschool_get_list_menus($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'melodyschool');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'melodyschool_get_list_sidebars' ) ) {
	function melodyschool_get_list_sidebars($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_sidebars'))=='') {
			if (($list = melodyschool_storage_get('registered_sidebars'))=='') $list = array();
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'melodyschool_get_list_sidebars_positions' ) ) {
	function melodyschool_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'melodyschool'),
				'left'  => esc_html__('Left',  'melodyschool'),
				'right' => esc_html__('Right', 'melodyschool')
				);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'melodyschool_get_sidebar_class' ) ) {
	function melodyschool_get_sidebar_class() {
		$sb_main = melodyschool_get_custom_option('show_sidebar_main');
		$sb_outer = melodyschool_get_custom_option('show_sidebar_outer');
		return (melodyschool_param_is_off($sb_main) || !is_active_sidebar(melodyschool_get_custom_option('sidebar_main')) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (melodyschool_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_body_styles' ) ) {
	function melodyschool_get_list_body_styles($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'melodyschool'),
				'wide'	=> esc_html__('Wide',		'melodyschool')
				);
			if (melodyschool_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'melodyschool');
				$list['fullscreen']	= esc_html__('Fullscreen',	'melodyschool');
			}
			$list = apply_filters('melodyschool_filter_list_body_styles', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return css-themes list
if ( !function_exists( 'melodyschool_get_list_themes' ) ) {
	function melodyschool_get_list_themes($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_themes'))=='') {
			$list = melodyschool_get_list_files("css/themes");
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_themes', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_templates' ) ) {
	function melodyschool_get_list_templates($mode='') {
		if (($list = melodyschool_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = melodyschool_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: melodyschool_strtoproper($v['layout'])
										);
				}
			}
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_templates_blog' ) ) {
	function melodyschool_get_list_templates_blog($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_templates_blog'))=='') {
			$list = melodyschool_get_list_templates('blog');
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_templates_blogger' ) ) {
	function melodyschool_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_templates_blogger'))=='') {
			$list = melodyschool_array_merge(melodyschool_get_list_templates('blogger'), melodyschool_get_list_templates('blog'));
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_templates_single' ) ) {
	function melodyschool_get_list_templates_single($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_templates_single'))=='') {
			$list = melodyschool_get_list_templates('single');
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_templates_header' ) ) {
	function melodyschool_get_list_templates_header($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_templates_header'))=='') {
			$list = melodyschool_get_list_templates('header');
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_templates_forms' ) ) {
	function melodyschool_get_list_templates_forms($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_templates_forms'))=='') {
			$list = melodyschool_get_list_templates('forms');
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_article_styles' ) ) {
	function melodyschool_get_list_article_styles($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'melodyschool'),
				"stretch" => esc_html__('Stretch', 'melodyschool')
				);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_post_formats_filters' ) ) {
	function melodyschool_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'melodyschool'),
				"thumbs"  => esc_html__('With thumbs', 'melodyschool'),
				"reviews" => esc_html__('With reviews', 'melodyschool'),
				"video"   => esc_html__('With videos', 'melodyschool'),
				"audio"   => esc_html__('With audios', 'melodyschool'),
				"gallery" => esc_html__('With galleries', 'melodyschool')
				);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_portfolio_filters' ) ) {
	function melodyschool_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'melodyschool'),
				"tags"		=> esc_html__('Tags', 'melodyschool'),
				"categories"=> esc_html__('Categories', 'melodyschool')
				);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_hovers' ) ) {
	function melodyschool_get_list_hovers($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'melodyschool');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'melodyschool');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'melodyschool');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'melodyschool');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'melodyschool');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'melodyschool');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'melodyschool');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'melodyschool');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'melodyschool');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'melodyschool');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'melodyschool');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'melodyschool');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'melodyschool');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'melodyschool');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'melodyschool');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'melodyschool');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'melodyschool');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'melodyschool');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'melodyschool');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'melodyschool');
			$list['square effect1']  = esc_html__('Square Effect 1',  'melodyschool');
			$list['square effect2']  = esc_html__('Square Effect 2',  'melodyschool');
			$list['square effect3']  = esc_html__('Square Effect 3',  'melodyschool');
			$list['square effect5']  = esc_html__('Square Effect 5',  'melodyschool');
			$list['square effect6']  = esc_html__('Square Effect 6',  'melodyschool');
			$list['square effect7']  = esc_html__('Square Effect 7',  'melodyschool');
			$list['square effect8']  = esc_html__('Square Effect 8',  'melodyschool');
			$list['square effect9']  = esc_html__('Square Effect 9',  'melodyschool');
			$list['square effect10'] = esc_html__('Square Effect 10',  'melodyschool');
			$list['square effect11'] = esc_html__('Square Effect 11',  'melodyschool');
			$list['square effect12'] = esc_html__('Square Effect 12',  'melodyschool');
			$list['square effect13'] = esc_html__('Square Effect 13',  'melodyschool');
			$list['square effect14'] = esc_html__('Square Effect 14',  'melodyschool');
			$list['square effect15'] = esc_html__('Square Effect 15',  'melodyschool');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'melodyschool');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'melodyschool');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'melodyschool');
			$list['square effect_more']  = esc_html__('Square Effect More',  'melodyschool');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'melodyschool');
			$list = apply_filters('melodyschool_filter_portfolio_hovers', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'melodyschool_get_list_blog_counters' ) ) {
	function melodyschool_get_list_blog_counters($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'melodyschool'),
				'likes'		=> esc_html__('Likes', 'melodyschool'),
				'rating'	=> esc_html__('Rating', 'melodyschool'),
				'comments'	=> esc_html__('Comments', 'melodyschool')
				);
			$list = apply_filters('melodyschool_filter_list_blog_counters', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'melodyschool_get_list_alter_sizes' ) ) {
	function melodyschool_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'melodyschool'),
					'1_2' => esc_html__('1x2', 'melodyschool'),
					'2_1' => esc_html__('2x1', 'melodyschool'),
					'2_2' => esc_html__('2x2', 'melodyschool'),
					'1_3' => esc_html__('1x3', 'melodyschool'),
					'2_3' => esc_html__('2x3', 'melodyschool'),
					'3_1' => esc_html__('3x1', 'melodyschool'),
					'3_2' => esc_html__('3x2', 'melodyschool'),
					'3_3' => esc_html__('3x3', 'melodyschool')
					);
			$list = apply_filters('melodyschool_filter_portfolio_alter_sizes', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_hovers_directions' ) ) {
	function melodyschool_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'melodyschool'),
				'right_to_left' => esc_html__('Right to Left',  'melodyschool'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'melodyschool'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'melodyschool'),
				'scale_up'      => esc_html__('Scale Up',  'melodyschool'),
				'scale_down'    => esc_html__('Scale Down',  'melodyschool'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'melodyschool'),
				'from_left_and_right' => esc_html__('From Left and Right',  'melodyschool'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_portfolio_hovers_directions', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'melodyschool_get_list_label_positions' ) ) {
	function melodyschool_get_list_label_positions($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'melodyschool'),
				'bottom'	=> esc_html__('Bottom',		'melodyschool'),
				'left'		=> esc_html__('Left',		'melodyschool'),
				'over'		=> esc_html__('Over',		'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_label_positions', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'melodyschool_get_list_bg_image_positions' ) ) {
	function melodyschool_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'melodyschool'),
				'center top'   => esc_html__("Center Top", 'melodyschool'),
				'right top'    => esc_html__("Right Top", 'melodyschool'),
				'left center'  => esc_html__("Left Center", 'melodyschool'),
				'center center'=> esc_html__("Center Center", 'melodyschool'),
				'right center' => esc_html__("Right Center", 'melodyschool'),
				'left bottom'  => esc_html__("Left Bottom", 'melodyschool'),
				'center bottom'=> esc_html__("Center Bottom", 'melodyschool'),
				'right bottom' => esc_html__("Right Bottom", 'melodyschool')
			);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'melodyschool_get_list_bg_image_repeats' ) ) {
	function melodyschool_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'melodyschool'),
				'repeat-x'	=> esc_html__('Repeat X', 'melodyschool'),
				'repeat-y'	=> esc_html__('Repeat Y', 'melodyschool'),
				'no-repeat'	=> esc_html__('No Repeat', 'melodyschool')
			);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'melodyschool_get_list_bg_image_attachments' ) ) {
	function melodyschool_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'melodyschool'),
				'fixed'		=> esc_html__('Fixed', 'melodyschool'),
				'local'		=> esc_html__('Local', 'melodyschool')
			);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'melodyschool_get_list_bg_tints' ) ) {
	function melodyschool_get_list_bg_tints($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'melodyschool'),
				'light'	=> esc_html__('Light', 'melodyschool'),
				'dark'	=> esc_html__('Dark', 'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_bg_tints', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_field_types' ) ) {
	function melodyschool_get_list_field_types($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'melodyschool'),
				'textarea' => esc_html__('Text Area','melodyschool'),
				'password' => esc_html__('Password',  'melodyschool'),
				'radio'    => esc_html__('Radio',  'melodyschool'),
				'checkbox' => esc_html__('Checkbox',  'melodyschool'),
				'select'   => esc_html__('Select',  'melodyschool'),
				'date'     => esc_html__('Date','melodyschool'),
				'time'     => esc_html__('Time','melodyschool'),
				'button'   => esc_html__('Button','melodyschool')
			);
			$list = apply_filters('melodyschool_filter_field_types', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'melodyschool_get_list_googlemap_styles' ) ) {
	function melodyschool_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_googlemap_styles', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'melodyschool_get_list_icons' ) ) {
	function melodyschool_get_list_icons($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_icons'))=='') {
			$list = melodyschool_parse_icons_classes(melodyschool_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? array_merge(array('inherit'), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'melodyschool_get_list_socials' ) ) {
	function melodyschool_get_list_socials($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_socials'))=='') {
			$list = melodyschool_get_list_files("images/socials", "png");
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'melodyschool_get_list_flags' ) ) {
	function melodyschool_get_list_flags($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_flags'))=='') {
			$list = melodyschool_get_list_files("images/flags", "png");
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_flags', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'melodyschool_get_list_yesno' ) ) {
	function melodyschool_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'melodyschool'),
			'no'  => esc_html__("No", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'melodyschool_get_list_onoff' ) ) {
	function melodyschool_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'melodyschool'),
			"off" => esc_html__("Off", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'melodyschool_get_list_showhide' ) ) {
	function melodyschool_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'melodyschool'),
			"hide" => esc_html__("Hide", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'melodyschool_get_list_orderings' ) ) {
	function melodyschool_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'melodyschool'),
			"desc" => esc_html__("Descending", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'melodyschool_get_list_directions' ) ) {
	function melodyschool_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'melodyschool'),
			"vertical" => esc_html__("Vertical", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'melodyschool_get_list_shapes' ) ) {
	function melodyschool_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'melodyschool'),
			"square" => esc_html__("Square", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'melodyschool_get_list_sizes' ) ) {
	function melodyschool_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'melodyschool'),
			"small"  => esc_html__("Small", 'melodyschool'),
			"medium" => esc_html__("Medium", 'melodyschool'),
			"large"  => esc_html__("Large", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'melodyschool_get_list_controls' ) ) {
	function melodyschool_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'melodyschool'),
			"side" => esc_html__("Side", 'melodyschool'),
			"bottom" => esc_html__("Bottom", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'melodyschool_get_list_floats' ) ) {
	function melodyschool_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'melodyschool'),
			"left" => esc_html__("Float Left", 'melodyschool'),
			"right" => esc_html__("Float Right", 'melodyschool')
		);
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'melodyschool_get_list_alignments' ) ) {
	function melodyschool_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'melodyschool'),
			"left" => esc_html__("Left", 'melodyschool'),
			"center" => esc_html__("Center", 'melodyschool'),
			"right" => esc_html__("Right", 'melodyschool')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'melodyschool');
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'melodyschool_get_list_hpos' ) ) {
	function melodyschool_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'melodyschool');
		if ($center) $list['center'] = esc_html__("Center", 'melodyschool');
		$list['right'] = esc_html__("Right", 'melodyschool');
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'melodyschool_get_list_vpos' ) ) {
	function melodyschool_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'melodyschool');
		if ($center) $list['center'] = esc_html__("Center", 'melodyschool');
		$list['bottom'] = esc_html__("Bottom", 'melodyschool');
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'melodyschool_get_list_sortings' ) ) {
	function melodyschool_get_list_sortings($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'melodyschool'),
				"title" => esc_html__("Alphabetically", 'melodyschool'),
				"views" => esc_html__("Popular (views count)", 'melodyschool'),
				"comments" => esc_html__("Most commented (comments count)", 'melodyschool'),
				"author_rating" => esc_html__("Author rating", 'melodyschool'),
				"users_rating" => esc_html__("Visitors (users) rating", 'melodyschool'),
				"random" => esc_html__("Random", 'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_list_sortings', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'melodyschool_get_list_columns' ) ) {
	function melodyschool_get_list_columns($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'melodyschool'),
				"1_1" => esc_html__("100%", 'melodyschool'),
				"1_2" => esc_html__("1/2", 'melodyschool'),
				"1_3" => esc_html__("1/3", 'melodyschool'),
				"2_3" => esc_html__("2/3", 'melodyschool'),
				"1_4" => esc_html__("1/4", 'melodyschool'),
				"3_4" => esc_html__("3/4", 'melodyschool'),
				"1_5" => esc_html__("1/5", 'melodyschool'),
				"2_5" => esc_html__("2/5", 'melodyschool'),
				"3_5" => esc_html__("3/5", 'melodyschool'),
				"4_5" => esc_html__("4/5", 'melodyschool'),
				"1_6" => esc_html__("1/6", 'melodyschool'),
				"5_6" => esc_html__("5/6", 'melodyschool'),
				"1_7" => esc_html__("1/7", 'melodyschool'),
				"2_7" => esc_html__("2/7", 'melodyschool'),
				"3_7" => esc_html__("3/7", 'melodyschool'),
				"4_7" => esc_html__("4/7", 'melodyschool'),
				"5_7" => esc_html__("5/7", 'melodyschool'),
				"6_7" => esc_html__("6/7", 'melodyschool'),
				"1_8" => esc_html__("1/8", 'melodyschool'),
				"3_8" => esc_html__("3/8", 'melodyschool'),
				"5_8" => esc_html__("5/8", 'melodyschool'),
				"7_8" => esc_html__("7/8", 'melodyschool'),
				"1_9" => esc_html__("1/9", 'melodyschool'),
				"2_9" => esc_html__("2/9", 'melodyschool'),
				"4_9" => esc_html__("4/9", 'melodyschool'),
				"5_9" => esc_html__("5/9", 'melodyschool'),
				"7_9" => esc_html__("7/9", 'melodyschool'),
				"8_9" => esc_html__("8/9", 'melodyschool'),
				"1_10"=> esc_html__("1/10", 'melodyschool'),
				"3_10"=> esc_html__("3/10", 'melodyschool'),
				"7_10"=> esc_html__("7/10", 'melodyschool'),
				"9_10"=> esc_html__("9/10", 'melodyschool'),
				"1_11"=> esc_html__("1/11", 'melodyschool'),
				"2_11"=> esc_html__("2/11", 'melodyschool'),
				"3_11"=> esc_html__("3/11", 'melodyschool'),
				"4_11"=> esc_html__("4/11", 'melodyschool'),
				"5_11"=> esc_html__("5/11", 'melodyschool'),
				"6_11"=> esc_html__("6/11", 'melodyschool'),
				"7_11"=> esc_html__("7/11", 'melodyschool'),
				"8_11"=> esc_html__("8/11", 'melodyschool'),
				"9_11"=> esc_html__("9/11", 'melodyschool'),
				"10_11"=> esc_html__("10/11", 'melodyschool'),
				"1_12"=> esc_html__("1/12", 'melodyschool'),
				"5_12"=> esc_html__("5/12", 'melodyschool'),
				"7_12"=> esc_html__("7/12", 'melodyschool'),
				"10_12"=> esc_html__("10/12", 'melodyschool'),
				"11_12"=> esc_html__("11/12", 'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_list_columns', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'melodyschool_get_list_dedicated_locations' ) ) {
	function melodyschool_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'melodyschool'),
				"center"  => esc_html__('Above the text of the post', 'melodyschool'),
				"left"    => esc_html__('To the left the text of the post', 'melodyschool'),
				"right"   => esc_html__('To the right the text of the post', 'melodyschool'),
				"alter"   => esc_html__('Alternates for each post', 'melodyschool')
			);
			$list = apply_filters('melodyschool_filter_list_dedicated_locations', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'melodyschool_get_post_format_name' ) ) {
	function melodyschool_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'melodyschool') : esc_html__('galleries', 'melodyschool');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'melodyschool') : esc_html__('videos', 'melodyschool');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'melodyschool') : esc_html__('audios', 'melodyschool');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'melodyschool') : esc_html__('images', 'melodyschool');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'melodyschool') : esc_html__('quotes', 'melodyschool');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'melodyschool') : esc_html__('links', 'melodyschool');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'melodyschool') : esc_html__('statuses', 'melodyschool');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'melodyschool') : esc_html__('asides', 'melodyschool');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'melodyschool') : esc_html__('chats', 'melodyschool');
		else						$name = $single ? esc_html__('standard', 'melodyschool') : esc_html__('standards', 'melodyschool');
		return apply_filters('melodyschool_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'melodyschool_get_post_format_icon' ) ) {
	function melodyschool_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('melodyschool_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'melodyschool_get_list_fonts_styles' ) ) {
	function melodyschool_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','melodyschool'),
				'u' => esc_html__('U', 'melodyschool')
			);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'melodyschool_get_list_fonts' ) ) {
	function melodyschool_get_list_fonts($prepend_inherit=false) {
		if (($list = melodyschool_storage_get('list_fonts'))=='') {
			$list = array();
			$list = melodyschool_array_merge($list, melodyschool_get_list_font_faces());
			// Google and custom fonts list:
			$list = melodyschool_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('melodyschool_filter_list_fonts', $list);
			if (melodyschool_get_theme_setting('use_list_cache')) melodyschool_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? melodyschool_array_merge(array('inherit' => esc_html__("Inherit", 'melodyschool')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'melodyschool_get_list_font_faces' ) ) {
	function melodyschool_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$list = array();
		$dir = melodyschool_get_folder_dir("css/font-face");
        if ( is_dir($dir) ) {
            $files = glob(sprintf("%s/*", $dir), GLOB_ONLYDIR);
            if ( is_array($files) ) {
                foreach ($files as $file) {
                    $file_name = basename($file);
                    if ( substr($file_name, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file_name) ) )
                        continue;
                    $css = file_exists( ($dir) . '/' . ($file_name) . '/' . ($file_name) . '.css' )
                        ? melodyschool_get_file_url("css/font-face/".($file_name).'/'.($file_name).'.css')
                        : (file_exists( ($dir) . '/' . ($file_name) . '/stylesheet.css' )
                            ? melodyschool_get_file_url("css/font-face/".($file_name).'/stylesheet.css')
                            : '');
                    if ($css != '')
                        $list[$file_name.' ('.esc_html__('uploaded font', 'melodyschool').')'] = array('css' => $css);
                }
            }
        }
        return $list;
	}
}


// Autoload templates, widgets, etc.
// Scan subfolders and require() file with same name in each folder
if (!function_exists('melodyschool_autoload_folder')) {
    function melodyschool_autoload_folder($folder, $from_subfolders=true, $from_skin=true) {
        static $skin_dir = '';
        if ($folder[0]=='/') $folder = melodyschool_substr($folder, 1);
        if ($from_skin && empty($skin_dir) && function_exists('melodyschool_get_custom_option')) {
            $skin_dir = sanitize_file_name(melodyschool_get_custom_option('theme_skin'));
            if ($skin_dir) $skin_dir  = 'skins/'.($skin_dir);
        } else
            $skin_dir = '-no-skins-';
        $theme_dir = get_template_directory();
        $child_dir = get_stylesheet_directory();
        $dirs = array(
            ($child_dir).'/'.($skin_dir).'/'.($folder),
            ($child_dir).'/'.($folder),
            ($child_dir).(MELODYSCHOOL_FW_DIR).($folder),
            ($theme_dir).'/'.($skin_dir).'/'.($folder),
            ($theme_dir).'/'.($folder),
            ($theme_dir).(MELODYSCHOOL_FW_DIR).($folder)
        );
        $loaded = array();
        foreach($dirs as $dir) {
            if ( is_dir($dir) ) {
                $files = glob(sprintf("%s/*", $dir));
                if ( is_array($files) ) {
                    foreach ($files as $file) {
                        if (substr($file, 0, 1) == '.' || in_array($file, $loaded)){
                            continue;
                        }
                        if ( is_dir( ($file) ) ) {
                            $file_name = basename($file);
                            if ($from_subfolders && file_exists( $file . '/' . ($file_name) . '.php' ) ) {
                                $loaded[] = $file . '/' . ($file_name) . '.php';
                                require_once( $file . '/' . ($file_name) . '.php' );
                            }
                        } else {
                            $loaded[] = $file;
                            require_once( $file );
                        }
                    }
                }
            }
        }
    }
}
?>