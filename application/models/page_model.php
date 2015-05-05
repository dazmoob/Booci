<?php

class Page_model extends CI_Model {

	/*
		@ Class 	: page_model
		@ Used For 	:
			> Get page data by additional condition
			> For insert, update and delete page data
		@ Function 	:
			> Main function 		: get, insert, update, delete
				> Common function 		: restrict, search, join, order
					> Included function		: condition,
			> Addtional function 	: - 
		@ Notes 	:
			> There are main/common website management process in Booci, there are :
				a 	Website Setting, excl : admin log
				b	Statistic 
				c	Section Title Management
				d	Widget Layout Setting
				e	pages Management
				f 	Messages Management
				g 	pages Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in page access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, page delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	page 			(g,h,i read and comment only)
	*/



	/* 
		=== Common Section ======================================
		Common function that used by all of function, there are :
		restrict, join, search, order
	*/


	/*
		Select function is used to define what column that will be shown from table

		param 		: $data with array 'select' that included array "column"
		other 		: -
		structure 	: 
			$data = array(
				'select' => array(
					'column' => 'title, date', (*, false)
				),
			);
	*/

	/*
		Select function is used to define what column that will be shown from table

		param 		: $data with array 'select' that included array "column"
		other 		: -
		structure 	: 
			$data = array(
				'select' => array(
					'column' => 'title, date', (*, false)
				),
			);
	*/

	private function select($param = false) {

		if (!empty($param['select'])) :

			$select = $param['select'];

			switch ($select) :
				case 'all':
					$this->db->select('*');
					break;

				case 'user':
					$this->db->select('*, page.id as id, c.id as c_id, c.username as c_username, u.id as u_id, u.username as u_username, page.created_time as created_time, page.updated_time as updated_time, u.created_time as u_created_time, u.updated_time as u_updated_time, c.created_time as c_created_time, c.updated_time as c_updated_time, page.state as state, c.state as c_state, u.state as u_state');
					break;
				
				default:
					$this->db->select($select);
					break;
			endswitch;

		else :
			$this->db->select('*');
		endif;

	}

	private function join($param = false) {

		if (!empty($param['join'])) :

			switch ($param['join']) :
				case 'all':
					// $this->db->join('category', 'page.id_category = category.id');
					break;

				case 'user' :
					$this->db->join('user c', 'page.created_by = c.id');
					$this->db->join('user u', 'page.updated_by = u.id');
					break;
				
				default:
					// $this->db->join('category', 'page.id_category = category.id');
					
					break;
			endswitch;

		endif;
	}

	private function condition($param) {

		if (!empty($param['type']) && !empty($param['condition'])) :

			$type = $param['type'];
			$condition = $param['condition'];

			switch ($type) :
				case 'where':
					$this->db->where($condition);
					break;
				case 'like':
					$this->db->like($condition);
					break;
				case 'where_in':
					// When set where_in key 'condition' => array('title' => $title)
					// Set $title with array('Web', 'Basisdata')
					$this->db->where_in($param['condition_column'], $param['condition_keyword']);
					break;
				case 'where_not_in':
					// When set where_not_in key 'condition' => array('title' => $title)
					// Set $title with array('Web', 'Basisdata')
					$this->db->where_not_in($condition);
					break;
				case 'having':
					$this->db->having($condition);
					break;
				case 'where_like':
					if (!empty($param['condition_where']))
						$this->db->where($param['condition_where']);

					if (!empty($param['condition_like']))
						$this->db->like($param['condition_like']);

					break;
			endswitch;

		endif;

	}

	private function limit($param = false) {

		$start = 0; $limit = 0;

		if (!empty($param['start'])) $start = $param['start'];
		if (!empty($param['limit'])) $limit = $param['limit'];

		if ($limit != 0) 
			$this->db->limit($limit, $start);
	}

	private function order_by($param = false) {
		if (!empty($param['order_by']))
			$this->db->order_by($param['order_by']);
	}

	private function set_post($param = false) {

		if ($param['restrict'] == 'update') :

			$data['title'] = $this->input->post('title');
			$data['slug'] = $this->input->post('slug');
			$data['content'] = $this->input->post('content');
			$data['featured_image'] = $this->input->post('featured_image');
			$data['excerpt'] = $this->input->post('excerpt');
			$data['description'] = $this->input->post('description');
			$data['keyword'] = $this->input->post('keyword');
			$data['updated_time'] = date('Y-m-d H:i:s');
			$data['updated_by'] = $this->input->post('updated_by');
			$data['state'] = $this->input->post('state');

		elseif ($param['restrict'] == 'state') :
			
			$data['state'] = $this->input->post('state');
			$data['updated_time'] = date('Y-m-d H:i:s');
			$data['updated_by'] = $this->input->post('updated_by');

		else :

			$data['title'] = $this->input->post('title');
			$data['slug'] = $this->input->post('slug');
			$data['content'] = $this->input->post('content');
			$data['featured_image'] = $this->input->post('featured_image');
			$data['excerpt'] = $this->input->post('excerpt');
			$data['description'] = $this->input->post('description');
			$data['keyword'] = $this->input->post('keyword');
			$data['created_time'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->input->post('created_by');
			$data['updated_time'] = date('Y-m-d H:i:s');
			$data['updated_by'] = $this->input->post('updated_by');
			$data['state'] = $this->input->post('state');

		endif;

		return $data;

	}

	public function get_one($param = false, $no_post = false) {

		$this->select($param);

		if (!empty($param['join']))
			$this->join($param);
		
		$this->condition($param);
		$query = $this->db->get('page');
		$data = $query->row();

		if ($no_post == false) :

			$_POST['id'] = $data->id;
			$_POST['title'] = $data->title;
			$_POST['slug'] = $data->slug;
			$_POST['content'] = $data->content;
			$_POST['featured_image'] = $data->featured_image;
			$_POST['excerpt'] = $data->excerpt;
			$_POST['description'] = $data->description;
			$_POST['keyword'] = $data->keyword;
			$_POST['created_time'] = $data->created_time;
			$_POST['created_by'] = $data->created_by;
			$_POST['updated_time'] = $data->updated_time;
			$_POST['updated_by'] = $data->updated_by;
			$_POST['state'] = $data->state;

		endif;

		return $data;

	}

	public function get_all($param = false) {

		$this->select($param);

		if (!empty($param['join']))
			$this->join($param);

		$this->condition($param);
		$this->limit($param);
		$this->order_by($param);
		$query = $this->db->get('page');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('page', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {
		$this->condition($param);
		return $this->db->update('page', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('page');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_page, check_slug
	*/

	public function check_page($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('page');
		$row = $query->row();

		return $row;

	}

	public function check_slug($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('page');
		$row = $query->row();

		return $row;

	}

	public function count($param = false) {

		$this->select($param);
		$this->condition($param);
		$this->db->group_by('state'); 
		$query = $this->db->get('page');
		return $query->result();

	}

}