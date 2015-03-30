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
		adm_log($adm_log)
		Used to check admin or super admin additional parameter to access login page
	*/
	public function adm_log($adm_log) {

		// Initialize
		$status = true;
		// Check param exist and key adm_log is correct
		$basic = $this->basic_info();
		if (empty($adm_log) || $adm_log != $basic->adm_log) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
			$this->error($code);
			$status = false;

		endif;

		return $status;

	}

	/* 
		login($action)
		Used to check user is logging in or not
	*/
	public function login($action = false) {

		// Initialize
		$status = true;

		// Check user logged in session
		if ($this->session->userdata('user') == false) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
			$this->error($code);
			$status = false;

		endif;

		return $status;

	}

	/* 
		access($action)
		Used to check user is logging in or not
	*/
	public function access($action) {

		// Initialize
		$status = true;
		$access = false;

		// Check user logged in session
		$usersession = $this->session->userdata('user');

		// Set user access
		if (!empty($usersession)) :
			$useraccess = $usersession['access'];
		endif;

		// Check user access
		if (!empty($useraccess)) :

			if (in_array('c_user', $useraccess))
				$access = true;

		endif; 

		if ($usersession == false || $access == false) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
			$this->error($code);
			$status = false;

		endif;

		return $status;

	}

	/* 
		basic_info($view, $basic)
		Used to get all web basic information
	*/
	public function basic_info($view = false, $basic = false) {

		// Get and fetch data from web table
		$query = $this->db->get('web');
		$data = $query->row();
		$basic = !empty($basic['basic']) ? $basic['basic'] : false;

		// If used for view
		if ($view) :

			$raw = $query->row();

			// Check web title info
			$title = !empty($basic['title']) ? $basic['title'] : $raw->title;

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
		backend_header($header)
		Used to set page header
	*/
	public function backend_header($header = false) {

		$data = false;

		// If used for view
		if (!empty($header['header'])) 
			$data = $header['header'];
		
		return $data;

	}

	/* 
		backend_breadcrumb($breadcrumb)
		Used to set page breadcrumb
	*/
	public function backend_breadcrumb($breadcrumb = false) {

		$data = false;

		// If used for view
		if (!empty($breadcrumb['breadcrumb'])) 
			$data = $breadcrumb['breadcrumb'];
		
		return $data;

	}

	/* 
		backend($param)
		Used to show page for backend view
	*/
	public function backend($param = false) {

		if (!empty($param['pages'])) :
			$this->load->view('backend/index', $param);
		endif;

	}

	/* 
		frontend($param)
		Used to show page for frontend view
	*/
	public function frontend($param = false) {

		if (!empty($param['pages'])) :
			$this->load->view('frontend/index', $param);
		endif;

	}

	/* 
		userpage($param)
		Used to show single user page for login/regsiter view
	*/
	public function userpage($param = false) {

		if (!empty($param['pages'])) :
			$this->load->view('userpage/login', $param);
		endif;

	}

	/* 
		error($code = array('status' => 'error', 'view' => 'frontend|backend', 'type' => ''))
		Used to show error page view
	*/
	public function error($code = false) {

		// Check error code
		if (!empty($code['type'])) :

			// Set error type, title, message and notes
			$error = array();
			switch ($code['type']) :
				case 404:
					$error['type'] = '404';
					$error['title'] = 'Page not found';
					$error['message'] = 'Oops, sorry, this page not found or no longer exist';
					$error['notes'] = 'Please try another page';
					$error['view'] = 'error/'.$code['view'];
					break;
				
				default:
					$error['type'] = 'Error';
					$error['title'] = 'Something bad happened';
					$error['message'] = 'We will find to fix this error';
					$error['notes'] = 'If you need something, feel free to contact us <a title="Send Message" href="'.site_url('messages/send').'">here</a>';
					$error['view'] = 'error/frontend';
					break;
			endswitch;

		endif;

		// Check error status
		if (!empty($code['status']) && $code['status'] == 'error') :
			$this->load->view($error['view'], $error);
		endif;

		return false;

	}

	/* 
		redirect($param)
		Used to redirect user from one page to another page
	*/
	public function redirect($param = false) {

		if (!empty($param['notification'])) :
			$this->session->set_flashdata($param);
		endif;

		if (!empty($param['redirect'])) :
			redirect($param['redirect']);
		else :

			if (!empty($_SERVER['HTTP_REFERER']))
				redirect($_SERVER['HTTP_REFERER']);
			else
				redirect(site_url());

		endif;

	}

	/* 
		check_param($param)
		Used to check paramater in URL
	*/
	public function check_param($param) {

		// Initialize
		$status = true;

		// Check param exist
		if (empty($param)) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 504);
			$this->error($code);
			$status = false;

		endif;

		return $status;

	}

}