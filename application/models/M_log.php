<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_log extends MY_Model {

	function __construct()
	{
		parent::__construct();

		$this->table = 'hdzp_logs';
	}
	
    public function countFalseLogin()
	{
		$start = strtotime('-1 days');

		$query = $this->db->query("SELECT id FROM {$this->table} WHERE log_ip='".CLIENTIP."' and log_type='falseLogin' and log_time>='{$start}'");
		return $query->num_rows();
	}

	public function add($data)
	{
		if (!isset($data['log_time']) || !$data['log_time']) {
			$data['log_time'] = TIMESTAMP;
		}
		if (!isset($data['log_ip']) || !$data['log_ip']) {
			$data['log_ip'] = CLIENTIP;
		}
		if (!isset($data['uid']) || !$data['uid']) {
			$data['uid'] = $this->user['id'];
		}
		if (isset($data['log_params']) && is_array($data['log_params'])) {
			$data['log_params'] = json_encode($data['log_params']);
		}

		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
}