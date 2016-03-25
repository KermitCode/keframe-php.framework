<?php

/*************************
 *Note:		:全局发邮件类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

keframe:仅为自己方便而写,不做为对外应用.
格言：适合自己的就是最好的！我只为自己代言。
************************/

define('SMTP_STATUS_NOT_CONNECTED', 1, TRUE);
define('SMTP_STATUS_CONNECTED', 2, TRUE);

/*控制器中调用示例
 *$this->KE('SendMail')->initMail('smtp.126.com',25,true,'lylboy@126.com','password');
 *$rs=$this->KE('SendMail')->->send('收件人邮箱','邮件标题','内容','邮件里标记的发件人名称','是否是HTML邮件，1或0');
 */
 
class sendMail{
	var $debug;
	var $host;
	var $port;
	var $auth;
	var $user;
	var $pass;

	public function initMail($host = "", $port = 25,$auth = false,$user,$pass){
		$this->host=$host;
		$this->port=$port;
		$this->auth=$auth;
		$this->user=$user;
		$this->pass=$pass;
	}

	public function send($to,$subject,$content,$fromname='',$type=0){
		$email=array($to);
		$_CFG['smtp_host']= $this->host;
		$_CFG['smtp_port']= $this->port;
		$_CFG['smtp_user']= $this->user;
		$_CFG['smtp_pass']= $this->pass;
		$_CFG['name']= $fromname;
		$_CFG['smtp_mail']= $this->user;
		$subject ="=?UTF-8?B?".base64_encode($subject)."==?=";
		$content = base64_encode($content);
		$headers[] = "To:=?UTF-8?B?".''."?= <$email[0]>";
		$headers[] = "From:=?UTF-8?B?".base64_encode($_CFG['name'])."?= <$_CFG[smtp_mail]>";
		$headers[] = "MIME-Version: Blueidea v1.0";
		$headers[] = "X-Mailer: 9gongyu Mailer v1.0";
		$headers[] = "Subject:$subject";
		$headers[] = ($type == 0) ? "Content-Type: text/plain; charset=gbk; format=flowed" : "Content-Type: text/html; charset=UTF-8; format=flowed";
		$headers[] = "Content-Transfer-Encoding: base64";
		$headers[] = "Content-Disposition: inline";
		$params['host'] = $_CFG['smtp_host'];
		$params['port'] = $_CFG['smtp_port'];
		$params['user'] = $_CFG['smtp_user'];
		$params['pass'] = $_CFG['smtp_pass'];
		if (empty($params['host']) || empty($params['port'])){
			return false;
		}else{
			$send_params['recipients']    = $email;
			$send_params['headers']        = $headers;
			$send_params['from']        = $_CFG['smtp_mail'];
			$send_params['body']        = $content;
			$smtp = new qb_smtp($params);
			if($smtp->connect() AND $smtp->send($send_params)){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
}

class qb_smtp{
	
    var $connection;
    var $recipients;
    var $headers;
    var $timeout;
    var $errors;
    var $status;
    var $body;
    var $from;
    var $host;
    var $port;
    var $helo;
    var $auth;
    var $user;
    var $pass;
    
    /*
     *  参数为一个数组
     *  host        SMTP 服务器的主机       默认：localhost
     *  port        SMTP 服务器的端口       默认：25
     *  helo        发送HELO命令的名称      默认：localhost
     *  user        SMTP 服务器的用户名     默认：空值
     *  pass        SMTP 服务器的登陆密码   默认：空值
     *  timeout     连接超时的时间          默认：5
     *  @return  bool
     */
    
    function qb_smtp($params = array()){
        if(!defined('CRLF')) define('CRLF', "\r\n", TRUE);
        $this->timeout  = 5;
        $this->status   = SMTP_STATUS_NOT_CONNECTED;
        $this->host     = 'localhost';
        $this->port     = 25;
        $this->auth     = FALSE;
        $this->user     = '';
        $this->pass     = '';
        $this->errors   = array();
        foreach($params as $key => $value){
            $this->$key = $value;
        }
        $this->helo = $this->host;      
        $this->auth = ('' == $this->user) ? FALSE : TRUE;
    }
	
    function connect($params = array()){
        if(!isset($this->status)){
            $obj = new qb_smtp($params);
            if($obj->connect()){
                $obj->status = SMTP_STATUS_CONNECTED;
            }
            return $obj;
        }else{
            $this->connection = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
            socket_set_timeout($this->connection, 0, 250000);
            $greeting = $this->get_data();
            if(is_resource($this->connection)){
                $this->status = 2;
                return $this->auth ? $this->ehlo() : $this->helo();
            }else{
                $this->errors[] = 'Failed to connect to server: '.$errstr;
                return FALSE;
            }
        }
    }
    
    /**
     * 参数为数组
     * recipients      接收人的数组
     * from            发件人的地址，也将作为回复地址
     * headers         头部信息的数组
     * body            邮件的主体
     */
    
    function send($params = array()){
        foreach($params as $key => $value){
            $this->set($key, $value);
        }
        if($this->is_connected()){
            //  服务器是否需要验证     
            if($this->auth){
                if(!$this->auth()) return FALSE;
            }
            $this->mail($this->from);
            if(is_array($this->recipients)){
                foreach($this->recipients as $value)
                {
                    $this->rcpt($value);
                }
            }else{
                $this->rcpt($this->recipients);
            }
            if(!$this->data()) return FALSE;
            $headers = str_replace(CRLF.'.', CRLF.'..', trim(implode(CRLF, $this->headers)));
            $body    = str_replace(CRLF.'.', CRLF.'..', $this->body);
            $body    = $body[0] == '.' ? '.'.$body : $body;
            $this->send_data($headers);
            $this->send_data('');
            $this->send_data($body);
            $this->send_data('.');
            return (substr(trim($this->get_data()), 0, 3) === '250');
        }else{
            $this->errors[] = 'Not connected!';
            return FALSE;
        }
    }
    
    function helo(){
        if(is_resource($this->connection)
                AND $this->send_data('HELO '.$this->helo)
                AND substr(trim($error = $this->get_data()), 0, 3) === '250' )
        {
            return TRUE;
        }else{
            $this->errors[] = 'HELO command failed, output: ' . trim(substr(trim($error),3));
            return FALSE;
        }
    }

    function ehlo(){
        if(is_resource($this->connection)
                AND $this->send_data('EHLO '.$this->helo)
                AND substr(trim($error = $this->get_data()), 0, 3) === '250' )
        {
            return TRUE;
        }else{
            $this->errors[] = 'EHLO command failed, output: ' . trim(substr(trim($error),3));
            return FALSE;
        }
    }
    
    function auth(){
        if(is_resource($this->connection)
                AND $this->send_data('AUTH LOGIN')
                AND substr(trim($error = $this->get_data()), 0, 3) === '334'
                AND $this->send_data(base64_encode($this->user))            // Send username
                AND substr(trim($error = $this->get_data()),0,3) === '334'
                AND $this->send_data(base64_encode($this->pass))            // Send password
                AND substr(trim($error = $this->get_data()),0,3) === '235' )
        {
            return TRUE;
        }else{
            $this->errors[] = 'AUTH command failed: ' . trim(substr(trim($error),3));
            return FALSE;
        }
    }
	
    function mail($from){
        if($this->is_connected()
            AND $this->send_data('MAIL FROM:<'.$from.'>')
            AND substr(trim($this->get_data()), 0, 2) === '250' )
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
    function rcpt($to){
        if($this->is_connected()
            AND $this->send_data('RCPT TO:<'.$to.'>')
            AND substr(trim($error = $this->get_data()), 0, 2) === '25' )
        {
            return TRUE;
        }
        else
        {
            $this->errors[] = trim(substr(trim($error), 3));
            return FALSE;
        }
    }
	
    function data(){
        if($this->is_connected()
            AND $this->send_data('DATA')
            AND substr(trim($error = $this->get_data()), 0, 3) === '354' )
        { 
            return TRUE;
        }
        else
        {
            $this->errors[] = trim(substr(trim($error), 3));
            return FALSE;
        }
    }
	
    function is_connected(){
        return (is_resource($this->connection) AND ($this->status === SMTP_STATUS_CONNECTED));
    }
	
    function send_data($data){
        if(is_resource($this->connection))
        {
            return fwrite($this->connection, $data.CRLF, strlen($data)+2);
        }
        else
        {
            return FALSE;
        }
    }
	
    function &get_data(){
        $return = '';
        $line   = '';
        if(is_resource($this->connection))
        {
            while(strpos($return, CRLF) === FALSE OR substr($line,3,1) !== ' ')
            {
                $line    = fgets($this->connection, 512);
                $return .= $line;
            }
            return $return;
        }
        else
        {
            return FALSE;
        }
    }
	
    function set($var, $value){
        $this->$var = $value;
        return TRUE;
    }
	
}
?>