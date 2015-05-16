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
		$this->load->model('navigation_model');
		$this->load->model('navigation_link_model');
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

			// Get menus data
			$param = array(
				'order_by' => 'navigation.id ASC',
				'type' => 'where',
				'condition' => array('state' => 'active'),
			);

			$param['navigations'] = $this->navigation_model->get_all();

			// Render view
			$param['pages'] = array('settings/navigation/index');
			$this->common->backend($param);

		endif;

	}

	public function createNavigation() {

		if ($this->access) :

			$validation = $this->navigationValidation();

			// Set navigation slug
			$this->set_slug();

			if ($this->navigation_model->insert()) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success create '.$this->input->post('name').' menu',
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when create new menu, please try again !',
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function editNavigation($slug = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($this->access && $param) :

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

			// Get edited navigation
			$param = array(
				'type' => 'where',
				'condition' => array('navigation.slug' => $slug),
			);
			$navigation = $this->navigation_model->get_one($param);

			// Check navigation data
			if (empty($navigation)) :

				$param = [
					'alert' => 'danger',
					'notification' => 'Navigation data not found !',
					'redirect' => site_url('settings/navigation')
				];

				$this->common->redirect($param);

			endif;

			// Get edited navigation link
			$param = array(
				'order_by' => 'navigation_link.sequence DESC',
				'select' => 'navigation',
				'join' => 'navigation',
				'type' => 'where',
				'condition' => array('navigation.slug' => $slug),
			);
			$navigation_link = $this->navigation_link_model->get_all($param);

			// Get menus data
			$param = array(
				'order_by' => 'navigation.id ASC',
				'type' => 'where',
				'condition' => array('state' => 'active'),
			);
			$navigations = $this->navigation_model->get_all();

			$param['navigation'] = $navigation;
			$param['navigation_link'] = $navigation_link;
			$param['navigations'] = $navigations;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/gridstack/gridstack.css');
			$this->additional_js = array('assets/js/jquery-ui-1.11.4/jquery-ui.min.js', 'assets/plugins/gridstack/jquery.ui.touch-punch.js', 'assets/plugins/gridstack/lodash.js', 'assets/plugins/gridstack/gridstack.js', 'assets/plugins/navigation/navigation.js');

			// Render view
			$param['pages'] = array('settings/navigation/edit');
			$this->common->backend($param);

		endif;

	}

	public function updateNavigation($slug = false) {

		if ($this->access && $slug) :

			$validation = $this->navigationValidation('update');

			// Load random string library and set random password
			$param = array();
			$param = [
				'restrict' => 'update',
				'type' => 'where',
				'condition' => array('slug' => $slug)
			];

			if ($this->navigation_model->update($param)) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success update '.$this->input->post('name').' navigation data',
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when update navigation data, please try again !',
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function updateNavigationLocation($slug = false) {

		if ($this->access && $slug) :

			// Get edited navigation link - Reverse
			$param = array(
				'order_by' => 'navigation_link.sequence ASC',
				'select' => 'navigation',
				'join' => 'navigation',
				'type' => 'where',
				'condition' => array('navigation.slug' => $slug),
			);
			$navigation_link_r = $this->navigation_link_model->get_all($param);

			$links = array();
			if (!empty($navigation_link_r)) :

        		foreach ($navigation_link_r as $link) :

        			array_push($links, $link->link_id);

        		endforeach;

        	endif;

			// Get new links
			$new_links = $this->input->post('new_links');

			$param = [
				'alert' => 'danger',
				'notification' => 'Something wrong when update navigation data, please try again !',
			];

			if (!empty($new_links)) :

				// Set new links
				$new_links = explode(',', $new_links);
				krsort($new_links);

				$length = count($new_links); $i = 1;
				$data = array();

				// Set data for links
				foreach ($new_links as $key => $value) :

					if ($i <= $length) :

						$linkData = array(
							'id' => $links[$value],
							'sequence' => $i
						);

						array_push($data, $linkData);

						$i++;

					endif;

				endforeach;

				// Load random string library and set random password
				$param = array();
				$param = [
					'batch' => true,
					'batch_data' => $data,
					'batch_key' => 'id',
				];

				$this->navigation_link_model->update($param);

				$param = [
					'alert' => 'success',
					'notification' => 'Success update navigation location data',
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function updateNavigationLink($id = false) {

		if ($this->access && $id) :

			// Get new post
			$new = $this->input->post('new');

			if ($new == 'true') :

				$validation = $this->navigationValidation('create_link');

				$_POST['navigation_id'] = $id;

				if ($this->navigation_link_model->insert()) :

					$param = [
						'alert' => 'success',
						'notification' => 'Success update '.$this->input->post('name').' navigation data',
					];

				else :

					$param = [
						'alert' => 'danger',
						'notification' => 'Something wrong when update navigation data, please try again !',
					];

				endif;

			else : 

				$validation = $this->navigationValidation('update_link');

				// Load random string library and set random password
				$param = array();
				$param = [
					'restrict' => 'update',
					'type' => 'where',
					'condition' => array('id' => $new)
				];

				if ($this->navigation_link_model->update($param)) :

					$param = [
						'alert' => 'success',
						'notification' => 'Success update '.$this->input->post('label').' link data',
					];

				else :

					$param = [
						'alert' => 'danger',
						'notification' => 'Something wrong when update link data, please try again !',
					];

				endif;

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function deleteNavigation($slug = false) {

		if ($this->access && $slug) :

			// Load random string library and set random password
			$param = array();
			$param = [
				'type' => 'where',
				'condition' => array('slug' => $slug)
			];

			if ($this->navigation_model->delete($param)) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success delete navigation data',
					'redirect' => site_url('settings/navigation')
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when delete navigation data, please try again !',
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function deleteNavigationLink($id = false) {

		if ($this->access && $id) :

			// Load random string library and set random password
			$param = array();
			$param = [
				'type' => 'where',
				'condition' => array('id' => $id)
			];

			if ($this->navigation_link_model->delete($param)) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success delete navigation link',
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when delete navigation link, please try again !',
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	private function navigationValidation($type = false) {

		$this->load->library('form_validation');
		$status = true;

		if ($type == 'update') :
			
			$this->form_validation->set_rules('name', 'Navigation name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('status', 'Navigation status', 'required|trim|xss_clean');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');

		elseif ($type == 'create_link') :
			
			$this->form_validation->set_rules('url', 'Links URL', 'required|prep_url|xss_clean');
			$this->form_validation->set_rules('label', 'Links label', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Links for CSS class', 'trim|xss_clean');
			$this->form_validation->set_rules('rel', 'Links Rel', 'trim|xss_clean');
			$this->form_validation->set_rules('target', 'Links Target', 'trim|xss_clean');
			$this->form_validation->set_rules('sequence', 'Links Sequence', 'required|trim|xss_clean');

		elseif ($type == 'update_link') :
			
			$this->form_validation->set_rules('url', 'Links URL', 'required|prep_url|xss_clean');
			$this->form_validation->set_rules('label', 'Links label', 'required|trim|xss_clean');
			$this->form_validation->set_rules('class', 'Links for CSS class', 'trim|xss_clean');
			$this->form_validation->set_rules('rel', 'Links Rel', 'trim|xss_clean');
			$this->form_validation->set_rules('target', 'Links Target', 'trim|xss_clean');

		else :

			$this->form_validation->set_rules('name', 'Navigation name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('status', 'Navigation status', 'required|trim|xss_clean');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');

		endif;

		if ($this->form_validation->run() == FALSE) :

			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();

			$this->common->redirect($param);

		endif;

		return true;

	}

	private function set_slug($oldSlug = false) {

		$this->load->library('slug');

		$slug = $this->input->post('name');

		$status = true; $i = 1;
		while ($status) :
			
			$rawSlug = $this->slug->get_slug($slug);
			$param = array(
				'type' => 'where',
				'condition' => array('slug' => $rawSlug)
			);
			$navigationSlug = $this->navigation_model->check($param);

			if ($navigationSlug) :
				$slug = $this->slug->set_increment($rawSlug, $i);
			else :
				$slug = $rawSlug;
				$status = false;
			endif;

			// Check slug for update
			if (!empty($oldSlug)) :

				if ($oldSlug == $rawSlug) :
					$slug = $oldSlug;
					$status = false;
				endif;

			endif;

		endwhile;

		$_POST['slug'] = $slug;

	}

}	