<?php

class Slideshow_type_model extends CI_Model {

	/*
		@ Class 	: slideshow_type_model
		@ Used For 	:
			> Get slideshow_type data by additional condition
			> For insert, update and delete slideshow_type data
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
				e	slideshow_types Management
				f 	Messages Management
				g 	slideshow_types Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in slideshow_type access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, slideshow_type delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	slideshow_type 			(g,h,i read and comment only)
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
					// $this->db->join('category', 'slideshow_type.id_category = category.id');
					break;

				default:
					// $this->db->join('category', 'slideshow_type.id_category = category.id');
					
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

			$data['name'] = $this->input->post('name');
			$data['status'] = $this->input->post('status');
			$data['notes'] = $this->input->post('notes');

		else :

			$data['name'] = $this->input->post('name');
			$data['slug'] = $this->input->post('slug');
			$data['status'] = $this->input->post('status');
			$data['notes'] = $this->input->post('notes');

		endif;

		return $data;

	}

	public function get_one($param = false, $no_post = false) {

		$this->select($param);

		if (!empty($param['join']))
			$this->join($param);
		
		$this->condition($param);
		$query = $this->db->get('slideshow_type');
		$data = $query->row();

		if ($no_post == false) :

			$_POST['id'] = $data->id;
			$_POST['name'] = $data->name;
			$_POST['slug'] = $data->slug;
			$_POST['status'] = $data->status;
			$_POST['notes'] = $data->notes;

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
		$query = $this->db->get('slideshow_type');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('slideshow_type', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {
		$this->condition($param);
		return $this->db->update('slideshow_type', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('slideshow_type');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_slideshow_type, check_slug
	*/

	public function check($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('slideshow_type');
		$row = $query->row();

		return $row;

	}

}	