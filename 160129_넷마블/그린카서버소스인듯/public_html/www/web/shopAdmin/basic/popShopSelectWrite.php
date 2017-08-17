<? include "./include/header.inc.php"?>
<? 
	## 설정
	require_once MALL_CONF_LIB."ShopMgr.php";
	$shopMgr				= new ShopMgr();

	## 리스트
	$intTotal				= $shopMgr->getShopListEx($db, "OP_COUNT", $param);							// 데이터 전체 개수 
	$intPageLine			= 10;																		// 리스트 개수 
	$intPage				= ( $intPage )				? $intPage		: 1;
	$intFirst				= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param					= "";
	$param['ORDER_BY']		= "SH.SH_NO DESC";
//	$param['LIMIT']			= "{$intFirst},{$intPageLine}";
	$shopListResult			= $shopMgr->getShopListEx($db, "OP_LIST", $param);

	$intPageBlock			= 10;																		// 블럭 개수 
	$intListNum				= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage				= ceil( $intTotal / $intPageLine );	
?>
<style type="text/css">

</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		var selectList = $(opener.document).find("input#selectList").val();

		if(selectList){
			var arySelectList			= selectList.split(",");
			var selectListLength		= $("div#selectList > ul").length;
			if(selectListLength <= 0)	{ $("div#selectList").append("<ul></ul>");			}
			for(var key in arySelectList){
				var val		= arySelectList[key];
				var data	= $("div#shopList").find("input[value="+val+"]").attr("checked","true").parent();
				$("div#selectList ul").append(data);
			}
		}

		$("input#listBox").change(function(){
			var val						= $(this).val();
			var checked					= $(this).prop("checked");
			var selectListLength		= $("div#selectList > ul").length;
			if(selectListLength <= 0)	{ $("div#selectList").append("<ul></ul>");			}
			if(checked)					{ $("div#selectList ul").append($(this).parent());	}
			else						{ $("div#shopList ul").append($(this).parent());	}
		});
	});

	function goShopSelectOk() {
		var selectList		= "";
		$("div#selectList").find("input#listBox").each(function() {
			if(selectList) { selectList += ","; }
			selectList += $(this).val();
		});
		$(opener.document).find("input#selectList").val(selectList);
		self.close();
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>접근 가능 입점몰</h2>			
		<a  href="javascript:self.close();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
</div>
<div id="contentArea">
	<div class="layoutWrap">

		<div class="right" style="margin:10px 10px 0 0">
			<a href="javascript:goShopSelectOk()" class="btn_blue_sml"><strong>확인</strong></a>
			<a href="javascript:location.reload()" class="btn_blue_sml"><strong>초기화</strong></a>
		</div>
		<div class="clr"></div>

		<div class="left shopListWrap">
			<div class="titleWrap">
				<h2>입점몰 리스트</h2>
			</div>

			<div class="shopList" id="shopList">
				<ul>
					<?while($row = mysql_fetch_array($shopListResult)):?>
					<li><input type="checkbox" id="listBox" value="<?=$row['SH_NO']?>"/> <span><?=$row['SH_COM_NAME']?></span></li>
					<?endwhile;?>
				</ul>
			</div>
		</div>

		<div class="left shopListWrap">
			<div class="titleWrap">
				<h2>현재 등록된 입점몰</h2>
			</div>

			<div class="shopList" id="selectList">
			</div>
		</div>
		<div class="clr"></div>

	</div>
</div>
</body>

</html>