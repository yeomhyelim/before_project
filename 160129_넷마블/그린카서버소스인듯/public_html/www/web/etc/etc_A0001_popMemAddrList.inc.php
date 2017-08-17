<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	
	$memberMgr = new MemberMgr();
	
	$memberMgr->setM_NO($g_member_no);
	$aryMemberAddrList = $memberMgr->getMemberAddrList($db);

	$aryCountryList		= getCountryList();			
	$aryCountryState	= getCommCodeList("STATE","");

?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goSelect(no)
	{
		opener.goMemberAddrPush(no);
		self.close();
	}
//-->
</script>
<style>
	div.popAddrWrap{height:336px;}
	div.tableOrderForm{padding:15px;}
	div.tableform table{width:100%;}
	div.tableform table th{height:22px;padding:5px;text-align:center !important;border:1px solid #cccccc;background:#f5f5f5;}
	div.tableform table td{padding:5px;border:1px solid #cccccc;}
	div.tableform table th.numDiv,
	div.tableform table td.numDiv{width:10%;text-align:center !important;}
	div.tableform table th.nameDiv,
	div.tableform table td.nameDiv{width:20%;text-align:center !important;}
	div.tableform table td.addrDiv{width:70%;}
</style>

<body>
<div class="popAddrWrap">
	<h2><?=$LNG_TRANS_CHAR["OW00085"] //주소록?></h2>

	<div class="tableOrderForm mt10">	
	<form name='form' method='post' id="form">
	<input type="hidden" name="menuType" value="member">
	<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" id="act" value="<?=$strMode?>">
	<input type="hidden" name="addrNo" id="addrNo" value="<?=$intMA_NO?>">
		<div class="tableform">
			<table>
				<tr>
					<th class="numDiv"><?=$LNG_TRANS_CHAR["CW00006"]  //번호?></th>
					<th class="nameDiv"><?=$LNG_TRANS_CHAR["OW00087"]  //성명?></th>
					<th class="addrDiv"><?=$LNG_TRANS_CHAR["OW00013"]  //주소?></th>
				<tr>
				<?
					if (is_array($aryMemberAddrList)){
						for($i=0;$i<sizeof($aryMemberAddrList);$i++){

							$strAddrState = $aryMemberAddrList[$i][MA_STATE];
							if ($aryMemberAddrList[$i][MA_COUNTRY] == "US") $strAddrState = $aryCountryState[$aryMemberAddrList[$i][MA_STATE]];
				?>
				<tr>
					<td class="numDiv"><?=($i+1)?></td>
					<td class="nameDiv"><a href="javascript:goSelect(<?=$aryMemberAddrList[$i][MA_NO]?>);"><?=$aryMemberAddrList[$i][MA_NAME]?></a></td>
					<td class="addrDiv">
						<?=($aryMemberAddrList[$i][MA_TYPE]=="1")? "[".$LNG_TRANS_CHAR["OW00086"]."]":"";?>
						<?if ($aryMemberAddrList[$i][MA_COUNTRY]) {echo $aryCountryList[$aryMemberAddrList[$i][MA_COUNTRY]];}?>
						<?=$aryMemberAddrList[$i][MA_ADDR1]?> <?=$aryMemberAddrList[$i][MA_ADDR2]?>
						<?if ($aryMemberAddrList[$i][MA_CITY]) {echo $aryMemberAddrList[$i][MA_CITY];}?>
						<?if ($aryMemberAddrList[$i][MA_STATE]) {echo $strAddrState;}?>
					</td>
				</tr>
				<?
						}
					}
				?>
			</table>
		</div>
	
		<div class="btnCenter">
			<a href="javascript:self.close();" class="btnClose"><span><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></span></a>
		</div>
	</form>
	</div>
</div>
</body>
</html>