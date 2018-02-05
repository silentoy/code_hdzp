<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weixin extends MY_Controller {

	private $appid;
	private $appsecret;

	public function __construct()
	{
		parent::__construct();

		$this->appid = 'wx77e44e2baa8205ce';
		$this->appsecret = '7ee7b6e3cb9e2948c3450b2193845087';
	}

	public function index()
	{

	}

	public function getSessionKey() {
		$code = $this->input->get('code', TRUE);
		if (!$code) {
			echojsondata('err', false, '信息不完整');
		}

		$apiUrl = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
		$response = curlpage(sprintf($apiUrl, $this->appid, $this->appsecret, $code));
		$aResponse = json_decode($response, true); // 正常为{"openid": "OPENID","session_key": "SESSIONKEY""expires_in": 2592000}

		echojsondata('ok', $aResponse);
	}
}
