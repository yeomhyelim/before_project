<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	
	$memberMgr = new MemberMgr();

	/* 관리자 Sub Menu 권한 설정 */
	$strLeftMenuCode01 = "004";
	$strLeftMenuCode02 = "001";
	/* 관리자 Sub Menu 권한 설정 */

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	/* 데이터 리스트 */
	$memberMgr->setSearchField("N");
	$memberMgr->setSearchKey($strSearchKey);
	$intTotal								= $memberMgr->getMemberTotal( $db );											// 데이터 전체 개수 

	$intPageLine							= 5;																			// 리스트 개수 
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
	$memberMgr->setLimitFirst($intFirst);
	$memberMgr->setPageLine($intPageLine);

	$memberResult							= $memberMgr->getMemberList( $db );
	$intPageBlock							= 10;																		// 블럭 개수 
	$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage								= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */


?>

<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
	});

	
	function goFind(){
		var doc = document.form;

		if(!C_chkInput("searchKey", true, "Search Key")) return;

		doc.method = "get";
		doc.action = "<?=$S_PHP_SELF?>";
		doc.submit();
	}

	function goSetMem(no,name,phone,id){
		// 부모창에 값 전달
		opener.returnSearchBrandManager(no, name, phone, id);
		self.close();
	}
//-->
</script>

<table style="width:100%;">
	<tr>
		<td class="contentWrap">
			<div class="layoutWrap">
				<form name="form" method="post">
				<input type="hidden" name="menuType" value="<?=$strMenuType?>">
				<input type="hidden" name="mode" value="<?=$strMode?>">
				<input type="hidden" name="act" value="<?=$strMode?>">
				<input type="hidden" name="page" value="<?=$intPage?>">
				<div id="contentArea" style="min-width:0px">
					<div class="contentTop">
						<h2><?=	$LNG_TRANS_CHAR["MW00053"] //회원 검색?></h2>
					</div>

					<!-- (1) 회원 정보 -->
					<div class="tableForm" style="margin-top:10px;">
					<table>			
						<tr>
							<th style="width:80px"><?=$LNG_TRANS_CHAR["MW00002"] //이름?></th>
							<td style="padding:5px">
													<input type="text" name="searchKey" id="searchKey" value="" style="width:150px;" value="<?=$strSearchKey?>"/>
							</td>
							<td style="width:80px">
													<a class="btn_sml" href="javascript:goFind();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
							</td>
						</tr>
					</table>
				</div>
				

				<div class="tableList">
					<table>
						<tr>
							<th >ID</th>
							<th style="width:100px"><?=$LNG_TRANS_CHAR["MW00002"] //이름?></th>
							<th style="width:150px"><?=$LNG_TRANS_CHAR["MW00010"] //연락처?></th>
						</tr>
						<?if($intTotal=="0"){?>
						<tr>
							<td colspan="3"><?=$LNG_TRANS_CHAR["CS00001"] //데이터가 없습니다..?></td>
						</tr>
						<?	}else{
								while($row = mysql_fetch_array($memberResult)){	?>
						<tr>
							<td style="border-left:none;"><a href="javascript:goSetMem(<?=$row[M_NO]?>,'<?=$row[M_NAME]?>','<?=$row[M_PHONE]?>','<?=$row[M_ID]?>');"><?=$row[M_ID]?></a></td>
							<td style="border-left:none;"><a href="javascript:goSetMem(<?=$row[M_NO]?>,'<?=$row[M_NAME]?>','<?=$row[M_PHONE]?>','<?=$row[M_ID]?>');"><?=$row[M_NAME]?></a></td>
							<td style="border-right:none;"><a href="javascript:goSetMem(<?=$row[M_NO]?>,'<?=$row[M_NAME]?>','<?=$row[M_PHONE]?>','<?=$row[M_ID]?>');"><?=$row[M_PHONE]?></a></td>
						</tr>
						<?	
							}}
						?>
					</table>
				</div>

				<!-- Pagenate object --> 
				<div class="paginate" style="width:400px;padding:0px 5px;">  
				<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
				</div> 

				<div style="text-align:center">
					<a class="btn_big" href="javascript:self.close();"><strong>Close</strong></a>
				</div>
			</div>
			</form>
		</td>
	</tr>
</table>

</body>

</html>