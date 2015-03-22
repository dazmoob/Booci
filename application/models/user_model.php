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

	private function select($param = false) {

		if (!empty($param['select'])) :

			switch ($param['select']) :
				case 'all':
					$this->db->select('*');
					break;
				
				default:
					$this->db->select('*');
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

	private function limit($start = 0, $limit = 0) {
		$this->db->limit($start, $limit);
	}

	private function set_post($restrict = false) {

		if ($restrict == 'update') :

			$data['name'] = $this->input->post['name'];
			$data['website'] = $this->input->post['website'];
			$data['facebook'] = $this->input->post['facebook'];
			$data['twitter'] = $this->input->post['twitter'];
			$data['gmail'] = $this->input->post['gmail'];
			$data['notes'] = $this->input->post['notes'];

		elseif ($restrict == 'password') :
			$data['password'] = $this->input->post['password'];
		elseif ($restrict == 'upload') :
			$data['picture'] = $this->input->post['picture'];
		elseif ($restrict == 'level') :
			$data['level'] = $this->input->post['level'];
		elseif ($restrict == 'state') :
			$data['state'] = $this->input->post['state'];

		else :

			$data['username'] = $this->input->post['username'];
			$data['name'] = $this->input->post['name'];
			$data['email'] = $this->input->post['email'];
			$data['website'] = $this->input->post['website'];
			$data['facebook'] = $this->input->post['facebook'];
			$data['twitter'] = $this->input->post['twitter'];
			$data['gmail'] = $this->input->post['gmail'];
			$data['password'] = $this->input->post['password'];
			$data['level'] = $this->input->post['level'];
			$data['state'] = $this->input->post['state'];
			$data['datetime'] = $this->input->post['datetime'];
			$data['notes'] = $this->input->post['notes'];

		endif;

		return $data;

	}

	public function get_one($param = false) {

		$this->select($param);
		$this->condition($param);
		$query = $this->db->get('user');
		$data = $query->row();

		$_POST['username'] = $data->username;
		$_POST['name'] = $data->name;
		$_POST['email'] = $data->email;
		$_POST['picture'] = $data->picture;
		$_POST['website'] = $data->website;
		$_POST['facebook'] = $data->facebook;
		$_POST['twitter'] = $data->twitter;
		$_POST['gmail'] = $data->gmail;
		$_POST['password'] = $data->password;
		$_POST['level'] = $data->level;
		$_POST['state'] = $data->state;
		$_POST['datetime'] = $data->datetime;
		$_POST['notes'] = $data->notes;

		return $data;

	}

	public function get_all($param = false) {

		$this->select($param);
		$this->condition($param);
		$this->limit($param);
		$this->db->order_by($param);
		$query = $this->db->get('user');
		return $query->result();

	}

	public function insert($param = false) {
		$this->condition($param);
		$this->db->insert_id('user', $this->set_post());
	}

	public function update($param = false) {
		$this->condition($param);
		$this->db->update('user', $this->set_post($param));
	}

	public function delete($param = false) {
		$this->condition($param);
		$this->db->delete('user');
	}

}