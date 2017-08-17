<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00043"] //적립금관리?> <!-- a href="http://www.eumshop.com/shopManual/?c=basic&p=0106" target="_blank"><img src="http://eumshop.co.kr/shopManual/images/common/ico_menual.gif"/></a --></h2>
		<div class="locationWrap">
			<span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00043"] //적립금관리?></strong>
		</div>
		<div class="clr"></div>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm mt20">
		<div class="titInfoTxt">
			<?=$LNG_TRANS_CHAR["BS00050"] //쇼핑몰 운영을 풍부하게 하기위한 포인트 설정 기능입니다.<br>적절할 포인트 정책을 수립하여 등록해 주세요.?>
		</div>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00015"] //사용유무?></th>
				<td>
					<input type="radio" id="point_use1" name="point_use1"  value="Y" <?=($row[S_POINT_USE1]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
					<input type="radio" id="point_use1" name="point_use1"  value="N" <?=($row[S_POINT_USE1]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용하지 않음?>
					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00051"] //쇼핑몰에서 포인트 기능 사용을 원하는 경우 <strong>사용</strong>을 선택해 주세요.?></li>
							<li>* <?=$LNG_TRANS_CHAR["BS00052"] //<strong>사용안함</strong>을 선택한 경우 설정되어 있는 모든 포인트 정책이 적용되지 않습니다.?></li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00044"] //적립금 사용시 <br>상품적립금 지급유무?></th>
				<td>
					<input type="radio" id="point_use2" name="point_use2"  value="Y" <?=($row[S_POINT_USE2]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00050"] //지급?>
					<input type="radio" id="point_use2" name="point_use2"  value="N" <?=($row[S_POINT_USE2]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00051"] //지급하지 않음?>
					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00053"] //포인트를 사용하여 구매할경우 포인트를 지급할지에 대한 설정입니다.?></li>
							<li>* <?=$LNG_TRANS_CHAR["BS00054"] //<strong>지급</strong>을 선택한 경우 포인트금액으로 구매하더라도 상품에 설정된 포인트가 지급됩니다.?></li>
							<li>* <?=$LNG_TRANS_CHAR["BS00055"] //<strong>지급하지 않음</strong> 선택한 경우 포인트 금액을 사용하는 경우 상품에 설정된 포인트가 지급되지 않습니다.?></li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00045"] //적립금지급주문상태?></th>
				<td>
					<input type="radio" id="point_order_status" name="point_order_status"  value="S" <?=($row[S_POINT_ORDER_STATUS]=="S")?"checked":"";?>/>
					<?=$LNG_TRANS_CHAR["BW00052"] //결제완료?><?=$LNG_TRANS_CHAR["BS00056"] //시 포인트 지급?>
					<input type="radio" id="point_order_status" name="point_order_status"  value="D" <?=($row[S_POINT_ORDER_STATUS]=="D")?"checked":"";?>/>
					<?=$LNG_TRANS_CHAR["BW00053"] //배송완료?><?=$LNG_TRANS_CHAR["BS00056"] //시 포인트 지급?>
					<input type="radio" id="point_order_status" name="point_order_status"  value="E" <?=($row[S_POINT_ORDER_STATUS]=="E")?"checked":"";?>/>
					<?=$LNG_TRANS_CHAR["OW00139"] //구매완료?><?=$LNG_TRANS_CHAR["BS00056"] //시 포인트 지급?>
				</td>
			</tr>

			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00046"] //적립금지급기준?></th>
				<td>
					<input type="radio" id="point_st" name="point_st"  value="P" <?=($row[S_POINT_ST]=="P")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00054"] //판매가?>
					<input type="radio" id="point_st" name="point_st"  value="S" <?=($row[S_POINT_ST]=="S")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00055"] //결제가?>
					가 
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> <input type="text"  class="_w50 _txtAlnR" id="point_st_price" name="point_st_price" value="<?=$row[S_POINT_ST_PRICE]?>"/> <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?> <?=$LNG_TRANS_CHAR["BS00057"] //이상 이상일때 적립금을 지급합니다.?>
					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00058"] //상품에서 설정된 포인트를 지급할때 <strong>기준 금액을 설정</strong>합니다.?></li>
							<li>* <?=$LNG_TRANS_CHAR["BS00059"] //설정한 금액 이상일때 포인트가 지급됩니다. <strong>0</strong>으로 입력한경우 무조건 지급됩니다.?></li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00047"] //적립금지급액?></th>
				<td>
					상품등록 시
						<input type="text" id="point_price" name="point_price" value="<?=$row[S_POINT_PRICE]?>" class="_w50 _txtAlnR"/> 
						<select name="point_price_unit" id="point_price_unit" class="_h22">
							<option value="1" <?=($row[S_POINT_PRICE_UNIT]=="1")?"selected":"";?>>%</option>
							<option value="2" <?=($row[S_POINT_PRICE_UNIT]=="2")?"selected":"";?>><?=$S_ST_CUR?></option>
						</select>로 설정하고, 소수점 
						<input type="text" <?=$nBox?>  style="width:30px;" id="point_price_pos" name="point_price_pos" value="<?=$row[S_POINT_PRICE_POS]?>"/>
						이하는 절삭합니다.
					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00060"] //상품에 실제 적용될 포인트의 비율 및 금액을 설정합니다.?></li>
						</ul>
					</div>
				</td>
			</tr>

			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00048"] //적립금최소/최대사용금액?></th>
				<td>
					보유적립금 사용은 최소
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> <input type="text" id="point_min" name="point_min" value="<?=$row[S_POINT_MIN]?>" class="_w50 _txtAlnR"/>  <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?> 이상부터 사용가능하며,
					최대 <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> <input type="text" id="point_max" name="point_max" value="<?=$row[S_POINT_MAX]?>" class="_w50 _txtAlnR"/>  <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?> 까지 한번에 사용 가능합니다.

					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00061"] //보유한 적립금을 사용할 수 있는 <strong>최소금액</strong>과 <strong>최대금액</strong>을 설정합니다.?></li>
						</ul>
					</div>
				</td>
			</tr>
			<!--
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00049"] //쿠폰사용시 적립금 사용유무?></th>
				<td>
					<input type="radio" id="point_coupon_use" name="point_coupon_use"  value="Y" <?=($row[S_POINT_COUPON_USE]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
					<input type="radio" id="point_coupon_use" name="point_coupon_use"  value="N" <?=($row[S_POINT_COUPON_USE]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BW00051"] //지급하지 않음?>
					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00062"] //포인트와 쿠폰을 중복 사용할 것인지 설정합니다.?></li>
						</ul>
					</div>
				</td>
			</tr>
			-->
			<tr>
				<th><?=$LNG_TRANS_CHAR["BS00063"] //첫구매시 포인트 지급?></th>
				<td>
					첫구매 회원에게
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?>
					<input type="text" id="point_order_give" name="point_order_give" value="<?=$row[S_POINT_ORDER_GIVE]?>" class="_w50 _txtAlnR"/> <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
					을 지급합니다.
					<div class="helpTxt">
						<ul>
							<li><?=$LNG_TRANS_CHAR["BS00064"] //* 첫구매 회원에게 이벤트 포인트를 지급하는  설정입니다.?></li>
							<li><?=$LNG_TRANS_CHAR["BS00065"] //* 지급하지 않는경우 <strong>0원</strong>을 설정하세요.?></li>
						</ul>
					</div>
				</td>
			</tr>
		</table>
		
	</div>

	<div class="buttonWrap">
		<a class="btn_Big_Blue" href="javascript:goPointModify();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
<!-- ******** 컨텐츠 ********* -->

	<div class="noticeInfoWrap">
		<ul>
			<li>- <?=$LNG_TRANS_CHAR["BS00081"] //쇼핑몰 전체에 적용할 포인트 설정 기능입니다. ?></li>
			<li>- <?=$LNG_TRANS_CHAR["BS00082"] //상품 구매시 기준을 정하는 기능이며 상품별 별도 포인트 설정은 상품 등록 및 수정에서 가능합니다. ?></li>
			<li>- <?=$LNG_TRANS_CHAR["BS00083"] //회원 기념일 관련하여 포인트 설정이 필요한 경우 여기를 클릭 하세요.  ?></li>
		</ul>
	</div>
</div>