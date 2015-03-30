<?php

class User_model extends CI_Model {

	/*
		@ Class 	: user_model
		@ Used For 	:
			> Get user data by additional condition
			> For insert, update and delete user data
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
				e	Users Management
				f 	Messages Management
				g 	Articles Management
				h 	Pages Management
				i 	Gallery Management 
			> There are some level in user access, there are :
				1 	=> 	Super Admin 	(All)
				2	=>	Admin 			(All, exc : admin log, user delete admin)
				3	=>	Editor 			(g,h,i)
				4	=>	Writer 			(g,h,i need editor agreement to publish)
				5	=>	User 			(g,h,i read and comment only)
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

	public $level_super = array(
		'' => 'Choose user level',
		'5' => 'User',
		'4' => 'Writer',
		'3' => 'Editor',
		'2' => 'Admin',
		'1' => 'Super Admin'
	);

	public $level = array(
		'' => 'Choose user level',
		'5' => 'User',
		'4' => 'Writer',
		'3' => 'Editor',
		'2' => 'Admin'
	);

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
					// $this->db->join('category', 'user.id_category = category.id');
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

		$this->db->limit($limit, $start);
	}

	private function order_by($param = false) {
		if (!empty($param['order_by']))
			$this->db->order_by($param['order_by']);
	}

	private function set_post($param = false) {

		if ($param['restrict'] == 'update') :

			$data['name'] = $this->input->post('name');
			$data['website'] = $this->input->post('website');
			$data['facebook'] = $this->input->post('facebook');
			$data['twitter'] = $this->input->post('twitter');
			$data['google'] = $this->input->post('google');
			$data['notes'] = $this->input->post('notes');
			$data['updated_time'] = date('Y-m-d H:i:s');

		elseif ($param['restrict'] == 'password') :

			$data['password'] = $this->input->post('password');
			$data['updated_time'] = date('Y-m-d H:i:s');

		elseif ($param['restrict'] == 'upload') :

			$data['picture'] = $this->input->post('picture');
			$data['picture_path'] = $this->input->post('picture_path');
			$data['updated_time'] = date('Y-m-d H:i:s');

		elseif ($param['restrict'] == 'level') :

			$data['level'] = $this->input->post('level');
			$data['updated_time'] = date('Y-m-d H:i:s');

		elseif ($param['restrict'] == 'state') :
			
			$data['state'] = $this->input->post('state');
			$data['updated_time'] = date('Y-m-d H:i:s');

		else :

			$data['username'] = $this->input->post('username');
			$data['name'] = $this->input->post('name');
			$data['email'] = $this->input->post('email');
			$data['website'] = $this->input->post('website');
			$data['facebook'] = $this->input->post('facebook');
			$data['twitter'] = $this->input->post('twitter');
			$data['google'] = $this->input->post('google');
			$data['password'] = $this->input->post('password');
			$data['level'] = $this->input->post('level');
			$data['state'] = 'Pending';
			$data['created_time'] = date('Y-m-d H:i:s');
			$data['notes'] = $this->input->post('notes');

		endif;

		return $data;

	}

	public function get_one($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('user');
		$data = $query->row();

		$_POST['id'] = $data->id;
		$_POST['username'] = $data->username;
		$_POST['name'] = $data->name;
		$_POST['email'] = $data->email;
		$_POST['picture'] = $data->picture;
		$_POST['picture_path'] = $data->picture_path;
		$_POST['website'] = $data->website;
		$_POST['facebook'] = $data->facebook;
		$_POST['twitter'] = $data->twitter;
		$_POST['google'] = $data->google;
		$_POST['password'] = $data->password;
		$_POST['level'] = $data->level;
		$_POST['state'] = $data->state;
		$_POST['created_time'] = $data->created_time;
		$_POST['updated_time'] = $data->updated_time;
		$_POST['notes'] = $data->notes;

		return $data;

	}

	public function get_all($param = false) {

		$this->select($param);
		$this->condition($param);
		$this->limit($param);
		$this->order_by($param);
		$query = $this->db->get('user');
		return $query->result();

	}

	public function insert($param = false) {
		$this->db->insert('user', $this->set_post());
		return $this->db->insert_id();
	}

	public function update($param = false) {
		$this->condition($param);
		return $this->db->update('user', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		return $this->db->delete('user');
	}

	/* 
		=== Others Section ======================================
		Others function that used for some condition :
		check_login
	*/

	public function check_login($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('user');
		$row = $query->row();

		if (!empty($row)) :
			$row = ($this->input->post('password') == $this->encrypt->decode($row->password)) 
				? $row : false;
		endif;

		return $row;

	}

}