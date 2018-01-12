<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//用户登录验证串加密解密
function dauthcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{

    $ckey_length   = 4;
    $authkey       = md5(config_item('authkey') . $_SERVER['HTTP_USER_AGENT']);
     
    $key   = md5($key != '' ? $key : $authkey);
    $keya  = md5(substr($key, 0, 16));
    $keyb  = md5(substr($key, 16, 16));
    $keyc  = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
     
    $cryptkey      = $keya.md5($keya.$keyc);
    $key_length    = strlen($cryptkey);
     
    $string        = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
     
    $result    = '';
    $box       = range(0, 255);
    $rndkey    = array();
     
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
     
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}


//清除登录cookie
function delcookie()
{
    $cook_pre     = config_item('cookie_prefix');
    $cook_domain  = config_item('cookie_domain');
    $cook_path    = config_item('cookie_path');

    $cookList = array('auth', 'userid', 'ajaxuid', 'avatar', 'nickname');

    foreach($cookList as $val) {
        delete_cookie($val, $cook_domain, $cook_path, $cook_pre);
    }
}

//设置登录用户cookie
function setloginstatus($member, $cookietime) {

    $uid        = (int)$member['uid'];
    $username   = $member['name'];
    $password   = $member['password'];
//    var_dump($cookietime,$uid,$username,$nickname,$password,$avatar);die;
    $cook_pre     = config_item('cookie_prefix');
    $cook_domain  = config_item('cookie_domain');
    $cook_path    = config_item('cookie_path');

    set_cookie('auth', dauthcode("{$password}\t{$uid}", 'ENCODE'), $cookietime, $cook_domain, $cook_path, $cook_pre, false, true);
    set_cookie('username', $username, $cookietime, $cook_domain, $cook_path, $cook_pre);
    set_cookie('uid', $uid, $cookietime, $cook_domain, $cook_path, $cook_pre);
}

//获取用户唯一字符
function gUnid($uid = false){
    $captchaUnid = get_cookie(config_item('cookie_prefix') . 'captcha');
    if (!$captchaUnid) {
        $captchaUnid = md5($_SERVER['HTTP_USER_AGENT'] . CLIENTIP . $uid);
        set_cookie('captcha', $captchaUnid, 900, config_item('cookie_domain'), config_item('cookie_path'), config_item('cookie_prefix'));
    }
    return $captchaUnid;
}





