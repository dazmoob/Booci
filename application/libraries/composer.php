<?php

/*
 * This is composer class, used for easy call vendor directory from composer
 *
 * @author Ayub Adiputra
 */

class composer {

	function __construct() {

		include ('./vendor/autoload.php');

	}

}