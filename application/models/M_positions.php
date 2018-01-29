<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class M_positions extends MY_Model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'hdzp_positions';
    }


    public function updateViews($pid=0, $cid = 0)
    {
        if ($pid) {
            $sql = "update {$this->table} set views=views+1 where id='{$pid}'";
            $this->db->query($sql);
        }

        if ($cid) {
            $sql = "update `hdzp_company` set views=views+1 where id='{$cid}'";
            $this->db->query($sql);
        }

        return true;
    }

    public function getInfo($params)
    {
        $params['pid'] = isset($params['pid']) ? (int)$params['pid'] : 0;
        $params['lat'] = isset($params['lat']) ? $params['lat'] : 0;
        $params['lng'] = isset($params['lng']) ? $params['lng'] : 0;

        $sql = "select p.id as pid,p.cid,p.name as position_name,p.wage_min,p.wage_max,p.wage_type,c.name as company_name,c.tagid,p.addtime,p.status,p.`intro`,p.`requirement`,p.views,p.ask_type,c.tel,c.email ";
        if (isset($params['lat']) && isset($params['lng']) && $params['lat'] && $params['lng']) {
            $sql .= ",( 6371 * acos( cos( radians('{$params['lat']}') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('{$params['lng']}') ) + sin( radians('{$params['lat']}') ) * sin( radians( lat ) ) ) ) AS distance ";
        }
        $sql .= "from hdzp_positions as p INNER JOIN hdzp_company as c on p.cid=c.id WHERE p.id='{$params['pid']}' and p.status>=2";

        $info = $this->db->query($sql)->row_array();

        return $this->_formatInfo($info);
    }

    public function getData($params)
    {
        $params['status'] = isset($params['status']) ? (int)$params['status'] : 0;
        $params['start'] = isset($params['start']) ? (int)$params['start'] : 0;
        $params['num'] = isset($params['num']) ? (int)$params['num'] : 0;
        $params['cid '] = isset($params['cid']) ? (int)$params['cid'] : 0;
        $params['tagid'] = isset($params['tagid']) ? (int)$params['tagid'] : 0;
        $params['lat'] = isset($params['lat']) ? $params['lat'] : 0;
        $params['lng'] = isset($params['lng']) ? $params['lng'] : 0;
        $params['openid'] = isset($params['openid']) ? $params['openid'] : 0;

        if ($params['start'] == 0 && $params['num'] == 0) {    #计数
            $sql = "select count(*) as total from hdzp_positions as p
					INNER JOIN hdzp_company as c on p.cid=c.id WHERE " . $this->_buildWhere($params);
            return (int)$this->db->query($sql)->row_array(0)['total'];
        }

        $sql = "select p.id as pid,p.cid,p.name as position_name,p.wage_min,p.wage_max,p.wage_type,c.name as company_name,c.tagid,p.addtime,p.status,p.ask_type,c.tel,c.email";
        if (isset($params['lat']) && isset($params['lng']) && $params['lat'] && $params['lng']) {
            $sql .= ",( 6371 * acos( cos( radians('{$params['lat']}') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('{$params['lng']}') ) + sin( radians('{$params['lat']}') ) * sin( radians( lat ) ) ) ) AS distance ";
        }
        $sql .= " from hdzp_positions as p INNER JOIN hdzp_company as c on p.cid=c.id WHERE " . $this->_buildWhere($params) . " order by p.addtime desc limit {$params['start']}, {$params['num']}";

        $list = $this->db->query($sql)->result_array();

        return $this->_formatList($list);
    }

    private function _formatList($list)
    {
        if (!$list) return $list;

        $this->load->model('M_Tag');
        foreach ($list as $key => $item) {
            $list[$key] = array(
                'pid'   => $item['pid'],
                'cid'   => $item['cid'],
                'position_name' => $item['position_name'],
                'company_name' => $item['company_name'],
                'distance' => isset($item['distance']) ? number_format($item['distance'], 1) : 0,
                'tags' => $this->M_Tag->getListByIn($item['tagid']),
                'wage' => $this->_formatWage($item['wage_min'], $item['wage_max'], $item['wage_type'])
            );
        }
        return $list;
    }

    private function _formatInfo($info)
    {
        if (!$info) return $info;

        $this->load->model('M_Tag');
        return array(
            'pid'   => $info['pid'],
            'cid'   => $info['cid'],
            'position_name' => $info['position_name'],
            'company_name' => $info['company_name'],
            'distance' => isset($info['distance']) ? number_format($info['distance'], 1) : 0,
            'tags' => $this->M_Tag->getListByIn($info['tagid']),
            'wage' => $this->_formatWage($info['wage_min'], $info['wage_max'], $info['wage_type']),
            'intro' => $info['intro'],
            'requirement' => $info['requirement'],
            'views' => $info['views'],
            'ask_type' => $info['ask_type'],
            'tel' => $info['tel'],
            'email' => $info['email'],
        );
    }

    private function _formatWage($min, $max, $type)
    {
        if ($type || (!$min && !$max)) {
            return '薪资面议';
        }

        $and = ($min && $max) ? ' - ' : false;
        if ($min) {
            $min = number_format($min / 1000, 1) . "K";
            if (!$and) return $min;
        }
        if ($max) {
            $max = number_format($max / 1000, 1) . "K";
            if (!$and) return $max;
        }

        return $min . $and . $max;
    }

    private function _buildWhere($params)
    {
        $where = '';

        if ($params['status'] == 3) {
            $where .= " p.status=3 and";
        } else {
            $where .= " p.status>=2 and";
        }
        if ($params['cid']) {
            $where .= " p.cid='{$params['cid']}' and";
        }

        if ($params['tagid']) {
            $where .= " find_in_set(`c.tagid`, '{$params['tagid']}') and";
        }

        if ($params['openid']) {
            $where .= " p.id in (select pid from hdzp_collect where openid='{$params['openid']}') and";
        }

        if ($params['name']) {
            $where .= " (p.name LIKE '%{$params['name']}%' or c.name LIKE '%{$params['name']}%') and";
        }

        return rtrim($where, 'and');
    }

}