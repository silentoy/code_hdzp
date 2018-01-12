<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH.'core/D_Common.php';

class MY_Controller extends D_Common {

	public function __construct() {
	    
		parent::__construct();

		//关闭enable_query_strings
		$this->config->set_item('enable_query_strings', FALSE);
		
		//检测到了哪个控制器
// 		var_dump($this->router->fetch_directory());
// 		var_dump($this->router->fetch_class());
// 		var_dump($this->router->fetch_method());

	}

}

