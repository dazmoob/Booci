<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

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
		$this->load->model('category_model');
		$this->load->model('user_model');
		$this->ci = &get_instance();

		$this->permit = $this->common->login('error');

		if ($this->permit) :
			$this->usersession = $this->session->userdata('user');
			$this->userdata = $this->usersession['data'];
			$this->useraccess = $this->usersession['access'];
			$this->userlog = $this->usersession['log'];
		endif;
	}

	/*
		=========== Private Function =============
	*/

	private function set_variable($variable = false) {
		$this->basic = $this->common->basic_info(true, $variable);
		$this->header = $this->common->backend_header($variable);
		$this->breadcrumb = $this->common->backend_breadcrumb($variable);
	}

	private function validation($type = false, $ajax = false) {

		$this->load->library('form_validation');
		$status = true;

		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('slug', 'Slug', 'trim|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');

		$param = [
			'alert' => 'success',
			'status' => true,
			'notification' => 'Success validating category !'
		];

		if ($this->form_validation->run() == FALSE) :

			$param['status'] = false;
			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();

			if ($ajax == false)
				$this->common->redirect($param);

		endif;

		if ($ajax == false)
			return true;
		else
			return $param;

	}

	private function set_slug() {

		$this->load->library('slug');

		$slug = $this->input->post('name');

		$response = [
			'status' => 'success',
			'message' => 'New category name !'
		];

		$status = true; $i = 1;
		while ($status) :
			
			$rawSlug = $this->slug->get_slug($slug);
			$param = array(
				'type' => 'where',
				'condition' => array('slug' => $rawSlug, 'name' => $this->input->post('name'))
			);
			$categoryName = $this->category_model->check($param);

			if ($categoryName) :
				$response = [
					'notification' => 'Category name already exist !',
					'alert' => 'danger'
				];
				$slug = $this->slug->set_increment($slug);
			else :
				$slug = $rawSlug;
				$status = false;
			endif;

		endwhile;

		$_POST['slug'] = $slug;

		return $response;

	}

	private function insert_category($id = false, $restrict = false) {

		if (!empty($id) && !empty($this->input->post('category'))) :

			$this->load->model('category_category_model');

			$category = $this->input->post('category');
			foreach ($category as $key => $value) :

				$_POST['category_id'] = $id;
				$_POST['category_id'] = $value;
				
				$param = [
					'type' => 'where',
					'condition' => array('category_id' => $id, 'category_id' => $value)
				];
				$check = $this->category_category_model->check_category_category($param);

				if ($check == false) :
						
					if ($restrict == false) :
						// $this->category_category_model->insert();
					endif;

				endif;

			endforeach;

		endif;

	}

	/*
		=========== Public Function =============
	*/

	public function all($state = false, $page = 0) {

		if ($this->permit) :

			// Initialize basic info
			$variable = array(
				'basic' => array(
					'title' => 'category List'
				),
				'header' => array(
					'title' => 'category',
					'description' => 'All category list in Booci',
				),
				'breadcrumb' => array(
					'one' => 'category',
					'one_link' => site_url('category'),
					'icon' => 'file-text-o',
					'two' => 'List',
				)
			);
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Check state
			$state = (!empty($this->uri->segment(3)) && in_array($this->uri->segment(3), array('publish', 'draft', 'trash'))) ? $this->uri->segment(3) : false;

			$search = (!empty($this->input->get('search'))) ? array('category.title' => $this->input->get('search')) : false;

			// Get categorys data
			$param = array(
				'select' => 'user',
				'join' => 'user',
				'start' => $page,
				'limit' => 10,
				'order_by' => 'category.created_time DESC',
				// Set default get all condition
				'type' => 'where_like',
				'condition' => true,
				'condition_like' => $search,
			);

			// For super admin, admin and editor if access not only all list
			if (!empty($state))
				$param['condition_where'] = array('category.state' => ucfirst($state));

			// For writer if access not only all list
			if ($userdata->level > 3) :
				
				$param['condition_where'] = array('created_by' => $userdata->id);
				
				if (!empty($state))
					$param['condition_where'] = array('created_by' => $userdata->id, 'category.state' => ucfirst($state));

			endif;

			// Set to conut all categorys data
			$param_count = array(
				'select' => 'user',
				'join' => 'user',
				'start' => $page,
				'limit' => 10
			);

			// For writer if access not only all list
			if ($userdata->level > 3) :
				
				$param_count['type'] = 'where';
				$param_count['condition'] = array('created_by' => $userdata->id);

			endif;

			$count = $this->set_count($param_count);
			$categorys = $this->category_model->get_all($param);

			// Set pagination
			$this->load->library('pagination');
			$this->load->model('page_numbering');

			$config = [
				'url' => [
					'uri3' => 'list'
				],
				'param' => [
					'table' => 'category',
					'param' => $param
				],
			];

			if (!empty($state))
				$config['url']['uri3'] = strtolower($state);

			$this->page_numbering->set_pagination($config);

			$param['count'] = $count;
			$param['categorys'] = $categorys;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/iCheck/flat/blue.css');
			$this->additional_js = array('assets/plugins/iCheck/icheck.min.js');

			// Render view
			$param['pages'] = array('category/index');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->permit) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Add New category'),
				'header' => [
					'title' => 'category',
					'description' => 'Create new category',
				],
				'breadcrumb' => [
					'one' => 'category',
					'one_link' => site_url('category'),
					'icon' => 'file-text-o',
					'two' => 'Create New category'
				]
			];
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Get categorys data
			$param = array(
				'select' => 'user',
				'join' => 'user'
			);
			if ($userdata->level > 3) :
				$param['type'] = 'where';
				$param['condition'] = array('created_by' => $userdata->id);
			endif;

			$count = $this->set_count($param);
			$param['count'] = $count;
			$param['categories'] = $this->set_category();

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css', 'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'assets/plugins/jMosaic-master/css/jquery.jMosaic.css', 'assets/plugins/gallery/gallery.css', 'assets/plugins/select2/select2.css', 'assets/plugins/fileinput/css/fileinput.min.css');
			$this->additional_js = array('assets/plugins/bootstrap-wysihtml5/wysihtml5x-toolbar.min.js', 'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.js', 'bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'assets/plugins/jMosaic-master/js/jquery.jMosaic.js', 'assets/plugins/gallery/gallery.js', 'assets/plugins/select2/select2.js', 'assets/plugins/fileinput/js/fileinput.min.js', 'assets/plugins/category/category.js');

			// Render view
			$param['pages'] = array('category/add', 'category/gallery');
			$this->common->backend($param);

		endif;

	}

	public function create() {

		$notification = [
			'notification' => 'Something wrong when create your category',
			'alert' => 'danger'
		];

		if ($this->permit) :

			// Check validation
			$validation = $this->validation();

			if ($validation) :

				// Set slug
				$this->set_slug();

				$id = $this->category_model->insert();

				$notification = [
					'notification' => 'Something wrong when create your category',
					'alert' => 'danger'
				];

				if ($id) :

					$this->insert_category($id);
					$notification = [
						'notification' => 'Category has been added !',
						'alert' => 'success',
						'category' => $this->input->post('name')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function ajaxCreate() {

		$notification = [
			'notification' => "You don't have access to this page !",
			'alert' => 'danger'
		];

		if ($this->permit) :

			// Check validation
			$notification = $this->validation(false, 'ajax');

			if ($notification['status']) :

				// Set slug
				$notification = $this->set_slug();

				$id = $this->category_model->insert();

				$notification = [
					'notification' => 'Something wrong when create your category',
					'alert' => 'danger'
				];

				if ($id) :

					$notification = [
						'notification' => 'Category has been added !',
						'alert' => 'success',
						'id' => $id,
						'category' => $this->input->post('name')
					];

				endif;

			endif;

		endif;

		echo json_encode($notification);

	}

	public function edit($slug = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($this->permit && $param) :

			// Check if user open right username
			$edit = $this->check_edit($slug);

			if ($edit) :

				$userdata = $this->userdata;
				$param = array(
					'type' => 'where',
					'condition' => array('category.slug' => $slug),
				);
				$category = $this->category_model->get_one($param, true);

				if (!empty($category)) :

					// Initialize basic info
					$variable = array(
						'basic' => array(
							'title' => 'Edit category'
						),
						'header' => array(
							'title' => 'category',
							'description' => 'Edit category '.$category->title,
						),
						'breadcrumb' => array(
							'one' => 'category',
							'one_link' => site_url('category'),
							'icon' => 'file-text-o',
							'two' => 'Edit',
							'two_link' => site_url('category'),
							'three' => $category->title
						)
					);
					$this->set_variable($variable);

					// Set additional CSS and JS
					$this->additional_css = array('assets/plugins/fileinput/css/fileinput.min.css');
					$this->additional_js = array('assets/plugins/fileinput/js/fileinput.min.js');

					// Render view
					$param['pages'] = array('category/edit');
					$this->common->backend($param);

				endif;

			endif;

		endif;

	}

	public function update($slug = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($this->permit && $param) :

			// Check if user open right username
			$edit = $this->check_edit($slug);

			if ($edit) :

				// Check validation
				$validation = $this->validation('update');
				if ($validation) :

					$param = array(
						'type' => 'where',
						'condition' => array('slug' => $slug),
						'restrict' => 'update',
					);
					$this->category_model->update($param);

				endif;

			endif;

		endif;

		$this->common->redirect();

	}

	public function changeState() {

		$notification = false;

		if ($this->permit) :

			// Get category ID
			$slugs = $this->input->post('slug');

			$status = true;
			foreach ($slugs as $key => $slug) :

				if ($this->check_edit($slug) == false)
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
				
				if ($this->category_model->update($param)) :

					$notification = [
						'notification' => "Your selected pages has been ".strtolower($this->input->post('state'))."ed successfully !",
						'alert' => 'success'
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function getImage($page = 0) {

		$this->load->model('media_model');
		$param = [
			'where' => array('type' => 'image'),
			'start' => $page,
			'limit' => 5
		];

		$gallery = $this->media_model->get_all($param);

		$paramCount = [
			'select' => 'COUNT(*) as count',
			'where' => array('type' => 'image')
		];
		$count = $this->media_model->count($paramCount);

		$status = (!empty($gallery)) ? true : false;
		$remaining = $count->count - $page - 5;
		$start = $page + 5;

		$data = [
			'status' => $status,
			'data' => $gallery,
			'remaining' => $remaining,
			'start' => $start
		];

		echo json_encode($data);

	}

	public function uploadPicture() {

		$config['upload_path'] = './media/gallery/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
		$config['max_size']	= '1024';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) :
			$response = array('error' => $this->upload->display_errors());
		else :

			// Get user data from session
			$userdata = $this->userdata;

			// Upload file data
			$upload_file = $this->upload->data();
			$upload_filename = 'media/gallery/'.$upload_file['client_name'];
			$rawImage = str_replace('-', ' ', $upload_file['raw_name']);
			$rawImage = str_replace('_', ' ', $rawImage);
			$typeImage = $upload_file['file_type'];
			$typeImage = explode('/', $typeImage);
			
			// Set POST for user upload picture
			$_POST['title'] = ucwords($rawImage);
			$_POST['filename'] = $upload_file['client_name'];
			$_POST['type'] = $typeImage[0];
			$_POST['src'] = $upload_filename;
			$_POST['created_time'] = date('Y-m-d H:i:s');
			$_POST['created_by'] = $userdata->id;
			$_POST['updated_time'] = date('Y-m-d H:i:s');
			$_POST['updated_by'] = $userdata->id;

			// Insert process
			$this->load->model('media_model');
			$insert = $this->media_model->insert();

			if ($insert) :

				$response = array(
					'data' => $upload_file,
					'file' => $upload_filename
				);

			else :
				$response = array('error' => $this->upload->display_errors());
			endif;

		endif;

		echo json_encode($response);

	}

}		