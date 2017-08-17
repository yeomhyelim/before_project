<?php
	
	## 모듈 설정
	$objShopMgrModule = new ShopMgrModule($db);

	## 입점사 리스트
	$param = '';
	$aryShopList = $objShopMgrModule->getShopMgrSelectEx("OP_ARYTOTAL", $param);

?>
<? include "./include/header.inc.php"?>
<script>
	
	// 변경
	function goProdShopActEvent() {
		var x = confirm('변경하시겠습니까?');
		if(!x) { return; }

		// 상품 리스트 만들기
		var strProdList = '';
		$(parent.document).find('[input[name^=chkNo]:checked').each(function() {
			if(strProdList) { strProdList = strProdList + ','; }
			strProdList = strProdList + $(this).val();
		});

		// 선택된 상품이 없는 경우
		if(!strProdList) { 
			alert('선택된 상품이 없습니다.');
			return;
		}

		// 선택된 입점사 설정
		var intShopNo = $('[name=shopNo]').val();
		
		// 데이터 전달
		var data			= new Object();
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "prodShopModify";
		data['pCodeList']	= strProdList;
		data['shopNo']		= intShopNo;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {

									alert('변경되었습니다.');
									parent.location.reload();
								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(strMsg);
								}
						   }
		});
	}

</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>입점사 변경</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm mt20">
		<table>
			<tr>
				<th>임점사</th>
				<td><select name="shopNo">
						<?php foreach($aryShopList as $key => $row):?>
						<option value="<?php echo $row['SH_NO'];?>"><?php echo $row['SH_COM_NAME'];?></option>
						<?php endforeach;?>
					</select>					
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goProdShopActEvent();" id="menu_auth_w"><strong>변경</strong></a>
	<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["PW00091"] //닫기?></strong></a>
</div>
</body>
</html>