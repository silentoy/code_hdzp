<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class D_Common extends CI_Controller {

	public $post; // 校验器与过滤器调用
	public $data; // 校验器与过滤器返回的值

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('cookie');
		$this->load->helper('global');
		$this->load->helper('user');
		$this->load->model('M_log');

		$this->_init_variable();		//初始化网站全局变量
	}


	/**
	 * 初始化网站全局变量
	 */
	private function _init_variable() 
	{

		define('IS_AJAX', $this->input->is_ajax_request());
		define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST' && count($_POST) ? TRUE : FALSE);
		define('SYS_TIME', $_SERVER['REQUEST_TIME'] ? $_SERVER['REQUEST_TIME'] : TIMESTAMP);
		define('SYS_KEY', 'hdzp');
		define('SITE_PATH', '/');
		define('CLIENTIP', $this->input->ip_address());
		define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);

		$this->load->model('M_user');
		$this->user = $this->M_user->user();    //获取当前登陆信息
		if ($this->user) {
			define('GLOBAL_USER', $this->user);
		} else {
			define('GLOBAL_USER', array());
		}

		//设置当前uri
		$this->redirection = urlencode($this->uri->uri_string());
		
	}

}

