<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00125"] //상품기간/할인관리?></h2>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<h3><?=$LNG_TRANS_CHAR["PW00126"] //할인등록?></h3>
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00234"] //할인 타입?></th>
				<td>
					<input type="radio" name="type" id="type" value="N" checked><?=$LNG_TRANS_CHAR["PW00235"] //신상품 할인?>
					<input type="radio" name="type" id="type" value="G"><?=$LNG_TRANS_CHAR["PW00236"] //기간 할인?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00237"] //할인 기간?></th>
				<td>
					<div style="height:30px;" id="divDiscountPeriodN">
						상품 
							<select name="day_time" id="day_time">
								<option value="1">등록일</option>
								<!--<option value="2">적용일</option>//-->
							</select> 로부터 <input type="text" <?=$nBox?>  style="width:50px;" id="day" name="day"/> 
							<select name="day_type" id="day_type">
								<option value="1">일</option>
								<option value="2">시간</option>
							</select>
					</div>
					<div style="height:30px;display:none" id="divDiscountPeriodG">
						<input type="text" <?=$nBox?>  style="width:80px;" id="eventStartDt" name="eventStartDt"/>
						<?=drawSelectBoxDate("eventStartHour",   0,   24,   1, "", "","Hour","")?>
						<?=drawSelectBoxDate("eventStartMin",   0,   60,   1, "", "","Minute","")?>

						~
						<input type="text" <?=$nBox?>  style="width:80px;" id="eventEndDt" name="eventEndDt"/>
						<?=drawSelectBoxDate("eventEndHour",   0,   24,   1, "", "","Hour","")?>
						<?=drawSelectBoxDate("eventEndMin",   0,   60,   1, "", "","Minute","")?>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00238"] //할인 제목?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="title" name="title"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00239"] //할인율 표시(상품목록)?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="price_mark" name="price_mark" value="<?=$row[SE_PRICE_MARK]?>"/>
					(숫자만 입력하세요.)
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00240"] //할인율 표시 문구<br>(상품상세보기)?></th>
				<td>
					<?
						$arySiteUseLng = explode("/",$S_USE_LNG);
						if (is_array($arySiteUseLng) && sizeof($arySiteUseLng) > 1){
							for($i=0;$i<sizeof($arySiteUseLng);$i++){
								?>
								<?=$S_ARY_COUNTRY[$arySiteUseLng[$i]]?> : <input type="text" <?=$nBox?>  style="width:250px;" id="price_text[]" name="price_text[]" value=""/><br>
								<?
							}
						} else {
							?>
							<input type="text" <?=$nBox?>  style="width:250px;" id="price_text[]" name="price_text[]" value=""/>
							<?
						}
					?>
					
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00241"] //할인 방식?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:50px;" id="price" name="price"/>
					<select name="price_type" id="price_type">
						<option value="1" >%</option>
						<option value="2" selected><?=$S_ST_CUR_MARK?></option> 
					</select>
					<select name="price_off" id="price_off">
						<option value="1" selected>절삭</option>
						<option value="2" >반올림</option> 
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00242"] //할인 권한?></th>
				<td>
					<input type="radio" name="sell_auth" id="sell_auth" value="1" checked><?=$LNG_TRANS_CHAR["PW00243"] //회원 + 비회원?>
					<input type="radio" name="sell_auth" id="sell_auth" value="2"><?=$LNG_TRANS_CHAR["PW00244"] //회원?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00245"] //상품적립금 적립여부?></th>
				<td>
					<input type="radio" name="give_point" id="give_point" value="Y" checked><?=$LNG_TRANS_CHAR["PW00246"] //상품적립금 적립?>
					<input type="radio" name="give_point" id="give_point" value="N"><?=$LNG_TRANS_CHAR["PW00247"] //상품적립금 미적립?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00248"] //결제시 쿠폰 사용여부?></th>
				<td>
					<input type="radio" name="coupon_use" id="coupon_use" value="Y" checked><?=$LNG_TRANS_CHAR["PW00249"] //쿠폰 결제 가능?>
					<input type="radio" name="coupon_use" id="coupon_use" value="N"><?=$LNG_TRANS_CHAR["PW00250"] //쿠폰 결제 불가능?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00251"] //회원등급별 할인 적용여부?></th>
				<td>
					<input type="radio" name="discount_use" id="discount_use" value="Y" ><?=$LNG_TRANS_CHAR["PW00252"] //할인 적용 가능?>
					<input type="radio" name="discount_use" id="discount_use" value="N" checked><?=$LNG_TRANS_CHAR["PW00253"] //할인 적용 불가능?>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goAct('prodEventWrite');" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	</div>

</div>
<div class="tabImgWrap mt40">
	<a href="./?menuType=product&mode=prodEvent&gb=1" <?=($strGb=="1")? "class='selected'":"";?>><?=$LNG_TRANS_CHAR["PW00254"] //시작전할인?></a>	
	<a href="./?menuType=product&mode=prodEvent&gb=2" <?=($strGb=="2")? "class='selected'":"";?>><?=$LNG_TRANS_CHAR["PW00255"] //진행중할인?></a>	
	<a href="./?menuType=product&mode=prodEvent&gb=3" <?=($strGb=="3")? "class='selected'":"";?>><?=$LNG_TRANS_CHAR["PW00256"] //종료할인?></a>
</div>

<div class="tableListWrap">
	<table class="tableList">
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00257"] //할인타입?></th>
			<th><?=$LNG_TRANS_CHAR["PW00258"] //할인제목?></th>
			<th><?=$LNG_TRANS_CHAR["PW00259"] //할인기간?></th>
			<th><?=$LNG_TRANS_CHAR["PW00260"] //할인방식?></th>
			<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
		</tr>
		<?

			if (is_array($arySiteEventList)){
				for($i=0;$i<sizeof($arySiteEventList);$i++){
					$strType = ($arySiteEventList[$i][SE_TYPE]=="N") ? "신상품할인" : "기간할인";

					$strDiscountUnit = ($arySiteEventList[$i][SE_PRICE_TYPE]=="1") ? "%" : $S_ST_CUR;
					$strDiscountOff  = ($arySiteEventList[$i][SE_PRICE_OFF]=="1") ? "절삭" : "반올림";
					
					if ($arySiteEventList[$i][SE_TYPE]=="N"){
						$strSiteEventGigan   = ($arySiteEventList[$i][SE_DAY_TIME]=="1") ? "상품등록일" : "상품적용일";
						$strSiteEventGigan  .= " ".$arySiteEventList[$i][SE_DAY];
						$strSiteEventGigan  .= ($arySiteEventList[$i][SE_DAY_TYPE]=="1") ? "일까지" : "시간까지";
					} else {
						$strSiteEventGigan   = $arySiteEventList[$i][SE_START_DT]." ~ ".$arySiteEventList[$i][SE_END_DT];
					}
				
				?>
		<tr>
			<td><?=$strType?></td>
			<td><?=$arySiteEventList[$i][SE_TITLE]?></td>
			<td><?=$strSiteEventGigan?></td>
			<td><?=getFormatPrice($arySiteEventList[$i][SE_PRICE],2)?> <?=$strDiscountUnit?> <?=$strDiscountOff?></td>
			<td>
				<a class="btn_sml" href="javascript:goProdView('<?=$arySiteEventList[$i][SE_NO]?>');"><strong><?=$LNG_TRANS_CHAR["PW00132"]?>(<?=$arySiteEventList[$i][PROD_CNT]?>)</strong></a>
				<a class="btn_sml" href="javascript:goProdSearch('<?=$arySiteEventList[$i][SE_NO]?>');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00050"]?></strong></a>
				<a class="btn_sml" href="javascript:goModify('<?=$arySiteEventList[$i][SE_NO]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"]?></strong></a>
				<a class="btn_sml" href="javascript:goDelete('<?=$arySiteEventList[$i][SE_NO]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"]?></strong></a>
			</td>
		</tr>
				<?
				}
			}
		?>
	</table>
</div>
<!-******** 컨텐츠 ********* -->