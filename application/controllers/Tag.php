<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_company');
		$this->load->model('M_tag');
	}

	public function getList()
	{
		$num = (int)$this->input->get('num', TRUE);

		$list = $this->M_tag->getList(array('status'=>0), 0, $num, 'orderby desc, id desc');
		echojsondata('ok', $list);
	}
}
