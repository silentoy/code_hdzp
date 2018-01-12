<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Code extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_code');
	}

	public function index()
	{
		$this->M_code->getCode();
	}
}
