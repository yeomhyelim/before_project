<?
	require_once MALL_CONF_LIB."PopupMgr.php";
	
	$popupMgr = new PopupMgr();

	$intPO_NO = $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intPO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00001"]); //"해당 팝업 정보가 존재하지 않습니다."
		exit;
	}

	$popupMgr->setPO_NO($intPO_NO);
	$aryPopupInfo = $popupMgr->getMainPopup($db);
?>
<?include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); ?>
<script type="text/javascript">
<!--
	function goLinkUrl(){
		<?if($aryPopupInfo[0][PO_LINK] != "#"){?>
		<?if($aryPopupInfo[0][PO_TYPE]==1){?>
			window.open("<?=$aryPopupInfo[0][PO_LINK]?>","_blank","");
		<?}else if($aryPopupInfo[0][PO_TYPE]==2){?>
			opener.location.href='<?=$aryPopupInfo[0][PO_LINK]?>';
		<?}}?>
		self.close();
	}

	// 쿠키
	function setCookie( name, value, expiredays ) 
	{ 
		var todayDate = new Date(); 
		todayDate.setDate( todayDate.getDate() + expiredays ); 
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
	} 

	function goCloseWin() 
	{ 
		if ($("#chk").attr("checked")){
			setCookie( "pop_<?=$intPO_NO?>", "done" , 1);//1은 하루동안 새창을 열지 않게 합니다.
		}
		window.close(); 
	} 


//-->
</script>
<style type="text/css" rel="stylesheet">
	body{margin:0}
	img{border:none}
	#wrapper{width:100%;}
	.todayCookie{width:100%;padding:5px 0;overflow:hidden;font-size:12px;background:#534c53;color:#ffffff;}
	.middle{vertical-align:middle}
	.left{float:left}
	.right{float:right}
</style>
<body leftmargin=0 topmargin=0>
<div id="wrapper">
	<img src="/upload/popup/<?=$aryPopupInfo[0][PO_FILE]?>" <?if($aryPopupInfo[0][PO_TYPE]!= "3") echo "onclick='javascript:goLinkUrl()' style='cursor:pointer'";?>>
	<div class="todayCookie">
		<span class="left">
			<input type="checkbox" id="chk" class="middle" onclick="javascript:goCloseWin();"/><label for="chk" class="middle"><?=$LNG_TRANS_CHAR["CW00050"] //오늘하루 열지 않음?></label>
		</span>
		<span class="right">
			<a onclick="javascript:self.close();" href="#"><img src="/himg/etc/btn_pop_x.gif" alt="닫기" style="margin-top:2px;margin-right:10px;"/></a>
		</span>
	</div>
</div>
</body>
</html>
