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

<body>
<div class="popContainer">
	<div class="addrHight">
	<h2><?=$LNG_TRANS_CHAR["OW00085"] //주소록?></h2>
	<form name='form' method='post' id="form">
	<input type="hidden" name="menuType" value="member">
	<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" id="act" value="<?=$strMode?>">
	<input type="hidden" name="addrNo" id="addrNo" value="<?=$intMA_NO?>">
		<div class="popTableList">
			<table>
				<tr>
					<th class="numDiv"><?=$LNG_TRANS_CHAR["CW00006"]  //번호?></th>
					<th class="nameDiv"><?=$LNG_TRANS_CHAR["OW00087"]  //성명?></th>
					<th><?=$LNG_TRANS_CHAR["OW00013"]  //주소?></th>
				<tr>
				<?
					if (is_array($aryMemberAddrList)){
						for($i=0;$i<sizeof($aryMemberAddrList);$i++){

							$strAddrState = $aryMemberAddrList[$i][MA_STATE];
							if ($aryMemberAddrList[$i][MA_COUNTRY] == "US") $strAddrState = $aryCountryState[$aryMemberAddrList[$i][MA_STATE]];
				?>
				<tr>
					<td><?=($i+1)?></td>
					<td><a href="javascript:goSelect(<?=$aryMemberAddrList[$i][MA_NO]?>);"><?=$aryMemberAddrList[$i][MA_NAME]?></a></td>
					<td>
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
			<a href="javascript:self.close();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></span></a>
		</div>
	</form>
	</div>
</div>
</body>
</html>