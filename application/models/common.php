<?php

class Common extends CI_Model {

	/*
		@ Class 	: common
		@ Used For 	:
			> Set adm_log handler for empty or wrong admin login parameter
		@ Function 	:
			> Main function 		: adm_log
				> Common function 		: 
					> Included function		: 
			> Addtional function 	: - 
		@ Notes 	: 
	*/



	/* 
		=== Common Section ======================================
		Common function that used by all of function, there are : 
	*/



	/* 
		=== Main Section ======================================
		Main function that called by Controllers, there are :
		adm_log
	*/


	/* 
		adm_log($param)
		Used to check admin or super admin additional parameter to access login page
	*/
	public function adm_log($adm_log) {

		// Check param exist
		$basic = $this->basic_info();
		if (empty($adm_log) || $adm_log != $basic->adm_log) :

			$this->load->view('error/404');
			return true;

		endif;

	}

	/* 
		basic_info()
		Used to get all web basic information
	*/
	public function basic_info($view = false, $basic = false) {

		// Get and fetch data from web table
		$query = $this->db->get('web');
		$data = $query->row();

		// If used for view
		if ($view) :

			$raw = $query->row();

			// Check web title info
			$title = !empty($basic) ? $basic['title'] : $raw->title;

			$data = array(
				'name' => $raw->name,
				'title' => $title,
				'domain' => $raw->domain,
				'description' => $raw->description,
				'keyword' => $raw->keyword,
				'created' => $raw->created,
				'creator' => $raw->creator
			);

		endif;
		
		return $data;

	}

	/* 
		backend($param)
		Used to show page for backend view
	*/
	public function backend($pages = false) {

		if (!empty($pages)) :
			$this->load->view('backend/index', $pages);
		endif;

	}

}