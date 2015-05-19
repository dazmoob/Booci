<?php

class Slideshow_model extends CI_Model {

	/*
		@ Class 	: slideshow_model
		@ Used For 	:
			> Get slideshow data by additional condition
			> For insert, update and delete slideshow data
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
				e	slideshows Management
				f 	Messages Management
				g 	Articles Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in slideshow access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, slideshow delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	slideshow 			(g,h,i read and comment only)
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

				case 'media':
					$this->db->select('*, slideshow.id as id, , media.id as media_ids, slideshow.title as title, media.title as media_title, slideshow.description as description, media.description as media_description');
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
					// $this->db->join('slideshow', 'slideshow.id_slideshow = slideshow.id');
					break;

				case 'media':
					$this->db->join('media', 'slideshow.media_id = media.id');
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
			$data['subtitle'] = $this->input->post('subtitle');
			$data['description'] = $this->input->post('description');
			$data['label'] = $this->input->post('label');
			$data['url'] = $this->input->post('url');
			$data['media_id'] = $this->input->post('media_id');

		else :

			$data['title'] = $this->input->post('title');
			$data['subtitle'] = $this->input->post('subtitle');
			$data['description'] = $this->input->post('description');
			$data['label'] = $this->input->post('label');
			$data['url'] = $this->input->post('url');
			$data['media_id'] = $this->input->post('media_id');
			$data['slideshow_type_id'] = $this->input->post('slideshow_type_id');

		endif;

		return $data;

	}

	public function get_one($param = false, $no_post = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('slideshow');
		$data = $query->row();

		if ($no_post == false) :

			$_POST['id'] = $data->id;
			$_POST['title'] = $data->title;
			$_POST['subttle'] = $data->subttle;
			$_POST['description'] = $data->description;
			$_POST['media_id'] = $data->media_id;
			$_POST['label'] = $data->label;
			$_POST['url'] = $data->url;
			$_POST['status'] = $data->status;
			$_POST['slideshow_type_id'] = $data->slideshow_type_id;

		endif;

		return $data;

	}

	public function get_all($param = false) {

		$this->select($param);
		$this->join($param);
		$this->condition($param);
		$this->limit($param);
		$this->order_by($param);
		$query = $this->db->get('slideshow');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('slideshow', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {
		$this->condition($param);
		return $this->db->update('slideshow', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('slideshow');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_login
	*/

	public function check($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('slideshow');
		$row = $query->row();

		return $row;

	}

}	