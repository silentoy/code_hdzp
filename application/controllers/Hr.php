<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr extends MY_Controller {

	private $hrInfo;

	public function __construct()
	{
		parent::__construct();

		if (!$this->user['id'] || $this->user['groupid']!=2) {
			header('HTTP/1.0 403 Forbidden');
			exit();
		}

		$this->load->model('M_company');
		$this->load->model('M_positions');
		$this->hrInfo = $this->M_company->get(array('uid'=>$this->user['id']));
		if (!$this->hrInfo) {
			header('HTTP/1.0 403 Forbidden');
			exit();
		}
	}

	/**
	 * HR首页
	 */
	public function index()
	{
		$data = array();

		$this->load->model('M_notice');
		$data['notices']    = $this->M_notice->getList(array('status'=>0), 0, 10, 'id DESC');
		$data['positions'] = $this->M_positions->total(array('cid'=>$this->hrInfo['id']));

		$this->load->view('hr/header', array('hrInfo'=>$this->hrInfo));
		$this->load->view('hr/index', $data);
	}

	public function vip()
	{
		$data = array();

		$this->load->view('hr/header', array('hrInfo'=>$this->hrInfo));
		$this->load->view('hr/vip', $data);
	}

	/**
	 * 新建&编辑职位
	 */
	public function positionAdd()
	{
		$id = (int)$this->input->get('id', TRUE);
		$data = array(
			'hrInfo'	=> $this->hrInfo
		);
		if ($id) {
			$data['info'] = $this->M_positions->get(array('id'=>$id, 'uid'=>$this->user['id']));
			if (!$data['info']) {
				echojsondata('err', false, '职位信息不存在');
			}
		}

		$this->load->view('hr/header', array('hrInfo'=>$this->hrInfo));
		$this->load->view('hr/position_add', $data);
	}

	public function positionUpdate()
	{
		$id 	= (int)$this->input->get('id', TRUE);
		$status = (int)$this->input->get('status', TRUE);
		if (!$id) {
			echojsondata('err', false, '职位信息不存在');
		}
		$info = $this->M_positions->get(array('id'=>$id, 'uid'=>$this->user['id']));
		if (!$info) {
			echojsondata('err', false, '职位信息不存在');
		}

		$this->M_positions->update(array('status'=>$status), array('id'=>$id, 'uid'=>$this->user['id']));

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
			$info = $this->M_positions->get(array('id'=>$id, 'uid'=>$this->user['id']));
			if (!$info) {
				echojsondata('err', false, '职位信息不存在');
			}

			unset($param['id']);
			$this->M_positions->update($param, array('id'=>$id));

			$logType = 'editPosition';
		} else {	#添加
			unset($param['id']);
			$param['cid'] 		= $this->hrInfo['id'];
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
		$pre_page = 1;
		$page = (int)$this->input->get('page', TRUE);
		$data['page'] = $page ? $page : 1;

		$data['total'] = $this->M_positions->total(array('cid'=>$this->hrInfo['id'], 'status>='=>0));
		if ($data['total']) {
			$start = ($data['page']-1) * $pre_page;

			$data['list'] = $this->M_positions->getList(array('cid'=>$this->hrInfo['id']), $start, $pre_page);

			//分页
			$this->load->library('pagination');

			$config['base_url']    = '/index.php?c=hr&m=positionlist';
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

		$this->load->view('hr/header', array('hrInfo'=>$this->hrInfo));
		$this->load->view('hr/position_list', $data);
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

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '职位名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intro', '工作职责', 'trim|required|xss_clean');
		$this->form_validation->set_rules('requirement', '岗位要求', 'trim|required|xss_clean');


		if ($this->form_validation->run() == FALSE){
			echojsondata('err', false, '提交参数错误！');
		}

		return $param;
	}
}
