<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00026"] //주문및결제관리?>
			<!--
			<a href="http://www.eumshop.com/shopManual/?c=basic&p=0105" target="_blank"><img src="http://eumshop.co.kr/shopManual/images/common/ico_menual.gif"/></a></h2>
			-->
			<div class="locationWrap">
				<span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <?=$LNG_TRANS_CHAR["BW00026"] //주문및결제관리?> / <strong><?=$LNG_TRANS_CHAR["BW00095"] //해외배송 설정?></strong>
			</div>
			<div class="clr"></div>
	</div>

	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('order','');"><?=$LNG_TRANS_CHAR["BW00094"] //국내배송 설정?></a>	
		<a href="javascript:javascript:goMoveUrl('orderFor','');" class="selected"><?=$LNG_TRANS_CHAR["BW00095"] //해외배송 설정?></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["BW00029"] //배송정책?></h3>
		<table>

			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00030"] //기본배송비?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> <input type="text" <?=$nBox?> style="width:50px;text-align:right;" id="delivery_free" name="delivery_free" value="<?=$row[S_DELIVERY_FREE_FOR]?>"/><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?> <?=$LNG_TRANS_CHAR["BS00047"] //일때 배송비 무료, 이하인경우?>
					<?=$LNG_TRANS_CHAR["BW00042"] //기본 배송비 금액?> : <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> <input type="text" <?=$nBox?> style="width:50px;text-align:right;" id="delivery_fee" name="delivery_fee" value="<?=$row[S_DELIVERY_FEE_FOR]?>"/><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?> <?=$LNG_TRANS_CHAR["BW00098"] //배송비 적용?>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00003"] //총 주문금액이 배송비 기준 금액으로 무료 금액이상일때는 배송비 무료, 미만일때는 배송비를 부과합니다.?>
					</div>
				</td>
			</tr>

			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00032"] //해외 배송 택배사 선택?></th>
				<td>
					<ul class="deliveryCompany">
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="013" <?=($aryDeliveryCom["013"])?"checked":"";?>> EMS</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="014" <?=($aryDeliveryCom["014"])?"checked":"";?>> K-Packet</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="015" <?=($aryDeliveryCom["015"])?"checked":"";?>> RR Register</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="016" <?=($aryDeliveryCom["016"])?"checked":"";?>> Air Parcel</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="017" <?=($aryDeliveryCom["017"])?"checked":"";?>> DHL</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="018" <?=($aryDeliveryCom["018"])?"checked":"";?>> TNT</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="019" <?=($aryDeliveryCom["019"])?"checked":"";?>> UPS</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="020" <?=($aryDeliveryCom["020"])?"checked":"";?>> FedEx</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="021" <?=($aryDeliveryCom["021"])?"checked":"";?>> 하나택배</li>

						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="022" <?=($aryDeliveryCom["022"])?"checked":"";?>> 사가와택배</li>

						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="023" <?=($aryDeliveryCom["023"])?"checked":"";?>> 순풍택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="024" <?=($aryDeliveryCom["024"])?"checked":"";?>> 원통택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="025" <?=($aryDeliveryCom["025"])?"checked":"";?>> 중퉁택배</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="026" <?=($aryDeliveryCom["026"])?"checked":"";?>> airmail</li>
						<li><input type="checkbox" name="delivery_com_chk[]" id="delivery_com_chk[]" value="027" <?=($aryDeliveryCom["027"])?"checked":"";?>> 윈다택배</li>
					</ul>
				</td>
			</tr>
		</table>
		<br/>
		<h3><?=$LNG_TRANS_CHAR["BW00033"] //은행계좌설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00034"] //계좌번호?></th>
				<td>
					<textarea name="for_bank" id="for_bank" style="width:50%;height:50px"><?=$row[S_FOR_BANK]?></textarea>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["BS00048"] //무통장입금을 사용하는 경우 계좌정보를 입력해 주세요.?><br>
						* <?=$LNG_TRANS_CHAR["BS00049"] //여러개의 통장정보가 있는경우 콤마(,)로 구분하여 입력해 주세요.?>
					</div>
				</td>
			</tr>
		</table>
		<br>
		<h3><?=$LNG_TRANS_CHAR["BW00035"] //결제방법설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00039"] //해외 PG사?></th>
				<td>
					<input type="checkbox" id="" name="for_pg"  value="Y" <?=($aryForPg[0]=="Y")?"checked":"";?>/>페이팔
					<input type="checkbox" id="" name="for_pg_card" value="X" <?=($aryForPg[1]=="X")?"checked":"";?>/> 국제카드결제
					<input type="checkbox" id="" name="for_alypay"  value="R" <?=($aryForPg[2]=="R")?"checked":"";?>/> 알리페이
					<input type="checkbox" id="" name="for_pg_bank" value="B" <?=($aryForPg[3]=="B")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00060"] //무통장입금?>

					<div class="helpTxtGray mt5">
						* <?=$LNG_TRANS_CHAR["BS00006"] //페이팔 결제 서비스는 한국어외 <strong>다국어 신청시 가능 서비스</strong> 입니다.?>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="buttonWrap">
		<a class="btn_Big_Blue" href="javascript:goOrderForModify();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
</div>