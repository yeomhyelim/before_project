<?
	// SMS 리스트

	## 모듈 설정
	require_once MALL_HOME . "/module2/PostEmailLog.module.php";
	$postEmailLog					= new PostEmailLogModule($db);

	## 기본 설정
	$intPlNo						= $_GET['plNo'];

	if($intPlNo):
		## 데이터 불러오기
		$param							= "";
		$param['PL_NO']					= $intPlNo;
		$row							= $postEmailLog->getPostEmailLogSelectEx("OP_SELECT", $param);

		## 데이터 설정
		$strFromName					= $row['PL_FROM_M_NAME'];
		$strFromEmail					= $row['PL_FROM_M_MAIL'];
		$strToName						= $row['PL_TO_M_NAME'];
		$strToEmail						= $row['PL_TO_M_MAIL'];
		$strTitle						= $row['PL_TITLE'];
		$strText						= $row['PL_TEXT'];
	endif;
?>
<script type="text/javascript">
<!--
	function goAct() {
		// 액션
		if(!C_chkInput("pm_title",true,"제목",true)) return; //제목
		if(!C_chkInput("pm_text",true,"내용",true)) return; //내용



		//alert('보내기 작업중입니다.');
		//C_getAction("memberMailSend","<?=$PHP_SELF?>");
	}
//-->
</script>
<div id="contentArea" style="margin:0 20px 0 10px;">
	<div id="contentWrap">

		<div class="tableForm">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00154"] //보내는 사람 이름?></th>
					<td><?=$strFromName?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00155"] //보내는 사람 메일?></th>
					<td><?=$strFromEmail?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00156"] //받는사람 이름?></th>
					<td><?=$strToName?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00157"] //받는사람 메일?></th>
					<td><?=$strToEmail?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00158"] //제목?></th>
					<td><?=$strTitle?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00159"] //내용?></th>
					<td><?=$strText?></td>
				</tr>
			</table>
		</div>
		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goMemberMailSendListMoveEvent()" id="menu_auth_m" style=""><strong>목록</strong></a>
		</div>
	</div>
</div>