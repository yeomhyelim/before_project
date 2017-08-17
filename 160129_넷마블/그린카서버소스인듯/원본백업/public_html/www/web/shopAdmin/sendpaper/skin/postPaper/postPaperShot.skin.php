<?
	# 쪽지멤버검색
	# postMailShot.skin.php
?>

<input type="hidden" name="pp_no" id="pp_no" value="<?=$intPP_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>쪽지발송관리</h2>
</div>
<br>

<!-- ******** 선택된 쪽지 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>선택된 쪽지</th>
			<td><?=$postPaperRow['PP_TITLE']?></td>
		</tr>	
	</table>
</div>
<!-- ******** 선택된 쪽지 ********* -->

<!-- ******** 멤버 검색폼 ********* -->
<div class="searchTableWrap mt20">
	<div class="searchFormWrap">
		<select name="searchField" id="searchField">
			<option value="I" <?=($strSearchField=="I")?"selected":"";?>><?=$LNG_TRANS_CHAR["CW00024"] //아이디?></option>
			<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00002"] //회원명?></option>
			<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00003"] //이메일?></option>
		</select>
		<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
		<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"]	//검색?></strong></a>
	</div><!-- searchFormWrap -->
	<table>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00004"] //가입일?></th>
			<td colspan="3">
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
				~
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
				<span class="searchWrapImg">
					<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
					<a class="btn_sml" href="./?menuType=member&mode=memberList"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
				</span>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00064"] //최종로그인?></th>
			<td colspan="3">
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchLastLoginStartDt" name="searchLastLoginStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
				~
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchLastLoginEndDt" name="searchLastLoginEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
				<span class="searchWrapImg">
					<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchLastLoginStartDt','searchLastLoginEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
					<a class="btn_sml" href="./?menuType=member&mode=memberList"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
				</span>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00065"] //방문횟수?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:60px;" id="searchVisitStartCnt" name="searchVisitStartCnt" value="<?=$strSearchOutStartDt?>"/>
				~
				<input type="text" <?=$nBox?>  style="width:60px;" id="searchVisitEndCnt" name="searchVisitEndCnt" value="<?=$strSearchOutEndDt?>"/>
			</td>
			<th><?=$LNG_TRANS_CHAR["MW00069"] //성별?></th>
			<td>
				<input type="radio" id="searchSex" name="searchSex" value="" checked><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
				<input type="radio" id="searchSex" name="searchSex" value="">남
				<input type="radio" id="searchSex" name="searchSex" value="">여
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00066"] //메인수신여부?></th>
			<td>
				<input type="radio" id="searchMailYN" name="searchMailYN" value="" checked><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
				<input type="radio" id="searchMailYN" name="searchMailYN" value="">수신
				<input type="radio" id="searchMailYN" name="searchMailYN" value="">수신거부
			</td>
			<th><?=$LNG_TRANS_CHAR["MW00067"] //SMS수신여부?></th>
			<td>
				<input type="radio" id="searchSmsYN" name="searchSmsYN" value="" checked><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
				<input type="radio" id="searchSmsYN" name="searchSmsYN" value="">수신
				<input type="radio" id="searchSmsYN" name="searchSmsYN" value="">수신거부
			</td>
		</tr>
		<tr>
			<th>생년월일</th>
			<td>
				<?=drawSelectBoxDate("searchBirthMonth", 1, 12, 1, "", "", $LNG_TRANS_CHAR["CW00022"],"")?>월
				<?=drawSelectBoxDate("searchBirthDay", 1, 31, 1, "", "", $LNG_TRANS_CHAR["CW00022"],"")?>일
			</td>
			<th><?=$LNG_TRANS_CHAR["MW00070"] //추천인ID?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchRecId" name="searchRecId" maxlength="10" value="<?=$strSearchOutStartDt?>"/>
			</td>
		</tr>

		<!--
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00005"] //탈퇴및삭제일?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchOutStartDt" name="searchOutStartDt" maxlength="10" value="<?=$strSearchOutStartDt?>"/>
				~
				<input type="text" <?=$nBox?>  style="width:100px;" id="searchOutEndDt" name="searchOutEndDt" maxlength="10" value="<?=$strSearchOutEndDt?>"/>
			</td>
		</tr>//-->
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00006"] //그룹?></th>
			<td colspan="3">
				<input type="checkbox" name="searchGroup" id="searchGroup" checked> <?=$LNG_TRANS_CHAR["CW00022"] //전체?>
				<?
					if (is_array($aryMemberGroup)){
						for($i=0;$i<sizeof($aryMemberGroup);$i++){
							$strSelected = ($strSearchGroup == $aryMemberGroup[$i][G_CODE]) ? "selected":"";

							echo "&nbsp;&nbsp;<input type=\"checkbox\" name=\"\" id=\"\" value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strSelected.">".$aryMemberGroup[$i][G_NAME];
						}
					}
				?>
			</td>
		</tr>
	</table>
</div>
<!-- ******** 멤버 검색폼 ********* -->
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableListTopWrap">
	<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["MS00010"],array($intTotal))?><!--총 <strong><?=$intListNum?>명</strong>의 회원이 검색되었습니다.//--></span>
	<!--div class="selectedSort">
		<span class="spanTitle mt5">정렬:</span>
		<select name="pageLine" style="vertical-align:middle;" onchange="javascript:C_getMoveUrl('<?=$strMode?>','get','<?=$PHP_SELF?>');">
			<option value="10">이름정렬▲</option>
			<option value="10">이름정렬▼</option>
		</select>
	</div>
	<div class="selectedSort">
		<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
		<select name="pageLine" style="vertical-align:middle;" onchange="javascript:C_getMoveUrl('<?=$strMode?>','get','<?=$PHP_SELF?>');">
			<option value="10" <? if($intPageLine==10) echo 'selected';?>>10</option>
			<option value="20" <? if($intPageLine==20) echo 'selected';?>>20</option>
			<option value="30" <? if($intPageLine==30) echo 'selected';?>>30</option>
			<option value="40" <? if($intPageLine==40) echo 'selected';?>>40</option>
			<option value="50" <? if($intPageLine==50) echo 'selected';?>>50</option>
			<option value="60" <? if($intPageLine==60) echo 'selected';?>>60</option>
			<option value="70" <? if($intPageLine==70) echo 'selected';?>>70</option>
			<option value="80" <? if($intPageLine==80) echo 'selected';?>>80</option>
			<option value="90" <? if($intPageLine==90) echo 'selected';?>>90</option>
			<option value="100" <? if($intPageLine==100) echo 'selected';?>>100</option>
			<option value="200" <? if($intPageLine==200) echo 'selected';?>>200</option>
		</select>
	</div>
	<div class="clear"></div-->
</div>

<div class="tableForm">
	<table>
		<tr>
			<th><input type="checkbox" id="allCheck"/></th>
			<th>번호</th>
			<th>아이디</th>
			<th>이름</th>
			<th>회원그룹</th>
			<th>이메일</th>
			<th>메일수신여부</th>
			<th>가입일</th>
		</tr>
		<? while($row = mysql_fetch_array($memberListResult)) :  ?>
		<tr>
			<td><input type="checkbox" name="selfCheck[]" value="<?=$row['M_NO']?>"/></td>
			<td><?=$intListNum--?></td>
			<td><?=$row['M_ID']?></td>
			<td><?=$row['M_F_NAME']?> <?=$row['M_L_NAME']?></td>
			<td><?=$row['M_GROUP']?></td>
			<td><?=$row['M_MAIL']?></td>
			<td><?=$row['M_MAILYN']?></td>
			<td><?=date("Y.m.d", strtotime($row['M_REG_DT']))?></td>
		</tr>
		<? endwhile; ?>
	</table>
</div>


<div class="buttonWrap">
	<select name="sendType">
		<option value="A">선택된 회원에게 쪽지를 보냅니다.</option>
		<option value="B">검색된 회원에게 쪽지를 보냅니다.</option>
	</select>
	<a class="btn_blue_big" href="javascript:postPaperShotSendActClickEvent()" id="menu_auth_m" style=""><strong>쪽지보내기</strong></a>
	<a class="btn_big" href="javascript:postPaperViewMoveClickEvent()"><strong>취소</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->