<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//获取backurl
function greferer($default = ''){

    //cookie中有没有
    $referer    = urldecode(get_cookie('referer'));
    if ($referer) {
        return $referer;
    }
    
    $referer    = !empty($_REQUEST['referer']) ? urldecode($_REQUEST['referer']) : (isset($_SERVER['HTTP_REFERER']) ? urldecode($_SERVER['HTTP_REFERER']) : '');
    $referer    = substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;         //去掉最后一个字符？
    
    $posstart	= strpos($referer, 'referer=');
    if ($posstart){
        $subreferer	= substr($referer, $posstart + 8);
        $referer	= $subreferer ? $subreferer : $referer;
    }
    
    //登录来源直接
    if (strpos($referer, BASEURL) !== false && $default) {
        $referer    = $default;
    }
    
    $reurl = parse_url($referer);
    if (!$reurl || (isset($reurl['scheme']) && !in_array(strtolower($reurl['scheme']), array('http', 'https')))) {
        $referer    = '';
    }
    
    if (!$referer) {
        $referer = WEBURL;
    }
    
    $cook_pre     = config_item('cookie_prefix');
    $cook_domain  = config_item('cookie_domain');
    $cook_path    = config_item('cookie_path');
    set_cookie('referer', urlencode($referer), 600, $cook_domain, $cook_path, $cook_pre, false, true);
    
    return $referer;
}


//清除backurl
function dreferer($default = ''){
    
    $referer    = greferer($default);
    
    $cook_pre     = config_item('cookie_prefix');
    $cook_domain  = config_item('cookie_domain');
    $cook_path    = config_item('cookie_path');
    
    set_cookie('referer', '', -1, $cook_domain, $cook_path, $cook_pre);

    return $referer;
}

//返回json后数据（ajax通用）
function echojsondata($status = 'ok', $info	= false, $msg = '处理成功', $ext = array(), $die = true){
    $data	= array(
        'status'	=> $status,
        'info'		=> $info,
        'msg'		=> $msg
    );
    if ($ext) {
        $data	= array_merge($data, $ext);
    }

    $jsonStr	= json_encode($data);

    //是否jsonp
    $callback   = !empty($_REQUEST['jsonp']) ? @htmlspecialchars($_REQUEST['jsonp']) : '';
    $callback   = !$callback ? (!empty($_REQUEST['callback']) ? @htmlspecialchars($_REQUEST['callback']) : '') : $callback;
    
    echo $callback
    ? sprintf('%s(%s)', $callback, $jsonStr)
    : $jsonStr;

    $die && die;
}

//成功返回json数据（ajax通用）
function outJsonSuccess($info	= false, $msg = '处理成功', $ext = array(), $die = true){
    $data	= array(
        'status'	=> 0,
        'data'		=> $info,
        'msg'		=> $msg
    );
    if ($ext) {
        $data	= array_merge($data, $ext);
    }

    $jsonStr	= json_encode(diconv($data, 'gbk', 'utf-8'));

    //是否jsonp
    $callback   = !empty($_REQUEST['jsonp']) ? @htmlspecialchars($_REQUEST['jsonp']) : '';
    $callback   = !$callback ? (!empty($_REQUEST['callback']) ? @htmlspecialchars($_REQUEST['callback']) : '') : $callback;

    echo $callback
        ? sprintf('%s(%s)', $callback, $jsonStr)
        : $jsonStr;

    $die && die;
}

//失败返回json数据（ajax通用）
function outJsonError( $info	= false, $msg = '处理失败', $ext = array(), $die = true){
    $data	= array(
        'status'	=> 1,
        'data'		=> $info,
        'msg'		=> $msg
    );
    if ($ext) {
        $data	= array_merge($data, $ext);
    }

    $jsonStr	= json_encode(diconv($data, 'gbk', 'utf-8'));

    //是否jsonp
    $callback   = !empty($_REQUEST['jsonp']) ? @htmlspecialchars($_REQUEST['jsonp']) : '';
    $callback   = !$callback ? (!empty($_REQUEST['callback']) ? @htmlspecialchars($_REQUEST['callback']) : '') : $callback;

    echo $callback
        ? sprintf('%s(%s)', $callback, $jsonStr)
        : $jsonStr;

    $die && die;
}


//验证手机号
function checkphonenum($phone){
    if (!$phone) {
        return false;
    }
    return preg_match("/^1(([38]\d)|(4[57])|(5[012356789])|(6[6])|(9[89])|(7\d))\d{8}$/", $phone);
}




function daddslashes($string, $force = 0)
{
    if(!get_magic_quotes_gpc() || $force) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}


//header跳转
function dheader($string, $replace = true, $http_response_code = 0) {
    $islocation = substr(strtolower(trim($string)), 0, 8) == 'location';
    $string     = str_replace(array("\r", "\n"), array('', ''), $string);
    if(empty($http_response_code) || PHP_VERSION < '4.3' ) {
        @header($string, $replace);
    } else {
        @header($string, $replace, $http_response_code);
    }
    if($islocation) {
        exit();
    }
}

function checkPswJsonData($pws,$username){
    if (!$pws || !$username) {
        return false;
    }
    $rst = checkPwdByRules($pws,$username);
    if ($rst) {
        echojsondata('err', 'psw', $rst);
    }
}

//验证密码规则
function checkPwdByRules($password, $username){
    if (32 == strlen($password)) {
        return false;
    }
    $re 		= '/^[\x21-\x7e]+$/';
    $renum		= '/^\d+$/';			//判断字符串是否为数字
    $restr 		= '/^[A-Za-z]+$/';
    $weakpwd	= array('123456','a12345','a123456','a123123','a88888','zm1234','abc1234567','q123123','ccc666','qweqwe123','a518518','a159159','123abc','www16888','abc123','123456abc','321abc','123qwe','asd123','qwe123','a000000','a1b2c3','aaa111');

    if (preg_match($renum, $password)){
        return '密码要求不得是纯数字';
    }
    if (preg_match($restr, $password)){
        return '密码要求不得是纯字母';
    }

    if (in_array($password, $weakpwd)) {
        return '您的密码设置的安全系数太低,禁止使用';
    }

    $strlen	= strlen($password);
    $sequal	= true;
    for ($i = 0; $i < $strlen; $i ++) {
        if ($password[$i] != $password[$strlen - 1]) {
            $sequal	= false;
            break;
        }
    }
    if ($sequal) {
        return '密码要求不得是一个字符重复';
    }

    if (isset($username)) {
        if($password == $username){
            return '用户名不能与密码相同';
        }

        if(stripos($username, $password) !== false){
            return '用户名不能包含密码';
        }
    }

    if (!preg_match($re, $password)){
        return '密码不符合规则';
    }
    return false;
}

/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @return String
 */
function encodeStrings($string = '', $skey = 'code') {
    $strArr     = str_split(base64_encode($string));
    $strCount   = count($strArr);
    foreach (str_split($skey) as $key => $value) {
        $key < $strCount && $strArr[$key].=$value;
    }
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}

/**
 * 简单对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param String $skey 解密KEY
 * @return String
 */
function decodeStrings($string = '', $skey = 'code') {
    $strArr     = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount   = count($strArr);
    foreach (str_split($skey) as $key => $value){
        $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    }
    return base64_decode(join('', $strArr));
}

/**
 * 检测是否存在繁体中文
 * @param $str
 */
function checkTraditional($str, $charset='gbk') {
    if (!$str) {
        return false;
    }

    if (strtolower($charset) != 'gbk') {
        $str = diconv($str, $charset, 'gbk');
    }

    //判断gbk编码
    if (json_encode($str) != false) {
        $str = diconv($str, 'utf-8', 'gbk');
    }

    if (strlen($str) !== strlen(diconv($str, 'gbk', 'gb2312'))) {
        return true;
    } else {
        return false;
    }
}

/**
 * 生成随机密码
 * @param int $pw_length
 * @return string
 */
function createPassword($pw_length = 8){
    $randpwd = '';
    for ($i = 0; $i < $pw_length; $i++) {
        $randpwd .= chr(mt_rand(65, 90));
    }
    return $randpwd;
}

function getLocation($address='') {
    $location = array('lat'=>'', 'lng'=>'');

    $url = "http://api.map.baidu.com/geocoder/v2/?address=".urlencode($address)."&output=json&ak=1LRmckBNyViwdlC9g9AihaSbH7aWbviY";
    $res = curlpage($url, '', 2, false);
    $res = json_decode($res, true);
    if ($res['status']==0 && isset($res['result']['location'])) {
        $location = $res['result']['location'];
    }

    return $location;
}

function positionStatus($status=0) {
    if ($status==3) {
        return '精选';
    } else if ($status==2) {
        return '<span class="online">已上线</span>';
    } else if($status==1) {
        return '已下线';
    } else {
        return '待审核';
    }
}

function pregKeyword($content, $keyword)
{
    $toReplce = '<i class="pitch_on">'.$keyword.'</i>';
    return str_replace($keyword, $toReplce, $content);
}

function curlpage($url, $postdata = '', $timeout = 2, $post = true, $header = array()){
    $timeout = (int)$timeout;

    if(!$timeout || empty($url))return false;

    $ch = curl_init();
    if (!$post && $postdata) {
        rtrim($url, '?');
        $mark	= strrpos($url, '?') ? '&' : '?';
        $url .= $mark . http_build_query($postdata);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, false);

    if ($post) {
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_AUTOREFERER, true);
        if ($header) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt ($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $data = curl_exec($ch);
    curl_close($ch);
    if (isset($_REQUEST['geturl'])) {
        var_dump($url);
    }
    if (isset($_REQUEST['geturldata'])) {
        var_dump($data);
    }
    return $data;
}
