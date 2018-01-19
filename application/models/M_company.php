<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_company extends MY_Model {

	function __construct($table='')
	{
		parent::__construct();

		$this->table = 'hdzp_company';
	}

	public function getData($params)
	{
		$params['ulevel'] = isset($params['ulevel']) ? $params['ulevel'] : 0;
		$params['start'] = isset($params['start']) ? (int)$params['start'] : 0;
		$params['num'] = isset($params['num']) ? (int)$params['num'] : 0;
		$params['name'] = isset($params['name']) ? $params['name'] : '';

		if ($params['start'] == 0 && $params['num'] == 0) {    #计数
			$sql = "select count(*) from {$this->table} WHERE " . $this->_buildWhere($params);
			return (int)$this->db->query($sql)->row_array(0, true);
		}

		$sql = "select id,uid,`name`,address,master,tel,email,views,ulevel from {$this->table}
				WHERE " . $this->_buildWhere($params) . " ORDER BY id desc limit {$params['start']},{$params['num']}";
		$list = $this->db->query($sql)->result_array();

		return $this->_formatList($list);
	}

	private function _formatList($list)
	{
		if (!$list) return $list;

		$this->load->model('M_user');
		$this->load->model('M_positions');
		foreach ($list as $key=>$item) {
			$user = $this->M_user->get(array('id'=>$item['uid']));
			$list[$key]['regdate'] = date("Y-m-d", $user['regdate']);
			$list[$key]['positions'] = $this->M_positions->total(array('cid'=>$item['id']));
		}
		return $list;
	}

	private function _buildWhere($params)
	{
		$where = ' 1 and';

		if ($params['ulevel']) {
			$where .= " `ulevel` in ({$params['ulevel']}) and";
		}

		if ($params['name']) {
			$where .= " `name` like '%{$params['name']}%' and";
		}

		return rtrim($where, 'and');
	}

}