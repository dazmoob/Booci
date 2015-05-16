<?php

class Navigation_link_model extends CI_Model {

	/*
		@ Class 	: navigation_link_model
		@ Used For 	:
			> Get navigation_link data by additional condition
			> For insert, update and delete navigation_link data
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
				e	navigation_links Management
				f 	Messages Management
				g 	Articles Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in navigation_link access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, navigation_link delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	navigation_link 			(g,h,i read and comment only)
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

				case 'navigation':
					$this->db->select('*, navigation_link.id as link_id');
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
					// $this->db->join('navigation_link', 'navigation_link.id_navigation_link = navigation_link.id');
					break;

				case 'navigation' :
					$this->db->join('navigation', 'navigation_link.navigation_id = navigation.id');
					break;
				
				default:
					
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

		$data['label'] = $this->input->post('label');
		$data['url'] = $this->input->post('url');
		$data['class'] = $this->input->post('class');
		$data['rel'] = $this->input->post('rel');
		$data['target'] = $this->input->post('target');

		if (empty($param['restrict'])) :
			
			$data['sequence'] = $this->input->post('sequence');
			$data['navigation_id'] = $this->input->post('navigation_id');
		
		endif;

		return $data;

	}

	public function get_one($param = false, $no_post = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('navigation_link');
		$data = $query->row();

		if ($no_post == false) :

			$_POST['id'] = $data->id;
			$_POST['label'] = $data->label;
			$_POST['url'] = $data->url;
			$_POST['class'] = $data->class;
			$_POST['rel'] = $data->rel;
			$_POST['target'] = $data->target;
			$_POST['navigation_id'] = $data->navigation_id;

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
		$query = $this->db->get('navigation_link');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('navigation_link', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {

		if (!empty($param['batch'])) :

			return $this->db->update_batch('navigation_link', $param['batch_data'], $param['batch_key']);

		else :

			$this->condition($param);
			return $this->db->update('navigation_link', $this->set_post($param));

		endif;

	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('navigation_link');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_login
	*/

	public function check($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('navigation_link');
		$row = $query->row();

		return $row;

	}

}	