<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('set_elapsed')) {

	function set_elapsed ($time = false) {

		// Now
		if ($time['end'] == 'now')
			$time = time() - strtotime($time['start']);
		else 
			$time = strtotime($time['end']) - strtotime($time['start']);

		$tokens = array (
			1 => 'second',
			60 => 'minute',
			3600 => 'hour',
			86400 => 'day',
			604800 => 'week',
			2592000 => 'month',
			31536000 => 'year',
		);

		$elapsed_time = 'Now';

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			$elapsed_time = $numberOfUnits.' '.$text.(($numberOfUnits>1) ?'s' : '');
		}

		return $elapsed_time;
	}

	function set_time ($time = false) {

		// Now
		$start_time = $time['start'];
		if ($time['end'] == 'now')
			$time = time() - strtotime($time['start']);
		else 
			$time = strtotime($time['end']) - strtotime($time['start']);

		$tokens = array (
			1 => 'second',
			60 => 'minute',
			3600 => 'hour',
			86400 => 'day',
			604800 => 'week',
			2592000 => 'month',
			31536000 => 'year',
		);

		$elapsed_time = 'Nothing';
		$status = null;

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			$status = $text;
			$elapsed_time = $numberOfUnits.' '.$text.(($numberOfUnits>1) ?'s' : '');
		}

		if (in_array($status, array('second', 'minute', 'hour'))) :
			$elapsed_time = date('H:i', strtotime($start_time));
		elseif (in_array($status, array('day', 'week', 'month'))) :
			$elapsed_time = date('M d', strtotime($start_time));
		else :
			$elapsed_time = date('Y M', strtotime($start_time));
		endif;

		return $elapsed_time;
	}

}	