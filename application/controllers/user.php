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
		$this->ci = &get_instance();

		$this->access = $this->common->access('c_user');
		$this->usersession = $this->session->userdata('user');
		$this->userdata = $this->usersession['data'];
		$this->useraccess = $this->usersession['access'];
		$this->userlog = $this->usersession['log'];
	}

	/*
		=========== Private Function =============
	*/

	private function set_variable($variable = false) {
		$this->basic = $this->common->basic_info(true, $variable);
		$this->header = $this->common->backend_header($variable);
		$this->breadcrumb = $this->common->backend_breadcrumb($variable);
	}

	private function validation($type = false) {

		$this->load->library('form_validation');
		$status = true;

		if ($type == 'update') :

			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean|alpha_numeric');
			$this->form_validation->set_rules('website', 'Website', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('facebook', 'Facebook', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('twitter', 'Twitter', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('google', 'Google', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean|alpha_dash');

		elseif ($type == 'password') :

			$this->form_validation->set_rules('old_password', 'Old Password', 'required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('retype_password', 'Retype Password', 'required|trim|xss_clean|min_length[6]|matches[password]');

		elseif ($type == 'level') :

			$this->form_validation->set_rules('level', 'Access Level', 'required|trim|xss_clean|integer');

		elseif ($type == 'state') :

			$this->form_validation->set_rules('state', 'Access State', 'required|trim|xss_clean|alpha');

		else :

			$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|is_unique[user.username]|min_length[6]|max_length[50]|alpha_dash');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|is_unique[user.email]|valid_email');
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('facebook', 'Facebook', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('twitter', 'Twitter', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('google', 'Google', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('level', 'Access Level', 'required|trim|xss_clean|integer');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean|alpha_dash');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('retype_password', 'Retype Password', 'required|trim|xss_clean|min_length[6]|matches[password]');

		endif;


		if ($this->form_validation->run() == FALSE) :
			$status = false;
		endif;

		return $status;

	}

	private function password() {
		$this->load->library('encrypt');
		$_POST['password'] = $this->encrypt->encode($this->input->post('password'));
	}

	/*
		=========== Public Function =============
	*/

	public function index($page = 0) {

		if ($this->access) :

			// Initialize basic info
			$basic = array('title' => 'User List');
			$this->set_variable($basic);

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/datatables/dataTables.bootstrap.css');
			$this->additional_js = array('assets/plugins/datatables/jquery.dataTables.js', 'assets/plugins/datatables/dataTables.bootstrap.js');

			// Set user data
			$user = [
				'start' => $page, 
				'limit' => 10,
				'order_by' => 'username desc'
			];

			$param['level'] = $this->user_model->level_super;
			
			if ($this->userdata->level != 1) :
				$user['condition'] = array('level !=' => 1);
				$param['level'] = $this->user_model->level;
			endif;

			$param['user'] = $this->user_model->get_all($user);

			// Render view
			$param['pages'] = array('user/index');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->access) :

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

	public function create() {

		$validation = $this->validation();

		if ($validation) :

			$this->password();
			$this->user_model->insert();

		endif;

		$this->common->redirect();

	}
}