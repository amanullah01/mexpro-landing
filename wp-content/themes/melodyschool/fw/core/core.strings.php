<?php
/**
 * MelodySchool Framework: strings manipulations
 *
 * @package	melodyschool
 * @since	melodyschool 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'MELODYSCHOOL_MULTIBYTE' ) ) define( 'MELODYSCHOOL_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('melodyschool_strlen')) {
	function melodyschool_strlen($text) {
		return MELODYSCHOOL_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('melodyschool_strpos')) {
	function melodyschool_strpos($text, $char, $from=0) {
		return MELODYSCHOOL_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('melodyschool_strrpos')) {
	function melodyschool_strrpos($text, $char, $from=0) {
		return MELODYSCHOOL_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('melodyschool_substr')) {
	function melodyschool_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = melodyschool_strlen($text)-$from;
		}
		return MELODYSCHOOL_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('melodyschool_strtolower')) {
	function melodyschool_strtolower($text) {
		return MELODYSCHOOL_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('melodyschool_strtoupper')) {
	function melodyschool_strtoupper($text) {
		return MELODYSCHOOL_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('melodyschool_strtoproper')) {
	function melodyschool_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<melodyschool_strlen($text); $i++) {
			$ch = melodyschool_substr($text, $i, 1);
			$rez .= melodyschool_strpos(' .,:;?!()[]{}+=', $last)!==false ? melodyschool_strtoupper($ch) : melodyschool_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('melodyschool_strrepeat')) {
	function melodyschool_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('melodyschool_strshort')) {
	function melodyschool_strshort($str, $maxlength, $add='...') {
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= melodyschool_strlen($str)) 
			return strip_tags($str);
		$str = melodyschool_substr(strip_tags($str), 0, $maxlength - melodyschool_strlen($add));
		$ch = melodyschool_substr($str, $maxlength - melodyschool_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = melodyschool_strlen($str) - 1; $i > 0; $i--)
				if (melodyschool_substr($str, $i, 1) == ' ') break;
			$str = trim(melodyschool_substr($str, 0, $i));
		}
		if (!empty($str) && melodyschool_strpos(',.:;-', melodyschool_substr($str, -1))!==false) $str = melodyschool_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('melodyschool_strclear')) {
	function melodyschool_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (melodyschool_substr($text, 0, melodyschool_strlen($open))==$open) {
					$pos = melodyschool_strpos($text, '>');
					if ($pos!==false) $text = melodyschool_substr($text, $pos+1);
				}
				if (melodyschool_substr($text, -melodyschool_strlen($close))==$close) $text = melodyschool_substr($text, 0, melodyschool_strlen($text) - melodyschool_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('melodyschool_get_slug')) {
	function melodyschool_get_slug($title) {
		return melodyschool_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('melodyschool_strmacros')) {
	function melodyschool_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('melodyschool_unserialize')) {
	function melodyschool_unserialize($str) {
        if ( ! empty( $str ) && is_serialized( $str ) ) {
            try {
                $data = unserialize( $str );
            } catch ( Exception $e ) {
                dcl( $e->getMessage() );
                $data = false;
            }
            if ( false === $data ) {
                try {
                    $str  = preg_replace_callback(
                        '!s:(\d+):"(.*?)";!',
                        function( $match ) {
                            return ( strlen( $match[2] ) == $match[1] )
                                ? $match[0]
                                : 's:' . strlen( $match[2] ) . ':"' . $match[2] . '";';
                        },
                        $str
                    );
                    $data = unserialize( $str );
                } catch ( Exception $e ) {
                    dcl( $e->getMessage() );
                    $data = false;
                }
            }
            return $data;
        } else {
            return $str;
        }
	}
}
?>