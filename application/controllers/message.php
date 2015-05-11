<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

	/**
	 * Index message for this controller.
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

		$this->load->model('message_model');
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

		// Get message data
		$param = array('slug' => $slug);
		if ($userdata->level > 3)
			$param['user_id'] = $userdata->id;
		$message = $this->message_model->check_message($param);
		
		if ($message == false) :

			// Set error code and call error function
			$code = array('status' => 'error', 'view' => 'frontend', 'type' => 404);
			$this->common->error($code);

		endif;

		return $message;

	}

	private function validation($type = false, $ajax = false) {

		$this->load->library('form_validation');

		if ($type == 'update') :

			$this->form_validation->set_rules('state', 'State', 'trim|xss_clean');
			$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean');

		else :

			$this->form_validation->set_rules('name', 'Sender Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('email', 'Sender Email', 'required|valid_email|trim|xss_clean');
			$this->form_validation->set_rules('url', 'URL', 'required|trim|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
			$this->form_validation->set_rules('content', 'Content', 'required|trim|xss_clean');
			$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean');

		endif;

		if ($this->form_validation->run() == FALSE) :

			$param['alert'] = 'danger';
			$param['notification'] = validation_errors();

			if ($ajax == false)
				$this->common->redirect($param);

			else
				echo json_encode($param);

		endif;

		return true;

	}

	private function set_count($param = false) {

		$data = array(); $data['total'] = 0;
		$type = $param['type'];
		$param['select'] = "$type, COUNT(*) as count";
		$param['join'] = false;
		$counts = $this->message_model->count($param);

		if (!empty($counts)) :
			$total = 0;
			foreach ($counts as $count) :
				$data[$count->$type] = $count->count;
				$total = $total + $count->count;
			endforeach;
			$data['total'] = $total;
		endif;

		return $data;

	}

	/*
		=========== Public Function =============
	*/

	public function all($state = false, $page = 0) {

		if ($this->permit) :

			// Initialize basic info
			$variable = array(
				'basic' => array(
					'title' => 'Messages List'
				),
				'header' => array(
					'title' => 'Messages Management',
					'description' => 'All message list in Booci',
				),
				'breadcrumb' => array(
					'one' => 'Messages',
					'one_link' => site_url('message'),
					'icon' => 'file-text-o',
					'two' => 'List',
				)
			);
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Check state
			$state = (!empty($this->uri->segment(3)) && in_array($this->uri->segment(3), array('unread', 'read', 'trash', 'solved', 'unsolved'))) ? $this->uri->segment(3) : false;

			$type = 'bc_message.state';
			if (!empty($state)) :

				if ($state == 'read' || $state == 'unread' || $state == 'trash') :
					$type = 'bc_message.state';

				elseif ($state == 'solved' || $state == 'unsolved') :
					$type = 'bc_message.solve';

				endif;

			endif;

			// Check search
			$search = (!empty($this->input->get('search'))) ? $this->input->get('search') : false;

			// Check category
			$category = (!empty($this->input->get('category', true)) && in_array($this->input->get('category', true), array('criticism', 'suggestion', 'question', 'others'))) ? $this->input->get('category', true) : false;

			// Get messages data
			$param = array(
				'start' => $page,
				'limit' => 10,
				'order_by' => 'bc_message.created_time DESC',
				// Set default get all condition
				'type' => 'where_like',
				'condition' => true,
				'condition_like' => array(
					'bc_message.title' => $search,
					'bc_message.type' => $category
				),
			);

			// For super admin, admin and editor if access not only all list
			if (!empty($state))
				$param['condition_where'] = array($type => $state);

			// Set to count all messages data
			$countRead = $this->set_count(array('type' => 'state'));
			$countSolve = $this->set_count(array('type' => 'solve')); 
			$countType = $this->set_count(array('type' => 'type')); 
			$messages = $this->message_model->get_all($param);

			// Set pagination
			$this->load->library('pagination');
			$this->load->model('page_numbering');

			$config = [
				'url' => [
					'uri3' => 'list'
				],
				'param' => [
					'table' => 'message',
					'param' => $param
				],
			];

			if (!empty($state))
				$config['url']['uri3'] = $state;

			$this->page_numbering->set_pagination($config);

			$param['count'] = array_merge($countRead, $countSolve, $countType);
			$param['messages'] = $messages;

			// Set additional CSS and JS
			$this->additional_css = array('assets/plugins/iCheck/flat/blue.css');
			$this->additional_js = array('assets/plugins/iCheck/icheck.min.js');

			// Render view
			$param['pages'] = array('message/index', 'message/show');
			$this->common->backend($param);

		endif;

	}

	public function add() {

		if ($this->permit) :

			// Initialize basic info
			$variable = [
				'basic' => array('title' => 'Add New message'),
				'header' => [
					'title' => 'message',
					'description' => 'Create new message',
				],
				'breadcrumb' => [
					'one' => 'message',
					'one_link' => site_url('message'),
					'icon' => 'file-text-o',
					'two' => 'Create New message'
				]
			];
			$this->set_variable($variable);

			$userdata = $this->userdata;

			// Get messages data
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
			$param['messages'] = array('message/add', 'message/gallery');
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

				$id = $this->message_model->insert();

				$notification = [
					'notification' => 'Something wrong when create your message !',
					'alert' => 'danger'
				];

				if ($id) :

					$notification = [
						'notification' => 'Success create new message !',
						'alert' => 'success',
						'redirect' => site_url('message/'.$this->input->post('slug').'/edit')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function update($id = false, $ajax = false) {

		// Check user parameter
		$param = $this->common->check_param($id);

		if ($this->permit && $param) :

			// Check validation
			$validation = $this->validation('update', $ajax);

			if ($validation) :

				$notification = [
					'notification' => 'Something wrong when update your message',
					'alert' => 'danger'
				];

				// Check type
				if (!empty($this->input->post('solve')))
					$type = 'solve';

				if (!empty($this->input->post('state')))
					$type = 'state';

				// Set parameter
				$param = array(
					'type' => 'where',
					'condition' => array('id' => $id),
					'restrict' => $type,
				);

				$update = $this->message_model->update($param);

				if ($update) :

					$notification = [
						'notification' => 'Success solved message !',
						'alert' => 'success',
						'redirect' => site_url('message/all')
					];

				endif;

			endif;

		endif;

		if ($ajax == false) 
			$this->common->redirect($notification);

		else
			echo json_encode($notification);

	}

	public function state($id = false, $state = false) {

		$notification = [
			'notification' => "You don't have access to do that !",
			'alert' => 'danger'
		];

		if ($this->permit) :

			if ($id && $state) :

				if ($state == 'read' || $state == 'unread') :
					$type = 'state';

				elseif ($state == 'solved' || $state == 'unsolved') :
					$type = 'solve';

				endif;

				$_POST[$type] = $state;

				$param = array(
					'type' => 'where',
					'condition' => array('id' => $id),
					'restrict' => $type,
				);
				
				if ($this->message_model->update($param)) :

					$notification = [
						'notification' => "Your selected messages has been set ".strtolower($this->input->post('state'))." successfully !",
						'alert' => 'success'
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

	public function changeState() {

		if ($this->permit) :

			// Get message ID
			$ids = $this->input->post('id');
			$type = $this->input->post('type');

			if ($type == 'read' || $type == 'unread' || $type == 'trash') :
				$column = 'state';

			elseif ($type == 'solved' || $type == 'unsolved') :
				$column = 'solve';

			endif;

			$_POST[$column] = $type;

			if ($ids) :

				$param = array(
					'type' => 'where_in',
					'condition' => true,
					'condition_column' => 'id',
					'condition_keyword' => $ids,
					'restrict' => $column,
				);
				
				if ($this->message_model->update($param)) :

					$notification = [
						'notification' => "Your selected messages has been ".strtolower($this->input->post('state'))."ed successfully !",
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
					'notification' => 'Something wrong when delete your message',
					'alert' => 'danger'
				];

				// Get data before delete message
				$param = array(
					'type' => 'where',
					'condition' => array('bc_message.slug' => $this->input->post('slug')),
				);
				$message = $this->message_model->get_one($param, true);

				$param = array(
					'type' => 'where',
					'condition' => array('slug' => $slug),
					'restrict' => 'update',
				);

				$delete = $this->message_model->delete($param);

				if ($delete) :

					$notification = [
						'notification' => 'Success deleted your message !',
						'alert' => 'success',
						'redirect' => site_url('message/all')
					];

				endif;

			endif;

		endif;

		$this->common->redirect($notification);

	}

}	