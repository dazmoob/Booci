<?php

class article_category_model extends CI_Model {

	/*
		@ Class 	: article_category_model
		@ Used For 	:
			> Get article_category data by additional condition
			> For insert, update and delete article_category data
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
				e	article_categorys Management
				f 	Messages Management
				g 	article_categorys Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in article_category access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, article_category delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	article_category 			(g,h,i read and comment only)
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
					// $this->db->join('category', 'article_category.id_category = category.id');
					break;

				default:
					// $this->db->join('category', 'article_category.id_category = category.id');
					
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
					$this->db->where_in($condition);
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

		$data['article_id'] = $this->input->post('article_id');
		$data['category_id'] = $this->input->post('category_id');

		return $data;

	}

	public function get_one($param = false, $no_post = false) {

		$this->select($param);

		if (!empty($param['join']))
			$this->join($param);
		
		$this->condition($param);
		$query = $this->db->get('article_category');
		$data = $query->row();

		if ($no_post == false) :

			$_POST['article_id'] = $data->article_id;
			$_POST['category_id'] = $data->category_id;

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
		$query = $this->db->get('article_category');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('article_category', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {
		$this->condition($param);
		return $this->db->update('article_category', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('article_category');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_article_category, check_slug
	*/

	public function check_article_category($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('article_category');
		$row = $query->row();

		return $row;

	}

	public function count($param = false) {

		$this->select($param);
		$this->condition($param);
		$this->db->group_by('category_id'); 
		$query = $this->db->get('article_category');
		return $query->result();

	}

}	