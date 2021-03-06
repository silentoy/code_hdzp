<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Position extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_positions');
    }

    public function getInfo()
    {
        $params['pid'] = (int)$this->input->get('pid', TRUE);
        //经纬度
        $params['lat'] = $this->input->get('lat', TRUE);
        $params['lng'] = $this->input->get('lng', TRUE);

        $openid = $this->input->get('openid', TRUE);

        $info = $this->M_positions->getInfo($params);

        //更新浏览数
        $this->M_positions->updateViews($info['pid'], $info['cid']);

        //是否收藏
        $this->load->model('M_collect');
        $collectInfo = $this->M_collect->get(array('openid'=>$openid, 'pid'=>$params['pid']));
        $isCollect = $collectInfo ? true : false;

        $data = array(
            'isCollect' => $isCollect,
            'info'      => $info
        );

        echojsondata('ok', $data);
    }

    public function getList()
    {
        $params = array();
        $params['status'] = (int)$this->input->get('status', TRUE); //简历状态 上线>=2  精选=3
        $params['cid'] = (int)$this->input->get('cid', TRUE); //公司ID
        $params['tagid'] = (int)$this->input->get('tagid', TRUE);
        //经纬度
        $params['lat'] = $this->input->get('lat', TRUE);
        $params['lng'] = $this->input->get('lng', TRUE);
        $params['openid'] = $this->input->get('openid', TRUE);
        $params['name'] = $this->input->get('name', TRUE);
        $total = $this->M_positions->getData($params);

        if ($total) {
            $params['num'] = (int)$this->input->get('num', TRUE);
            $params['num'] = $params['num'] ? $params['num'] : 10;

            $page = (int)$this->input->get('page', TRUE);
            $page = $page ? $page : 1;
            $params['start'] = ($page-1)*$params['num'];

            $list = $this->M_positions->getData($params);
        } else {
            $list = false;
        }

        echojsondata('ok', array('total'=>$total, 'list'=>$list));
    }
}
