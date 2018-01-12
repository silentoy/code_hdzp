<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_user extends MY_Model {

	function __construct($table='')
	{
		parent::__construct();

		$this->table = 'hdzp_users';
	}
	
    //添加用户记录
	public function add($data)
	{
		extract($data);

		if (!$name || !$password || !$groupid) {
			return false;
		}

		$salt     = substr(uniqid(rand()), -6);

		$password = strlen($password) == 32 ? $password : md5($password) ;
		$password = md5($password.$salt);

		$data = array(
			'name'		=> $name,
			'password'	=> $password,
			'salt'		=> $salt,
			'regdate'	=> TIMESTAMP,
			'regip'		=> CLIENTIP,
			'lastdate'	=> TIMESTAMP,
			'lastip'	=> CLIENTIP,
			'groupid'	=> $groupid,
			'status'	=> 1
		);
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}


	//获取当前登陆用户信息
	public function user()
	{
		//获取cookie信息
		$hdzp_uid    = $this->input->cookie('hdzp_ajaxuid', TRUE);        //用户uid
		$hdzp_auth   = $this->input->cookie('hdzp_auth', TRUE);           //加密串
		$hdzp_userid = $this->input->cookie('hdzp_userid', TRUE);         //用户名


		// 手动模拟提交cookie的时候，+号会自动变为空格导致解码失败。
		$hdzp_auth   = str_replace(' ', '+', $hdzp_auth);
		$auth         = daddslashes(explode("\t", dauthcode($hdzp_auth, 'DECODE')), 1);
		$userinfo     = array();
		$data         = array('uid' => 0, 'username' => '', 'groupid' => 0, 'regdate' => 0, 'sjyz' => '', 'nickname' => '');

		list($pw, $userid) = empty($auth) || count($auth) < 2 ? array('', '') : $auth;

		$this->load->model('M_user');

		if($userid) {
			$userinfo = $this->M_user->get(array('uid' => $userid));
		}

		if (isset($userinfo['uid']) && $hdzp_uid == $userinfo['uid']) {
			//已登录
			foreach ($data as $key=>$val) {
				$data[$key]   = isset($userinfo[$key]) ? $userinfo[$key] : $val;
			}

		} else {
			//未登录
			delcookie();
		}

		return $data;
	}

	//登录
	public function onLogin($data) {

		//uc表user信息
		$userInfo      = $this->get(array('user'=>$data['user']));
		$passwordmd5   = strlen($data['password']) == 32 ? $data['password'] : md5($data['password']);

		if (!$userInfo) {
			return 0;
		} elseif ($userInfo['password'] != md5($passwordmd5.$userInfo['salt'])) {
			return $this->_pwdErr;
		} else {
			return $userInfo['uid'];
		}
	}

	//更新用户状态


}