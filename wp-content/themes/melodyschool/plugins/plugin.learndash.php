<?php
/* LearnDash LMS support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('melodyschool_learndash_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_learndash_theme_setup', 1 );
	function melodyschool_learndash_theme_setup() {

		// Register shortcode in the shortcodes list
		if (melodyschool_exists_learndash()) {

			// Change slugs for courses and lessons to compatibility with built-in courses and lessons
			add_filter('learndash_post_args',					'melodyschool_learndash_post_args');

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('melodyschool_filter_get_blog_type',			'melodyschool_learndash_get_blog_type', 9, 2);
			add_filter('melodyschool_filter_get_blog_title',		'melodyschool_learndash_get_blog_title', 9, 2);
			add_filter('melodyschool_filter_get_parent_id',			'melodyschool_learndash_get_parent_course_id', 9, 2);
			add_filter('melodyschool_filter_get_current_taxonomy',	'melodyschool_learndash_get_current_taxonomy', 9, 2);
			add_filter('melodyschool_filter_is_taxonomy',			'melodyschool_learndash_is_taxonomy', 9, 2);
			add_filter('melodyschool_filter_get_stream_page_title',	'melodyschool_learndash_get_stream_page_title', 9, 2);
			add_filter('melodyschool_filter_get_stream_page_link',	'melodyschool_learndash_get_stream_page_link', 9, 2);
			add_filter('melodyschool_filter_get_stream_page_id',	'melodyschool_learndash_get_stream_page_id', 9, 2);
			add_filter('melodyschool_filter_query_add_filters',		'melodyschool_learndash_query_add_filters', 9, 2);
			add_filter('melodyschool_filter_detect_inheritance_key','melodyschool_learndash_detect_inheritance_key', 9, 1);

			add_action('melodyschool_action_add_styles',			'melodyschool_learndash_frontend_scripts');

			add_filter('melodyschool_filter_list_post_types', 		'melodyschool_learndash_list_post_types', 10, 1);

			// Get list post_types and taxonomies
			melodyschool_storage_set('learndash_post_types', array('sfwd-courses', 'sfwd-lessons', 'sfwd-quiz', 'sfwd-topic', 'sfwd-certificates', 'sfwd-transactions'));
			melodyschool_storage_set('learndash_taxonomies', array('category'));
		}
		if (is_admin()) {
			add_filter( 'melodyschool_filter_required_plugins',				'melodyschool_learndash_required_plugins' );
		}
	}
}

// Attention! Add action on 'init' instead 'before_init_theme' because LearnDash add post_types and taxonomies on this action
if ( !function_exists( 'melodyschool_learndash_settings_theme_setup2' ) ) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_learndash_settings_theme_setup2', 3 );
	//Handler of add_action( 'init', 'melodyschool_learndash_settings_theme_setup2', 20 );
	function melodyschool_learndash_settings_theme_setup2() {
		// Add LearnDash post type and taxonomy into theme inheritance list
		if (melodyschool_exists_learndash()) {
			// Get list post_types and taxonomies
			if (!empty(SFWD_CPT_Instance::$instances) && count(SFWD_CPT_Instance::$instances) > 0) {
				$post_types = array();
				foreach (SFWD_CPT_Instance::$instances as $pt=>$data)
					$post_types[] = $pt;
				if (count($post_types) > 0)
					melodyschool_storage_set('learndash_post_types', $post_types);
			}
			// Add in the inheritance list
			melodyschool_add_theme_inheritance( array('learndash' => array(
				'stream_template' => 'blog-learndash',
				'single_template' => 'single-learndash',
				'taxonomy' => melodyschool_storage_get('learndash_taxonomies'),
				'taxonomy_tags' => array('post_tag'),
				'post_type' => melodyschool_storage_get('learndash_post_types'),
				'override' => 'custom'
				) )
			);
		}
	}
}



if ( !function_exists( 'melodyschool_exists_learndash' ) ) {
	function melodyschool_exists_learndash() {
		return class_exists('SFWD_LMS');
	}
}


// Return true, if current page is donations page
if ( !function_exists( 'melodyschool_is_learndash_page' ) ) {
	function melodyschool_is_learndash_page() {
		$is = false;
		if (melodyschool_exists_learndash()) {
			$is = in_array(melodyschool_storage_get('page_template'), array('blog-learndash', 'single-learndash'));
			if (!$is) {
				$is = !melodyschool_storage_empty('pre_query')
							? melodyschool_storage_call_obj_method('pre_query', 'is_single') && in_array(melodyschool_storage_call_obj_method('pre_query', 'get', 'post_type'), melodyschool_storage_get('learndash_post_types'))
							: is_single() && in_array(get_query_var('post_type'), melodyschool_storage_get('learndash_post_types'));
			}
			if (!$is) {
				$post_types = melodyschool_storage_get('learndash_post_types');
				if (count($post_types) > 0) {
					foreach ($post_types as $pt) {
						if (!melodyschool_storage_empty('pre_query') ? melodyschool_storage_call_obj_method('pre_query', 'is_post_type_archive', $pt) : is_post_type_archive($pt)) {
							$is = true;
							break;
						}
					}
				}
			}
			if (!$is) {
				$taxes = melodyschool_storage_get('learndash_taxonomies');
				if (count($taxes) > 0) {
					foreach ($taxes as $pt) {
						if (!melodyschool_storage_empty('pre_query') ? melodyschool_storage_call_obj_method('pre_query', 'is_tax', $pt) : is_tax($pt)) {
							$is = true;
							break;
						}
					}
				}
			}
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'melodyschool_learndash_detect_inheritance_key' ) ) {
	//Handler of add_filter('melodyschool_filter_detect_inheritance_key',	'melodyschool_learndash_detect_inheritance_key', 9, 1);
	function melodyschool_learndash_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return melodyschool_is_learndash_page() ? 'learndash' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'melodyschool_learndash_get_blog_type' ) ) {
	//Handler of add_filter('melodyschool_filter_get_blog_type',	'melodyschool_learndash_get_blog_type', 9, 2);
	function melodyschool_learndash_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		$taxes = melodyschool_storage_get('learndash_taxonomies');
		if (count($taxes) > 0) {
			foreach ($taxes as $pt) {
				if ($query && $query->is_tax($pt) || is_tax($pt)) {
					$page = 'learndash_'.$pt;
					break;
				}
			}
		}
		if (empty($page)) {
			$pt = $query ? $query->get('post_type') : get_query_var('post_type');
			if (in_array($pt, melodyschool_storage_get('learndash_post_types'))) {
				$page = $query && $query->is_single() || is_single() ? 'learndash_item' : 'learndash';
			}
		}
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'melodyschool_learndash_get_blog_title' ) ) {
	//Handler of add_filter('melodyschool_filter_get_blog_title',	'melodyschool_learndash_get_blog_title', 9, 2);
	function melodyschool_learndash_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( melodyschool_strpos($page, 'learndash')!==false ) {
			if ( $page == 'learndash_item' ) {
				$title = melodyschool_get_post_title();
			} else if ( melodyschool_strpos($page, 'learndash_')!==false ) {
				$parts = explode('_', $page);
				$term = get_term_by( 'slug', get_query_var( $parts[1] ), $parts[1], OBJECT);
				$title = $term->name;
			} else {
				$title = esc_html__('All courses', 'melodyschool');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'melodyschool_learndash_get_stream_page_title' ) ) {
	//Handler of add_filter('melodyschool_filter_get_stream_page_title',	'melodyschool_learndash_get_stream_page_title', 9, 2);
	function melodyschool_learndash_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (melodyschool_strpos($page, 'learndash')!==false) {
			if (($page_id = melodyschool_learndash_get_stream_page_id(0, $page=='learndash' ? 'blog-learndash' : $page)) > 0)
				$title = melodyschool_get_post_title($page_id);
			else
				$title = esc_html__('All courses', 'melodyschool');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'melodyschool_learndash_get_stream_page_id' ) ) {
	//Handler of add_filter('melodyschool_filter_get_stream_page_id',	'melodyschool_learndash_get_stream_page_id', 9, 2);
	function melodyschool_learndash_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (melodyschool_strpos($page, 'learndash')!==false) $id = melodyschool_get_template_page_id('blog-learndash');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'melodyschool_learndash_get_stream_page_link' ) ) {
	//Handler of add_filter('melodyschool_filter_get_stream_page_link',	'melodyschool_learndash_get_stream_page_link', 9, 2);
	function melodyschool_learndash_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (melodyschool_strpos($page, 'learndash')!==false) {
			$id = melodyschool_get_template_page_id('blog-learndash');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to get course ID for current lesson
if ( !function_exists( 'melodyschool_learndash_get_parent_course_id' ) ) {
	//Handler of add_filter('melodyschool_filter_get_parent_id',	'melodyschool_learndash_get_parent_course_id', 9, 2);
	function melodyschool_learndash_get_parent_course_id($id, $post_id) {
		if (!empty($id)) return $id;
		$pt = get_post_type($post_id);
		if ($pt=='sfwd-topic' || $pt=='sfwd-quiz') $id = get_post_meta($post_id, 'lesson_id', true);
		else if ($pt=='sfwd-lessons') $id = get_post_meta($post_id, 'course_id', true);
		return $id;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'melodyschool_learndash_get_current_taxonomy' ) ) {
	//Handler of add_filter('melodyschool_filter_get_current_taxonomy',	'melodyschool_learndash_get_current_taxonomy', 9, 2);
	function melodyschool_learndash_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( melodyschool_strpos($page, 'learndash')!==false ) {
			$taxes = melodyschool_storage_get('learndash_taxonomies');
			if (count($taxes) > 0) {
				$tax = $taxes[0];
			}
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'melodyschool_learndash_is_taxonomy' ) ) {
	//Handler of add_filter('melodyschool_filter_is_taxonomy',	'melodyschool_learndash_is_taxonomy', 9, 2);
	function melodyschool_learndash_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else {
			$taxes = melodyschool_storage_get('learndash_taxonomies');
			if (count($taxes) > 0) {
				foreach ($taxes as $pt) {
					if ($query && ($query->get($pt)!='' || $query->is_tax($pt)) || is_tax($pt)) {
						$tax = $pt;
						break;
					}
				}
			}
			return $tax;
		}
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'melodyschool_learndash_query_add_filters' ) ) {
	//Handler of add_filter('melodyschool_filter_query_add_filters',	'melodyschool_learndash_query_add_filters', 9, 2);
	function melodyschool_learndash_query_add_filters($args, $filter) {
		if ($filter == 'learndash') {
			$args['post_type'] = 'sfwd-courses';
		}
		return $args;
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'melodyschool_learndash_required_plugins' ) ) {
	//Handler of add_filter('melodyschool_filter_required_plugins',	'melodyschool_learndash_required_plugins');
	function melodyschool_learndash_required_plugins($list=array()) {
		if (in_array('learndash', melodyschool_storage_get('required_plugins'))) {
			$path = melodyschool_get_file_dir('plugins/install/sfwd-lms.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('LearnDash LMS', 'melodyschool'),
					'slug' 		=> 'sfwd-lms',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}

// Add custom post type into list
if ( !function_exists( 'melodyschool_learndash_list_post_types' ) ) {
	//Handler of add_filter('melodyschool_filter_list_post_types', 	'melodyschool_learndash_list_post_types', 10, 1);
	function melodyschool_learndash_list_post_types($list) {
		$list['sfwd-courses'] = esc_html__('Courses (LearnDash)', 'melodyschool');
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'melodyschool_learndash_frontend_scripts' ) ) {
	//Handler of add_action( 'melodyschool_action_add_styles', 'melodyschool_learndash_frontend_scripts' );
	function melodyschool_learndash_frontend_scripts() {
		if (file_exists(melodyschool_get_file_dir('css/plugin.learndash.css')))
			wp_enqueue_style( 'melodyschool-plugin-learndash-style',  melodyschool_get_file_url('css/plugin.learndash.css'), array(), null );
	}
}

// Change slugs for courses and lessons to compatibility with built-in courses and lessons
if ( !function_exists( 'melodyschool_learndash_post_args' ) ) {
	//Handler of add_filter('learndash_post_args',	'melodyschool_learndash_post_args');
	function melodyschool_learndash_post_args($args) {
		if (is_array($args) && count($args)>0) {
			$cnt = 0;
			for ($i=0; $i<count($args); $i++) {
				if (!empty($args[$i]['post_type']) && !empty($args[$i]['slug_name'])) {
					if ($args[$i]['post_type']=='sfwd-courses' && $args[$i]['slug_name']=='courses') {
						$args[$i]['slug_name']='sfwd-courses';
						$cnt++;
					}
					if ($args[$i]['post_type']=='sfwd-lessons' && $args[$i]['slug_name']=='lessons') {
						$args[$i]['slug_name']='sfwd-lessons';
						$cnt++;
					}
					if ($cnt==2) break;
				}
			}
		}
		return $args;
	}
}
?>