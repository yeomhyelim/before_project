<?php
// autoload
require 'PHPMailerAutoload.php' ;

class EmailInfo extends PHPMailer {



	function __construct () {
		parent::__construct () ;
	}

	function goSendEmail ( $param ) {

		## 기본 설정

		$this->isMail();                                      // Set mailer to use php's mail
//		$this->From			= $param['SEND_EMAIL'] ;
//		$this->FromName		= $param['SEND_NAME'] ;
		//메일 From 설정 방법 변경. 남덕희
		$this->setFrom($param['SEND_EMAIL'], $param['SEND_NAME']);
		$this->addReplyTo ( $param['SEND_EMAIL'] , $param['SEND_NAME'] ) ;
		$this->addAddress ( $param['RECEIVE_EMAIL'] , $param['RECEIVE_NAME'] ) ;
		$this->Subject		= $param['TITLE'] ;
		$this->Body			= $param['TEXT'] ;
		$this->AltBody		= $param['TEXT'] ;

		if ( ! $this->send () )
			return false;
		else
			return true ;
	}
}