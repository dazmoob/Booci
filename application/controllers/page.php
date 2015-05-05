<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

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
		$this->ci = &get_instance();

		$this->load->model('page_model');
		$this->load->model('user_model');

		$this->load->helper('label_icon_helper');
		$this->load->helper('elapsed_helper');

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

		// Get page data
		$param = array('slug' => $slug);
		if ($userdata->level > 3)
			$param['user_id'] = $userdata->id;
		$page = $this->page_model->check_page($param);
		
		if ($page == false) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
			$this->common->error($code);

		endif;

		return $page;

	}

	private function validation($type = false) {

		$this->load->library('form_validation');

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
		$counts = $this->page_model->count($param);

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
			$pageSlug = $this->page_model->check_slug($param);

			if ($pageSlug) :
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

	/*
		=========== Public Function =============
	*/

	public function all($state = false, $page = 0) {

		if ($this->permit) :

			// Initialize basic info
			$variable = array(
				'basic' => array(
					'title' => 'Pages List'
				),
				'header' => array(
					'title' => 'Pages Management',
					'description' => 'All page list in Booci',
				),
				'breadcrumb' => array(
					'one' => 'Pages',
					'one_link' => site_url('page'),
					'icon' => 'file-text-o',
					'two' => 'List',
				)
			);
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Check state
			$state = (!empty($this->uri->segment(3)) && in_array($this->uri->segment(3), array('publish', 'draft', 'trash'))) ? $this->uri->segment(3) : false;

			$search = (!empty($this->input->get('search'))) ? array('bc_page.title' => $this->input->get('search')) : false;

			// Get pages data
			$param = array(
				'select' => 'user',
				'join' => 'user',
				'start' => $page,
				'limit' => 10,
				'order_by' => 'bc_page.created_time DESC',
				// Set default get all condition
				'type' => 'where_like',
				'condition' => true,
				'condition_like' => $search,
			);

			// For super admin, admin and editor if access not only all list
			if (!empty($state))
				$param['condition_where'] = array('bc_page.state' => ucfirst($state));

			// For writer if access not only all list
			if ($userdata->level > 3) :
				
				$param['condition_where'] = array('created_by' => $userdata->id);
				
				if (!empty($state))
					$param['condition_where'] = array('created_by' => $userdata->id, 'bc_page.state' => ucfirst($state));

			endif;

			// Set to conut all pages data
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
			$pages = $this->page_model->get_all($param);

			// Set pagination
			$this->load->library('pagination');
			$this->load->model('page_numbering');

			$config = [
				'url' => [
					'uri3' => 'list'
				],
				'param' => [
					'table' => 'page',
					'param' => $param
				],
			];

			if (!empty($state))
				$config['url']['uri3'] = strtolower($state);

			$this->page_numbering->set_pagination($config);

			$param['count'] = $count;
			$param['pagesData'] = $pages;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/iCheck/flat/blue.css');
			$this->additional_js = array('assets/plugins/iCheck/icheck.min.js');

			// Render view
			$param['pages'] = array('page/index');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->permit) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Add New page'),
				'header' => [
					'title' => 'page',
					'description' => 'Create new page',
				],
				'breadcrumb' => [
					'one' => 'page',
					'one_link' => site_url('page'),
					'icon' => 'file-text-o',
					'two' => 'Create New Page'
				]
			];
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Get pages data
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

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css', 'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'assets/plugins/jMosaic-master/css/jquery.jMosaic.css', 'assets/plugins/gallery/gallery.css', 'assets/plugins/select2/select2.css', 'assets/plugins/fileinput/css/fileinput.min.css');
			$this->additional_js = array('assets/plugins/bootstrap-wysihtml5/wysihtml5x-toolbar.min.js', 'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.js', 'bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'assets/plugins/jMosaic-master/js/jquery.jMosaic.js', 'assets/plugins/gallery/gallery.js', 'assets/plugins/select2/select2.js', 'assets/plugins/fileinput/js/fileinput.min.js');

			// Render view
			$param['pages'] = array('page/add', 'page/gallery');
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

				$id = $this->page_model->insert();

				$notification = [
					'notification' => 'Something wrong when create your page !',
					'alert' => 'danger'
				];

				if ($id) :

					$notification = [
						'notification' => 'Success create new page !',
						'alert' => 'success',
						'redirect' => site_url('page/'.$this->input->post('slug').'/edit')
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

				// Get edited page
				$param = array(
					'type' => 'where',
					'condition' => array('bc_page.slug' => $slug),
				);
				$page = $this->page_model->get_one($param);

				if (!empty($page)) :

					// Initialize basic info
					$variable = array(
						'basic' => array(
							'title' => 'Edit page'
						),
						'header' => array(
							'title' => 'page',
							'description' => 'Edit page '.$page->title,
						),
						'breadcrumb' => array(
							'one' => 'page',
							'one_link' => site_url('page'),
							'icon' => 'file-text-o',
							'two' => 'Edit',
							'two_link' => site_url('page'),
							'three' => $page->title
						)
					);
					$this->set_variable($variable);

					// Get pages data
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

					// Set additional CSS and JS
					$this->additional_css = array('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css', 'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'assets/plugins/jMosaic-master/css/jquery.jMosaic.css', 'assets/plugins/gallery/gallery.css', 'assets/plugins/select2/select2.css', 'assets/plugins/fileinput/css/fileinput.min.css');
					$this->additional_js = array('assets/plugins/bootstrap-wysihtml5/wysihtml5x-toolbar.min.js', 'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.js', 'bower_components/moment/min/moment.min.js', 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'assets/plugins/jMosaic-master/js/jquery.jMosaic.js', 'assets/plugins/gallery/gallery.js', 'assets/plugins/select2/select2.js', 'assets/plugins/fileinput/js/fileinput.min.js');

					// Render view
					$param['pages'] = array('page/edit', 'page/gallery');
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
						'notification' => 'Something wrong when update your page',
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

					$update = $this->page_model->update($param);

					if ($update) :

						// Get edited page
						$param = array(
							'type' => 'where',
							'condition' => array('bc_page.slug' => $this->input->post('slug')),
						);
						$page = $this->page_model->get_one($param, true);

						$notification = [
							'notification' => 'Success updated your page !',
							'alert' => 'success',
							'redirect' => site_url('page/'.$this->input->post('slug').'/edit')
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

			// Get edited page
			$param = array(
				'type' => 'where',
				'condition' => array('bc_page.slug' => $slug, 'bc_page.state' => 'publish')
			);

			if ($draft) :
				$param = null;
				$param = array(
					'type' => 'where',
					'condition' => "bc_page.slug = '".$slug."' AND bc_page.state = 'Publish' OR bc_page.state = 'Draft'"
				);
			endif;

			$page = $this->page_model->get_one($param, true);

			// Render view
			$param['page'] = $page;
			$param['pages'] = array('page/show');
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
					'notification' => 'Something wrong when '.$state.' your page',
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

				$action = $this->page_model->update($param);

				if ($action) :

					// Get edited page
					$param = array(
						'type' => 'where',
						'condition' => array('bc_page.slug' => $this->input->post('slug')),
					);
					$page = $this->page_model->get_one($param, true);

					$notification = [
						'notification' => 'Success '.$state.'ed your page !',
						'alert' => 'success',
						'redirect' => site_url('page/all')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function changeState() {

		$notification = false;

		if ($this->permit) :

			// Get page ID
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
				
				if ($this->page_model->update($param)) :

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
					'notification' => 'Something wrong when delete your page',
					'alert' => 'danger'
				];

				// Get data before delete page
				$param = array(
					'type' => 'where',
					'condition' => array('bc_page.slug' => $this->input->post('slug')),
				);
				$page = $this->page_model->get_one($param, true);

				$param = array(
					'type' => 'where',
					'condition' => array('slug' => $slug),
					'restrict' => 'update',
				);

				$delete = $this->page_model->delete($param);

				if ($delete) :

					$notification = [
						'notification' => 'Success deleted your page !',
						'alert' => 'success',
						'redirect' => site_url('page/all')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

}	