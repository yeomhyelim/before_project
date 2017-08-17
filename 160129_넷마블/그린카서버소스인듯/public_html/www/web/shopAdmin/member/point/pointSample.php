<?
	$file = MALL_HOME."/web/shopAdmin/member/point.xls";
	$dnfile = "point.xls"; 

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
 
 
 