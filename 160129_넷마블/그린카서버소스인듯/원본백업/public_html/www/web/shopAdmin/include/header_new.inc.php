<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>:: Admin ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="./common/css/layout.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/calendar.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/design.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/treeMenu.css"/>
	<link class="include" rel="stylesheet" type="text/css" href="../common/css/jquery.jqplot.min.css" /> 
	<link rel="stylesheet" href="./common/css/jquery.smartPop.css" />	
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->

	<script language="javascript" type="text/javascript" src="../common/js/jquery-1.7.2.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.validate.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.alphanumeric.pack.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/cal.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/swf.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.smartPop.js"></script>

	<script type="text/javascript">
	<!--
		var strSiteJsLng		= "<?=$strAdmSiteLng?>";
		var strAdminSiteLng		= "<?=$strAdmSiteLng?>";
		var intAdminLevel		= "<?=$a_admin_level?>"; //최상위관리자 구분

		var strMenuAuthBtn_L	= "";	//목록
		var strMenuAuthBtn_W	= "";	//등록
		var strMenuAuthBtn_M	= "";	//수정
		var strMenuAuthBtn_D	= "";	//삭제
		var strMenuAuthBtn_E	= "";	//엑셀
		var strMenuAuthBtn_C	= "";	//정산
		var strMenuAuthBtn_S	= "";	//SMS
		var strMenuAuthBtn_P	= "";	//포인트
		var strMenuAuthBtn_U	= "";	//업로드
		var strMenuAuthBtn_E1	= "";	//기타기능1
		var strMenuAuthBtn_E2	= "";	//기타기능2
		var strMenuAuthBtn_E3	= "";	//기타기능3
		var strMenuAuthBtn_E4	= "";	//기타기능4
		var strMenuAuthBtn_E5	= "";	//기타기능5
	
	
		$(document).ready(function() {
			if (strAdminSiteLng != "KR")
			{
				$(".subNav li").css("width","250px");
			}
		});

	
	//-->
	</script>
</head>
<body>
