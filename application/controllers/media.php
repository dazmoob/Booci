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
		$this->ci = &get_instance();

		$this->load->model('media_model');
		$this->load->model('user_model');

		$this->load->helper('label_icon_helper');
		$this->load->helper('elapsed_helper');

		$this->load->library('upload_config');

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
		
		if ($this->form_validation->run() == FALSE) :
			
			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();
			$param['redirect'] = site_url('media');

			$this->common->redirect($param);
		
		endif;

		return true;

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
					'icon' => 'film',
					'two' => 'List',
				)
			);
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Check state
			$state = 'image';
			$state = (!empty($this->uri->segment(3)) && in_array($this->uri->segment(3), array('image', 'audio', 'video', 'file'))) ? $this->uri->segment(3) : false;

			$search = (!empty($this->input->get('search'))) ? array('media.title' => $this->input->get('search')) : false;

			// Get media data
			$param = array(
				'select' => 'user',
				'join' => 'user',
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
				$param['condition_where'] = array('media.type' => $state);

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
				'param' => [
					'table' => 'media',
					'param' => $param
				],
			];

			if (!empty($state))
				$config['url']['uri3'] = $state;

			$this->page_numbering->set_pagination($config);

			$param['count'] = $count;
			$param['media'] = $media;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/iCheck/flat/blue.css');
			$this->additional_js = array('assets/plugins/iCheck/icheck.min.js');

			// Render view
			$param['pages'] = array('media/index', 'media/edit');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->access) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Add New media'),
				'header' => [
					'title' => 'Media Management',
					'description' => 'Upload new media',
				],
				'breadcrumb' => [
					'one' => 'media',
					'one_link' => site_url('media'),
					'icon' => 'medias',
					'two' => 'Create New media'
				]
			];
			$this->set_variable($variable);

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/fileinput/css/fileinput.min.css');
			$this->additional_js = array('assets/plugins/fileinput/js/fileinput.min.js');

			// Render view
			$param['pages'] = array('media/add');
			$this->common->backend($param);

		endif;

	}

	public function uploadFiles() {

		$count = count($_FILES['userfile']['size']);

		foreach ($_FILES as $key => $value) :

			for ($i = 0; $i <= $count-1; $i++) :

				// Set data for each files
				$_FILES['userfile']['name']= $value['name'][$i];
		        $_FILES['userfile']['type']= $value['type'][$i];
		        $_FILES['userfile']['tmp_name']= $value['tmp_name'][$i];
		        $_FILES['userfile']['error']= $value['error'][$i];
		        $_FILES['userfile']['size']= $value['size'][$i];

		        // Get files type
		        $type = $value['type'][$i];
		        $config = $this->upload_config->set_config($type);

		        // Set upload configuration
				$this->load->library('upload', $config);

		        if (!$this->upload->do_upload()) :

					$response = array('error' => $this->upload->display_errors());

				else :

					// Get user data from session
					$userdata = $this->userdata;

					// Upload file data
					$uploadFile = $this->upload->data();

					$fileSource = $config['upload_src'].$uploadFile['file_name'];
					$rawFile = str_replace('-', ' ', $uploadFile['raw_name']);
					$rawFile = str_replace('_', ' ', $rawFile);
					$fileType = $uploadFile['file_type'];
					$fileType = explode('/', $fileType);
					
					// Set POST for user upload files
					$_POST['title'] = ucwords($rawFile);
					$_POST['filename'] = $uploadFile['file_name'];
					$_POST['type'] = $fileType[0];
					$_POST['src'] = $fileSource;
					$_POST['created_time'] = date('Y-m-d H:i:s');
					$_POST['created_by'] = $userdata->id;
					$_POST['updated_time'] = date('Y-m-d H:i:s');
					$_POST['updated_by'] = $userdata->id;

					// Insert process
					$this->load->model('media_model');
					$insert = $this->media_model->insert();

					if ($insert) :

						$response = array(
							'data' => $uploadFile,
							'file' => $fileSource
						);

					else :
						$response = array('error' => $this->upload->display_errors());
					endif;

				endif;

				echo json_encode($response);

		    endfor;

		endforeach;
	}

	public function edit($filename = false) {

		// Check media parameter
		$param = $this->common->check_param($filename);

		if ($this->access && $param) :

			// Check if media open right filename
			$edit = $this->check_edit($filename);

			if ($edit) :

				// Initialize basic info
				$variable = [
					'basic' => array('title' => 'Edit '.$filename),
					'header' => [
						'title' => 'media Management',
						'description' => 'Edit '.$filename.' data',
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

	public function update($filename = false) {

		// Check media parameter
		$param = $this->common->check_param($filename);

		if ($this->access && $param) :

			$validation = $this->validation();

			// Check validation
			if ($validation) :

				// Set creator / updater
				$userdata = $this->userdata;
				$_POST['updated_by'] = $userdata->id;
				$_POST['updated_time'] = date('Y-m-d H:i:s');

				// Set update parameter
				$param = array();
				$param = [
					'restrict' => 'update',
					'type' => 'where',
					'condition' => array('filename' => $filename)
				];

				if ($this->media_model->update($param)) :

					$param = [
						'alert' => 'success',
						'notification' => 'Success update '.$this->input->post('filename').' data',
						'redirect' => site_url('media/'.$this->input->post('type')),
					];

				else :

					$param = [
						'alert' => 'danger',
						'notification' => 'Something wrong when update media data, please try again !',
						'redirect' => site_url('media/'.$filename.'/edit'),
					];

				endif;

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function delete($filename = false) {

		// Check media parameter
		$param = $this->common->check_param($filename);

		if ($this->access && $param) :

			// Set delete parameter
			$param = array();
			$param = [
				'type' => 'where',
				'condition' => array('filename' => $filename)
			];

			// Get media data first and save image path
			$media = $this->media_model->get_one($param);
			$path = $media->src;

			if ($this->media_model->delete($param)) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success delete '.$media->filename.' image, now file is no longer exist',
					'redirect' => site_url('media/'.$media->type),
				];

				// Delete old files
				if (file_exists('./'.$path)) :
					unlink('./'.$path);
				endif;

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when delete media data, please try again !',
					'redirect' => site_url('media/'.$media->type),
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function changeState() {

		$notification = false;

		if ($this->access) :

			// Get article ID
			$slugs = $this->input->post('slug');

			$status = true;
			foreach ($slugs as $key => $slug) :

				if ($this->check_access($slug) == false)
					$status = false;

			endforeach;

			if ($status && $slugs) :

				// Set creator / updater
				$userdata = $this->userdata;
				$_POST['updated_by'] = $userdata->id;

				$param = array(
					'type' => 'where_in',
					'condition' => true,
					'condition_column' => 'slug',
					'condition_keyword' => $slugs,
					'restrict' => 'state',
				);
				
				if ($this->article_model->update($param)) :

					$notification = [
						'notification' => "Your selected pages has been ".strtolower($this->input->post('state'))."ed successfully !",
						'alert' => 'success'
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

}