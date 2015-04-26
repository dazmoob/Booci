<?php

class Page_numbering extends CI_Model {

	public function set_pagination($param = false) {

		// Get base URL
		$config['base_url'] = $this->set_url($param);

		// Add suffix for GET parameter
		if (!empty($_GET)) :
			$config['suffix'] = '?'.http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		endif;

		// Set numbering segment if segment 3 used
		if (!empty($param['url']['uri3']))
			$config['uri_segment'] = 4;

		// Get total rows
		$config['total_rows'] = $this->set_total_rows($param);

		// Set data rows limit per page
		$config['per_page'] = (!empty($param['per_page'])) ? $param['per_page'] : 10; 

		// Set pagination design
		$config['full_tag_open'] = "<ul class='pagination pagination-sm no-margin pull-right'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		// Set for Next & Prev only
		if (!empty($param['next_prev']))
			$config['display_pages'] = FALSE;

		$this->pagination->initialize($config);

	}

	private function set_url($param = false) {

		// Get current URL
		$base_url = site_url($this->uri->segment(1).'/');

		// URI Segment 2
		if (!empty($this->uri->segment(2)))
			$base_url = $base_url.'/'.$this->uri->segment(2).'/';
		else
			$base_url = $base_url.'/index/';

		// URI 2 URL - Set manually by user
		if (!empty($param['url']['uri2']))
			$base_url = $base_url.$param['url']['uri2'];

		// URI 3 URL - Set manually by user
		if (!empty($param['url']['uri3']))
			$base_url = $base_url.$param['url']['uri3'];

		// Fix URL
		if (!empty($param['url']['fix']))
			$base_url = $param['url']['fix'];

		return $base_url;

	}

	private function set_total_rows($param = false) {

		$total = 10;

		if (!empty($param['param']['table']) && !empty($param['param']['param'])) :

			$table = $param['param']['table'].'_model';
			$param = $param['param']['param'];

			$this->load->model($table);

			$param['limit'] = false;
			$all = $this->$table->get_all($param);
			$total = count($all);

		endif;

		return $total;

	}

}	