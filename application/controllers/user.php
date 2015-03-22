<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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

	public function add() {

		// Checking log key
		// $permit = $this->common->login('error');
		$permit = true;

		if ($permit) :

			// Initialize basic info
			$basic = array(
				'title' => 'Add New User',
			);
			$this->set_variable($basic);

			// Render view
			$param['pages'] = array('user/add');
			$this->common->backend($param);

		endif;

	}
}