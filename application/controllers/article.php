<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

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
		$this->load->model('article_model');
		$this->load->model('user_model');
		$this->load->helper('label_icon_helper');
		$this->load->helper('elapsed_helper');
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

	private function check_access($slug = false) {

		$userdata = $this->userdata;

		// Get article data
		$param = array('slug' => $slug);
		if ($userdata->level > 3)
			$param['user_id'] = $userdata->id;
		$article = $this->article_model->check_article($param);
		
		if ($article == false) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'backend', 'type' => 404);
			$this->common->error($code);

		endif;

		return $article;

	}

	private function validation($type = false) {

		$this->load->library('form_validation');
		$status = true;

		$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
		$this->form_validation->set_rules('content', 'Content', 'trim');
		$this->form_validation->set_rules('excerpt', 'Excerpt', 'trim|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) :

			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();

			$this->common->redirect($param);

		endif;

		return true;

	}

	private function set_count($param = false) {

		$data = array(); $data['total'] = 0;
		$param['select'] = 'state, COUNT(*) as count';
		$param['join'] = false;
		$counts = $this->article_model->count($param);

		if (!empty($counts)) :
			$total = 0;
			foreach ($counts as $count) :
				$data[$count->state] = $count->count;
				$total = $total + $count->count;
			endforeach;
			$data['total'] = $total;
		endif;

		return $data;

	}

	private function set_category($param = false) {

		$this->load->model('category_model');
		$result = $this->category_model->get_all($param);

		$category = array();
		foreach ($result as $result) :
			$category[$result->id] = $result->name;
		endforeach;

		return $category;

	}

	private function set_selected_category($param = false) {

		$this->load->model('article_category_model');
		$result = $this->article_category_model->get_all($param);

		$category = array();
		foreach ($result as $result) :
			array_push($category, $result->category_id);
		endforeach;

		return $category;

	}

	private function set_slug($oldSlug = false) {

		$this->load->library('slug');

		if (!empty($this->input->post('slug'))) :
			$slug = $this->input->post('slug');
		else :
			$slug = $this->input->post('title');
		endif;

		$status = true; $i = 1;
		while ($status) :
			
			$rawSlug = $this->slug->get_slug($slug);
			$param = array(
				'type' => 'where',
				'condition' => array('slug' => $rawSlug)
			);
			$articleSlug = $this->article_model->check_slug($param);

			if ($articleSlug) :
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

	private function insert_category($id = false, $restrict = false) {

		$this->load->model('article_category_model');

		if (!empty($id) && !empty($this->input->post('category'))) :

			// Delete category data
			if ($restrict == 'update') :

				$param = array(
					'type' => 'where_in',
					'condition' => true,
					'condition_column' => 'article_id',
					'condition_keyword' => $id
				);
				
				$this->article_category_model->delete($param);

			endif;

			$category = $this->input->post('category');
			foreach ($category as $key => $value) :

				echo $_POST['article_id'] = $id;
				echo $_POST['category_id'] = $value;
				
				$param = [
					'type' => 'where',
					'condition' => array('article_id' => $id, 'category_id' => $value)
				];
				$check = $this->article_category_model->check_article_category($param);

				if ($check == false) 
					$this->article_category_model->insert();

			endforeach;

		elseif (!empty($restrict == 'update') && empty($this->input->post('category'))) :

			// Delete category data
			if ($restrict == 'update') :

				$param = array(
					'type' => 'where_in',
					'condition' => true,
					'condition_column' => 'article_id',
					'condition_keyword' => $id
				);
				
				$this->article_category_model->delete($param);

			endif;

		endif;

	}

	/*
		=========== Public Function =============
	*/

	public function index($page = 0) {

		// Check search
		$search = (!empty($this->input->get('search'))) ? array('article.title' => $this->input->get('search')) : false;

		// Get articles data
		$param = array(
			'select' => 'user',
			'join' => 'user',
			'start' => $page,
			'limit' => 5,
			'order_by' => 'article.created_time DESC',
			// Set default get all condition
			'type' => 'where_like',
			'condition' => true,
			'condition_like' => $search,
			'condition_where' => array('article.state' => 'publish')
		);

		$articles = $this->article_model->get_all($param);

		// Set pagination
		$this->load->library('pagination');
		$this->load->model('page_numbering');

		$config = [
			'url' => [
				'fix' => site_url('article')
			],
			'per_page' => 5,
			'param' => [
				'table' => 'article',
				'param' => $param
			],
		];

		$this->page_numbering->set_pagination($config);

		$param['articles'] = $articles;

		// Render view
		$param['pages'] = array('article/index');
		$this->common->frontend($param);

	}

	public function all($state = false, $page = 0) {

		if ($this->permit) :

			// Initialize basic info
			$variable = array(
				'basic' => array(
					'title' => 'Article List'
				),
				'header' => array(
					'title' => 'Article',
					'description' => 'All article list in Booci',
				),
				'breadcrumb' => array(
					'one' => 'Article',
					'one_link' => site_url('article'),
					'icon' => 'file-text-o',
					'two' => 'List',
				)
			);
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Check state
			$state = (!empty($this->uri->segment(3)) && in_array($this->uri->segment(3), array('publish', 'draft', 'trash'))) ? $this->uri->segment(3) : false;

			$search = (!empty($this->input->get('search'))) ? array('article.title' => $this->input->get('search')) : false;

			// Get articles data
			$param = array(
				'select' => 'user',
				'join' => 'user',
				'start' => $page,
				'limit' => 10,
				'order_by' => 'article.created_time DESC',
				// Set default get all condition
				'type' => 'where_like',
				'condition' => true,
				'condition_like' => $search,
			);

			// For super admin, admin and editor if access not only all list
			if (!empty($state))
				$param['condition_where'] = array('article.state' => ucfirst($state));

			// For writer if access not only all list
			if ($userdata->level > 3) :
				
				$param['condition_where'] = array('created_by' => $userdata->id);
				
				if (!empty($state))
					$param['condition_where'] = array('created_by' => $userdata->id, 'article.state' => ucfirst($state));

			endif;

			// Set to conut all articles data
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
			$articles = $this->article_model->get_all($param);

			// Set pagination
			$this->load->library('pagination');
			$this->load->model('page_numbering');

			$config = [
				'url' => [
					'uri3' => 'list'
				],
				'param' => [
					'table' => 'article',
					'param' => $param
				],
			];

			if (!empty($state))
				$config['url']['uri3'] = strtolower($state);

			$this->page_numbering->set_pagination($config);

			$param['count'] = $count;
			$param['articles'] = $articles;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/iCheck/flat/blue.css');
			$this->additional_js = array('assets/plugins/iCheck/icheck.min.js');

			// Render view
			$param['pages'] = array('article/index');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->permit) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Add New Article'),
				'header' => [
					'title' => 'Article',
					'description' => 'Create new article',
				],
				'breadcrumb' => [
					'one' => 'Article',
					'one_link' => site_url('article'),
					'icon' => 'file-text-o',
					'two' => 'Create New Article'
				]
			];
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Get articles data
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
			$param['pages'] = array('article/add', 'article/gallery');
			$this->common->backend($param);

		endif;

	}

	public function create() {

		if ($this->permit) :

			// Check validation
			$validation = $this->validation();

			if ($validation) :

				// Set slug
				$this->set_slug();

				// Set state
				$this->input->post('state');
				if (!empty($this->input->post('created_time'))) :
					$this->load->library('datetimes');
					$diff = $this->datetimes->datetime_status($this->input->post('created_time'));
					$_POST['state'] = ($diff) ? 'Publish' : 'Draft';
				endif;

				// Set creator / updater
				$userdata = $this->userdata;
				$_POST['created_by'] = $userdata->id;
				$_POST['updated_by'] = $userdata->id;
				$_POST['updated_time'] = date('Y-m-d H:i:s');

				$id = $this->article_model->insert();

				$notification = [
					'notification' => 'Something wrong when create your article',
					'alert' => 'danger'
				];

				if ($id) :

					$this->insert_category($id);
					$notification = [
						'notification' => 'Success create new article !',
						'alert' => 'success',
						'redirect' => site_url('article/'.$this->input->post('slug').'/edit')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function edit($slug = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($this->permit && $param) :

			// Check if user open right username
			$edit = $this->check_access($slug);

			if ($edit) :
				
				$userdata = $this->userdata;

				// Get edited article
				$param = array(
					'type' => 'where',
					'condition' => array('article.slug' => $slug),
				);
				$article = $this->article_model->get_one($param);

				if (!empty($article)) :

					// Initialize basic info
					$variable = array(
						'basic' => array(
							'title' => 'Edit Article'
						),
						'header' => array(
							'title' => 'Article',
							'description' => 'Edit article '.$article->title,
						),
						'breadcrumb' => array(
							'one' => 'Article',
							'one_link' => site_url('article'),
							'icon' => 'file-text-o',
							'two' => 'Edit',
							'two_link' => site_url('article'),
							'three' => $article->title
						)
					);
					$this->set_variable($variable);

					// Get selected categories
					$param = array(
						'type' => 'where',
						'condition' => array('article_category.article_id' => $article->id),
					);
					$selected = $this->set_selected_category($param);

					// Get articles data
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
					$param['selected'] = $selected;

					// Set additional CSS and JS
					$this->additional_css = array('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css', 'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'assets/plugins/jMosaic-master/css/jquery.jMosaic.css', 'assets/plugins/gallery/gallery.css', 'assets/plugins/select2/select2.css', 'assets/plugins/fileinput/css/fileinput.min.css');
					$this->additional_js = array('assets/plugins/bootstrap-wysihtml5/wysihtml5x-toolbar.min.js', 'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.js', 'bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'assets/plugins/jMosaic-master/js/jquery.jMosaic.js', 'assets/plugins/gallery/gallery.js', 'assets/plugins/select2/select2.js', 'assets/plugins/fileinput/js/fileinput.min.js', 'assets/plugins/category/category.js');

					// Render view
					$param['pages'] = array('article/edit', 'article/gallery');
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
			$edit = $this->check_access($slug);

			if ($edit) :

				// Check validation
				$validation = $this->validation('update');

				if ($validation) :

					$notification = [
						'notification' => 'Something wrong when update your article',
						'alert' => 'danger'
					];

					// Set state
					$this->input->post('state');
					if (!empty($this->input->post('created_time'))) :
						$this->load->library('datetimes');
						$diff = $this->datetimes->datetime_status($this->input->post('created_time'));
						$_POST['state'] = ($diff) ? 'Publish' : 'Draft';
					endif;

					// Set creator / updater
					$userdata = $this->userdata;
					$_POST['updated_by'] = $userdata->id;
					$_POST['updated_time'] = date('Y-m-d H:i:s');

					$param = array(
						'type' => 'where',
						'condition' => array('slug' => $slug),
						'restrict' => 'update',
					);

					// Set slug
					$this->set_slug($slug);

					$update = $this->article_model->update($param);

					if ($update) :

						// Get edited article
						$param = array(
							'type' => 'where',
							'condition' => array('article.slug' => $this->input->post('slug')),
						);
						$article = $this->article_model->get_one($param, true);

						$this->insert_category($article->id, 'update');
						$notification = [
							'notification' => 'Success updated your article !',
							'alert' => 'success',
							'redirect' => site_url('article/'.$this->input->post('slug').'/edit')
						];

					endif;

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function show($slug = false, $draft = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($param) :

			// Get edited article
			$param = array(
				'type' => 'where',
				'condition' => array('article.slug' => $slug, 'article.state' => 'publish')
			);

			if ($draft) :
				$param = null;
				$param = array(
					'type' => 'where',
					'condition' => "article.slug = '".$slug."' AND article.state = 'Publish' OR article.state = 'Draft'"
				);
			endif;

			$article = $this->article_model->get_one($param, true);

			if (!empty($article)) :

				// Get selected categories
				$param = array(
					'type' => 'where',
					'condition' => array('article_category.article_id' => $article->id),
				);
				$selected = $this->set_selected_category($param);

				$param['selected'] = $selected;
				
			endif;

			// Render view
			$param['article'] = $article;
			$param['pages'] = array('article/show');
			$this->common->frontend($param);

		endif;

	}

	public function status($slug = false, $state = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($this->permit && $param) :

			// Check if user open right username
			$access = $this->check_access($slug);

			if ($access) :

				$notification = [
					'notification' => 'Something wrong when '.$state.' your article',
					'alert' => 'danger'
				];

				// Set state
				$state = ($state == 'restore') ? 'draft' : $state;
				$_POST['state'] = ucfirst($state);

				// Set creator / updater
				$userdata = $this->userdata;
				$_POST['updated_by'] = $userdata->id;
				$_POST['updated_time'] = date('Y-m-d H:i:s');

				$param = array(
					'type' => 'where',
					'condition' => array('slug' => $slug),
					'restrict' => 'state',
				);

				$action = $this->article_model->update($param);

				if ($action) :

					// Get edited article
					$param = array(
						'type' => 'where',
						'condition' => array('article.slug' => $this->input->post('slug')),
					);
					$article = $this->article_model->get_one($param, true);

					if ($state == 'trash') :
						$_POST['category'] = null;
						$this->insert_category($article->id, 'update');
					endif;

					$notification = [
						'notification' => 'Success '.$state.'ed your article !',
						'alert' => 'success',
						'redirect' => site_url('article/all')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function changeState() {

		$notification = false;

		if ($this->permit) :

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

	public function delete($slug = false) {

		// Check user parameter
		$param = $this->common->check_param($slug);

		if ($this->permit && $param) :

			// Check if user open right username
			$delete = $this->check_access($slug);

			if ($delete) :

				$notification = [
					'notification' => 'Something wrong when delete your article',
					'alert' => 'danger'
				];

				// Get data before delete article
				$param = array(
					'type' => 'where',
					'condition' => array('article.slug' => $this->input->post('slug')),
				);
				$article = $this->article_model->get_one($param, true);

				$param = array(
					'type' => 'where',
					'condition' => array('slug' => $slug),
					'restrict' => 'update',
				);

				$delete = $this->article_model->delete($param);

				if ($delete) :

					$this->load->model('article_category_model');

					$param = array(
						'type' => 'where',
						'condition' => array('article_id' => $id)
					);
					
					$this->article_category_model->delete($param);

					$notification = [
						'notification' => 'Success deleted your article !',
						'alert' => 'success',
						'redirect' => site_url('article/all')
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

		$config['upload_path'] = './gallery/images/';
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
			$upload_filename = 'gallery/images/'.$upload_file['client_name'];
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