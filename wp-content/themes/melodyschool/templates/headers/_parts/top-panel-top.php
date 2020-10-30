<?php 
// Get template args
extract(melodyschool_template_get_args('top-panel-top'));

if (in_array('contact_info', $top_panel_top_components) && ($contact_info=trim(melodyschool_get_custom_option('contact_info')))!='') {
	?>
	<div class="top_panel_top_contact_area icon-location">
		<?php melodyschool_show_layout($contact_info); ?>
	</div>
	<?php
}
?>

<?php
if (in_array('open_hours', $top_panel_top_components) && ($open_hours=trim(melodyschool_get_custom_option('contact_open_hours')))!='') {
	?>
	<div class="top_panel_top_open_hours icon-clock"><?php melodyschool_show_layout($open_hours); ?></div>
	<?php
}
?>

<div class="top_panel_top_user_area">
	<?php
	if (in_array('socials', $top_panel_top_components) && melodyschool_get_custom_option('show_socials')=='yes') {
		?>
		<div class="top_panel_top_socials">
			<?php melodyschool_show_layout(melodyschool_sc_socials(array('size'=>'tiny'))); ?>
		</div>
		<?php
	}

	if (in_array('search', $top_panel_top_components) && melodyschool_get_custom_option('show_search')=='yes' && function_exists('melodyschool_sc_search')) {
		?>
		<div class="top_panel_top_search"><?php melodyschool_show_layout(melodyschool_sc_search(array('state'=>'fixed'))); ?></div>
		<?php
	}

	$menu_user = melodyschool_get_nav_menu('menu_user');
	if (empty($menu_user)) {
		?>
		<ul id="<?php echo (!empty($menu_user_id) ? esc_attr($menu_user_id) : 'menu_user'); ?>" class="menu_user_nav">
		<?php
	} else {
		$menu = melodyschool_substr($menu_user, 0, melodyschool_strlen($menu_user)-5);
		$pos = melodyschool_strpos($menu, '<ul');
		if ($pos!==false && melodyschool_strpos($menu, 'menu_user_nav')===false)
			$menu = melodyschool_substr($menu, 0, $pos+3) . ' class="menu_user_nav"' . melodyschool_substr($menu, $pos+3);
		if (!empty($menu_user_id))
			$menu = melodyschool_set_tag_attrib($menu, '<ul>', 'id', $menu_user_id);
		echo str_replace('class=""', '', $menu);
	}
	

	if (in_array('currency', $top_panel_top_components) && function_exists('melodyschool_is_woocommerce_page') && melodyschool_is_woocommerce_page() && melodyschool_get_custom_option('show_currency')=='yes') {
		?>
		<li class="menu_user_currency">
			<a href="#">$</a>
			<ul>
				<li><a href="#"><b>&#36;</b> <?php esc_html_e('Dollar', 'melodyschool'); ?></a></li>
				<li><a href="#"><b>&euro;</b> <?php esc_html_e('Euro', 'melodyschool'); ?></a></li>
				<li><a href="#"><b>&pound;</b> <?php esc_html_e('Pounds', 'melodyschool'); ?></a></li>
			</ul>
		</li>
		<?php
	}

	if (in_array('language', $top_panel_top_components) && melodyschool_get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=1');
		if (!empty($languages) && is_array($languages)) {
			$lang_list = '';
			$lang_active = '';
			foreach ($languages as $lang) {
				$lang_title = esc_attr($lang['translated_name']);
				if ($lang['active']) {
					$lang_active = $lang_title;
				}
				$lang_list .= "\n"
					.'<li><a rel="alternate" hreflang="' . esc_attr($lang['language_code']) . '" href="' . esc_url(apply_filters('WPML_filter_link', $lang['url'], $lang)) . '">'
						.'<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang_title) . '" title="' . esc_attr($lang_title) . '" />'
						. ($lang_title)
					.'</a></li>';
			}
			?>
			<li class="menu_user_language">
				<a href="#"><span><?php melodyschool_show_layout($lang_active); ?></span></a>
				<ul><?php melodyschool_show_layout($lang_list); ?></ul>
			</li>
			<?php
		}
	}

	if (in_array('bookmarks', $top_panel_top_components) && melodyschool_get_custom_option('show_bookmarks')=='yes') {
		// Load core messages
		melodyschool_enqueue_messages();
		?>
		<li class="menu_user_bookmarks"><a href="#" class="bookmarks_show icon-star" title="<?php esc_attr_e('Show bookmarks', 'melodyschool'); ?>"><?php esc_html_e('Bookmarks', 'melodyschool'); ?></a>
		<?php 
			$list = melodyschool_get_value_gpc('melodyschool_bookmarks', '');
			if (!empty($list)) $list = json_decode($list, true);
			?>
			<ul class="bookmarks_list">
				<li><a href="#" class="bookmarks_add icon-star-empty" title="<?php esc_attr_e('Add the current page into bookmarks', 'melodyschool'); ?>"><?php esc_html_e('Add bookmark', 'melodyschool'); ?></a></li>
				<?php 
				if (!empty($list) && is_array($list)) {
					foreach ($list as $bm) {
						echo '<li><a href="'.esc_url($bm['url']).'" class="bookmarks_item">'.($bm['title']).'<span class="bookmarks_delete icon-cancel" title="'.esc_attr__('Delete this bookmark', 'melodyschool').'"></span></a></li>';
					}
				}
				?>
			</ul>
		</li>
		<?php 
	}

	if (in_array('cart', $top_panel_top_components) && function_exists('melodyschool_exists_woocommerce') && melodyschool_exists_woocommerce() && (melodyschool_is_woocommerce_page() && melodyschool_get_custom_option('show_cart')=='shop' || melodyschool_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
		?>
		<li class="menu_user_cart">
			<?php do_action('trx_utils_show_contact_info_cart'); ?>
		</li>
		<?php
	}
	?>

	</ul>

</div>