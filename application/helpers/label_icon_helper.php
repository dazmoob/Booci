<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_label')) {

	function get_label($type = false, $key = false) {

		$state = false;

		if (!empty($type)) :

			switch ($type) {
				case 'article_state':

					$state = array(
						'Publish' => 'success',
						'Draft' => 'warning',
						'Trash' => 'danger'
					);

					break;
				
				default:
					
					break;
			}

		endif;

		return $state[$key];
	}

	function get_icon($type = false, $key = false) {

		$state = false;

		if (!empty($type)) :

			switch ($type) {
				case 'article_state':

					$state = array(
						'Publish' => 'globe',
						'Draft' => 'file-text-o',
						'Trash' => 'trash'
					);

					break;
				
				default:
					
					break;
			}

		endif;

		return $state[$key];
	}
}