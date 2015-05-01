<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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

		$this->permit = $this->common->login('error');
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

	private function check_edit($username = false) {

		$userdata = $this->userdata;
		$status = true;
		
		if ($username != $userdata->username) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
			$this->common->error($code);
			$status = false;

		endif;

		return $status;

	}

	private function validation($type = false) {

		$this->load->library('form_validation');
		$status = true;

		if ($type == 'update') :

			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('facebook', 'Facebook', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('twitter', 'Twitter', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('google', 'Google', 'prep_url|trim|xss_clean');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');

		elseif ($type == 'password') :

			$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('retype_password', 'Retype Password', 'required|trim|xss_clean|min_length[6]|matches[new_password]');

		endif;


		if ($this->form_validation->run() == FALSE) :
			
			$notification = [
				'notification' => validation_errors(),
				'alert' => 'danger',
				'redirect' => site_url('profile/'.$this->userdata->username.'/edit')
			];

			$this->common->redirect($notification);

			$status = false;
		
		endif;

		return $status;

	}

	/*
		=========== Public Function =============
	*/

	public function index($username = false) {

		// Check user parameter
		$param = $this->common->check_param($username);

		if ($this->permit && $param) :

			$param = array(
				'type' => 'where',
				'condition' => array('username' => $username, 'state' => 'active'),
			);
			$user = $this->user_model->get_one($param, true);

			if (!empty($user)) :

				// Initialize basic info
				$variable = array(
					'basic' => array(
						'title' => $user->name
					),
					'header' => array(
						'title' => 'Profile',
						'description' => $user->name.' profile details',
					),
					'breadcrumb' => array(
						'one' => 'Dashboard',
						'one_link' => site_url('dashboard'),
						'icon' => 'dashboard',
						'two' => 'Profile',
						'two_link' => site_url('profile/'.$user->username),
						'three' => $user->username
					)
				);
				$this->set_variable($variable);

				// Get user activities data
				$this->load->model('activities_log_model');
				$this->load->helper('elapsed');

				$param = array(
					'limit' => 5,
					'order_by' => 'created_time DESC',
					'type' => 'where',
					'condition' => array('user_id' => $user->id)
				);
				$activities = $this->activities_log_model->get_all($param);

				// Set additional CSS and JS
				$this->additional_css = array('assets/plugins/fileinput/css/fileinput.min.css');
				$this->additional_js = array('assets/plugins/fileinput/js/fileinput.min.js');

				// Set additional variable
				$this->level = $this->user_model->level_super;

				// Render view
				$param['user'] = $user;
				$param['activities'] = $activities;
				$param['pages'] = array('profile/picture', 'profile/show', 'profile/password', 'profile/activity');
				$this->common->backend($param);

			endif;

		endif;

	}

	public function edit($username = false) {

		// Check user parameter
		$param = $this->common->check_param($username);

		if ($this->permit && $param) :

			// Check if user open right username
			$edit = $this->check_edit($username);

			if ($edit) :

				$session = $this->usersession;
				$data = $session['data'];
				$param = array(
					'type' => 'where',
					'condition' => array('username' => $data->username, 'state' => 'active'),
				);
				$user = $this->user_model->get_one($param);

				if (!empty($user)) :

					// Initialize basic info
					$variable = array(
						'basic' => array(
							'title' => $user->name
						),
						'header' => array(
							'title' => 'Profile',
							'description' => $user->name.' profile details',
						),
						'breadcrumb' => array(
							'one' => 'Dashboard',
							'one_link' => site_url('dashboard'),
							'icon' => 'dashboard',
							'two' => 'Profile',
							'two_link' => site_url('profile/'.$user->username),
							'three' => $user->username
						)
					);
					$this->set_variable($variable);

					// Set additional CSS and JS
					$this->additional_css = array('assets/plugins/fileinput/css/fileinput.min.css');
					$this->additional_js = array('assets/plugins/fileinput/js/fileinput.min.js');

					// Render view
					$param['pages'] = array('profile/edit', 'profile/password', 'profile/picture');
					$this->common->backend($param);

				endif;

			endif;

		endif;

	}

	public function uploadPicture() {

		$config['upload_path'] = './media/profile/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
		$config['max_size']	= '100';
		$config['max_width'] = '160';
		$config['max_height'] = '160';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) :
			$response = array('error' => $this->upload->display_errors());
		else :

			// Get user data from session
			$user = $this->session->userdata('user');
			$userdata = $user['data'];

			// Get user data from database
			$param = array(
				'type' => 'where',
				'condition' => array('id' => $userdata->id, 'state' => 'active'),
			);
			$data = $this->user_model->get_one($param);

			// Upload file data
			$upload_file = $this->upload->data();
			$upload_filename = 'media/profile/'.$upload_file['client_name'];

			// Set POST for user upload picture
			$_POST['picture'] = $upload_file['client_name'];
			$_POST['picture_path'] = $upload_filename;

			// Update process
			$param = array(
				'type' => 'where',
				'condition' => array('id' => $userdata->id, 'state' => 'active'),
				'restrict' => 'upload'
			);
			$update = $this->user_model->update($param);

			if ($update) :

				// Delete old profile picture
				if (file_exists('./'.$data->picture_path)) :
					unlink('./'.$data->picture_path);
				endif;

				// Set response data
				$response = array(
					'data' => $upload_file,
					'file' => $upload_filename
				);

				// Unset current user session
				$this->session->unset_userdata('user');

				// Get user data from database
				$param = array(
					'type' => 'where',
					'condition' => array('id' => $userdata->id, 'state' => 'active'),
				);
				$data = $this->user_model->get_one($param);

				// Set user data after login
				$userdata = array(
					'data' => $data,
					'access' => $user['access'],
					'log' => $user['log']
				);
				$this->session->set_userdata('user', $userdata);

			else :
				$response = array('error' => $this->upload->display_errors());
			endif;

		endif;

		echo json_encode($response);

	}

	public function update($username = false) {

		$this->load->library('encrypt');

		// Check user parameter
		$param = $this->common->check_param($username);

		if ($this->permit && $param) :

			// Check password for username
			$username = $this->input->post('username');
			$param = array(
				'type' => 'where',
				'select' => 'all',
				'condition' => array('username' => $this->input->post('username'), 'state' => 'active')
			);

			$user = $this->user_model->check_login($param);

			// Check user password match with username
			if ($user) :

				// Check validation
				$validation = $this->validation('update');
				if ($validation) :

					$param = array(
						'type' => 'where',
						'condition' => array('username' => $user->username, 'state' => 'active'),
						'restrict' => 'update',
					);
					$this->user_model->update($param);

				endif;

			endif;

		endif;

		$this->common->redirect();

	}

	public function changePassword() {

		$this->load->library('encrypt');

		if ($this->permit) :

			$username = $this->userdata->username;

			$param = array(
				'type' => 'where',
				'condition' => array('username' => $username, 'state' => 'active'),
			);
			$user = $this->user_model->check_login($param);

			$param['alert'] = 'danger';
			$param['notification'] = 'Old password is wrong !';

			if ($user) :

				// Check validation
				$validation = $this->validation('password');

				if ($validation) :

					$_POST['password'] = $this->encrypt->encode($this->input->post('new_password'));

					$param = array(
						'type' => 'where',
						'condition' => array('username' => $username, 'state' => 'active'),
						'restrict' => 'password',
					);
					$this->user_model->update($param);

					$param['alert'] = 'success';
					$param['notification'] = 'Your passwrod has been successfully update ! Please <a href="'.site_url('login/logout').'">logout</a> to retrieve new session';

				endif;

			endif;

		endif;

		$this->common->redirect($param);

	}

}