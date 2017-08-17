<?
	if ($intNo && !$strGubun) {	
		$row = $db->getSelect("SELECT * FROM ".TBL_COMM_FILE." WHERE F_NO=".$intNo);

		$file = "../".iconv("UTF-8","EUC-KR",$row[F_FILE_PATH]);
		$dnfile =  iconv("UTF-8","EUC-KR",$row[F_ORG_NAME]); 
	}else if($_REQUEST['b_code'] && $_REQUEST['fl_no']) {
		$row		= $db->getSelect("SELECT * FROM BOARD_FL_{$_REQUEST['b_code']} WHERE FL_NO={$_REQUEST['fl_no']}");	
		$file		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}" . $row[FL_DIR] . $row[FL_NAME];
		$temp		= explode("_", $row[FL_NAME]);
		$temp_size	= sizeof($temp);
		for($i=2;$i<$temp_size;$i++):
			$dnfile .= $temp[$i];	
		endfor;
	//	$file		=  iconv("UTF-8","EUC-KR",$file); 
		$dnfile		=  iconv("UTF-8","EUC-KR",$dnfile); 

	}else if (!$intNo && $strGubun == "member_kor_insert"){
//		$file = "./".iconv("UTF-8","EUC-KR","member/member_kor_insert.xls");
//		$dnfile =  iconv("UTF-8","EUC-KR","member_kor_insert.xls"); 
		$file	= "{$S_DOCUMENT_ROOT}www/web/shopAdmin/member/member_kor_insert.xls";
		$file	=  iconv("UTF-8","EUC-KR",$file); 
		$dnfile =  iconv("UTF-8","EUC-KR","member_kor_insert.xls"); 
	}else if (!$intNo && $strGubun == "sms_kor_insert"){
		$file	= "{$S_DOCUMENT_ROOT}www/web/shopAdmin/sendsms/smsExcelSample.xls";
		$file	=  iconv("UTF-8","EUC-KR",$file); 
		$dnfile =  iconv("UTF-8","EUC-KR","smsExcelSample.xls"); 
	}else if (!$intNo && $strGubun == "mail_kor_insert"){
		$file	= "{$S_DOCUMENT_ROOT}www/web/shopAdmin/sendmail/mailExcelSample.xls";
		$file	=  iconv("UTF-8","EUC-KR",$file); 
		$dnfile =  iconv("UTF-8","EUC-KR","mailExcelSample.xls"); 
	}else if (!$intNo && $strGubun == "member_point_sample"){
		$file	= "{$S_DOCUMENT_ROOT}www/web/shopAdmin/member/point.xls";
		$file	=  iconv("UTF-8","EUC-KR",$file); 
		$dnfile =  iconv("UTF-8","EUC-KR","point.xls"); 
	}


	if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
	{ 
	  if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) 
	  { 
		header("Content-Type: doesn/matter"); 
		header("Content-disposition: filename=$dnfile"); 
		header("Content-Transfer-Encoding: binary"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	  } 

	  if(strstr($HTTP_USER_AGENT, "MSIE 5.0")) 
	  { 
		Header("Content-type: file/unknown"); 
		header("Content-Disposition: attachment; filename=$dnfile"); 
		Header("Content-Description: PHP3 Generated Data"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	  } 

	  if(strstr($HTTP_USER_AGENT, "MSIE 5.1")) 
	  { 
		Header("Content-type: file/unknown"); 
		header("Content-Disposition: attachment; filename=$dnfile"); 
		Header("Content-Description: PHP3 Generated Data"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	  } 
	  
	  if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
	  {
		Header("Content-type: application/x-msdownload"); 
		Header("Content-Length: ".(string)(filesize("$file")));
		Header("Content-Disposition: attachment; filename=$dnfile");   
		Header("Content-Transfer-Encoding: binary");   
		Header("Pragma: no-cache");   
		Header("Expires: 0");   
	  }
	} else { 
	  Header("Content-type: file/unknown");     
	  Header("Content-Length: ".(string)(filesize("$file"))); 
	  Header("Content-Disposition: attachment; filename=$dnfile"); 
	  Header("Content-Description: PHP3 Generated Data"); 
	  Header("Pragma: no-cache"); 
	  Header("Expires: 0"); 
	} 

	if (is_file("$file")) { 
	  $fp = fopen("$file", "rb"); 

	if (!fpassthru($fp))  
		fclose($fp); 

	} else { 
	  echo $LNG_TRANS_CHAR["CS00012"]; //"해당 파일이나 경로가 존재하지 않습니다."; 
	} 


?>
 
 
 