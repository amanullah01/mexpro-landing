<?php
// Get template args
extract(melodyschool_template_get_args('counters'));

$show_all_counters = !isset($post_options['counters']);
$counters_tag = is_single() ? 'span' : 'a';

// Views
if ($show_all_counters || melodyschool_strpos($post_options['counters'], 'views')!==false && function_exists('trx_utils_get_post_views')) {
	?>
	<<?php melodyschool_show_layout($counters_tag); ?> class="post_counters_item post_counters_views icon-eye" title="<?php echo esc_attr( sprintf(esc_html__('Views - %s', 'melodyschool'), $post_data['post_views']) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php  echo esc_html($post_data['post_views']); ?></span><?php if (melodyschool_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Views', 'melodyschool'); ?></<?php melodyschool_show_layout($counters_tag); ?>>
	<?php
}

// Comments
if ($show_all_counters || melodyschool_strpos($post_options['counters'], 'comments')!==false) {
	?>
	<a class="post_counters_item post_counters_comments icon-comment" title="<?php echo esc_attr( sprintf( esc_html__('Comments - %s', 'melodyschool'), $post_data['post_comments']) ); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="post_counters_number"><?php  echo esc_html($post_data['post_comments']); echo ' '.esc_html__('comments', 'melodyschool');?></span><?php if (melodyschool_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Comments', 'melodyschool'); ?></a>
	<?php 
}
 
// Rating
$rating = $post_data['post_reviews_'.(melodyschool_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters || melodyschool_strpos($post_options['counters'], 'rating')!==false)) { 
	?>
	<<?php melodyschool_show_layout($counters_tag); ?> class="post_counters_item post_counters_rating icon-star" title="<?php echo esc_attr( sprintf(esc_html__('Rating - %s', 'melodyschool'), $rating) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php  echo esc_html($rating); ?></span></<?php melodyschool_show_layout($counters_tag); ?>>
	<?php
}

// Likes
if ($show_all_counters || melodyschool_strpos($post_options['counters'], 'likes')!==false && function_exists('trx_utils_get_post_likes')) {
	// Load core messages
	melodyschool_enqueue_messages();
	$likes = isset($_COOKIE['melodyschool_likes']) ? melodyschool_get_value_gpc('melodyschool_likes') : '';
	$allow = melodyschool_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart <?php echo !empty($allow) ? 'enabled' : 'disabled'; ?>" title="<?php echo !empty($allow) ? esc_attr__('Like', 'melodyschool') : esc_attr__('Dislike', 'melodyschool'); ?>" href="#"
		data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
		data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
		data-title-like="<?php esc_attr_e('Like', 'melodyschool'); ?>"
		data-title-dislike="<?php esc_attr_e('Dislike', 'melodyschool'); ?>"><span class="post_counters_number"><?php  echo esc_html($post_data['post_likes']); ?></span><?php if (melodyschool_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Likes', 'melodyschool'); ?></a>
	<?php
}

// Edit page link
if (melodyschool_strpos($post_options['counters'], 'edit')!==false) {
	edit_post_link( esc_html__( 'Edit', 'melodyschool' ), '<span class="post_edit edit-link">', '</span>' );
}

// Markup for search engines
if (is_single() && melodyschool_strpos($post_options['counters'], 'markup')!==false) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(melodyschool_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(melodyschool_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>