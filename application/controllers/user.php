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

		if ($type == 'update') :

			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('facebook', 'Facebook', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('twitter', 'Twitter', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('google', 'Google', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean|alpha_dash');
			
			$param['redirect'] = site_url('user/'.$param.'/edit');

		elseif ($type == 'password') :

			$this->form_validation->set_rules('old_password', 'Old Password', 'required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('retype_password', 'Retype Password', 'required|trim|xss_clean|min_length[6]|matches[password]');

			$param['redirect'] = site_url('user/'.$param.'/edit');

		elseif ($type == 'level') :

			$this->form_validation->set_rules('level', 'Access Level', 'required|trim|xss_clean|integer');
			$param['redirect'] = site_url('user');

		elseif ($type == 'state') :

			$this->form_validation->set_rules('state', 'Access State', 'required|trim|xss_clean|alpha');
			$param['redirect'] = site_url('user');

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

			$param['redirect'] = site_url('user');

		endif;


		if ($this->form_validation->run() == FALSE) :
			
			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();

			$this->common->redirect($param);
		
		endif;

	}

	private function password() {
		$this->load->library('encrypt');
		$_POST['password'] = $this->encrypt->encode($this->input->post('password'));
	}

	private function check_edit($username = false) {

		$param = array('type' => 'where', 'condition' => array('username' => $username));
		$this->userprofile = $this->user_model->get_one($param, true);
		$userdata = $this->userdata;

		$status = true;

		if ($userdata->level > $this->userprofile->level) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'backend', 'type' => 404);
			$this->common->error($code);
			$status = false;

		endif;

		return $status;

	}

	/*
		=========== Public Function =============
	*/

	public function index($page = 0) {

		if ($this->access) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'User List'),
				'header' => [
					'title' => 'User Management',
					'description' => 'Users list in Booci',
				],
				'breadcrumb' => [
					'one' => 'User',
					'one_link' => site_url('user'),
					'icon' => 'users',
					'two' => 'List User'
				]
			];
			$this->set_variable($variable);

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
			$variable = [
				'basic' => array('title' => 'Add New User'),
				'header' => [
					'title' => 'User Management',
					'description' => 'Create a user',
				],
				'breadcrumb' => [
					'one' => 'User',
					'one_link' => site_url('user'),
					'icon' => 'users',
					'two' => 'Create New User'
				]
			];
			$this->set_variable($variable);

			// Render view
			$param['pages'] = array('user/add');
			$this->common->backend($param);

		endif;

	}

	public function create() {

		$validation = $this->validation();

		// Load random string library and set random password
		$this->load->library('random');
		$password = $this->random->get_random();
		$_POST['password'] = $password;
		$this->password();

		if ($this->user_model->insert()) :

			$param = [
				'alert' => 'success',
				'notification' => 'Success create '.$this->input->post('username').' with password '.$password,
				'redirect' => site_url('user/add'),
			];

		else :

			$param = [
				'alert' => 'danger',
				'notification' => 'Something wrong when add new user, please try again !',
				'redirect' => site_url('user/add'),
			];

		endif;

		$this->common->redirect($param);

	}

	public function edit($username = false) {

		// Check user parameter
		$param = $this->common->check_param($username);

		if ($this->access && $param) :

			// Check if user open right username
			$edit = $this->check_edit($username);

			if ($edit) :

				// Initialize basic info
				$variable = [
					'basic' => array('title' => 'Edit '.$username),
					'header' => [
						'title' => 'User Management',
						'description' => 'Edit '.$username.' data',
					],
					'breadcrumb' => [
						'one' => 'User',
						'one_link' => site_url('user'),
						'icon' => 'users',
						'two' => 'Edit User'
					]
				];
				$this->set_variable($variable);

				// Render view
				$param = array();
				$param['user'] = $this->userprofile;
				$param['pages'] = array('user/edit');
				$this->common->backend($param);

			endif;

		endif;

	}

	public function update($username = false) {

		// Check user parameter
		$param = $this->common->check_param($username);

		if ($this->access && $param) :

			$validation = $this->validation('update');

			// Load random string library and set random password
			$param = array();
			$param = [
				'restrict' => 'update',
				'type' => 'where',
				'condition' => array('username' => $username)
			];

			if ($this->user_model->update($param)) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success update '.$this->input->post('username').' data',
					'redirect' => site_url('user/'.$username.'/edit'),
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when update user data, please try again !',
					'redirect' => site_url('user/'.$username.'/edit'),
				];

			endif;

			$this->common->redirect($param);

		endif;

	}
}