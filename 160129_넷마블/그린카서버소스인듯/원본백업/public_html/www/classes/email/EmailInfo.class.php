<?php
#/*====================================================================*/#
#|화일명	: 															|#
#|작성자	: kim hee sung												|#
#|작성일	: 2013-11-29												|#
#|작성내용	: email 전송 클레스											|#
#/*====================================================================*/#

class EmailInfo {

	function initConfig() {

	}

	function __construct() {

	}

	function goSendEmail($param) {

		## 기본 설정
		$sendName				= str_replace( ' ' , '' , $param['SEND_NAME'] );
		$sendEmail				= $param['SEND_EMAIL'];
		$receiveName			= $param['RECEIVE_NAME'];
		$receiveEmail			= $param['RECEIVE_EMAIL'];
		$subject				= $param['TITLE'];
		$message				= $param['TEXT'];
		$charset				= "UTF-8";
		$headers				= "Content-Type: text/html;charset={$charset}\n";

		## 한글 깨짐 추가 코드
		$subject				= base64_encode($subject);
		$subject				= "=?{$charset}?B?{$subject}?=\n";
		$sendName				= base64_encode($sendName);
		$sendName				= "=?{$charset}?B?{$sendName}?=\n";
		$receiveName			= base64_encode($receiveName);
		$receiveName			= "=?{$charset}?B?{$receiveName}?=\n";

		## 메일 정보 만들기
		$from					= "From: {$sendName} <{$sendEmail}>\n";
		$to						= "{$receiveName} <{$receiveEmail}>";
		$headers				= "{$headers}{$from}";

		/**
		 * @param $to 받는사람
		 * @param $headers 보내는 사람 및 기타 정보
		 * @param $subject 제목
		 * @param $message 내용
		 */
		return mail($to, $subject, $message, $headers);
	}
}