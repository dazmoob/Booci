<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('clear_text')) {

	function clear_text ($text = false) {

		$clean = null;

		if (!empty($text)) :

			$clean = str_replace('_', ' ', $text);

		endif;

		return $clean;

	}

}		
