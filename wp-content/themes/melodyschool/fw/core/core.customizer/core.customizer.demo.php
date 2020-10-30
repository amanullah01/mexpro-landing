<div class="to_demo_wrap">
	<a href="" class="to_demo_pin iconadmin-pin" title="<?php esc_attr_e('Pin/Unpin demo-block by the right side of the window', 'melodyschool'); ?>"></a>
	<div class="to_demo_body_wrap">
		<div class="to_demo_body">
            <h1 class="to_demo_header"><?php esc_html_e('Header with', 'melodyschool'); ?> <span class="to_demo_header_link"><?php esc_html_e('inner link', 'melodyschool'); ?></span> <?php esc_html_e('and it', 'melodyschool'); ?> <span class="to_demo_header_hover"><?php esc_html_e('hovered state', 'melodyschool'); ?></span></h1>
            <p class="to_demo_info"><?php esc_html_e('Posted', 'melodyschool'); ?> <span class="to_demo_info_link">12 <?php esc_html_e('May', 'melodyschool'); ?>, 2015</span> <?php esc_html_e('by', 'melodyschool'); ?> <span class="to_demo_info_hover"><?php esc_html_e('Author name hovered', 'melodyschool'); ?></span>.</p>
            <p class="to_demo_text"><?php esc_html_e('This is default post content. Colors of each text element are set based on the color you choose below.', 'melodyschool'); ?></p>
            <p class="to_demo_text"><span class="to_demo_text_link"><?php esc_html_e('link example', 'melodyschool'); ?></span> <?php esc_html_e('and', 'melodyschool'); ?> <span class="to_demo_text_hover"><?php esc_html_e('hovered link', 'melodyschool'); ?></span></p>

			<?php 
			$colors = melodyschool_storage_get('custom_colors');
			if (is_array($colors) && count($colors) > 0) {
				foreach ($colors as $slug=>$scheme) { 
					?>
                    <h3 class="to_demo_header"><?php esc_html_e('Accent colors', 'melodyschool'); ?></h3>
					<?php if (isset($scheme['text_link'])) { ?>
                        <div class="to_demo_columns3"><p class="to_demo_text"><span class="to_demo_text_link"><?php esc_html_e('text_link example', 'melodyschool'); ?></span><?php esc_html_e ('and', 'melodyschool' ); ?><span class="to_demo_text_hover"><?php esc_html_e('hovered text_link', 'melodyschool'); ?></span></p></div>
					<?php } ?>
					<?php if (isset($scheme['accent2'])) { ?>
                        <div class="to_demo_columns3"><p class="to_demo_text"><span class="to_demo_accent2"> <?php esc_html_e('accent2 example', 'melodyschool'); ?></span><?php esc_html_e ( 'and', 'melodyschool' ); ?><span class="to_demo_accent2_hover"><?php esc_html_e( 'hovered accent2', 'melodyschool'); ?></span></p></div>
					<?php } ?>
					<?php if (isset($scheme['accent3'])) { ?>
                        <div class="to_demo_columns3"><p class="to_demo_text"><span class="to_demo_accent3"><?php esc_html_e( 'accent3 example', 'melodyschool'); ?></span><?php esc_html_e ( 'and', 'melodyschool' ); ?><span class="to_demo_accent3_hover"><?php esc_html_e( 'hovered accent3', 'melodyschool'); ?></span></p></div>
					<?php } ?>

                    <h3 class="to_demo_header"><?php esc_html_e('Inverse colors (on accented backgrounds)', 'melodyschool'); ?></h3>
					<?php if (isset($scheme['text_link'])) { ?>
						<div class="to_demo_columns3 to_demo_text_link_bg to_demo_inverse_block">
                            <h4 class="to_demo_text_hover_bg to_demo_inverse_dark"><?php esc_html_e('Accented block header', 'melodyschool'); ?></h4>
							<div>
                                <p class="to_demo_inverse_light"><?php esc_html_e('Posted', 'melodyschool'); ?> <span class="to_demo_inverse_link">12 <?php esc_html_e('May', 'melodyschool'); ?>, 2015</span> <?php esc_html_e('by', 'melodyschool'); ?> <span class="to_demo_inverse_hover"><?php esc_html_e('Author name hovered', 'melodyschool'); ?></span>.</p>
                                <p class="to_demo_inverse_text"><?php esc_html_e('This is a inversed colors example for the normal text', 'melodyschool'); ?></p>
                                <p class="to_demo_inverse_text"><span class="to_demo_inverse_link"><?php esc_html_e('link example', 'melodyschool'); ?></span> <?php esc_html_e('and', 'melodyschool'); ?> <span class="to_demo_inverse_hover"><?php esc_html_e('hovered link', 'melodyschool'); ?></span></p>
							</div>
						</div>
					<?php } ?>
					<?php if (isset($scheme['accent2'])) { ?>
						<div class="to_demo_columns3 to_demo_accent2_bg to_demo_inverse_block">
                            <h4 class="to_demo_accent2_hover_bg to_demo_inverse_dark"><?php esc_html_e('Accented block header', 'melodyschool'); ?></h4>
							<div>
                                <p class="to_demo_inverse_light"><?php esc_html_e('Posted', 'melodyschool'); ?> <span class="to_demo_inverse_link">12 <?php esc_html_e('May', 'melodyschool'); ?>, 2015</span> <?php esc_html_e('by', 'melodyschool'); ?> <span class="to_demo_inverse_hover"><?php esc_html_e('Author name hovered', 'melodyschool'); ?></span>.</p>
                                <p class="to_demo_inverse_text"><?php esc_html_e('This is a inversed colors example for the normal text', 'melodyschool'); ?></p>
                                <p class="to_demo_inverse_text"><span class="to_demo_inverse_link"><?php esc_html_e('link example', 'melodyschool'); ?></span> <?php esc_html_e('and', 'melodyschool'); ?> <span class="to_demo_inverse_hover"><?php esc_html_e('hovered link', 'melodyschool'); ?></span></p>
							</div>
						</div>
					<?php } ?>
					<?php if (isset($scheme['accent3'])) { ?>
						<div class="to_demo_columns3 to_demo_accent3_bg to_demo_inverse_block">
                            <h4 class="to_demo_accent3_hover_bg to_demo_inverse_dark"><?php esc_html_e('Accented block header', 'melodyschool'); ?></h4>
							<div>
                                <p class="to_demo_inverse_light"><?php esc_html_e('Posted', 'melodyschool'); ?> <span class="to_demo_inverse_link">12 <?php esc_html_e('May', 'melodyschool'); ?>, 2015</span> <?php esc_html_e('by', 'melodyschool'); ?> <span class="to_demo_inverse_hover"><?php esc_html_e('Author name hovered', 'melodyschool'); ?></span>.</p>
                                <p class="to_demo_inverse_text"><?php esc_html_e('This is a inversed colors example for the normal text', 'melodyschool'); ?></p>
                                <p class="to_demo_inverse_text"><span class="to_demo_inverse_link"><?php esc_html_e('link example', 'melodyschool'); ?></span> <?php esc_html_e('and', 'melodyschool'); ?> <span class="to_demo_inverse_hover"><?php esc_html_e('hovered link', 'melodyschool'); ?></span></p>
							</div>
						</div>
					<?php } ?>
                    <?php
					break;
				}
			}
			?>

            <h3 class="to_demo_header"><?php esc_html_e('Alternative colors used to decorate highlight blocks and form fields', 'melodyschool'); ?></h3>
			<div class="to_demo_columns2">
				<div class="to_demo_alter_block">
                    <h4 class="to_demo_alter_header"><?php esc_html_e('Highlight block header', 'melodyschool'); ?></h4>
                    <p class="to_demo_alter_text"><?php esc_html_e('This is a plain text in the highlight block. This is a plain text in the highlight block.', 'melodyschool'); ?></p>
                    <p class="to_demo_alter_text"><span class="to_demo_alter_link"><?php esc_html_e('link example', 'melodyschool'); ?></span> <?php esc_html_e('and', 'melodyschool'); ?> <span class="to_demo_alter_hover"><?php esc_html_e('hovered link', 'melodyschool'); ?></span></p>
				</div>
			</div>
			<div class="to_demo_columns2">
				<div class="to_demo_form_fields">
                    <h4 class="to_demo_header"><?php esc_html_e('Form field', 'melodyschool'); ?></h4>
					<input type="text" class="to_demo_field" value="Input field example">
                    <h4 class="to_demo_header"><?php esc_html_e('Form field focused', 'melodyschool'); ?></h4>
					<input type="text" class="to_demo_field_focused" value="Focused field example">
				</div>
			</div>
		</div>
	</div>
</div>
