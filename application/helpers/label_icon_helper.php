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

				case 'page_state':

					$state = array(
						'Publish' => 'success',
						'Draft' => 'warning',
						'Trash' => 'danger'
					);

					break;

				case 'message_state':

					$state = array(
						'read' => 'primary',
						'unread' => 'info',
						'trash' => 'danger'
					);

					break;

				case 'message_solved':

					$state = array(
						'solved' => 'success',
						'unsolved' => 'danger'
					);

					break;

				case 'media_type':

					$state = array(
						'image' => 'primary',
						'file' => 'info',
						'audio' => 'success',
						'video' => 'danger'
					);

					break;

				case 'message_type':

					$state = array(
						'others' => 'success',
						'question' => 'info',
						'suggestion' => 'warning',
						'criticism' => 'danger'
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

				case 'page_state':

					$state = array(
						'Publish' => 'globe',
						'Draft' => 'file-text-o',
						'Trash' => 'trash'
					);

					break;

				case 'media_type':

					$state = array(
						'image' => 'photo',
						'file' => 'file',
						'audio' => 'music',
						'video' => 'video-camera'
					);

					break;

				case 'message_state':

					$state = array(
						'read' => 'circle',
						'unread' => 'circle-o',
						'trash' => 'trash'
					);

					break;

				case 'message_solved':

					$state = array(
						'solved' => 'check-square-o',
						'unsolved' => 'times'
					);

					break;
				
				default:
					
					break;
			}

		endif;

		return $state[$key];
	}
}