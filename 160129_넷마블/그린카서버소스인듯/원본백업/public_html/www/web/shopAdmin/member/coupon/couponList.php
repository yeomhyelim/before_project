<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MW00110"] //쿠폰관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00111"] //쿠폰명?></option>
			</select>
			<input type="text" name="searchKey" id="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchTableWrap -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00110"] //쿠폰 종류?></th>
				<td colspan="3">
					<input type="radio" name="searchCouponIssue" id="searchCouponIssue" value="" <?=(!$strSearchCouponIssue)?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
					<input type="radio" name="searchCouponIssue" id="searchCouponIssue" value="1" <?=($strSearchCouponIssue=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00113"] //회원발급?>
					<!--<input type="radio" name="searchCouponIssue" id="searchCouponIssue" value="2" <?=($strSearchCouponIssue=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00114"] //회원 다운로드?>//-->
					<input type="radio" name="searchCouponIssue" id="searchCouponIssue" value="3" <?=($strSearchCouponIssue=="3")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00115"] //회원 가입시 자동발급?>
					<input type="radio" name="searchCouponIssue" id="searchCouponIssue" value="4" <?=($strSearchCouponIssue=="4")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00116"] //구매 후 자동발급?>
					<input type="radio" name="searchCouponIssue" id="searchCouponIssue" value="6" <?=($strSearchCouponIssue=="6")?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00147"] //오프라인발급?>

				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00110"] //쿠폰 사용여부?></th>
				<td colspan="3">
					<input type="radio" name="searchCouponUse" id="searchCouponUse" value="" <?=(!$strSearchCouponUse)?"checked":"";?>><?=$LNG_TRANS_CHAR["MW00110"] //전체?>
					<input type="radio" name="searchCouponUse" id="searchCouponUse" value="Y" <?=($strSearchCouponUse=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
					<input type="radio" name="searchCouponUse" id="searchCouponUse" value="N" <?=($strSearchCouponUse=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				</td>
			</tr>
		</table>
	</div>
	<!-- 포인트 내역 및 목록수 설정 -->
	<div class="tableListWrap mt20">
		<div class="tableListTopWrap">
			<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["MS00036"],array($intTotal));?></span>
		</div>
		<div class="clear"></div>
	</div>
	<!-- 포인트 내역 및 목록수 설정 -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:8%;">
				<col />
				<col style="width:10%;">
				<col style="width:10%;">
				<col style="width:18%;">
				<col style="width:10%;"/>
				<col style="width:10%;">
				<col style="width:10%;">
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["MW00111"] //쿠폰명?></th>
				<th><?=$LNG_TRANS_CHAR["MW00112"] //쿠폰종류?></th>
				<th><?=$LNG_TRANS_CHAR["MW00118"] //쿠폰금액(율)?></th>
				<th><?=$LNG_TRANS_CHAR["MW00119"] //쿠폰기간?></th>
				<th><?=$LNG_TRANS_CHAR["MW00120"] //쿠폰등록일?></th>
				<th><?=$LNG_TRANS_CHAR["MW00121"] //발급/발급된 수량?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="8"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
			</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){
					
					if ($row[CU_ISSUE] == "1") { $strIssueName = $LNG_TRANS_CHAR["MW00113"]; } //회원발급";
					else if ($row[CU_ISSUE] == "2") { $strIssueName = $LNG_TRANS_CHAR["MW00114"];} //"회원 다운로드";
					else if ($row[CU_ISSUE] == "3") { $strIssueName = $LNG_TRANS_CHAR["MW00115"];} //"회원 가입시 자동발급";
					else if ($row[CU_ISSUE] == "4") { $strIssueName = $LNG_TRANS_CHAR["MW00116"];} //"구매 후 자동발급"
					else if ($row[CU_ISSUE] == "5") { $strIssueName = $LNG_TRANS_CHAR["MW00125"];} //"이벤트발급";
					else if ($row[CU_ISSUE] == "6") { $strIssueName = $LNG_TRANS_CHAR["MW00147"];} //"오프라인발급";
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td class="alignLeft"><?=$row[CU_NAME]?></td>
				<td><span><em><?=$strIssueName?></em></span></td>
				<td><?=$row[CU_PRICE]?><?=($row[CU_PRICE_OFF]=="1")?"%":$S_SITE_ST;?></td>
				<td>
					<?
						if ($row[CU_PERIOD] == "1") { echo SUBSTR($row[CU_START_DT],0,10)." ~ ".SUBSTR($row[CU_END_DT],0,10);}
						else if ($row[CU_PERIOD] == "2") { echo callLangTrans($LNG_TRANS_CHAR["MW00122"],array($row[CU_USE_DAY]));}
						else { echo $LNG_TRANS_CHAR["MW00123"]; }//"기간제한없음";
					?>
				</td>
				<td>
					<?=$row[CU_REG_DT]?>
				</td>
				<td>
					<a href="javascript:goCouponMoveUrl('<?=$row[CU_NO]?>','couponView');" class="btn_inbox_gray _w150"><strong class="ico_chk"><?=$LNG_TRANS_CHAR["MW00126"] //발급관리?> <span>(<?=$row[COUPON_ISSUE_CNT]?>)</span></strong></a>
				</td>
				<td>
					<a class="btn_sml" href="javascript:goCouponMoveUrl('<?=$row[CU_NO]?>','couponModify');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goCouponMoveUrl('<?=$row[CU_NO]?>','couponDelete');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //수정?></strong></a>
				</td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->

	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="./?menuType=member&mode=couponWrite" id="menu_auth_m" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["MM00127"]//쿠폰신규등록?></strong></a>
	</div>
</div>
