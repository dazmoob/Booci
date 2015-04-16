<?php 
	if (!empty($pages)) :
		foreach ($pages as $key => $value) :
			$this->load->view('frontend/'.$value);
		endforeach;
	endif;
?>