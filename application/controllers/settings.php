<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

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

	/*
		=========== Public Function =============
	*/

	public function basic($page = 0) {

		if ($this->access) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Basic Settings'),
				'header' => [
					'title' => 'Basic Settings',
					'description' => 'Basic configuration for web detail and basic info',
				],
				'breadcrumb' => [
					'one' => 'Settings',
					'one_link' => site_url('settings/basic'),
					'icon' => 'wrench',
					'two' => 'Basic'
				]
			];
			$this->set_variable($variable);

			// Set basic data
			$basic = [
				'type' => 'where', 
				'type' => array('id' => 1)
			];

			$param['basic'] = $this->web_model->get_one($basic);

			// Set additional CSS and JS
			$this->additional_css = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
			$this->additional_js = array('bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');

			// Render view
			$param['pages'] = array('settings/basic');
			$this->common->backend($param);

		endif;

	}

	public function updateBasic() {

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

	public function navigation($page = 0) {

		if ($this->access) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Navigation Settings'),
				'header' => [
					'title' => 'Navigation Settings',
					'description' => 'Navigation configuration for web menu and navigating',
				],
				'breadcrumb' => [
					'one' => 'Settings',
					'one_link' => site_url('settings/navigation'),
					'icon' => 'list',
					'two' => 'Navigation'
				]
			];
			$this->set_variable($variable);

			// Set basic data
			$param['navigation'] = $this->navigation_model->get_all($param);

			// Set additional CSS and JS
			$this->additional_css = array('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
			$this->additional_js = array('bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');

			// Render view
			$param['pages'] = array('settings/navigation/index');
			$this->common->backend($param);

		endif;

	}

	public function updateNavigation() {

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