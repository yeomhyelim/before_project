<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00092"] //쿠폰관리?></h2>
		<div class="locationWrap">
			<span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00092"] //쿠폰관리?></strong>
		</div>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00015"] //사용유무?></th>
				<td>
					<input type="radio" id="coupon_use" name="coupon_use"  value="Y" <?=($row[S_COUPON_USE]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
					<input type="radio" id="coupon_use" name="coupon_use"  value="N" <?=($row[S_COUPON_USE]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용하지 않음?>
					<div class="helpTxt">
						<ul>
							<li>* <?=$LNG_TRANS_CHAR["BS00028"] //쇼핑몰에서 쿠폰 기능 사용을 원하는 경우 <strong>사용</strong>을 선택해 주세요.?></li>
							<li>* <?=$LNG_TRANS_CHAR["BS00029"] //<strong>사용안함</strong>을 선택한 경우 설정되어 있는 모든 포인트 정책이 적용되지 않습니다.?></li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00093"] //사용제한?></th>
				<td>
					<ul>
						<li><input type="radio" id="coupon_limit" name="coupon_limit"  value="1" <?=($row[S_COUPON_LIMIT]=="1")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BS00030"] //하나의 주문에 여러개 쿠폰 사용가능 설정?></li>
						<li><input type="radio" id="coupon_limit" name="coupon_limit"  value="2" <?=($row[S_COUPON_LIMIT]=="2")?"checked":"";?>/><?=$LNG_TRANS_CHAR["BS00031"] //하나의 주문에 한개의 쿠폰만 사용가능 설정?></li>
					</ul>
				</td>
			</tr>
		</table>
	</div>

	<div class="buttonWrap">
		<a class="btn_Big_Blue" href="javascript:goCouponModify();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="noticeInfoWrap">
		<ul>
			<li>- <?=$LNG_TRANS_CHAR["BS00032"] //쇼핑몰 전체에 적용할 쿠폰 설정 기능입니다.?> </li>
			<li>- <?=$LNG_TRANS_CHAR["BS00033"] //<strong>쿠폰 생성</strong> 이 필요한 경우 <a href="./?menuType=member&mode=couponWrite">여기를 클릭</a> 하세요. ?></li>
		</ul>
	</div>
</div>