<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slideshow extends CI_Controller {

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

		$this->load->model('slideshow_model');
		$this->load->model('slideshow_type_model');
		$this->load->model('media_model');
		$this->load->model('user_model');

		$this->load->helper('label_icon_helper');
		$this->load->helper('elapsed_helper');

		$this->load->library('upload_config');

		$this->access = $this->common->access('c_slideshow');

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

	private function validation($type = false) {

		$this->load->library('form_validation');

		if ($type == 'slideshow_type') :

			$this->form_validation->set_rules('name', 'Slideshow Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('status', 'Slideshow Status', 'required|trim|xss_clean');

		endif;
		
		if ($this->form_validation->run() == FALSE) :
			
			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();
			$param['redirect'] = site_url('slideshow');

			$this->common->redirect($param);
		
		endif;

		return true;

	}

	private function set_slug($oldSlug = false) {

		$this->load->library('slug');

		if (!empty($this->input->post('slug'))) :
			$slug = $this->input->post('slug');
		else :
			$slug = $this->input->post('name');
		endif;

		$status = true; $i = 1;
		while ($status) :
			
			$rawSlug = $this->slug->get_slug($slug);
			$param = array(
				'type' => 'where',
				'condition' => array('slug' => $rawSlug)
			);
			$slideshowSlug = $this->slideshow_type_model->check($param);

			if ($slideshowSlug) :
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

	public function index($state = false, $page = 0) {

		if ($this->access) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Slideshow List'),
				'header' => [
					'title' => 'Slideshow Management',
					'description' => 'Slideshow management to control all image slider on Booci',
				],
				'breadcrumb' => [
					'one' => 'Slideshow',
					'one_link' => site_url('slideshow'),
					'icon' => 'list',
					'two' => 'List'
				]
			];
			$this->set_variable($variable);

			// Get menus data
			$param = array(
				'order_by' => 'slideshow_type.id ASC',
				'type' => 'where',
				'condition' => array('status' => 'active'),
			);

			$param['slideshow_types'] = $this->slideshow_type_model->get_all();

			// Render view
			$param['pages'] = array('slideshow/index');
			$this->common->backend($param);

		endif;

	}

	public function create() {

		if ($this->access) :

			$validation = $this->validation('slideshow_type');

			// Set navigation slug
			$this->set_slug();

			if ($this->slideshow_type_model->insert()) :

				$param = [
					'alert' => 'success',
					'notification' => 'Success create '.$this->input->post('name').' slideshow',
				];

			else :

				$param = [
					'alert' => 'danger',
					'notification' => 'Something wrong when create new slideshow, please try again !',
				];

			endif;

			$this->common->redirect($param);

		endif;

	}

	public function edit($slug = false) {

		// Check media parameter
		$param = $this->common->check_param($slug);

		if ($this->access && $param) :

			// Get edited slideshow_type
			$param = array(
				'type' => 'where',
				'condition' => array('slideshow_type.slug' => $slug),
			);
			$slideshow_type = $this->slideshow_type_model->get_one($param);

			if (!empty($slideshow_type)) :

				// Initialize basic info
				$variable = [
					'basic' => array('title' => 'Edit '.$slideshow_type->name),
					'header' => [
						'title' => 'Slideshow Management',
						'description' => 'Edit '.$slideshow_type->name.' slideshow data',
					],
					'breadcrumb' => [
						'one' => 'Slideshow',
						'one_link' => site_url('slideshow'),
						'icon' => 'picture',
						'two' => 'Edit slideshow'
					]
				];
				$this->set_variable($variable);

				// Get slideshow picture data
				$param = array(
					'select' => 'media',
					'join' => 'media',
					'order_by' => 'slideshow.id ASC',
					'type' => 'where',
					'condition' => array('slideshow.status' => 'active', 'slideshow.slideshow_type_id' => $slideshow_type->id),
				);

				$slideshows = $this->slideshow_model->get_all($param);

				// Get menus data
				$param = array(
					'order_by' => 'slideshow_type.id ASC',
					'type' => 'where',
					'condition' => array('status' => 'active'),
				);

				$param['slideshows'] = $slideshows;
				$param['slideshow_types'] = $this->slideshow_type_model->get_all();

				// Render view
				$param['pages'] = array('slideshow/edit', 'slideshow/slideshow_detail/edit');
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
			$filenames = $this->input->post('filename');
			$count = count($filenames);
			$count = ($count > 1) ? $count.' files' : $count.' file';

			if (!empty($filenames)) :

				foreach ($filenames as $key => $filename) :

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

						$notification = [
							'alert' => 'success',
							'notification' => 'Success delete '.$count.', now file is no longer exist'
						];

						// Delete old files
						if (file_exists('./'.$path)) :
							unlink('./'.$path);
						endif;

					else :

						$notification = [
							'alert' => 'danger',
							'notification' => 'Something wrong when delete media data, please try again !'
						];

					endif;

				endforeach;

			endif;

		endif;

		$this->common->redirect($notification);

	}

}