<?
	$tb_counter = "LOG_COUNT_".date("Y");
	$tb_referer = "LOG_REFERER_".date("Y");
	$tb_pgview  = "LOG_PGVIEW_".date("Y");

	$strCountryCode	= $_POST["countryCode"] ? $_POST["countryCode"]	: $_REQUEST["countryCode"];

	function cutQueryStr($str,$gb="")
	{
		$strArr=explode("&",$str);
		$cnt=sizeof($strArr);
		for($x=0;$x<$cnt;$x++)
		{
			$str_=explode("=",$strArr[$x]);

			if ($gb){
				if($str_[0]=="host") {
					$keyword=$str_[1];
					break;
				}
			} else {
				if(($str_[0]=="query")||
					($str_[0]=="q")||
					($str_[0]=="QR")||
					($str_[0]=="p")||
					($str_[0]=="search")||
					($str_[0]=="Keywords") ||
					($str_[0]=="n"))
				{
					$keyword=$str_[1];
				}
			}
		}

		return $keyword;
	}

	function cutQueryReSet($str)
	{
		$strArr=explode("&",$str);
		$cnt=sizeof($strArr);
		for($x=0;$x<$cnt;$x++)
		{
			$str_=explode("=",$strArr[$x]);

			if($str_[0]!= "host"){
				$keyword .= "&".$str_[0]."=".$str_[1];
			}
		}

		return SUBSTR($keyword,1);
	}

	function chkHost($host,$local)
	{
		$cnt=sizeof($local);
		$val=1;

		if ($host == "URL" || $host == ""){
			$val=0;
		} else {
			for($x=0;$x<$cnt;$x++)
			{
				if($local[$x] == $host)$val=0;
			}
		}

		return $val;
	}

	$query = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$db->db."' AND table_name = '".$tb_counter."'";
	$cnt = $db->getCount($query);
	if ($cnt == 0){
		$query  = "CREATE TABLE ".$tb_counter." (         ";
		$query .= "  `NO` int(11) NOT NULL auto_increment, ";
		$query .= "  `CODE` VARCHAR(2) default NULL,       ";
		$query .= "  `Y` smallint(6) default NULL,         ";
		$query .= "  `M` tinyint(4) default NULL,          ";
		$query .= "  `D` tinyint(4) default NULL,          ";
		$query .= "  `H` tinyint(4) default NULL,          ";
		$query .= "  `CNT` int(11) default NULL,           ";
		$query .= "  PRIMARY KEY  (`NO`),                  ";
		$query .= "  KEY `IDX_Y` (`Y`),";
		$query .= "  KEY `IDX_M` (`M`),";
		$query .= "  KEY `IDX_D` (`D`),";
		$query .= "  KEY `IDX_H` (`H`)";
		$query .= ")";

		$db->getExecSql($query);
	}

	$query = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$db->db."' AND table_name = '".$tb_referer."'";
	$cnt = $db->getCount($query);
	if ($cnt == 0){

		$query  = "CREATE TABLE `".$tb_referer."` (        ";
		$query .= "  `NO` int(11) NOT NULL auto_increment,";
		$query .= "  `IP` varchar(64) default NULL,     ";
		$query .= "  `Y` smallint(6) default NULL,         ";
		$query .= "  `M` tinyint(4) default NULL,          ";
		$query .= "  `D` tinyint(4) default NULL,          ";
		$query .= "  `H` tinyint(4) default NULL,          ";
		$query .= "  `SCHEME` varchar(8) default NULL,     ";
		$query .= "  `HOST` varchar(255) default NULL,     ";
		$query .= "  `PATH` varchar(64) default NULL,     ";
		$query .= "  `QUERY` varchar(128) default NULL,     ";
		$query .= "  `KEYWORD` varchar(128) default NULL,     ";
		$query .= "  `DEVICE` varchar(10) default NULL,     ";
		$query .= "  PRIMARY KEY  (`no`),                  ";
		$query .= "  KEY `IDX_Y` (`Y`),";
		$query .= "  KEY `IDX_M` (`M`),";
		$query .= "  KEY `IDX_D` (`D`),";
		$query .= "  KEY `IDX_H` (`H`)";
		$query .= ");                                      ";
		$db->getExecSql($query);
	}

	// 디바이스 체크
	require_once MALL_HOME . "/classes/client/Mobile_Detect.php";
	$detect				= new Mobile_Detect;
	$deviceType			= ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

	// 카운트 하지 않을 REFERER 를 적는다. 2차 호스트, 포워딩 호스트 등...)
	$localhost=array(STR_REPLACE("http://","",$S_SITE_URL));

	$nowY=date("Y");
	$nowM=date("n");
	$nowD=date("j");
	$nowH=date("G");


	// get 방식으로 주소에 입력후 테스트 할 때 만 주석 해지
	// http://ivenet.co.kr/counter.php?countryCode=KR&host=http://search.naver.com/search.nave&where=nexearch&query=%EC%95%84%EC%9D%B4%EB%B0%B0%EB%83%87&sm=top_hty&fbm=1&ie=utf8
	// $_SERVER['HTTP_REFERER'] = "http://ivenet.co.kr/counter.php/?countryCode=KR&host=http://search.naver.com/search.nave&where=nexearch&query=%EC%95%84%EC%9D%B4%EB%B0%B0%EB%83%87&sm=top_hty&fbm=1&ie=utf8";

	$rfr=$_SERVER['HTTP_REFERER'];
	$rfr=rawurldecode($rfr);
	$parseUrl=parse_url($rfr);
	$keyword=cutQueryStr($parseUrl[query]);//echo $parseUrl[host];

	$parseUrl[host]=cutQueryStr($parseUrl[query],"host");
	if(!$parseUrl[host])$pHost="URL";
	else $pHost = $parseUrl[host];
	$parseUrl[query] = cutQueryReSet($parseUrl[query]);

	if(chkHost($pHost,$localhost)){
		$query="insert into $tb_referer values(
		'',
		'". ClientInfo::getClientIP() ."',
		'$nowY',
		'$nowM',
		'$nowD',
		'$nowH',
		'$parseUrl[scheme]',
		'$parseUrl[host]',
		'$parseUrl[path]',
		'$parseUrl[query]',
		'$keyword',
		'$deviceType'
		)";
		$db->getExecSql($query);
	}

	$query="select count(*) from $tb_referer where y='$nowY' and m='$nowM' and d='$nowD' and h='$nowH' and ip='". ClientInfo::getClientIP() ."' ";
	$cnt=$db->getCount($query);
	if ($cnt == 0 && !chkHost($pHost,$localhost)){
		$query="insert into $tb_referer values(
		'',
		'". ClientInfo::getClientIP() ."',
		'$nowY',
		'$nowM',
		'$nowD',
		'$nowH',
		'$parseUrl[scheme]',
		'$parseUrl[host]',
		'$parseUrl[path]',
		'$parseUrl[query]',
		'$keyword',
		'$deviceType'
		)";
		$db->getExecSql($query);
	}

	if($cnt<1)//referer 테이블에 한 줄만 있으믄 카운터 1 증가 시킨다.
	{
		$query="select count(*) as countab from $tb_counter where y='$nowY' and m='$nowM' and d='$nowD' and h='$nowH' and code='".$strCountryCode."'";
		$result = $db->getExecSql($query);
		$cnt_=$db->getCount($query);

		if($cnt_)$query="update $tb_counter set cnt=cnt+1 where y='$nowY' and m='$nowM' and d='$nowD' and h='$nowH' and code='".$strCountryCode."'";
		else {
			$query="insert into $tb_counter values('','$strCountryCode','$nowY','$nowM','$nowD','$nowH','1')";
		}
		$db->getExecSql($query);

		//총 total;
		$query = "select count(*) from SITE_INFO WHERE COL = 'S_SITE_TOT_COUNT'";
		$tot_cnt = $db->getCount($query);
		if (!$tot_cnt) {
			$query = "insert into SITE_INFO (COL,VAL) values ('S_SITE_TOT_COUNT',1)";
			$db->getExecSql($query);
		}

		if($tot_cnt){
			$query = "update SITE_INFO SET VAL = VAL + 1 WHERE COL = 'S_SITE_TOT_COUNT'";
			$db->getExecSql($query);
		}
	}

?>