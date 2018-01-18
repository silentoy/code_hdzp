<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_collect extends MY_Model {

	function __construct()
	{
		parent::__construct();

		$this->table = 'hdzp_collect';
	}
}