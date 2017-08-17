<!DOCTYPE html>
<head>
<title>:: Admin ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="ROBOTS" content="no" />
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<META NAME="GOOGLEBOT" CONTENT= "NOINDEX, NOFOLLOW">

	<link rel="stylesheet" type="text/css" href="./common/css/layout.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/calendar.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/design.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/treeMenu.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/button.css"/>
	<link rel="stylesheet" type="text/css" href="./common/css/farbtastic.css"/>
	<link rel="stylesheet" type="text/css" href="../common/css/jquery.jqplot.min.css" />
	<link rel="stylesheet" type="text/css" href="./common/css/jquery.smartPop.css" />
<?if($strAdmSiteLng!="KR"){?>
	<link rel="stylesheet" type="text/css" href="./common/css/style_<?=strtolower($strAdmSiteLng)?>.css" />
<?}?>
<?if($aryCss):
  foreach($aryCss as $key => $data):?>
	<link rel="stylesheet" type="text/css" href="<?=$data?>" />
<?endforeach;
  endif;?>

	<script language="javascript" type="text/javascript" src="../common/js/jquery-1.7.2.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.validate.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.alphanumeric.pack.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/commonReady.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/cal.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/swf.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/farbtastic.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/jquery.smartPop.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/toggle.checkbox.js"></script>
	<script language="javascript" type="text/javascript" src="./common/js/tinybox.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.eum.ajax.js"></script>
<?if($aryScript):
  foreach($aryScript as $key => $data):?>
	<script language="javascript" type="text/javascript" src="<?=$data?>"></script>
<?endforeach;
  endif;?>

	<script type="text/javascript">
		<!--
			var strSiteJsLng		= "<?=$strAdmSiteLng?>";
			var strAdminSiteLng		= "<?=$strAdmSiteLng?>";
			var intAdminLevel		= "<?=$a_admin_level?>"; //최상위관리자 구분
			var strAdminType		= "<?=$a_admin_type?>"; //최상위관리자 구분

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

			var G_PHP_PARAM			= "<?=$_SERVER['QUERY_STRING']?>";
			var G_APP_PARAM			= new Object();
		//-->
	</script>

  <!-- toggle for checkbox -->
  <script type="text/javascript" charset="utf-8">
    $(window).load(function() {
      $('.on_off :checkbox').iphoneStyle();

      var onchange_checkbox = ($('.onchange :checkbox')).iphoneStyle({
        onChange: function(elem, value) {
          $('span#status').html(value.toString());
        }
      });

      setInterval(function() {
        onchange_checkbox.prop('checked', !onchange_checkbox.is(':checked')).iphoneStyle("refresh");
        return
      }, 2500);
    });
  </script>
</head>
<body>
