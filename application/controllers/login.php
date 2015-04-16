<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->ci =& get_instance();
	}

	/*
		=========== Private Function =============
	*/

	private function setVariable ($basic = false) {
		$this->basic = $this->common->basic_info(true, $basic);
	}

	private function validation ($type = false) {

		$this->load->library('form_validation');
		$status = true;

		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');

		if ($this->form_validation->run() == FALSE) :
			$status = false;
		endif;

		return $status;

	}

	private function lastAccess ($valid = false) {

		$this->load->model('login_model');
		// $_POST['username'] = $this->input->post('username');
		// $_POST['username'] = $this->input->post('username');

	}



	/*
		=========== Public Function =============
	*/

	// Admin login page
	public function user($adm_log = false) {

		// Checking log key
		$permit = $this->common->adm_log($adm_log);

		if ($permit) :

			// Initialize basic info
			$basic = array(
				'title' => 'Administrator Login',
			);
			$this->setVariable($basic);

			// Render view
			$param['pages'] = array('login/user');
			$this->common->userpage($param);

		endif;

	}

	// Authentication
	public function authentication() {

		$this->load->library('encrypt');

		$validation = $this->validation();

		if ($validation) :


			$username = $this->input->post('username');
			$param = array(
				'type' => 'where',
				'select' => 'all',
				'condition' => array('username' => $this->input->post('username'), 'state' => 'Active')
			);

			$user = $this->user_model->check_login($param);
			// $this->lastAccess($user);

			if ($user) :

				// Access and get YAML data
				$filepath = APPPATH.'/config/access_level.yaml';
				$array = $this->yaml->parse_file($filepath);
				
				// Set user access by compare user data and user access in YAML
				$level = $this->user_model->level_super;
				$user_level = $level[$user->level];
				$user_access = $array[str_replace(' ', '_', strtolower($user_level))];

				// Set user data after login
				$data = array(
					'data' => $user,
					'access' => $user_access,
					'log' => array('login_time' => date('Y-m-d H:i:s'))
				);
				$this->session->set_userdata('user', $data);

				$param = array(
					'alert' => 'success',
					'notification' => 'Welcome '.$user->username,
					'redirect' => site_url('profile/'.$user->username),
				);
				$this->common->redirect($param);

			else :

				$param = array(
					'alert' => 'danger',
					'notification' => 'Invalid username and password, try again'
				);
				$this->common->redirect($param);

			endif;

		endif;
			
	}

	// Logout
	public function logout () {

		// Get userdata
		$usersession = $this->session->userdata('user');
		$userdata = $usersession['data'];

		// Get adm_log keyword
		$basic = $this->common->basic_info();

		// Destroy all session
		$this->session->sess_destroy();

		$param = array(
			'alert' => 'success',
			'notification' => 'See you soon '.$userdata->username,
			'redirect' => site_url('login/user/'.$basic->adm_log)
		);
		$this->common->redirect($param);

	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */	
