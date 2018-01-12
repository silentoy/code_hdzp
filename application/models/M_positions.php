<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_positions extends MY_Model {

	function __construct()
	{
		parent::__construct();

		$this->table = 'hdzp_positions';
	}


	public function updateViews($id, $cid=0) {
		if (!$id) return false;

		$sql = "update {$this->table} set views=views+1 where id='{$id}'";
		$this->db->query($sql);

		if ($cid) {
			$sql = "update `hdzp_company` set views=views+1 where id='{$id}'";
			$this->db->query($sql);
		}

		return true;
	}

}