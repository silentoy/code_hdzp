<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->user['id'] || $this->user['groupid']!=1) {
			header('HTTP/1.0 403 Forbidden');
			exit();
		}
		$this->load->model('M_company');
		$this->load->model('M_positions');
		$this->load->model('M_user');
	}

	/**
	 * Admin首页
	 */
	public function index()
	{
		//获取公司列表
		$data = array();
		$pre_page = 10;
		$page = (int)$this->input->get('page', TRUE);
		$name = $this->input->get('name', TRUE);
		$data['page'] = $page ? $page : 1;

		$params['name'] = $name;
		$data['total'] = $this->M_company->getData($params);

		if ($data['total']) {
			$params['start'] = ($data['page']-1) * $pre_page;
			$params['num'] = $pre_page;
			$data['list'] = $this->M_company->getData($params);

			//分页
			$this->load->library('pagination');

			$config['base_url']    = '/index.php?c=admin';
			if ($name) $config['base_url'] .= "&name={$name}";
			$config['total_rows']  = $data['total'];        //总数
			$config['per_page']    = $pre_page;         //每页个数
			$config['num_links']   = 10;                       //分页个数
			$config['cur_page']    = $data['page'];

			$config['data_page_attr']      = false;
			$config['reuse_query_string']  = true;
			$config['use_page_numbers']    = true;
			$config['page_query_string']   = true;
			$config['query_string_segment'] = 'page';

			$config['first_link']  = false;
			$config['prev_link']   = '上一页';
			$config['next_link']   = '下一页';
			$config['last_link']   = false;

			$config['attriclass']      = array(                //首尾页特殊class
				'prev' => 'page-over',
				'next' => 'page-over',
			);
			$config['cur_tag_open']    = '<a class="current">';
			$config['cur_tag_close']   = '</a>';
			$config['num_tag_open']    = ' ';
			$config['num_tag_close']   = ' ';

			$this->pagination->initialize($config);

			$data['pageStr']    = $this->pagination->create_links();
		}

		$this->load->view('admin/header');
		$this->load->view('admin/index', $data);
	}

	public function companyAdd()
	{
		$this->load->model('M_Tag');

		$data = array();
		$data['tags'] = $this->M_Tag->getList(array('status'=>0), 0, 1000, 'orderby desc, id asc');
		if ($id = (int)$this->input->get('id', TRUE)) {
			$data['info'] = $this->M_company->get(array('id' => $id));
		}

		$this->load->view('admin/header');
		$this->load->view('admin/company/add', $data);
	}

	public function onCompanyUpdate()
	{
		$id       = (int)$this->input->post('id', TRUE);
		$password = $this->input->post('password', TRUE);
		$ulevel   = $this->input->post('ulevel', TRUE);
		$vip_start= $this->input->post('vip_start', TRUE);
		$vip_end  = $this->input->post('vip_end', TRUE);

		if (!$id) {
			echojsondata('err', false, '公司信息不存在');
		}
		$info = $this->M_company->get(array('id'=>$id));
		if (!$info) {
			echojsondata('err', false, '公司信息不存在');
		}

		if ($password) {
			$salt     = substr(uniqid(rand()), -6);
			$password = strlen($password) == 32 ? $password : md5($password) ;
			$password = md5($password.$salt);

			$param = array(
				'password'	=> $password,
				'salt'		=> $salt
			);
			$this->M_user->update($param, array('id'=>$info['uid']));
			$param['uid'] = $info['uid'];

			$this->M_log->add(array(
				'log_type'		=> 'updatePassword',
				'log_params'	=> $param
			));
		}

		if ($ulevel) {
			$param = array(
				'ulevel'	=> $ulevel,
				'vip_start' => strtotime($vip_start),
				'vip_end'	=> strtotime($vip_end)
			);
			$this->M_company->update($param, array('id'=>$id));
			$param['id'] = $id;
			$this->M_log->add(array(
				'log_type'		=> 'updateCompany',
				'log_params'	=> $param
			));
		}
		echojsondata('ok');
	}

	/**
	 * 新建&编辑职位
	 */
	public function positionAdd()
	{
		$data = array();
		//获取公司列表
		$data['companys'] = $this->M_company->getList(array('ulevel<='=>2));

		$id = (int)$this->input->get('id', TRUE);
		if ($id) {
			$data['info'] = $this->M_positions->get(array('id'=>$id));
			if (!$data['info']) {
				echojsondata('err', false, '职位信息不存在');
			}
		}

		$this->load->view('admin/header');
		$this->load->view('admin/position/add', $data);
	}

	public function positionUpdate()
	{
		$id 	= (int)$this->input->get('id', TRUE);
		$status = (int)$this->input->get('status', TRUE);
		if (!$id) {
			echojsondata('err', false, '职位信息不存在');
		}
		$info = $this->M_positions->get(array('id'=>$id));
		if (!$info) {
			echojsondata('err', false, '职位信息不存在');
		}

		$this->M_positions->update(array('status'=>$status), array('id'=>$id));

		//记录日志
		$param['id'] = $id;
		$this->M_log->add(array(
			'log_type'		=> 'updatePosition',
			'log_params'	=> array('status'=>$status, 'id'=>$id)
		));

		echojsondata('ok');
	}

	public function onAdd()
	{
		$param = $this->getFromData();

		if ($id = $param['id']) {	#更新
			$info = $this->M_positions->get(array('id'=>$id));
			if (!$info) {
				echojsondata('err', false, '职位信息不存在');
			}

			unset($param['id']);
			$this->M_positions->update($param, array('id'=>$id));

			$logType = 'editPosition';
		} else {	#添加
			unset($param['id']);
			$param['uid'] 		= $this->user['id'];
			$param['addtime'] 	= TIMESTAMP;

			$id = $this->M_positions->add($param);
			$logType = 'addPosition';
		}

		//记录日志
		$param['id'] = $id;
		$this->M_log->add(array(
			'log_type'		=> $logType,
			'log_params'	=> $param
		));

		echojsondata('ok', array('id'=>$id));
	}

	public function positionList()
	{
		$data = array();
		$pre_page = 10;
		$page = (int)$this->input->get('page', TRUE);
		$name = addslashes(htmlspecialchars($this->input->get('name', TRUE)));
		$data['page'] = $page ? $page : 1;

		$like = false;
		if ($name) $like = array('name'=>$name);
		$data['total'] = $this->M_positions->total(array('status>'=>0), $like);
		if ($data['total']) {
			$start = ($data['page']-1) * $pre_page;

			$data['list'] = $this->M_positions->getList(array('status>'=>0), $start, $pre_page, 'addtime desc', $like);
			foreach ($data['list'] as $key=>$item) {
				$company = $this->M_company->get(array('id'=>$item['cid']));
				$data['list'][$key]['company_name'] = $company['name'];
			}

			//分页
			$this->load->library('pagination');

			$config['base_url']    = '/index.php?c=admin&m=positionlist';
			if ($name) $config['base_url'] .= "&name={$name}";
			$config['total_rows']  = $data['total'];        //总数
			$config['per_page']    = $pre_page;         //每页个数
			$config['num_links']   = 10;                       //分页个数
			$config['cur_page']    = $data['page'];

			$config['data_page_attr']      = false;
			$config['reuse_query_string']  = true;
			$config['use_page_numbers']    = true;
			$config['page_query_string']   = true;
			$config['query_string_segment'] = 'page';

			$config['first_link']  = false;
			$config['prev_link']   = '上一页';
			$config['next_link']   = '下一页';
			$config['last_link']   = false;

			$config['attriclass']      = array(                //首尾页特殊class
				'prev' => 'page-over',
				'next' => 'page-over',
			);
			$config['cur_tag_open']    = '<a class="current">';
			$config['cur_tag_close']   = '</a>';
			$config['num_tag_open']    = ' ';
			$config['num_tag_close']   = ' ';

			$this->pagination->initialize($config);

			$data['pageStr']    = $this->pagination->create_links();
		}

		$this->load->view('admin/header');
		$this->load->view('admin/position/list', $data);
	}

	public function companyList()
	{
		$data = array();
		$pre_page = 20;
		$page = (int)$this->input->get('page', TRUE);
		$data['page'] = $page ? $page : 1;

		$data['total'] = $this->M_company->total(array('status>'=>0));
		if ($data['total']) {
			$start = ($data['page']-1) * $pre_page;

			$data['list'] = $this->M_company->getList(array('status>'=>0), $start, $pre_page);

			//分页
			$this->load->library('pagination');

			$config['base_url']    = '/index.php?c=admin&m=companylist';
			$config['total_rows']  = $data['total'];        //总数
			$config['per_page']    = $pre_page;         //每页个数
			$config['num_links']   = 10;                       //分页个数
			$config['cur_page']    = $data['page'];

			$config['data_page_attr']      = false;
			$config['reuse_query_string']  = true;
			$config['use_page_numbers']    = true;
			$config['page_query_string']   = true;
			$config['query_string_segment'] = 'page';

			$config['first_link']  = false;
			$config['prev_link']   = '上一页';
			$config['next_link']   = '下一页';
			$config['last_link']   = false;

			$config['attriclass']      = array(                //首尾页特殊class
				'prev' => 'page-over',
				'next' => 'page-over',
			);
			$config['cur_tag_open']    = '<a class="current">';
			$config['cur_tag_close']   = '</a>';
			$config['num_tag_open']    = ' ';
			$config['num_tag_close']   = ' ';

			$this->pagination->initialize($config);

			$data['pageStr']    = $this->pagination->create_links();
		}

		$this->load->view('Admin/Company/List', $data);
	}

	public function companyUpdate()
	{
		$id 		= (int)$this->input->get('id', TRUE);
		$ulevel 	= (int)$this->input->get('ulevel', TRUE);
		$vip_start 	= $this->input->get('vip_start', TRUE);
		$vip_end   	= $this->input->get('vip_end', TRUE);
		$vip_start  = $vip_start ? strtotime($vip_start) : 0;
		$vip_end    = $vip_end   ? strtotime($vip_end) : 0;

		$set        = array(
			'ulevel'	=> $ulevel,
			'vip_start' => $vip_start,
			'vip_end'	=> $vip_end,
		);
		$this->M_company->update($set, array('id'=>$id));

		$set['id'] = $id;
		$this->M_log->add(array(
			'log_type'		=> 'updateCompany',
			'log_params'	=> $set
		));

		echojsondata('ok', array('id'=>$id));
	}

	public function tagAdd()
	{
		$this->load->model('M_Tag');
		$param = $this->getTagData();

		if ($id = $param['id']) {
			$set['status'] = $param['status'];

			$this->M_Tag->update($set, array('id'=>$id));
			$logType = 'updateTag';
		} else {
			//检查重复
			$isExist = $this->M_Tag->get(array('name'=>$param['name']));
			if ($isExist) {
				echojsondata('err', false, '标签名已存在');
			}

			unset($param['id']);
			$this->M_Tag->add($param);
			$logType = 'addTag';
		}

		//记录日志
		$param['id'] = $id;
		$this->M_log->add(array(
			'log_type'		=> $logType,
			'log_params'	=> $param
		));

		echojsondata('ok', array('id'=>$id));
	}

	/*
	 * 标签排序 array(array('id'=>1, 'orderby'=>4), array('id'=>2, 'orderby'=>3))
	 */
	public function tagOrder()
	{
		$order = $this->input->get('order', TRUE);
		if (!$order) {
			echojsondata('err', false, '参数不完整');
		}
		$this->load->model('M_Tag');
		foreach ($order as $item) {
			$this->M_Tag->update(array('orderby'=>$item['orderby']), array('id'=>$item['id']));
		}
		echojsondata('ok');
	}

	public function tagList()
	{
		$this->load->model('M_Tag');

		$data = array();
		$pre_page = 20;
		$page = (int)$this->input->get('page', TRUE);
		$data['page'] = $page ? $page : 1;

		$data['total'] = $this->M_Tag->total(array('status'=>0));
		if ($data['total']) {
			$start = ($data['page']-1) * $pre_page;

			$data['list'] = $this->M_Tag->getList(array('status'=>0), $start, $pre_page, 'orderby desc');

			//分页
			$this->load->library('pagination');

			$config['base_url']    = '/index.php?c=admin&m=taglist';
			$config['total_rows']  = $data['total'];        //总数
			$config['per_page']    = $pre_page;         //每页个数
			$config['num_links']   = 10;                       //分页个数
			$config['cur_page']    = $data['page'];

			$config['data_page_attr']      = false;
			$config['reuse_query_string']  = true;
			$config['use_page_numbers']    = true;
			$config['page_query_string']   = true;
			$config['query_string_segment'] = 'page';

			$config['first_link']  = false;
			$config['prev_link']   = '上一页';
			$config['next_link']   = '下一页';
			$config['last_link']   = false;

			$config['attriclass']      = array(                //首尾页特殊class
				'prev' => 'page-over',
				'next' => 'page-over',
			);
			$config['cur_tag_open']    = '<a class="current">';
			$config['cur_tag_close']   = '</a>';
			$config['num_tag_open']    = ' ';
			$config['num_tag_close']   = ' ';

			$this->pagination->initialize($config);

			$data['pageStr']    = $this->pagination->create_links();
		}

		$this->load->view('admin/header');
		$this->load->view('admin/tag/list', $data);
	}

	public function noticeList()
	{
		$this->load->model('M_notice');

		$data = array();
		$pre_page = 20;
		$page = (int)$this->input->get('page', TRUE);
		$data['page'] = $page ? $page : 1;

		$data['total'] = $this->M_notice->total(array('status'=>0));
		if ($data['total']) {
			$start = ($data['page']-1) * $pre_page;

			$data['list'] = $this->M_notice->getList(array('status'=>0), $start, $pre_page, 'addtime desc');

			//分页
			$this->load->library('pagination');

			$config['base_url']    = '/index.php?c=admin&m=noticelist';
			$config['total_rows']  = $data['total'];        //总数
			$config['per_page']    = $pre_page;         //每页个数
			$config['num_links']   = 10;                       //分页个数
			$config['cur_page']    = $data['page'];

			$config['data_page_attr']      = false;
			$config['reuse_query_string']  = true;
			$config['use_page_numbers']    = true;
			$config['page_query_string']   = true;
			$config['query_string_segment'] = 'page';

			$config['first_link']  = false;
			$config['prev_link']   = '上一页';
			$config['next_link']   = '下一页';
			$config['last_link']   = false;

			$config['attriclass']      = array(                //首尾页特殊class
				'prev' => 'page-over',
				'next' => 'page-over',
			);
			$config['cur_tag_open']    = '<a class="current">';
			$config['cur_tag_close']   = '</a>';
			$config['num_tag_open']    = ' ';
			$config['num_tag_close']   = ' ';

			$this->pagination->initialize($config);

			$data['pageStr']    = $this->pagination->create_links();
		}

		$this->load->view('admin/header');
		$this->load->view('admin/notice/list', $data);
	}

	public function noticeAdd()
	{
		$this->load->model('M_Notice');
		$param = $this->getNoticeData();

		if ($id = $param['id']) {

			unset($param['id']);
			$this->M_notice->update($param, array('id'=>$id));
			$logType = 'updateNotice';
		} else {
			unset($param['id']);
			$param['addtime'] = TIMESTAMP;
			$id = $this->M_notice->add($param);
			$logType = 'addNotice';
		}

		//记录日志
		$param['id'] = $id;
		$this->M_log->add(array(
			'log_type'		=> $logType,
			'log_params'	=> $param
		));

		echojsondata('ok', array('id'=>$id));
	}

	//参数过滤
	private function getFromData(){
		$param = array();

		$param['id'] 			= $this->input->post('id', TRUE);
		$param['name'] 			= $this->input->post('name', TRUE);
		$param['wage_min']  	= $this->input->post('wage_min', TRUE);
		$param['wage_max']      = $this->input->post('wage_max', TRUE);
		$param['wage_type']     = $this->input->post('wage_type', TRUE);
		$param['intro']     	= $this->input->post('intro', TRUE);
		$param['requirement']   = $this->input->post('requirement', TRUE);
		$param['ask_type']     	= $this->input->post('ask_type', TRUE);
		$param['cid']			= $this->input->post('cid', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '职位名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intro', '工作职责', 'trim|required|xss_clean');
		$this->form_validation->set_rules('requirement', '岗位要求', 'trim|required|xss_clean');


		if ($this->form_validation->run() == FALSE){
			echojsondata('err', false, '提交参数错误！');
		}

		return $param;
	}

	private function getTagData()
	{
		$param = array();

		$param['id'] 			= $this->input->post('id', TRUE);
		$param['name'] 			= $this->input->post('name', TRUE);
		$param['status']		= $this->input->post('status', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '标签名称', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE){
			echojsondata('err', false, '提交参数错误！');
		}

		return $param;
	}

	private function getNoticeData()
	{
		$param = array();

		$param['id'] 			= $this->input->post('id', TRUE);
		$param['subject'] 	    = $this->input->post('subject', TRUE);
		$param['content']		= $this->input->post('content', TRUE);
		$param['status']        = $this->input->post('status', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject', '标题', 'trim|required|xss_clean');
		$this->form_validation->set_rules('subject', '内容', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE){
			echojsondata('err', false, '提交参数错误！');
		}

		return $param;
	}
}
