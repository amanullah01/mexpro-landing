<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'melodyschool_template_form_1_theme_setup' ) ) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_template_form_1_theme_setup', 1 );
	function melodyschool_template_form_1_theme_setup() {
		melodyschool_add_template(array(
			'layout' => 'form_1',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 1', 'melodyschool')
			));
	}
}

// Template output
if ( !function_exists( 'melodyschool_template_form_1_output' ) ) {
	function melodyschool_template_form_1_output($post_options, $post_data) {
		?>
		<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
			<?php melodyschool_sc_form_show_fields($post_options['fields']); ?>
			<div class="sc_form_info">
				<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'melodyschool'); ?></label><input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Name *', 'melodyschool'); ?>"></div>
                <div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_subj"><?php esc_html_e('Subject', 'melodyschool'); ?></label><input id="sc_form_subj" type="text" name="subject" placeholder="<?php esc_attr_e('Subject', 'melodyschool'); ?>"></div>
			</div>
            <div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'melodyschool'); ?></label><input id="sc_form_email" type="text" name="email" placeholder="<?php esc_attr_e('E-mail *', 'melodyschool'); ?>"></div>
			<div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'melodyschool'); ?></label><textarea id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Message *', 'melodyschool'); ?>"></textarea></div>

        <?php static $cnt = 0;
        $cnt++;
        $privacy = melodyschool_get_privacy_text();
        if (!empty($privacy)) {
        ?><div class="sc_form_field sc_form_field_checkbox"><?php
        ?><input type="checkbox" id="i_agree_privacy_policy_sc_form_<?php echo esc_attr($cnt); ?>" name="i_agree_privacy_policy" class="sc_form_privacy_checkbox" value="1">
        <label for="i_agree_privacy_policy_sc_form_<?php echo esc_attr($cnt); ?>"><?php trx_utils_show_layout($privacy); ?></label>
        </div><?php
    }
    ?><div class="sc_form_item sc_form_button sc_form_field sc_form_field_button sc_form_field_submit"><?php
    ?><button<?php
    if (!empty($privacy)) echo ' disabled="disabled"'
    ?> class="sc_button_size_medium"><?php
    if (!empty($args['button_caption']))
        echo esc_html($args['button_caption']);
    else
        esc_html_e('Send Message', 'melodyschool');
    ?></button>
    </div>
    <div class="result sc_infobox"></div>

    </form>
		<?php
	}
}
?>