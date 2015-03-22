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
		$ci =& get_instance();
	}

	/*
		=========== Private Function =============
	*/

	private function set_variable($basic = false) {
		$this->basic = $this->common->basic_info(true, $basic);
	}



	/*
		=========== Public Function =============
	*/

	public function index() {
		// $this->load->view('welcome_message');
	}

	// Admin login page
	public function admin($adm_log = false) {

		// Checking log key
		$permit = $this->common->adm_log($adm_log);

		if ($permit) :

			// Initialize basic info
			$basic = array(
				'title' => 'Administrator Login',
			);
			$this->set_variable($basic);

			// Render view
			$param['pages'] = array('login/index');
			$this->common->frontend($param);

		endif;

	}

	// Admin authentication
	public function admin_authentication() {
		$filepath = APPPATH.'/config/access_level.yaml';
		$array = $this->yaml->parse_file($filepath);
		// $this->load->view('welcome_message');
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */	
