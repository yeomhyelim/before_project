<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	
	$orderMgr = new OrderMgr();

	if (!$g_member_login || !$g_member_no){
		goClose($LNG_TRANS_CHAR["OS00014"]);
		exit;
	}
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goOrderEstimateAct()
	{
		var intCartCnt = $('input:checkbox[id="cartNo[]"]:checked',opener.document).length;
		if (intCartCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00083']?>"); //견적내실 상품이 존재하지 않습니다.
			return;
		}

		var data				= new Array(intCartCnt + 5);
		$('input:checkbox[id="cartNo[]"]:checked',opener.document).each(function(i){
			data["chkNo["+i+"]"] = $(this).val();
				
		});
		

		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderEstimate"; 
		data['memo']				= "ddd";
		C_getSelfAction(data);
	}
//-->
</script>
<body>
<div class="popContainer">
<form name='form' method='post' ID="form">
<input type="hidden" name="menuType" value="order">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">

	<div class="couponHight">
		<h2><?=$LNG_TRANS_CHAR["OW00108"] //견적의뢰?></h2>

			<div class="popTableList">
				<table>
					<colgroup>
						<col style="width:100px;"/>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?></th>
						<td>
							<textarea style="width:98%;height:150px;"></textarea>
						</td>
					</tr>
				</table>
			</div>
							
			<div class="btnCenter">				
				<a href="javascript:goOrderEstimateAct();" class="popChkOkBtn"><?=$LNG_TRANS_CHAR["OW00108"] //견적의뢰?></a>
				<a href="javascript:self.close();" class="popCloeBtn"><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></a>
			</div>
		</div>
		<div id="divHiddenCartList">
		</div>
	</div>
</div>
</form>
</body>
</html>