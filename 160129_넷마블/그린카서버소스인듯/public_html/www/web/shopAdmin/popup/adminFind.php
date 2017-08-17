<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	
	$memberMgr = new MemberMgr();

	$intPageBlock = 10;
	$intPageLine  = 10;

	$memberMgr->setPageLine($intPageLine);
	$memberMgr->setSearchField("N");
	$memberMgr->setSearchKey($strSearchKey);
	$memberMgr->setSearchGroupNotView("Y");
	//회원정보
	$intTotal = 0;
//	if ($strSearchKey) {
		$intTotal = $memberMgr->getMemberTotal($db);	
		$intTotPage	= ceil($intTotal / $memberMgr->getPageLine());

		if(!$intPage)	$intPage =1;

		if ($intTotal==0) {
			$intFirst	= 1;
			$intLast	= 0;			
		} else {
			$intFirst	= $intPageLine *($intPage -1);
			$intLast	= $intPageLine * $intPage;
		}
		$memberMgr->setLimitFirst($intFirst);
		$result = $memberMgr->getMemberList($db);		
//	}

	$intListNum = $intTotal - ($intPageLine *($intPage-1));		
	$linkPage  = "./?menuType=popup&mode=adminFind&searchField=F&searchKey=$strSearchKey";
	$linkPage .= "&page=";

?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
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
		
		opener.document.form.m_no.value = no;
		opener.document.form.m_name.value = name;
		opener.document.form.m_phone.value = phone;
		opener.document.form.m_id.value = id;

		self.close();
	}
//-->

</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=	$LNG_TRANS_CHAR["MW00053"] //회원 검색?></h2>			
		<a href="javascript:self.close();"><img src="/shopAdmin/himg/common/btn_pop_close_white.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" method="post">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">

	<!-- (1) 회원 정보 -->
	<div class="searchTableWrap mt20 txtCenter">
			<?=$LNG_TRANS_CHAR["MW00002"] //이름?>
			<input type="text" name="searchKey" id="searchKey" value="" class="_w300" value="<?=$strSearchKey?>"/>
			<a class="btn_sml" href="javascript:goFind();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
	</div>
				
	<!-- tableOrderForm -->						
				
	<div class="tableList mt10">
		<table>
			<tr>
				<th><?=($S_MEM_CERITY == "1") ? "ID" : "MAIL"?></th>
				<th style="width:100px"><?=$LNG_TRANS_CHAR["MW00002"] //이름?></th>
				<th style="width:150px"><?=$LNG_TRANS_CHAR["MW00010"] //연락처?></th>
			</tr>
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="3"><?=$LNG_TRANS_CHAR["CS00001"] //데이터가 없습니다..?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){

					$strM_ID =  ($S_MEM_CERITY == "1") ? $row[M_ID] : $row[M_MAIL]; 
			?>
			<tr>
				<td style="border-left:none;"><a href="javascript:goSetMem(<?=$row[M_NO]?>,'<?=$row[M_NAME]?>','<?=$row[M_PHONE]?>','<?=$strM_ID?>');"><?=$strM_ID?></a></td>
				<td style="border-left:none;"><?=$row[M_NAME]?></td>
				<td style="border-right:none;"><?=$row[M_PHONE]?></td>
			</tr>
			<?	
				}}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt20">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div> 

</form>
</div>
</body>
</html>