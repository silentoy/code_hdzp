<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_company');
	}

	public function getInfo()
	{
		$params['cid'] = (int)$this->input->get('cid', TRUE);
		//经纬度
		$params['lat'] = $this->input->get('lat', TRUE);
		$params['lng'] = $this->input->get('lng', TRUE);

		$info = $this->M_company->getInfo($params);

		//更新浏览数
		$this->M_positions->updateViews(0, $params['cid']);

		$data = array(
			'info'      => $info
		);

		echojsondata('ok', $data);
	}

	public function getList()
	{
		$params = array();
		//经纬度
		$params['lat'] = $this->input->get('lat', TRUE);
		$params['lng'] = $this->input->get('lng', TRUE);
		$params['name'] = $this->input->get('name', TRUE);
		$total = $this->M_company->getData($params);

		if ($total) {
			$params['num'] = (int)$this->input->get('num', TRUE);
			$params['num'] = $params['num'] ? $params['num'] : 10;

			$page = (int)$this->input->get('page', TRUE);
			$page = $page ? $page : 1;
			$params['start'] = ($page-1)*$params['num'];

			$list = $this->M_company->getData($params);
		} else {
			$list = false;
		}

		echojsondata('ok', array('total'=>$total, 'list'=>$list));
	}
}
