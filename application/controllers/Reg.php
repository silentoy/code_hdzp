<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_code');
	}

	public function index()
	{
		$this->load->model('M_Tag');

		$data = array();
		$data['tags'] = $this->M_Tag->getList(array('status'=>0), 0, 1000, 'orderby desc, id asc');
		$this->load->view('reg', $data);
	}

	public function onReg()
	{
		$this->load->model('M_user');
		$this->load->model('M_company');

		//获取post数据
		$param = $this->getFromData();

		//检测公司名重复
		$existInfo = $this->M_company->get(array('name'=>$param['name']));
		if ($existInfo && $existInfo['uid']!=$param['uid']) {
			echojsondata('err', false, '您注册的公司名称已存在');
		}

		if (!$param['uid']) {
			//随机生成密码串
			$param['password'] = createPassword(8);

			//写入用户表
			$user = array(
				'name' => $param['name'],
				'password' => $param['password'],
				'groupid' => 2
			);
			$uid = $this->M_user->add($user);

			if (!$uid) {
				echojsondata('err', false, '注册失败,请联系管理员');
			}
		} else {
			$uid = $param['uid'];
		}

		//获取地址经纬度
		$location = getLocation($param['address']);


		//写入公司表
		$company = array(
			'uid'		=> $uid,
			'name'		=> $param['name'],
			'address'	=> $param['address'],
			'tagid'		=> $param['tagid'],
			'lat'		=> $location['lat'],
			'lng'		=> $location['lng'],
			'master'	=> $param['master'],
			'tel'		=> $param['tel'],
			'email'		=> $param['email'],
			'license'	=> $param['license'],
			'intro'		=> $param['intro'],
			'ulevel'	=> 3
		);
		if (!$param['uid']) {
			$this->M_company->add($company);
		} else {
			$this->M_company->update($company, array('uid'=>$uid));
			$this->M_user->update(array('name'=>$param['name']), array('id'=>$uid));
		}

		//注册完成
		$res = array(
			'uid'		=> $uid,
			'password'	=> isset($param['password']) ? $param['password'] : ''
		);

		echojsondata('ok', $res);
	}

	//参数过滤
	private function getFromData(){
		$param = array();

		//var_dump($this->input->post());die();
		$param['uid'] 		= (int)$this->input->post('uid', TRUE);
		$param['name'] 		= $this->input->post('name', TRUE);
		$param['address'] 	= $this->input->post('address', TRUE);
		$param['tagid']  	= is_array($this->input->post('tagid', TRUE)) ? implode(',', $this->input->post('tagid', TRUE)) : $this->input->post('tagid', TRUE);
		$param['master']    = $this->input->post('master', TRUE);
		$param['tel']	    = $this->input->post('tel', TRUE);
		$param['email']	    = $this->input->post('email', TRUE);
		$param['license']	= $this->input->post('license', TRUE);
		$param['intro']	    = $this->input->post('intro', TRUE);


		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '公司名称', 'trim|required');
		$this->form_validation->set_rules('address', '公司地址', 'trim|required');
		$this->form_validation->set_rules('tagid', '公司地点标签', 'trim|required');
		$this->form_validation->set_rules('master', '招聘负责人', 'trim|required');
		$this->form_validation->set_rules('tel', '联系电话', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('email', '电子邮箱', 'trim|required');
		$this->form_validation->set_rules('license', '营业执照副本', 'trim|required');
		$this->form_validation->set_rules('intro', '公司简介', 'trim|required');

		if ($this->form_validation->run() == FALSE){

			$msg   = '提交参数错误！';
			echojsondata('err', false, $msg);

		}

		return $param;
	}
}
