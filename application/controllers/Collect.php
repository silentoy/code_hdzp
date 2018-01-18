<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collect extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_collect');
	}

	public function index()
	{

	}

	public function add()
	{
		$pid = (int)$this->input->get('pid', TRUE);
		$openid = $this->input->get('openid', TRUE);

		if (!$openid || !$pid) {
			echojsondata('err', false, '信息不完整');
		}

		$collectInfo = $this->M_collect->get(array('openid'=>$openid, 'pid'=>$pid));
		if ($collectInfo) {
			echojsondata('err', false, '您已经收藏过该职位');
		}

		$col = array(
			'openid'	=> $openid,
			'pid'		=> $pid,
			'addtime'	=> TIMESTAMP
		);
		$id = $this->M_collect->add($col);
		echojsondata('ok', array('id'=>$id));
	}
}
