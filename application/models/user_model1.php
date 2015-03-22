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

	private function select($data = false) {
		if ($data['select']['column'])
			$this->db->select($data['select']['column']);
		else
			$this->db->select('*');
	}

	// End of Select function


	/*
		Select option function is used to select data with group function condition

		param 		: $data with array 'option' that include array "type" and "column"
		other 		: connected to option function
		structure 	: 
			$data = array(
				'option' => array(
					'type' => 'min',
					'column' => 'date',
				),
			);
	*/
	
	private function select_option($data = false) {
		// Check what's option type
		switch ($data['option']['type']) {
			case 'max':
				$this->db->select_max($data['option']['column']);
				break;

			case 'min':
				$this->db->select_min($data['option']['column']);
				break;

			case 'avg':
				$this->db->select_avg($data['option']['column']);
				break;

			case 'sum':
				$this->db->select_sum($data['option']['column']);
				break;

			case 'distinct':
				$this->db->distinct();
				break;
		}
	}

	// End of Select option function


	/*
		Search function is used to find user data by some condition

		param 		: $data with array 'action' that include array "type" and "condition"
		other 		: connected to condition function
		structure 	: 
			$data = array(
				'action' => array(
					'key' => 'search',
					'type' => 'where',
					'condition' => array('title !=' => 'Web'),
				),
			);
	*/

	private function search($data = false) {
		// Check if search is true
		if ($data['action']['key'] == 'search')
			// Check SQL condition
			$this->condition($data);
	}

		private function condition($data = false) {
			// Check what's condition type
			switch ($data['action']['type']) {
				case 'where':
					$this->db->where($data['action']['condition']);
					break;
				case 'like':
					$this->db->like($data['action']['condition']);
					break;
				case 'where_in':
					// When set where_in key 'condition' => array('title' => $title)
					// Set $title with array('Web', 'Basisdata')
					foreach ($data['action']['condition'] as $key => $value) :
						$column = $key;
						$value = $value;
					endforeach;
					$this->db->where_in($column, $value);
					break;
				case 'where_not_in':
					// When set where_not_in key 'condition' => array('title' => $title)
					// Set $title with array('Web', 'Basisdata')
					foreach ($data['action']['condition'] as $key => $value) :
						$column = $key;
						$value = $value;
					endforeach;
					$this->db->where_not_in($column, $value);
					break;
				case 'having':
					$this->db->having($data['action']['condition']);
					break;
			}
		}

	// End of Search function


	/*
		Limit function is used to limit and offset data that will be shown

		param 		: $data with array 'limit' that included array "limit" and "offset"
		other 		: -
		structure 	: 
			$data = array(
				'limit' => array(
					'limit' => 5,
					'offset' => false,
				),
			);
	*/

	private function limit($data = false) {
		// Check if limit and offset exist
		if ($data['limit']['limit'] == true && $data['limit']['offset'] == true)
			$this->db->limit($data['limit']['limit'], $data['limit']['offset']);
		
		// Check if limit exist
		elseif ($data['limit']['limit'] == true)
			$this->db->limit($data['limit']['limit']);
	}

	// End of Limit function


	/*
		Join function is used to join more than 2 tables

		param 		: $data with array 'join' that include array "table" and "select"
		other 		: connected to other_table function
		structure 	: 
			$data = array(
				'join' => array(
					'table' => 'category',
					'select' => 'category.id as id_cat, category.name', (Can be not used)
				),
			);

		default 	: empty
		example		: place it on other_table function
			if (array_key_exists('select', $data['join'])) :
				$this->db->select($data['join']['select']);

			switch ($data['join']['table']) {
				case 'category':
					$this->db->join('category', 'user.id_category = category.id');
					break;
			}
	*/
	

	public function join($data = false) {
		// Call other table function
		$this->other_table($data);
	}

		private function other_table($data = false) {
			// Check if select is true or not
				// Code here ...
			
			// Check what's table name
				// Code here ...
		}

	// End of Join function


	/*
		Group By function is used to grouping data based on column table

		param 		: $data with array 'group' that included array "column"
		other 		: -
		structure 	: 
			$data = array(
				'group' => array(
					'column' => 'title',
				),
			);
	*/

	private function group($data = false) {
		$this->db->group_by($data['group']['column']);
	}

	// End of Group by function


	/*
		Order function is used to order data by condition was been setted

		param 		: $data with array 'order' that included array "condition"
		other 		: -
		structure 	: 
			$data = array(
				'order' => array(
					'condition' => 'title ASC, date DESC',
				),
			);
	*/

	private function order($data = false) {
		$this->db->order_by($data['order']['condition']);
	}

	// End of Order function


	/*
		Callback function is used to collect common function that always used frquently

		param 		: $data
		other 		: connected to select, select_option, search, join, limit, group,
					  order function
		structure 	: 
			$data = array( ... );
	*/

	private function callback($data = false) {
		// Check if $data is true
		if ($data == true) :
			// Check if data with key action is exist
			if (array_key_exists('select', $data)) :
				$this->select($data);
			endif;

			// Check if data with key action is exist
			if (array_key_exists('select_option', $data)) :
				$this->select_option($data);
			endif;

			// Check if data with key action is exist
			if (array_key_exists('action', $data)) :
				$this->search($data);
			endif;

			// Check if data with key limit is exist and count key didn't exist
			if (array_key_exists('limit', $data) && !array_key_exists('count', $data)) 
				$this->limit($data);

			// Check if data with key action is exist
			if (array_key_exists('join', $data)) :
				$this->join($data);
			endif;

			// Check if data with key group is exist
			if (array_key_exists('group', $data)) 
				$this->group($data);

			// Check if data with key order is exist
			if (array_key_exists('order', $data)) 
				$this->order($data);
		endif;
	}

	// End of Callback function


	/*
		Structure function is used to set data structure that will be return
		Count Result function is used to count how much row that produced 

		param 		: $data with array 'structure' that included array 'data'
		other 		: -
		structure 	: 
			$data = array(
				'structure' => array(
					'data' => 'result_array', (result_array, row)
				),
				default is result
			);
	*/

	private function structure($data = false) {
		// Call callback function to get query condition
		$this->callback($data);

		// Get data from database
		$query = $this->db->get('user');
		$result = $query->result();

		// Check if key structure is true
		if ($data == true) :
			if (array_key_exists('structure', $data)) :
				switch ($data['structure']['data']) {
					// Return array
					case 'result_array':
						$result = $query->result_array();
						break;

					// Return object
					case 'row':
						$result = $query->row();
						break;

					// Return objects
					default :
						$result = $query->result();
				}
			endif;
		endif;

		return $result;
	}

	private function count_result($data = false) {
		// Add array count to define if in callback function didn't need limit
		$data['count'] = true;

		// Call callback function to get query condition
		$this->callback($data);
		$this->db->from('user');
		
		// Get number of result
		return $this->db->count_all_results();
	}

	// End of Structure and Count Result function



	/*
		=== Main Section ======================================
		Main function that always accessed by controllers
	*/

	// Get function is used to get data from database
	public function get($data = false) {

		// Set and return data as data and count
		$result = array(
			'data' => $this->structure($data),
			'count' => $this->count_result($data),
		);
		
		return $result;
	}

	/*
		Insert function is used to create new data and return new id

		param 		: $data with array 'insert' that included array 'post'
		other 		: -
		structure 	: 
			$data = array(
				'insert' => array(
					'post' => array(
						'title' => 'Test',
						'content' => 'Test content'
					),
				),
			);
	*/

	public function insert($data) {
		$this->db->insert('user', $data['insert']['post']);
		return $this->db->insert_id();
	}

	// End of Insert function

	/*
		Update function is used to update old data by some condition and return true/false

		param 		: $data with array 'update' that included array 'post' and 'condition'
		other 		: -
		structure 	: 
			$data = array(
				'update' => array(
					'post' => array(
						'title' => 'Test',
						'content' => 'Test content'
					),
				),
				'action' => array(
					'key' => 'search',
					'type' => 'where',
					'condition' => array('title !=' => 'Web'),
				),
			);
	*/

	public function update($data) {
		// Set search data
		$this->search($data);
		return $this->db->update('user', $data['update']['post']);
	}

	// End of Update function

	/*
		Delete function is used to delete old data by some condition and return true/false

		param 		: $data with array 'delete' that included 'condition'
		other 		: -
		structure 	: 
			$data = array(
				'update' => array(
					'post' => array(
						'title' => 'Test',
						'content' => 'Test content'
					),
				),
				'action' => array(
					'key' => 'search',
					'type' => 'where',
					'condition' => array('title !=' => 'Web'),
				),
			);
	*/

	public function delete($data) {
		// Set search data
		$this->search($data);

		// Check delete process is true or false
		if ($data['delete'])
			return $this->db->delete('user');
		else
			return false;
	}

	// End of Delete function

	

















	// Join function is used to combine more than 2 tables, user table with others
	private function join1($join = false) {
		if ($join == true) :
			// $this->db->select('*');
			// $this->db->join('other_tables', 'other_tables.id = user.id');
		endif;
	}

	// Search function is used to get data with some condition and join or not $search 
	// will be sent as array, there is 2 elements, 1 as type, 2 as condition
	private function search1($search = false) {
		$type = $search['type'];
		$condition = $search['condition'];

		$this->search_type($type, $condition);
	}

		// Set search type (like, where, ...), key (coloumn), value (search data)
		private function search_type($type = false, $condition = false) {
			if ($type == 'where') :
				$this->db->where($condition);
			elseif ($type == 'like') :
				$this->db->like($condition);
			elseif ($type == 'in') :
				$this->db->where_in($condition);
			endif;
		}

	// Order function to order data by some coloumn
	private function order1($order = false) {
		if ($order == true)
			$this->db->order_by($order['coloumn'], $order['type']);
	}

	// Return function used to return value from database
	private function return_data($return = false, $query = false) {
		if ($return == 'array') :
			return $query->result_array();
		elseif ($return == 'row') :
			return $query->row();
		else :
			return $query->result();
		endif;
	}

	// Function to count all data from query
	private function count_result1($query) {
		$query;
		return $this->db->count_all_results();
	}



	/*
		=== Main Section ======================================
		Main function that always accessed by controllers
	*/
	
	// Get only 1 data
	public function get1($join = false, $search = false, $array = false) {

		// Get data source by join, search or restrict condition
		$this->join($join);
		$this->search($search);
		$this->restrict(true);

		$query = $this->db->get('user');

		// Set return data as user data and count result data
		$data = array(
			'data' => $this->return_data($array, $query),
			'count_result' => $count_result = $this->count_result($query),
		);

		return $data;
	}

}