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

	function __constrcut() {
		$this->load->model('user');
	}

	/*
		=========== Private Function =============
	*/

	private function set_variable() {
		$this->basic = $this->common->basic_info(true);
	}



	/*
		=========== Public Function =============
	*/

	public function index() {
		$filepath = APPPATH.'/config/access_level.yaml';
		$array = $this->yaml->parse_file($filepath);
		var_dump($array);
		// $this->load->view('welcome_message');
	}

	public function admin($adm_log = false) {

		// Checking log key
		$permit = $this->common->adm_log($adm_log);

		// Initialize
		$this->set_variable();
		$pages = false;

		$this->common->backend($pages, $permit);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */	
