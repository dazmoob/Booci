<?php

/*
 * This is datetimes class, used for easy create some function datetimes
 *
 * @author Ayub Adiputra
 */

class datetimes {

	function __construct() {

	}

	public function datetime_status($datetime = false) {

		$now = new DateTime ('now');
		$schedule = new DateTime ($datetime);
		$diff = $now > $schedule;

		return $diff;

	}

}	