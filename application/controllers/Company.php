<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_company');
	}

	public function index()
	{

	}
}
