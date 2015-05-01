<?php

class Message_model extends CI_Model {

	/*
		@ Class 	: message_model
		@ Used For 	:
			> Get message data by additional condition
			> For insert, update and delete message data
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
				e	messages Management
				f 	Messages Management
				g 	messages Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in message access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, message delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	message 			(g,h,i read and comment only)
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
					// $this->db->select('*');
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
					// $this->db->join('category', 'message.id_category = category.id');
					break;
				
				default:
					// $this->db->join('category', 'message.id_category = category.id');
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

		if ($param['restrict'] == 'state') :
			
			$data['state'] = $this->input->post('state');

		elseif ($param['restrict'] == 'solve') :
			
			$data['solve'] = $this->input->post('solve');

		else :

			$data['title'] = $this->input->post('title');
			$data['content'] = $this->input->post('content');
			$data['state'] = $this->input->post('state');
			$data['solve'] = $this->input->post('solve');
			$data['type'] = $this->input->post('type');
			$data['created_time'] = date('Y-m-d H:i:s');

		endif;

		return $data;

	}

	public function get_one($param = false, $no_post = false) {

		$this->select($param);

		if (!empty($param['join']))
			$this->join($param);
		
		$this->condition($param);
		$query = $this->db->get('message');
		$data = $query->row();

		if ($no_post == false) :

			$_POST['id'] = $data->id;
			$_POST['title'] = $data->title;
			$_POST['content'] = $data->content;
			$_POST['state'] = $data->state;
			$_POST['solve'] = $data->solve;
			$_POST['type'] = $data->type;
			$_POST['created_time'] = $data->created_time;

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
		$query = $this->db->get('message');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('message', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {
		$this->condition($param);
		return $this->db->update('message', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('message');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_message, check_slug
	*/

}