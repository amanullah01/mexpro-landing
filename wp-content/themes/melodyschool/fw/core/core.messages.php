<?php
/**
 * MelodySchool Framework: messages subsystem
 *
 * @package	melodyschool
 * @since	melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('melodyschool_messages_theme_setup')) {
	add_action( 'melodyschool_action_before_init_theme', 'melodyschool_messages_theme_setup' );
	function melodyschool_messages_theme_setup() {
		// Core messages strings
		add_filter('melodyschool_action_add_scripts_inline', 'melodyschool_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('melodyschool_get_error_msg')) {
	function melodyschool_get_error_msg() {
		return melodyschool_storage_get('error_msg');
	}
}

if (!function_exists('melodyschool_set_error_msg')) {
	function melodyschool_set_error_msg($msg) {
		$msg2 = melodyschool_get_error_msg();
		melodyschool_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('melodyschool_get_success_msg')) {
	function melodyschool_get_success_msg() {
		return melodyschool_storage_get('success_msg');
	}
}

if (!function_exists('melodyschool_set_success_msg')) {
	function melodyschool_set_success_msg($msg) {
		$msg2 = melodyschool_get_success_msg();
		melodyschool_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('melodyschool_get_notice_msg')) {
	function melodyschool_get_notice_msg() {
		return melodyschool_storage_get('notice_msg');
	}
}

if (!function_exists('melodyschool_set_notice_msg')) {
	function melodyschool_set_notice_msg($msg) {
		$msg2 = melodyschool_get_notice_msg();
		melodyschool_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('melodyschool_set_system_message')) {
	function melodyschool_set_system_message($msg, $status='info', $hdr='') {
		update_option(melodyschool_storage_get('options_prefix') . '_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('melodyschool_get_system_message')) {
	function melodyschool_get_system_message($del=false) {
		$msg = get_option(melodyschool_storage_get('options_prefix') . '_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			melodyschool_del_system_message();
		return $msg;
	}
}

if (!function_exists('melodyschool_del_system_message')) {
	function melodyschool_del_system_message() {
		delete_option(melodyschool_storage_get('options_prefix') . '_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('melodyschool_messages_add_scripts_inline')) {
    function melodyschool_messages_add_scripts_inline($vars=array()) {
        // Strings for translation
        $vars["strings"] = array(
            'ajax_error' => esc_html__('Invalid server answer', 'melodyschool'),
            'bookmark_add' => esc_html__('Add the bookmark', 'melodyschool'),
            'bookmark_added' => esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'melodyschool'),
            'bookmark_del' => esc_html__('Delete this bookmark', 'melodyschool'),
            'bookmark_title' => esc_html__('Enter bookmark title', 'melodyschool'),
            'bookmark_exists' => esc_html__('Current page already exists in the bookmarks list', 'melodyschool'),
            'search_error' => esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'melodyschool'),
            'email_confirm' => esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'melodyschool'),
            'reviews_vote' => esc_html__('Thanks for your vote! New average rating is:', 'melodyschool'),
            'reviews_error' => esc_html__('Error saving your vote! Please, try again later.', 'melodyschool'),
            'error_like' => esc_html__('Error saving your like! Please, try again later.', 'melodyschool'),
            'error_global' => esc_html__('Global error text', 'melodyschool'),
            'name_empty' => esc_html__('The name can\'t be empty', 'melodyschool'),
            'name_long' => esc_html__('Too long name', 'melodyschool'),
            'email_empty' => esc_html__('Too short (or empty) email address', 'melodyschool'),
            'email_long' => esc_html__('Too long email address', 'melodyschool'),
            'email_not_valid' => esc_html__('Invalid email address', 'melodyschool'),
            'subject_empty' => esc_html__('The subject can\'t be empty', 'melodyschool'),
            'subject_long' => esc_html__('Too long subject', 'melodyschool'),
            'text_empty' => esc_html__('The message text can\'t be empty', 'melodyschool'),
            'text_long' => esc_html__('Too long message text', 'melodyschool'),
            'send_complete' => esc_html__("Send message complete!", 'melodyschool'),
            'send_error' => esc_html__('Transmit failed!', 'melodyschool'),
            'login_empty' => esc_html__('The Login field can\'t be empty', 'melodyschool'),
            'login_long' => esc_html__('Too long login field', 'melodyschool'),
            'login_success' => esc_html__('Login success! The page will be reloaded in 3 sec.', 'melodyschool'),
            'login_failed' => esc_html__('Login failed!', 'melodyschool'),
            'password_empty' => esc_html__('The password can\'t be empty and shorter then 4 characters', 'melodyschool'),
            'password_long' => esc_html__('Too long password', 'melodyschool'),
            'password_not_equal' => esc_html__('The passwords in both fields are not equal', 'melodyschool'),
            'registration_success' => esc_html__('Registration success! Please log in!', 'melodyschool'),
            'registration_failed' => esc_html__('Registration failed!', 'melodyschool'),
            'geocode_error' => esc_html__('Geocode was not successful for the following reason:', 'melodyschool'),
            'googlemap_not_avail' => esc_html__('Google map API not available!', 'melodyschool'),
            'editor_save_success' => esc_html__("Post content saved!", 'melodyschool'),
            'editor_save_error' => esc_html__("Error saving post data!", 'melodyschool'),
            'editor_delete_post' => esc_html__("You really want to delete the current post?", 'melodyschool'),
            'editor_delete_post_header' => esc_html__("Delete post", 'melodyschool'),
            'editor_delete_success' => esc_html__("Post deleted!", 'melodyschool'),
            'editor_delete_error' => esc_html__("Error deleting post!", 'melodyschool'),
            'editor_caption_cancel' => esc_html__('Cancel', 'melodyschool'),
            'editor_caption_close' => esc_html__('Close', 'melodyschool')
        );
        return $vars;
    }
}
?>