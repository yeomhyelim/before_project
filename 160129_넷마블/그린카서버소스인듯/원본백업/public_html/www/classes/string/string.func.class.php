<?php
    /**
     * /home/shop_eng/www/classes/string/string.func.class.php
     * @author eumshop(thav@naver.com)
     * string func class
     * **/

	class StringFunc {

		function __construct() {
			
		}

		function getMessage() {
			echo "string func class";
		}
		
		/**
		 * getCode($len)
		 * 랜덤 문자열 유일키 발생한 후 길이에 따라 자르기
		 **/
		function getCode($len, $op="OP_STRING") {
			
			if($op == "OP_INTEGER")		{ $sid	= uniqid(rand()); }
			else						{ $sid	= md5(uniqid(rand())); }

			$code	= substr($sid, 0, $len);
			return $code;
		}

		/**
		 * strConvertCut($content,$len ="0",$html ='N')
		 * 텍스트 내용중 '\'제거
		 * html 사용여부에 따른 표현방법 제어,문자열 URL자동 링크,EMAIL자동링크
		 * len 길이만큼 텍스트 내용 자르기
		 **/
		function strConvertCut($content,$len ="0",$html ='N'){
			if(!strcmp($len,"") || !strcmp($len,"0")) $len ="9000000";
			$content = stripslashes($content);
			if($html == 'N') {
				$content = nl2br(htmlspecialchars($content));
				$content = $this->strAutoLink($content);
			} else {
				$content = $this->strAboidCrack($content);
			}
			return $content = $this->strHanCutUtf2($content,$len);
		}


		/**
		 * strAboidCrack($str)
		 * HTML 중 공격 태그 삭제
		 **/
		function strAboidCrack($str) {

			$str = eregi_replace("<\?","&lt;?",$str);
			$str = eregi_replace("\?>","?&gt;",$str);
			$str = eregi_replace("vbscript","",$str);
			$str = eregi_replace("url(.*)","",$str);
			$str = eregi_replace("codebase=","",$str);
			$str = eregi_replace("while","",$str);
			$str = eregi_replace("{.*}","",$str);
			$str = eregi_replace("<iframe.*>","",$str);
			$str = eregi_replace("<param.*>","",$str);
			$str = eregi_replace("<plaintext.*>","",$str);
			$str = eregi_replace("<xml.*>","",$str);
			$str = eregi_replace("<base.*>","",$str);
			$str = eregi_replace("<applet.*>","",$str);
			$str = eregi_replace("c\|/con/con/","",$str);

			return $str;
		}

		/**
		 * strAutoLink($str)
		 * 문자열 URL자동 링크,EMAIL자동링크
		 **/
		function strAutoLink($str) {
			
			$str=ereg_replace("(http://|ftp://|telnet:)[[:alnum:]-]+(\.[[:alnum:]-]+)+(:[[:digit:]]+)?(/[^\/:*\"<>|&?]+)*(\?[^\/:*\"<>|&?]+(&amp;[^\/:*\"<>|&?]+)*)?", "<A href=\"\\0\" target=\"_blank\">\\0</A>", $str);

			$str=ereg_replace("[[:alnum:]._-]+@[[:alnum:]-]+(\.[[:alnum:]-]+)+", "<A href=\'mailto:\\0\'>\\0</A>", $str);

			return $str;
		}

		/*
			설명 : 문자열 $len 만큼 자르기 (New Style)
			날짜 : 2013.04.11 
		*/
		function strHanCutUtf2($str, $len, $checkmb=false, $tail='...') {
			$strLen = mb_strlen($str, "UTF-8");
			if($strLen > $len):
				$str	= mb_substr($str, 0, $len, "UTF-8");
				$str	=  $str . $tail;
			endif;
			return $str;
		}


	}


?>
