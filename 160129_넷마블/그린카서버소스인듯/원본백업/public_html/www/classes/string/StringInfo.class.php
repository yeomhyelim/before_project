<?php
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-01-03												|# 
#|작성내용	: 문자열  클레스											|# 
#/*====================================================================*/# 

class StringInfo {

	function initConfig() {
		
	}

	function __construct() {

	}

	// StringInfo::isEmailCheck($str)
	static function isEmailCheck($str) {
		
		return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $str);

	}

	// StringInfo::isPhoneCheck($str)
	static function isPhoneCheck($str) {
		
		return preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $string);
	}

}