<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";	
	$productMgr = new ProductAdmMgr();		
	
	$intSE_NO			= $_POST["no"]					? $_POST["no"]				: $_REQUEST["no"];
	
	$productMgr->setSE_NO($intSE_NO);
	$row = $productMgr->getSiteEventView($db);
	
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
			
		$('input[name=eventStartDt]').simpleDatepicker();
		$('input[name=eventEndDt]').simpleDatepicker();
	
		$("#type").live("click",function(){
			
			$("#divDiscountPeriodN").css("display", "none");
			$("#divDiscountPeriodG").css("display", "none");
			
			$("#divDiscountPeriod"+$(this).val()).css("display", "block");			
		});		
	});
	
	function goAct(mode)
	{
		if(!C_chkInput("title",true,"<?=$LNG_TRANS_CHAR['PW00127']?>",true)) return; //할인제목
		if(!C_chkInput("price",true,"<?=$LNG_TRANS_CHAR['PW00128']?>",true)) return; //할인방식

		C_getAction(mode,'<?=$PHP_SELF?>');
	}

	function goClose()
	{
		parent.location.reload();
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>상품 기간/할인관리 수정</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>

</div>
<div id="contentArea">
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">
<input type="hidden" name="no" id="no" value="<?=$intSE_NO?>">
	<!-- ******** 컨텐츠 ********* -->
		<div class="tableForm">
		<table>
			<tr>
				<th>할인 타입</th>
				<td>
					<input type="radio" name="type" id="type" value="N" <?=($row[SE_TYPE]=="N")?"checked":"";?>>신상품 할인
					<input type="radio" name="type" id="type" value="G" <?=($row[SE_TYPE]=="G")?"checked":"";?>>기간 할인
				</td>
			</tr>
			<tr>
				<th>할인 기간</th>
				<td>
					<div style="<?=($row[SE_TYPE]=="N")?"height:30px;":"display:none";?>" id="divDiscountPeriodN">
						상품 
							<select name="day_time" id="day_time">
								<option value="1" <?=($row[SE_DAY_TIME]=="1")?"selected":"";?>>등록일</option>
								<!--<option value="2" <?=($row[SE_DAY_TIME]=="2")?"selected":"";?>>적용일</option>//-->
							</select> 로부터 <input type="text" <?=$nBox?>  style="width:50px;" id="day" name="day" value="<?=$row[SE_DAY]?>"/> 
							<select name="day_type" id="day_type">
								<option value="1" <?=($row[SE_DAY_TYPE]=="1")?"selected":"";?>>일</option>
								<option value="2" <?=($row[SE_DAY_TYPE]=="2")?"selected":"";?>>시간</option>
							</select>
					</div>
					<div style="<?=($row[SE_TYPE]=="G")?"height:30px;":"display:none";?>" id="divDiscountPeriodG">
						<input type="text" <?=$nBox?>  style="width:80px;" id="eventStartDt" name="eventStartDt" value="<?=SUBSTR($row[SE_START_DT],0,10)?>"/>
						<?=drawSelectBoxDate("eventStartHour",   0,   24,   1, SUBSTR($row[SE_START_DT],11,2), "","Hour","")?>
						<?=drawSelectBoxDate("eventStartMin",   0,   60,   1, SUBSTR($row[SE_START_DT],14,2), "","Minute","")?>

						~
						<input type="text" <?=$nBox?>  style="width:80px;" id="eventEndDt" name="eventEndDt" value="<?=SUBSTR($row[SE_END_DT],0,10)?>"/>
						<?=drawSelectBoxDate("eventEndHour",   0,   24,   1, SUBSTR($row[SE_END_DT],11,2), "","Hour","")?>
						<?=drawSelectBoxDate("eventEndMin",   0,   60,   1, SUBSTR($row[SE_END_DT],14,2), "","Minute","")?>
					</div>
				</td>
			</tr>
			<tr>
				<th>할인 제목</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="title" name="title" value="<?=$row[SE_TITLE]?>"/>
				</td>
			</tr>
			<tr>
				<th>할인율 표시(상품목록)</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="price_mark" name="price_mark" value="<?=$row[SE_PRICE_MARK]?>"/>
				</td>
			</tr>
			<tr>
				<th>할인율 표시 문구<br>(상품상세보기)</th>
				<td>
					<?
						$arySiteUseLng = explode("/",$S_USE_LNG);
						$aryUsePriceText = explode("/",$row[SE_PRICE_TEXT]);
						if (is_array($arySiteUseLng) && sizeof($arySiteUseLng) > 1){
							for($i=0;$i<sizeof($arySiteUseLng);$i++){
								$aryPriceText = explode(":",$aryUsePriceText[$i]);
								?>
								<?=$arySiteUseLng[$i]?> : <input type="text" <?=$nBox?>  style="width:250px;" id="price_text[]" name="price_text[]" value="<?=$aryPriceText[1]?>"/><br>
								<?
							}
						} else {
							$aryPriceText = explode(":",$aryUsePriceText[0]);
							?>
							<input type="text" <?=$nBox?>  style="width:250px;" id="price_text[]" name="price_text[]" value="<?=$aryPriceText[1]?>"/>
							<?
						}
					?>
				</td>
			</tr>
			<tr>
				<th>할인 방식</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="price" name="price" value="<?=$row[SE_PRICE]?>"/>
					<select name="price_type" id="price_type">
						<option value="1" <?=($row[SE_PRICE_TYPE]=="1")?"selected":"";?>>%</option>
						<option value="2" <?=($row[SE_PRICE_TYPE]=="2")?"selected":"";?>><?=$S_ST_CUR?></option> 
					</select>
					<select name="price_off" id="price_off">
						<option value="1" <?=($row[SE_PRICE_OFF]=="1")?"selected":"";?>>절삭</option>
						<option value="2" <?=($row[SE_PRICE_OFF]=="2")?"selected":"";?>>반올림</option> 
					</select>
				</td>
			</tr>

			<tr>
				<th>할인 권한</th>
				<td>
					<input type="radio" name="sell_auth" id="sell_auth" value="1" <?=($row[SE_SELL_AUTH]=="1")?"checked":"";?>>회원 + 비회원
					<input type="radio" name="sell_auth" id="sell_auth" value="2" <?=($row[SE_SELL_AUTH]=="2")?"checked":"";?>>회원
				</td>
			</tr>
			<tr>
				<th>상품적립금 적립여부</th>
				<td>
					<input type="radio" name="give_point" id="give_point" value="Y"  <?=($row[SE_GIVE_POINT]=="Y")?"checked":"";?>>상품적립금 적립
					<input type="radio" name="give_point" id="give_point" value="N"  <?=($row[SE_GIVE_POINT]=="N")?"checked":"";?>>상품적립금 미적립
				</td>
			</tr>
			<tr>
				<th>결제시 쿠폰 사용여부</th>
				<td>
					<input type="radio" name="coupon_use" id="coupon_use" value="Y" <?=($row[SE_COUPON_USE]=="Y")?"checked":"";?>>쿠폰 결제 가능
					<input type="radio" name="coupon_use" id="coupon_use" value="N" <?=($row[SE_COUPON_USE]=="N")?"checked":"";?>>쿠폰 결제 불가능
				</td>
			</tr>
			<tr>
				<th>회원등급별 할인 적용여부</th>
				<td>
					<input type="radio" name="discount_use" id="discount_use" value="Y" <?=($row[SE_DISCOUNT_USE]=="Y")?"checked":"";?>>할인 적용 가능
					<input type="radio" name="discount_use" id="discount_use" value="N" <?=($row[SE_DISCOUNT_USE]=="N")?"checked":"";?>>할인 적용 불가능
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goAct('prodEventModify');" id="menu_auth_m"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_big" href="javascript:goClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"]?></strong></a>
	</div>
</form>
</div>
</body>
</html>