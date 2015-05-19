<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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

}