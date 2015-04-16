<?php

/*
 * This is slug class, used for easy create slug for hyperlink
 *
 * @author Ayub Adiputra
 */

class slug {

	function __construct() {

	}

	public function get_slug($text = false) {

		$slug = $text;

		if (!empty($text)) :

			$text = strtolower($text);
			$special = preg_replace('/[^A-Za-z0-9\-]/', ' ', $text);
			$special = str_replace('-', ' ', $special);
			$space = preg_replace('!\s+!', ' ', $special);
			$slug = str_replace(' ', '-', $space);

			$last = substr($slug, -1);
			$slug = ($last == '-') ? substr($slug, 0, -1) : $slug;

		endif;

		return $slug;

	}

	public function set_increment($text = false, $number = 0) {

		$slug = $text;

		if (!empty($text)) :

			$number = $number++;
			$slug = $text.$number; 

		endif;

		return $slug;

	}

}	