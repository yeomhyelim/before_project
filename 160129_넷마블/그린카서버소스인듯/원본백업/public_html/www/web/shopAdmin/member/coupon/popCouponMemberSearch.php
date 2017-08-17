<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";

	$memberMgr = new MemberMgr();
	$couponMgr = new CouponMgr();

	require_once "basic.param.inc.php";


	/* 회원검색(2013.08.13) */
	$strLinkPageStr	= "";
	include MALL_WEB_PATH."shopAdmin/member/member/memberList.helper.inc.php";
	/* 회원검색(2013.08.13) */


?>

<style type="text/css">
	#contentArea{position:relative;min-width:700px;padding:10px}
</style>

<script type="text/javascript">
<!--
	$(document).ready(function(){
	});

	
	function goFind(){
		var doc = document.form;

		//if(!C_chkInput("searchKey", true, "Search Key")) return;

		doc.method = "get";
		doc.action = "<?=$S_PHP_SELF?>";
		doc.submit();
	}

	function goCreateCoupon(type){
		
		var doc = document.form;
		
		if (type == "S")
		{
			var val = C_getCheckedCode(doc["chkNo[]"]);
			
			if(val == ""){
				alert("<?=$LNG_TRANS_CHAR['MS00038']?>"); //회원을 선택하세요.
				return;
			} else {
				C_getAjax("couponMemberChoiceCreate","act");		
			}
		} else if (type == "A"){
			var x = confirm("<?=$LNG_TRANS_CHAR['MS00039']?>"); //
			if (x == true)
			{
				C_getAjax("couponMemberAllCreate","act");
			}
		}
		
	}

	function goAjaxRet(name,result){
		if (name == "couponMemberChoiceCreate" || name=="couponMemberAllCreate")
		{			
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "Y"){
				alert("<?=$LNG_TRANS_CHAR['MS00040']?>"); //쿠폰이 발급되었습니다.
				parent.location.reload();
			}
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=	$LNG_TRANS_CHAR["MW00053"] //회원 검색?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">
<input type="hidden" name="cuNo" value="<?=$intCU_NO?>">
	<div id="contentArea">
		<div class="searchTableWrap">
			<?	include MALL_WEB_PATH."shopAdmin/member/member/search.inc.php"; ?>
		</div>

		<!-- tableOrderForm -->						
		<div class="tableList mt20">
			<table>
				<tr>
					<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
					<th >ID</th>
					<th><?=$LNG_TRANS_CHAR["MW00002"] //이름?></th>
					<th><?=$LNG_TRANS_CHAR["MW00010"] //연락처?></th>
				</tr>
				<?if($intTotal=="0"){?>
				<tr>
					<td colspan="4"><?=$LNG_TRANS_CHAR["CS00001"] //데이터가 없습니다..?></td>
				</tr>
				<?}else{
					while($row = mysql_fetch_array($result)){
						if ($S_MEM_CERITY == "1") $strMemberId = $row[M_ID];
						else $strMemberId = $row[M_MAIL];
				?>
				<tr>
					<td><input type="checkbox" name="chkNo[]" id="chkNo[]" value="<?=$row[M_NO]?>">
					<td><a href="#"><?=$strMemberId?></a></td>
					<td><?=$row[M_NAME]?></td>
					<td><?=$row[M_PHONE]?></td>
				</tr>
				<?	
					}}
				?>
			</table>
		</div>
		<!-- tableList -->

		<!-- Pagenate object --> 
		<div class="paginate mt10">  
			<?=drawPaging($intMemPage,$intPageLine,$intPageBlock,$intMemTotal,$intMemTotPage,$memLinkPage,"","")?> 
		</div> 
		
		<div style="text-align:center">
			<a class="btn_big" href="javascript:goCreateCoupon('A');"><strong><?=$LNG_TRANS_CHAR["MW00149"] //검색회원전체쿠폰발급?></strong></a>
			<a class="btn_big" href="javascript:goCreateCoupon('S');"><strong><?=$LNG_TRANS_CHAR["MW00150"] //선택쿠폰발급?></strong></a>
			<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //Close?></strong></a>
		</div>
	</div>
</form>
</div>
</body>
</html>