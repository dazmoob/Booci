<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('excerpt_words')) {

	function excerpt_words ($text = false, $limit = 10) {

		$excerpt = null;

		if (!empty($text)) :

			$text_raw = explode(' ', $text);
			$i = 1; $excerpt = ''; $status = true;
			foreach ($text_raw as $key => $value) :
				if ($i <= $limit) :
					$excerpt = $excerpt.' '.$value;
				endif;
				$i++;
			endforeach;

		endif;

		return $excerpt;

	}

	function excerpt_chars ($text = false, $limit = 10) {

		$excerpt = null;

		if (!empty($text)) 
			$excerpt = substr($text, 1, $limit);

		return $excerpt;

	}

}	