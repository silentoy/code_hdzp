<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_log');
		$this->load->model('M_User');
	}

	public function index()
	{
		//获取密码错误次数
		$data['falseNum'] = (int)$this->M_log->countFalseLogin();

		$this->load->view('login', $data);
	}

	public function onLogin()
	{
		$param = $this->getFromData();

		//检测验证码
		$falseNum = (int)$this->M_log->countFalseLogin();
		if ($falseNum > 3) {
			//检测图片验证码
			$this->load->model('M_code');
			$this->M_code->checkPicCaptcha($param['code']);
		}

		//调用登录
		$uid = $this->M_user->onLogin($param);
		if (!$uid) {
			$errLog = array(
				'log_type'	=> 'falseLogin',
				'log_param' => json_encode($param),
				'log_time'	=> TIMESTAMP,
				'log_ip'	=> CLIENTIP
			);
			$this->M_log->add($errLog);
			echojsondata('err', false, '登录失败');
		}

		//登录成功,写入cookie
		$user = $this->M_user->get(array('uid'=>$uid));
		setloginstatus($user, 2592000);

        //记录成功日志
        $okLog = array(
            'uid'   => $uid,
            'log_type'	=> 'tureLogin',
            'log_param' => json_encode($param),
            'log_time'	=> TIMESTAMP,
            'log_ip'	=> CLIENTIP
        );
        $this->M_log->add($okLog);
        echojsondata('ok', $user);
	}

	//参数过滤
	private function getFromData(){
		$param = array();

		$param['name'] = $this->input->post('name', TRUE);
		$param['password'] = $this->input->post('password', TRUE);
		$param['referer']  = $this->input->post('referer', TRUE);
		$param['code']     = $this->input->post('code', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '用户名', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', '密码', 'trim|required|xss_clean');

		if (isset($param['cookietime'])) {
			$this->form_validation->set_rules('cookietime', '自动登录', 'trim|required|xss_clean');
		}

		if (isset($param['referer'])){
			$this->form_validation->set_rules('referer', '来源url', 'trim|required|xss_clean');
		}


		if ($this->form_validation->run() == FALSE){

			if (!$param['username']) {
				$msg   = '用户名有误！';
			} else {
				$msg   = '提交参数错误！';
			}
			echojsondata('err', false, $msg);

		}

		return $param;
	}
}
