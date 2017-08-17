<?php 

	## 기본설정
//	$strSubPageCode // 상단에서 설정

	## 모듈 설정
	$objIconMgrModule = new IconMgrModule($db);

	## 체크
	if(!in_array($strSubPageCode, array("ZL0001","PL0001"))) { return; }

	## MAIN or SUB 설정
	$strIC_TYPE = "MAIN";
	if($strSubPageCode == "PL0001") { $strIC_TYPE = "SUB"; }

	## MAIN or SUB 불러오기
	$param = "";
	$param['IC_TYPE'] = $strIC_TYPE;
	$param['ORDER_BY'] = "icCodeAsc";
	$aryIconList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);
	$aryIconInfo = "";
	foreach($aryIconList as $key => $data):
		## 기본설정
		$intIC_NO = $data['IC_NO'];
		$intIC_CODE = $data['IC_CODE'];
		$strIC_NAME = $data['IC_NAME'];
		$strIC_IMG = $data['IC_IMG'];
		$strIC_USE = $data['IC_USE'];

		## 사용유무 설정
		if(!$strIC_USE) { $strIC_USE = "N"; }

		## 만들기	
		$aryIconInfo[$intIC_CODE]['NAME'] = $strIC_NAME;
		$aryIconInfo[$intIC_CODE]['IMG'] = $strIC_IMG;
		$aryIconInfo[$intIC_CODE]['USE'] = $strIC_USE;
	endforeach;

	include_once  "./include/header.inc.php"; 

?>
	<div class="layerPopWrap">
		<div class="popTop">
			<h2>진열장 관리</h2>			
			<a  href="javascript:void(0);" onclick="parent.goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
			<div class="clear"></div>
		</div>
		<div class="popBoxWrap">
			<!-- ******** 컨텐츠 ********* -->
			<div class="tableList">
				<table>
				<tr>
					<th>진열명</th>
				</tr>
				<?php foreach($aryIconInfo as $key => $data):?>
				<tr>
					<td>
						<input type="text" <?php echo $nBox;?>  style="width:300px;" name="name_<?php echo $key;?>" value="<?php echo $data['NAME'];?>"/>
					</td>
				</tr>
				<?php endforeach;?>
				</table>
			</div>
			<!-- ******** 컨텐츠 ********* -->
		</div>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:void(0);" onclick="goLayoutPopSkinProdDisplayActEvent();" id="menu_auth_m" style="display:none"><strong>저장</strong></a>
		<a class="btn_big" href="javascript:void(0);" onclick="parent.goClose();"><strong>닫기</strong></a>
	</div>

<script type="text/javascript">
<!--
	// 전역 변수 설정
	var strSubPageCode = '<?php echo $strSubPageCode;?>';

	$(function() {

		// 권한 설정
		C_CallMenuAuthBtn("<?php echo $a_admin_no;?>","<?php echo $strTopMenuCode;?>","<?php echo $strLeftMenuCode01;?>","<?php echo $strLeftMenuCode02;?>");

	});
	
	// 저장
	function goLayoutPopSkinProdDisplayActEvent() {

		// 기본설정
		var objTarget = $('.layerPopWrap');

		// 설정
		var strName1 = objTarget.find('[name=name_1]').val();
		var strName2 = objTarget.find('[name=name_2]').val();
		var strName3 = objTarget.find('[name=name_3]').val();
		var strName4 = objTarget.find('[name=name_4]').val();
		var strName5 = objTarget.find('[name=name_5]').val();

		// 전달
		var data = new Object();
		data['menuType'] = 'layout';
		data['mode'] = 'json';
		data['act'] = 'prodDisplayModify';
		data['subPageCode'] = strSubPageCode;
		data['name_1'] = strName1;
		data['name_2'] = strName2;
		data['name_3'] = strName3;
		data['name_4'] = strName4;
		data['name_5'] = strName5;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
					if(data['__STATE__'] == "SUCCESS") {

						alert("수정되었습니다.");
//						parent.location.reload();
						parent.goLayoutPopCloseEvent();

					} else {
						var strMsg = data['__MSG__'];
						if(!strMsg) { strMsg = data; }
						alert(data);
					}
			   }
		});
	}


//-->
</script>

</body>

</html>