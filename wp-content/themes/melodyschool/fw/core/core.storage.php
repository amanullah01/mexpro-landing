<?php
/**
 * MelodySchool Framework: theme variables storage
 *
 * @package	melodyschool
 * @since	melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('melodyschool_storage_get')) {
	function melodyschool_storage_get($var_name, $default='') {
		global $MELODYSCHOOL_STORAGE;
		return isset($MELODYSCHOOL_STORAGE[$var_name]) ? $MELODYSCHOOL_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('melodyschool_storage_set')) {
	function melodyschool_storage_set($var_name, $value) {
		global $MELODYSCHOOL_STORAGE;
		$MELODYSCHOOL_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('melodyschool_storage_empty')) {
	function melodyschool_storage_empty($var_name, $key='', $key2='') {
		global $MELODYSCHOOL_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($MELODYSCHOOL_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($MELODYSCHOOL_STORAGE[$var_name][$key]);
		else
			return empty($MELODYSCHOOL_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('melodyschool_storage_isset')) {
	function melodyschool_storage_isset($var_name, $key='', $key2='') {
		global $MELODYSCHOOL_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($MELODYSCHOOL_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($MELODYSCHOOL_STORAGE[$var_name][$key]);
		else
			return isset($MELODYSCHOOL_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('melodyschool_storage_inc')) {
	function melodyschool_storage_inc($var_name, $value=1) {
		global $MELODYSCHOOL_STORAGE;
		if (empty($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = 0;
		$MELODYSCHOOL_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('melodyschool_storage_concat')) {
	function melodyschool_storage_concat($var_name, $value) {
		global $MELODYSCHOOL_STORAGE;
		if (empty($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = '';
		$MELODYSCHOOL_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('melodyschool_storage_get_array')) {
	function melodyschool_storage_get_array($var_name, $key, $key2='', $default='') {
		global $MELODYSCHOOL_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($MELODYSCHOOL_STORAGE[$var_name][$key]) ? $MELODYSCHOOL_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($MELODYSCHOOL_STORAGE[$var_name][$key][$key2]) ? $MELODYSCHOOL_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('melodyschool_storage_set_array')) {
	function melodyschool_storage_set_array($var_name, $key, $value) {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if ($key==='')
			$MELODYSCHOOL_STORAGE[$var_name][] = $value;
		else
			$MELODYSCHOOL_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('melodyschool_storage_set_array2')) {
	function melodyschool_storage_set_array2($var_name, $key, $key2, $value) {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if (!isset($MELODYSCHOOL_STORAGE[$var_name][$key])) $MELODYSCHOOL_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$MELODYSCHOOL_STORAGE[$var_name][$key][] = $value;
		else
			$MELODYSCHOOL_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('melodyschool_storage_set_array_after')) {
	function melodyschool_storage_set_array_after($var_name, $after, $key, $value='') {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if (is_array($key))
			melodyschool_array_insert_after($MELODYSCHOOL_STORAGE[$var_name], $after, $key);
		else
			melodyschool_array_insert_after($MELODYSCHOOL_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('melodyschool_storage_set_array_before')) {
	function melodyschool_storage_set_array_before($var_name, $before, $key, $value='') {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if (is_array($key))
			melodyschool_array_insert_before($MELODYSCHOOL_STORAGE[$var_name], $before, $key);
		else
			melodyschool_array_insert_before($MELODYSCHOOL_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('melodyschool_storage_push_array')) {
	function melodyschool_storage_push_array($var_name, $key, $value) {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($MELODYSCHOOL_STORAGE[$var_name], $value);
		else {
			if (!isset($MELODYSCHOOL_STORAGE[$var_name][$key])) $MELODYSCHOOL_STORAGE[$var_name][$key] = array();
			array_push($MELODYSCHOOL_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('melodyschool_storage_pop_array')) {
	function melodyschool_storage_pop_array($var_name, $key='', $defa='') {
		global $MELODYSCHOOL_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($MELODYSCHOOL_STORAGE[$var_name]) && is_array($MELODYSCHOOL_STORAGE[$var_name]) && count($MELODYSCHOOL_STORAGE[$var_name]) > 0) 
				$rez = array_pop($MELODYSCHOOL_STORAGE[$var_name]);
		} else {
			if (isset($MELODYSCHOOL_STORAGE[$var_name][$key]) && is_array($MELODYSCHOOL_STORAGE[$var_name][$key]) && count($MELODYSCHOOL_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($MELODYSCHOOL_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('melodyschool_storage_inc_array')) {
	function melodyschool_storage_inc_array($var_name, $key, $value=1) {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if (empty($MELODYSCHOOL_STORAGE[$var_name][$key])) $MELODYSCHOOL_STORAGE[$var_name][$key] = 0;
		$MELODYSCHOOL_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('melodyschool_storage_concat_array')) {
	function melodyschool_storage_concat_array($var_name, $key, $value) {
		global $MELODYSCHOOL_STORAGE;
		if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
		if (empty($MELODYSCHOOL_STORAGE[$var_name][$key])) $MELODYSCHOOL_STORAGE[$var_name][$key] = '';
		$MELODYSCHOOL_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('melodyschool_storage_call_obj_method')) {
	function melodyschool_storage_call_obj_method($var_name, $method, $param=null) {
		global $MELODYSCHOOL_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($MELODYSCHOOL_STORAGE[$var_name]) ? $MELODYSCHOOL_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($MELODYSCHOOL_STORAGE[$var_name]) ? $MELODYSCHOOL_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('melodyschool_storage_get_obj_property')) {
	function melodyschool_storage_get_obj_property($var_name, $prop, $default='') {
		global $MELODYSCHOOL_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($MELODYSCHOOL_STORAGE[$var_name]->$prop) ? $MELODYSCHOOL_STORAGE[$var_name]->$prop : $default;
	}
}

// Merge two-dim array element
if (!function_exists('melodyschool_storage_merge_array')) {
    function melodyschool_storage_merge_array($var_name, $key, $arr) {
        global $MELODYSCHOOL_STORAGE;
        if (!isset($MELODYSCHOOL_STORAGE[$var_name])) $MELODYSCHOOL_STORAGE[$var_name] = array();
        if (!isset($MELODYSCHOOL_STORAGE[$var_name][$key])) $MELODYSCHOOL_STORAGE[$var_name][$key] = array();
        $MELODYSCHOOL_STORAGE[$var_name][$key] = array_merge($MELODYSCHOOL_STORAGE[$var_name][$key], $arr);
    }
}
?>