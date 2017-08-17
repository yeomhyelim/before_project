<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MW00127"] //쿠폰생성?></h2>
	<div class="clr"></div>
</div>
<!-- ******** 컨텐츠 ********* -->
<div class="tableFormWrap">
	<table class="tableForm">
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00111"] //쿠폰이름?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:150px;" id="name" name="name" value="<?=$row[CU_NAME]?>" maxlength="50"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00236"] //쿠폰설명?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:250px;" id="memo" name="memo" value="<?=$row[CU_TEXT]?>" maxlength="200"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00112"] //쿠폰발급방식?></th>
			<td>
				<input type="radio" name="issue" id="issue" value="1" <?=($row[CU_ISSUE]=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00113"] //회원발급?>
				<!-- <input type="radio" name="issue" id="issue" value="2" <?=($row[CU_ISSUE]=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00114"] //회원 다운로드?> //-->
				<input type="radio" name="issue" id="issue" value="3" <?=($row[CU_ISSUE]=="3")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00115"] //회원 가입시 자동발급?>
				<input type="radio" name="issue" id="issue" value="4" <?=($row[CU_ISSUE]=="4")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00116"] //구매 후 자동발급?>
				<!-- <input type="radio" name="issue" id="issue" value="5" <?=($row[CU_ISSUE]=="5")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00125"] //이벤트발급?> //-->
				<input type="radio" name="issue" id="issue" value="6" <?=($row[CU_ISSUE]=="6")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00147"] //오프라인발급?>

			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00118"] //쿠폰금액?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:50px;" id="price" name="price" value="<?=$row[CU_PRICE]?>" maxlength="20"/>
				<select name="price_off" id="price_off">
					<option value="1" <?=($row[CU_PRICE_OFF]=="1")?"selected":"";?>>%</option>
					<option value="2" <?=($row[CU_PRICE_OFF]=="2")?"selected":"";?>><?=$S_ST_CUR?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00126"] //쿠폰사용조건?></th>
			<td>
				<input type="radio" name="use" id="use" value="1" <?=($row[CU_USE]=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00127"] //모든 상품 적용?>
				<input type="radio" name="use" id="use" value="2" <?=($row[CU_USE]=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00128"] //특정 카테고리?>
				<input type="radio" name="use" id="use" value="3" <?=($row[CU_USE]=="3")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00129"] //특정 상품?>
				
				<div id="divUse2" style="<?=($row[CU_USE]=="2")?"":"display:none";?>">
					<select id="cateHCode1" name="cateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"]?></option>
					</select>
					<select id="cateHCode2" name="cateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"]?></option>
					</select>
					<select id="cateHCode3" name="cateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"]?></option>
					</select>
					<select id="cateHCode4" name="cateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"]?></option>
					</select>
					<a class="btn_sml" href="javascript:goGroupExpCateogryInsert();"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용?></strong></a>
					<br>
					<ul id="ulExpCate">
						<?=$strCouponExpCategoryHtml?>
					</ul>
				</div>

				<div id="divUse3" style="<?=($row[CU_USE]=="3")?"":"display:none";?>">
					<a class="btn_sml" href="javascript:goCouponExpProductSearch(<?=$intCU_NO?>);"><strong><?=$LNG_TRANS_CHAR["CW00072"] //상품검색?></strong></a>
					<ul id="ulExpProd">
						<?=$strCouponExpProductHtml?>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00132"] //쿠폰이미지?></th>
			<td>
				<input type="radio" name="img_mth" id="img_mth" value="1" <?=($row[CU_IMG_MTH]=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00130"] //샘플사용?>
				<input type="radio" name="img_mth" id="img_mth" value="2" <?=($row[CU_IMG_MTH]=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00131"] //직접 등록?>

				<div id="divImg1">
					<?=$LNG_TRANS_CHAR["MW00132"] //샘플이미지?>
				</div>

				<div id="divImg2" style="<?=($row[CU_IMG_MTH]=="2")?"":"display:none";?>">
					<input type="file" name="img_file" id="img_file"> 
					<?if ($row[CU_IMG_PATH]){?><a href="javascript:goCouponImgDel();">[x]</a><?}?>
				</div>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00133"] //쿠폰기간?></th>
			<td>
				<input type="radio" name="period" id="period" value="1" <?=($row[CU_PERIOD]=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00136"]; //사용기간지정?>
				<input type="radio" name="period" id="period" value="2" <?=($row[CU_PERIOD]=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00137"]; //발급일로부터 지정?>
				<input type="radio" name="period" id="period" value="3" <?=($row[CU_PERIOD]=="3")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00138"]; //사용하지 않음?>

				<div id="divPeriod1" style="<?=($row[CU_PERIOD]=="1")?"":"display:none";?>">
					<?=$LNG_TRANS_CHAR["CW00073"] //시작일?> <input type="text" <?=$nBox?>  style="width:80px;" id="start_dt" name="start_dt" value="<?=SUBSTR($row[CU_START_DT],0,10)?>" maxlength="10"/>
					<?=$LNG_TRANS_CHAR["CW00074"] //종료일?> <input type="text" <?=$nBox?>  style="width:80px;" id="end_dt" name="end_dt" value="<?=SUBSTR($row[CU_END_DT],0,10)?>" maxlength="10"/>
				</div>

				<div id="divPeriod2" style="<?=($row[CU_PERIOD]=="2")?"":"display:none";?>">
					<?=$LNG_TRANS_CHAR["MW00139"] //발급일로부터 사용기간?> <input type="text" <?=$nBox?>  style="width:30px;" id="use_day" name="use_day" value="<?=$row[CU_USE_DAY]?>" maxlength="10"/>
				</div>


			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00235"] //쿠폰사용제한(주문금액)?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:50px;" id="limit_price" name="limit_price" value="<?=$row[CU_LIMIT_PRICE]?>" maxlength="20"/>
				(<?=$LNG_TRANS_CHAR["MS00037"] //입력한 주문금액이상일때만 쿠폰 사용가능?>)
			</td>
		</tr>
		<!--<tr>
			<th>쿠폰사용제한(결제방법)</th>
			<td>
				<input type="radio" name="limit_settle" id="limit_settle" value="1" <?=($row[CU_LIMIT_SETTLE]=="1")?"checked":"";?>>모든 결제방법
				<input type="radio" name="limit_settle" id="limit_settle" value="2" <?=($row[CU_LIMIT_SETTLE]=="2")?"checked":"";?>>무통장 입금
			</td>
		</tr>//-->
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00145"] //쿠폰적용여부?></th>
			<td>
				<input type="radio" name="useYN" id="useYN" value="Y" <?=($row[CU_USEYN]=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				<input type="radio" name="useYN" id="useYN" value="N" <?=($row[CU_USEYN]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
			</td>
		</tr>

	</table>
	
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:goCouponAct('couponModify');"  id="menu_auth_m" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00003"] //등록?></strong></a>
	<a class="btn_new_gray" href="javascript:C_getMoveUrl('couponList','get','<?=$PHP_SELF?>');"><strong class="ico_calcel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->