<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'melodyschool_template_team_1_theme_setup' ) ) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_template_team_1_theme_setup', 1 );
	function melodyschool_template_team_1_theme_setup() {
		melodyschool_add_template(array(
			'layout' => 'team-1',
			'template' => 'team-1',
			'mode'   => 'team',
			'title'  => esc_html__('Team /Style 1/', 'melodyschool'),
			'thumb_title'  => esc_html__('Medium square image (crop)', 'melodyschool'),
			'w' => 370,
			'h' => 370
		));
	}
}

// Template output
if ( !function_exists( 'melodyschool_template_team_1_output' ) ) {
	function melodyschool_template_team_1_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
		if (melodyschool_param_is_on($post_options['slider'])) {
			?><div class="swiper-slide" data-style="<?php echo esc_attr($post_options['tag_css_wh']); ?>" style="<?php echo esc_attr($post_options['tag_css_wh']); ?>"><?php
		} else if ($columns > 1) {
			?><div class="column-1_<?php echo esc_attr($columns); ?> column_padding_bottom"><?php
		}
		?>
			<div<?php echo !empty($post_options['tag_id']) ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''; ?>
				class="sc_team_item sc_team_item_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : '') . (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"
				<?php echo (!empty($post_options['tag_css']) ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
					. (!melodyschool_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(melodyschool_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>>
				<div class="sc_team_item_avatar"><?php melodyschool_show_layout($post_options['photo']); ?></div>
				<div class="sc_team_item_info">
                    <?php
                    if(!isset($post_data['post_id'])) $post_data['post_id']=1;
                    $custom_team_title = (!empty($post_data['post_title'])) ?  $post_data['post_title'] : melodyschool_get_post_title($post_data['post_id']);
                    ?>
                    <h3 class="sc_team_item_title"><?php echo (!empty($post_options['link']) ? '<a href="'. esc_url($post_options['link']) .'">' : '') . $custom_team_title . (!empty($post_options['link']) ? '</a>' : ''); ?></h3>
                    <div class="sc_team_item_position">
                        <p><?php melodyschool_show_layout($post_options['position']);?></p>
                        <a href="mailto:<?php echo antispambot($post_options['email']);?>"><?php melodyschool_show_layout($post_options['email']);?></a>
                    </div>
					<?php melodyschool_show_layout($post_options['socials']); ?>
				</div>
			</div>
		<?php
		if (melodyschool_param_is_on($post_options['slider']) || $columns > 1) {
			?></div><?php
		}
	}
}
?>