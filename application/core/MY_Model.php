<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $table;

	public function __construct() {
	    
		parent::__construct();
	}

	public function add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get($data)
	{
		return $this->db->get_where($this->table, $data, 1)->row_array();
	}

	public function update($set, $where)
	{
		return $this->db->update($this->table, $set, $where);
	}

	public function total($data)
	{
		$this->db->where($data);
		$this->db->from($this->table);
		return (int)$this->db->count_all_results();
	}

	public function getList($where, $start=0, $limit=1000)
	{
		return $this->db->select('*')->from($this->table)->where($where)->limit($start, $limit);
	}

}

