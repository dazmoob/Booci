<?php

/*
 * This is random class, used for easy create random string
 *
 * @author Ayub Adiputra
 */

class random {

	function __construct() {

	}

	public function get_random() {

		$number = rand(100000, 999999);
		$crypt = md5($number);
		$string = substr($crypt, 0, 6);

		return $string;

	}

}	