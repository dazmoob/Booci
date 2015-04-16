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

	private function check_edit($slug = false) {

		$userdata = $this->userdata;

		// Get article data
		$param = array('slug' => $slug);
		if ($userdata->level > 3)
			$param['user_id'] = $userdata->id;
		$article = $this->article_model->check_article($param);
		
		if ($article) :

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

	private function set_slug() {

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

		endwhile;

		$_POST['slug'] = $slug;

	}

	private function insert_category($id = false, $restrict = false) {

		if (!empty($id) && !empty($this->input->post('category'))) :

			$this->load->model('article_category_model');

			$category = $this->input->post('category');
			foreach ($category as $key => $value) :

				$_POST['article_id'] = $id;
				$_POST['category_id'] = $value;
				
				$param = [
					'type' => 'where',
					'condition' => array('article_id' => $id, 'category_id' => $value)
				];
				$check = $this->article_category_model->check_article_category($param);

				if ($check == false) :
						
					if ($restrict == false) :
						// $this->article_category_model->insert();
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

			// Get articles data
			$param = array(
				'select' => 'user',
				'join' => 'user',
				'start' => $page,
				'limit' => 10,
				'order_by' => 'article.created_time DESC'
			);

			// For super admin, admin and editor if access not only all list
			if (!empty($state)) :
				$param['type'] = 'where';
				$param['condition'] = array('article.state' => ucfirst($state));
			endif;

			// For writer if access not only all list
			if ($userdata->level > 3) :
				
				$param['type'] = 'where';
				$param['condition'] = array('created_by' => $userdata->id);
				
				if (!empty($state)) :
					$param['type'] = 'where';
					$param['condition'] = array('created_by' => $userdata->id, 'article.state' => ucfirst($state));
				endif;

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
			$param['count'] = $count;
			$param['articles'] = $articles;

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
			$this->additional_css = array('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css', 'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'assets/plugins/jMosaic-master/css/jquery.jMosaic.css', 'assets/plugins/gallery/gallery.css', 'assets/plugins/select2/select2.css');
			$this->additional_js = array('assets/plugins/bootstrap-wysihtml5/wysihtml5x-toolbar.min.js', 'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.js', 'bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'assets/plugins/jMosaic-master/js/jquery.jMosaic.js', 'assets/plugins/gallery/gallery.js', 'assets/plugins/select2/select2.js');

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
						'alert' => 'success'
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
			$edit = $this->check_edit($slug);

			if ($edit) :

				$userdata = $this->userdata;
				$param = array(
					'type' => 'where',
					'condition' => array('article.slug' => $slug),
				);
				$article = $this->article_model->get_one($param, true);

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

					// Set additional CSS and JS
					$this->additional_css = array('assets/plugins/fileinput/css/fileinput.min.css');
					$this->additional_js = array('assets/plugins/fileinput/js/fileinput.min.js');

					// Render view
					$param['pages'] = array('article/edit');
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
					$this->article_model->update($param);

				endif;

			endif;

		endif;

		$this->common->redirect();

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

}	