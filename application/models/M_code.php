<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_code extends MY_Model {

    private $_codeTimeOut   = 900;      //验证码超时时间15min
    
    
	function __construct()
	{
		parent::__construct();
	}
	
    //获取验证码
	public function getCode()
	{
	    $refererhost = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : array('host' => '');
	    $refererhost['host'] .= isset($refererhost['port']) ? (':'.$refererhost['port']) : '';

	    if($refererhost['host'] != $_SERVER['HTTP_HOST']) {
			//@todo 安全限制
	        //exit('Access Denied');
	    }
	    
	    $code  = rand(1000, 9999);
	    
	    #将验证码字符串保存到数据库中
	    $data = array(
	        'captcha_time' => TIMESTAMP,
	        'ip_address'   => CLIENTIP,
	        'word'         => $code,
	        'unid'         => gUnid()
	    );

	    $query = $this->db->insert_string('hdzp_captcha', $data);
	    $this->db->query($query);
	    
	    #调用函数生成验证码
	    $vals = array(
	        'word'         => $code, 
	        'img_width'    => '64', 
	        'img_height'   => '40', 
	    );

		
	    $this->load->helper('captcha');
	    create_captcha($vals);
	}
	
	//检测验证码
	public function checkCode($code)
	{
		if (!$code) {
			echojsondata('err', false, '没有code' . $code);
	        return 0;      //失败
	    }

	    $codeInfo  = $this->db->order_by('captcha_time', 'DESC')->get_where('hdzp_captcha', array('unid' => gUnid()), 1)->row_array();

	     if (!$codeInfo) {
	        return 0;      //失败
	    }
	    
	    if (TIMESTAMP - $codeInfo['captcha_time'] > $this->_codeTimeOut) {
	        return -1;     //超时
	    }

	    if ($code == $codeInfo['word']) {
	        return 1;      //成功
	    }
	    return -2;         //失败
	}

	//检验图形验证码,输出json形式
	public function checkPicCaptcha($picCaptcha)
	{
		$res   = $this->checkCode($picCaptcha);

		if ($res > 0) {
			return true;
		} else {
			echojsondata('err', 'code', '图片文字填写错误或已过期');
		}
	}
}