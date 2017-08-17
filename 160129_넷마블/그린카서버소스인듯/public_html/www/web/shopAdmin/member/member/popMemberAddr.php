<? include "./include/header.inc.php"?>
<?
	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}

	$memberMgr->setM_NO($intM_NO);
	$row = $memberMgr->getMemberView($db);
	
	/* 국가 리스트 */
	if ($S_SITE_LNG != "KR"){
		$aryCountryList		= getCountryList();			
		$aryCountryState	= getCommCodeList("STATE","");
	}

	if ($row[M_COUNTRY] == "US") $strMemberState = $aryCountryList[$row[M_COUNTRY]];
	else $strMemberState = $row[M_STATE]
?>
<style type="text/css">
	#contentArea{position:relative;min-width:300px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
	

	});


	function goClose()
	{
		parent.goPopClose();
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>[<?=$row[M_NAME]?> <?=$row[M_L_NAME]?>]님의 주소</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th>우편번호</th>
				<td colspan="3">
					<?=$row[M_ZIP]?>
				</td>
			</tr>
			<tr>
				<th>주소</th>
				<td colspan="3">
					<?=$row[M_ADDR]?> <?=$row[M_ADDR2]?> <?=$row[M_CITY]?> <?=$strMemberState?> <?=$aryCountryList[$row[M_COUNTRY]]?>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>