<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_company extends MY_Model {

	function __construct($table='')
	{
		parent::__construct();

		$this->table = 'hdzp_company';
	}



}