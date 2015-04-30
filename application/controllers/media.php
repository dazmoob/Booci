<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {

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
	 * @see http://codeigniter.com/media_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model('media_model');
		$this->load->model('user_model');
		$this->ci = &get_instance();

		$this->access = $this->common->access('c_media');
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

	private function set_count($param = false) {

		$data = array(); $data['total'] = 0;
		$param['select'] = 'type, COUNT(*) as count';
		$param['join'] = false;
		$counts = $this->media_model->count($param);

		if (!empty($counts)) :
			$total = 0;
			foreach ($counts as $count) :
				$data[$count->type] = $count->count;
				$total = $total + $count->count;
			endforeach;
			$data['total'] = $total;
		endif;

		return $data;

	}

	private function validation($type = false) {

		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean');
		$this->form_validation->set_rules('update_time', 'Update Time', 'trim|xss_clean');
		$this->form_validation->set_rules('update_by', 'Updater', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) :
			
			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();
			$param['redirect'] = site_url('media');

			$this->common->redirect($param);
		
		endif;

	}

	/*
		=========== Public Function =============
	*/

	public function index($state = false, $page = 0) {

		if ($this->access) :

			// Initialize basic info
			$variable = array(
				'basic' => array(
					'title' => 'Media List'
				),
				'header' => array(
					'title' => 'Media Management',
					'description' => 'All media list in Booci',
				),
				'breadcrumb' => array(
					'one' => 'Media',
					'one_link' => site_url('media'),
					'icon' => 'picture',
					'two' => 'List',
				)
			);
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Check state
			$state = 'image';
			$state = (!empty($this->uri->segment(3)) && in_array($this->uri->segment(3), array('image', 'audio', 'video', 'file'))) ? $this->uri->segment(3) : false;

			$search = (!empty($this->input->get('search'))) ? array('media.title' => $this->input->get('search')) : false;

			// Get articles data
			$param = array(
				'start' => $page,
				'limit' => 10,
				'order_by' => 'media.created_time DESC',
				// Set default get all condition
				'type' => 'where_like',
				'condition' => true,
				'condition_like' => $search,
			);

			// For super admin, admin and editor if access not only all list
			if (!empty($state))
				$param['condition_where'] = array('media.type' => ucfirst($state));

			// Set to count all articles data
			$param_count = array(
				'start' => $page,
				'limit' => 10
			);

			$count = $this->set_count($param_count);
			$media = $this->media_model->get_all($param);

			// Set pagination
			$this->load->library('pagination');
			$this->load->model('page_numbering');

			$config = [
				'url' => [
					'uri3' => 'list'
				],
				'param' => [
					'table' => 'media',
					'param' => $param
				],
			];

			if (!empty($state))
				$config['url']['uri3'] = strtolower($state);

			$this->page_numbering->set_pagination($config);

			$param['count'] = $count;
			$param['media'] = $media;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/iCheck/flat/blue.css');
			$this->additional_js = array('assets/plugins/iCheck/icheck.min.js');

			// Render view
			$param['pages'] = array('media/index');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->access) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Add New media'),
				'header' => [
					'title' => 'media Management',
					'description' => 'Create a media',
				],
				'breadcrumb' => [
					'one' => 'media',
					'one_link' => site_url('media'),
					'icon' => 'medias',
					'two' => 'Create New media'
				]
			];
			$this->set_variable($variable);

			// Render view
			$param['pages'] = array('media/add');
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

		if ($this->media_model->insert()) :

			$param = [
				'alert' => 'success',
				'notification' => 'Success create '.$this->input->post('medianame').' with password '.$password,
				'redirect' => site_url('media/add'),
			];

		else :

			$param = [
				'alert' => 'danger',
				'notification' => 'Something wrong when add new media, please try again !',
				'redirect' => site_url('media/add'),
			];

		endif;

		$this->common->redirect($param);

	}

	public function edit($medianame = false) {

		// Check media parameter
		$param = $this->common->check_param($medianame);

		if ($this->access && $param) :

			// Check if media open right medianame
			$edit = $this->check_edit($medianame);

			if ($edit) :

				// Initialize basic info
				$variable = [
					'basic' => array('title' => 'Edit '.$medianame),
					'header' => [
						'title' => 'media Management',
						'description' => 'Edit '.$medianame.' data',
					],
					'breadcrumb' => [
						'one' => 'media',
						'one_link' => site_url('media'),
						'icon' => 'medias',
						'two' => 'Edit media'
					]
				];
				$this->set_variable($variable);

				// Render view
				$param = array();
				$param['media'] = $this->mediaprofile;
				$param['pages'] = array('media/edit');
				$this->common->backend($param);

			endif;

		endif;

	}

	public function update($medianame = false) {

		// Check media parameter
		$param = $this->common->check_param($medianame);

		if ($this->access && $param) :

			$validation = $this->validation('update');

			// Load random string library and set random password
			$param = array();
			$param = [
				'restrict' => 'update',
				'type' => 'where',
				'condition' => array('medianame' => $medianame)
			];

			if ($this->media_model->update($param)) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success update '.$this->input->post('medianame').' data',
					'redirect' => site_url('media/'.$medianame.'/edit'),
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when update media data, please try again !',
					'redirect' => site_url('media/'.$medianame.'/edit'),
				];

			endif;

			$this->common->redirect($param);

		endif;

	}
}