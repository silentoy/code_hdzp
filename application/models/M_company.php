<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_company extends MY_Model {

	function __construct($table='')
	{
		parent::__construct();

		$this->table = 'hdzp_company';
	}

    public function getInfo($params)
    {
        $params['cid'] = isset($params['cid']) ? (int)$params['cid'] : 0;

        $sql = "select id,uid,`name`,address,master,tel,email,views,ulevel,tagid,intro,pics ";
        if (isset($params['lat']) && isset($params['lng']) && $params['lat'] && $params['lng']) {
            $sql .= ",( 6371 * acos( cos( radians('{$params['lat']}') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('{$params['lng']}') ) + sin( radians('{$params['lat']}') ) * sin( radians( lat ) ) ) ) AS distance ";
        }
        $sql .= " from {$this->table} WHERE id='{$params['cid']}' and ulevel in (1,2)";

        $info = $this->db->query($sql)->row_array();

        return $this->_formatInfo($info);
    }

	public function getData($params)
	{
		$params['ulevel'] = isset($params['ulevel']) ? $params['ulevel'] : '1,2,3';
		$params['start'] = isset($params['start']) ? (int)$params['start'] : 0;
		$params['num'] = isset($params['num']) ? (int)$params['num'] : 0;
		$params['name'] = isset($params['name']) ? $params['name'] : '';

		if ($params['start'] == 0 && $params['num'] == 0) {    #计数
			$sql = "select count(*) as total from {$this->table} WHERE " . $this->_buildWhere($params);
			return (int)$this->db->query($sql)->row_array(0, true)['total'];
		}

		$sql = "select id,uid,`name`,address,master,tel,email,views,ulevel,tagid,vip_start,vip_end ";
        if (isset($params['lat']) && isset($params['lng']) && $params['lat'] && $params['lng']) {
            $sql .= ",( 6371 * acos( cos( radians('{$params['lat']}') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('{$params['lng']}') ) + sin( radians('{$params['lat']}') ) * sin( radians( lat ) ) ) ) AS distance ";
        }
		$sql .= " from {$this->table} WHERE " . $this->_buildWhere($params) . " ORDER BY id desc limit {$params['start']},{$params['num']}";
		$list = $this->db->query($sql)->result_array();

		return $this->_formatList($list, $params['name']);
	}

    private function _formatInfo($info)
    {
        if (!$info) return $info;

        $this->load->model('M_user');
        $this->load->model('M_positions');
        $this->load->model('M_Tag');

        $user = $this->M_user->get(array('id'=>$info['uid']));
        $info['regdate'] = date("Y-m-d", $user['regdate']);
        $info['positions'] = $this->M_positions->total(array('cid'=>$info['id']));
        $info['distance'] = isset($item['distance']) ? number_format($info['distance'], 1) : 0;
        $info['tags']    = $this->M_Tag->getListByIn($info['tagid']);
		$info['pics']    = stripos($info['pics'], ',') ? explode(",", $info['pics']) : array();

        return $info;
    }

	private function _formatList($list, $preg=false)
	{
		if (!$list) return $list;

		$this->load->model('M_user');
		$this->load->model('M_positions');
        $this->load->model('M_Tag');
		foreach ($list as $key=>$item) {
			$user = $this->M_user->get(array('id'=>$item['uid']));
            if ($preg) {
                $list[$key]['name'] = pregKeyword($item['name'], $preg);
            }
			$list[$key]['regdate'] = date("Y-m-d", $user['regdate']);
			$list[$key]['positions'] = $this->M_positions->total(array('cid'=>$item['id']));
            $list[$key]['distance'] = isset($item['distance']) ? number_format($item['distance'], 1) : 0;
            $list[$key]['tags']    = $this->M_Tag->getListByIn($item['tagid']);
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