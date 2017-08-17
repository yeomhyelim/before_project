<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MW00140"] //쿠폰발행관리?></h2>
	<div class="clr"></div>
</div>
<!-- ******** 컨텐츠 ********* -->
<div class="tableFormWrap">
	<table class="tableForm">
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00111"] //쿠폰이름?></th>
			<td>
				<?=$row[CU_NAME]?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00112"] //쿠폰발급방식?></th>
			<td>
				<?=($row[CU_ISSUE]=="1")? $LNG_TRANS_CHAR["MW00113"]:""; //"회원발급"?>
				<?=($row[CU_ISSUE]=="2")? $LNG_TRANS_CHAR["MW00114"]:""; //"회원 다운로드"?>
				<?=($row[CU_ISSUE]=="3")? $LNG_TRANS_CHAR["MW00115"]:""; //"회원 가입시 자동발급"?>
				<?=($row[CU_ISSUE]=="4")? $LNG_TRANS_CHAR["MW00116"]:""; //"구매 후 자동발급"?>
				<?=($row[CU_ISSUE]=="5")? $LNG_TRANS_CHAR["MW00125"]:""; //"이벤트발급"?>
				<?=($row[CU_ISSUE]=="6")? $LNG_TRANS_CHAR["MW00147"]:""; //"오프라인발급"?>

			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00118"] //쿠폰금액?></th>
			<td>
				<?=$row[CU_PRICE]?> <?=($row[CU_PRICE_OFF]=="1")?"%":$S_ST_CUR;?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00119"] //쿠폰기간?></th>
			<td>
				<?
					if ($row[CU_PERIOD] == "1") { echo SUBSTR($row[CU_START_DT],0,10)." ~ ".SUBSTR($row[CU_END_DT],0,10);}
					else if ($row[CU_PERIOD] == "2") { echo callLangTrans($LNG_TRANS_CHAR["MW00122"],array($row[CU_USE_DAY]));}
					else { echo $LNG_TRANS_CHAR["MW00123"];}
				?>
			</td>
		</tr>
	</table>
</div>
<div class="buttonBoxWrap">
	<?if ($row[CU_ISSUE]=="1"){?>
		<a href="javascript:goCouponMoveUrl('<?=$row[CU_NO]?>','popCouponMemberSearch');" class="btn_new_blue"><strong class="ico_write"><?=$LNG_TRANS_CHAR["MW00141"] //회원지정발급?></strong></a>
	<?}?>
		<a href="javascript:C_getMoveUrl('couponList','get','<?=$PHP_SELF?>');" class="btn_new_gray"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		<a class="btn_excel_big" href="javascript:goExcel('excelCouponIssueList','<?=$intCU_NO?>');" id="menu_auth_e"><strong>Excel Download</strong></a>
</div>
<div class="tableListWrap mt20">
	<table class="tableList">
		<colgroup>
			<col style="width:8%;">
			<col style="width:15%;">
			<col />
			<col style="width:15%;">
			<col style="width:10%;">
			<col style="width:15%;">
			<col style="width:10%;"/>
		</colgroup>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
			<th><?=$LNG_TRANS_CHAR["MW00142"] //발급코드?></th>
			<th><?=$LNG_TRANS_CHAR["MW00143"] //발급받은 회원정보?></th>
			<th><?=$LNG_TRANS_CHAR["MW00144"] //발급일?></th>
			<th><?=$LNG_TRANS_CHAR["MW00145"] //사용유무?></th>
			<th><?=$LNG_TRANS_CHAR["MW00146"] //사용일자?></th>
			<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
		</tr>
		<!-- (1) -->
		<?if($intTotal=="0"){?>
		<tr>
			<td colspan="7"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
		</tr>		
		<?}?>
		<?
			while($couponIssueRow = mysql_fetch_array($result)){
				if ($S_MEM_CERITY == "1") $strMemberId = $couponIssueRow[M_ID];
				else $strMemberId = $couponIssueRow[M_MAIL];
		?>
		<tr>
			<td><?=$intListNum--?></td>
			<td><?=$couponIssueRow[CI_CODE]?></td>
			<td><?if ($couponIssueRow[M_NO] > 0){?><span><em><?=$couponIssueRow[M_NAME]?>(<?=$strMemberId?>)</em></span><?}?></td>
			<td><?=$couponIssueRow[CI_REG_DT]?></td>
			<td><?=($couponIssueRow[CI_USE]=="Y")? $LNG_TRANS_CHAR["CW00010"]: $LNG_TRANS_CHAR["CW00075"]; //사용/미사용?></td>
			<td><?=$couponIssueRow[CI_USE_DT]?></td>
			<td>
				<a class="btn_sml" href="javascript:goCouponMoveUrl('<?=$couponIssueRow[CI_NO]?>','couponIssueDelete');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
			</td>
		</tr>
		<?
			}
		?>
	</table>
</div>
<!-- Pagenate object --> 
<div class="paginate mt20">  
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
</div>  


<!-- ******** 컨텐츠 ********* -->