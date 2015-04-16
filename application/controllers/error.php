<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

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
		$this->load->model('web_model');
		$this->load->model('user_model');
		$this->ci = &get_instance();
	}

	/*
		=========== Private Function =============
	*/

	private function set_variable($variable = false) {
		$this->basic = $this->common->basic_info(true, $variable);
		$this->header = $this->common->backend_header($variable);
		$this->breadcrumb = $this->common->backend_breadcrumb($variable);
	}

	/*
		=========== Public Function =============
	*/

	public function index() {

		// For logged in user
		$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
		$this->common->error($code);

	}

}		