<?php

/*
 * This is slug class, used for easy create slug for hyperlink
 *
 * @author Ayub Adiputra
 */

class upload_config {

	function __construct() {

	}

	public function set_config($type = false) {

		if (!empty($type)) :

			$typeRaw = explode('/', $type);
			$mainType = $typeRaw[0];

			switch ($mainType) :
				
				case 'image':
					
					$config['upload_path'] = './gallery/images/';
					$config['upload_src'] = 'gallery/images/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
					$config['max_size']	= '2048';

					break;

				case 'application':
					
					$config['upload_path'] = './gallery/files/';
					$config['upload_src'] = 'gallery/files/';
					$config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pdf';
					$config['max_size']	= '2048';

					break;

				case 'text':
					
					$config['upload_path'] = './gallery/files/';
					$config['upload_src'] = 'gallery/files/';
					$config['allowed_types'] = 'txt';
					$config['max_size']	= '2048';

					break;
				
				default:
					# code...
					break;
			
			endswitch;

		endif;

		return $config;

	}

}	