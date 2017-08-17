<?
	require_once MALL_CONF_LIB."DesignMgr.php";					// 디자인 모듈 통합

	$designMgr				= new DesignMgr();
	
	$strPV_PAGE				= $_POST["pv_page"]			? $_POST["pv_page"]			: $_REQUEST["pv_page"];
	
	$strPV_PAGE 				= strTrim($strPV_PAGE,10);
	
	/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
	$intPageBlock				= 10;
	$intPageLine				= 10;
	
	$designMgr->setPageLine($intPageLine);
	
	$designMgr->setPV_PAGE($strPV_PAGE);
	
	$intTotal 					= $designMgr->getProdPageTotal($db);
	
	$intTotPage				= ceil($intTotal / $designMgr->getPageLine());
	
	$intPage					= (!$intPage) ? 1 : $intPage;
	
	if ($intTotal==0) :
		$intFirst				= 1;
		$intLast				= 0;
	else :
		$intFirst				= $intPageLine * ($intPage - 1);
		$intLast				= $intPageLine * $intPage;
	endif;
	
	$designMgr->setLimitFirst($intFirst);
	/* 페이지 시작 시점 지정 및 리스트 개수 지정  */

	$result 						= $designMgr->getProdPageList($db);
	$intListNum 				= $intTotal - ($intPageLine *($intPage-1));

?>
<? include "./include/header.inc.php";?>
<style>
	ul.sampleWrap li{padding: 3px 0;line-height:18px;color:#5b5b5b;letter-spacing:-1px;}
	ul.sampleWrap li.title{font-weight:bold;color:#333;}
</style>
<script type="text/javascript">
<!--
	function goParamSubmit(no,group,type,code,title)
	{

		var aryParam = new Array(5);
		
		aryParam[0] = "SAMPLE";
		aryParam[1] = no;
		aryParam[2] = group;
		aryParam[3] = type;
		aryParam[4] = code;
		aryParam[5] = title;

		opener.getParamInput(aryParam);
		self.close();
	}
//-->
</script>
<body>
	<div id="contentArea" style="padding: 15px 10px;">
		<h2>디자인 선택</h2>
		<div class="tableList">
			<table style="border-left:1px solid #D2D0D0">
				<colgroup>
					<col style="width:50px;"/>
					<col/>
					<col/>
				</colgroup>
				<tr>
					<th>번호</th>
					<th>디자인</th>
					<th>관리</th>
				</tr>
				<!-- (1) -->
				<?if($intTotal=="0"){?>
					<tr>
						<td colspan="9">등록된 데이터가 없습니다.</td>
					</tr>		
				<?}?>
				<?
					while($row = mysql_fetch_array($result)){
						
				?>
				<tr>
					<td><?=$intListNum--?></td>
					<td style="text-align:left;">
						<ul class="sampleWrap">
							<li class="title"><?=$row[DM_DESIGN_TITLE]?> [<?=$row[DM_DESIGN_GROUP]?>-<?=$row[DM_DESIGN_TYPE]?>-<?=$row[DM_DESIGN_CODE]?>]</li>
							<li><img src="http://eumshop.co.kr/himg/design/designSample/designLayout/<?=$row[DM_DESIGN_GROUP]?>_<?=$row[DM_DESIGN_TYPE]?><?=$row[DM_DESIGN_CODE]?>_s.jpg"/></li>
							<li>
								<?=$row[DM_DESIGN_TXT]?>
							</li>
						</ul>
					</td>
					<td>
						 <a class="btn_blue_sml" href="javascript:goParamSubmit('<?=$row[DM_NO]?>','<?=$row[DM_DESIGN_GROUP]?>','<?=$row[DM_DESIGN_TYPE]?>','<?=$row[DM_DESIGN_CODE]?>','<?=$row[DM_DESIGN_TITLE]?>');"><span>선택</span></a>  
					</td>
				</tr>
				<?
					}
				?>
			</table>
		</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate" style="width:400px;padding:0px 5px;">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->

	</div>
</body>
</html>