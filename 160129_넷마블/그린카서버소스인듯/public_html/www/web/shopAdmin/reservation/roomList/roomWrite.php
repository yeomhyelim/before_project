<?php
	## 스크립트 설정
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/roomList/roomWrite.js";



?>
<?include "roomList.helper.inc.php"?>
<?include "roomList.script.inc.php"?>
<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">
<div id="contentArea">
	<div class="contentTop">
		<h2>환경설정</h2>
		<div class="clr"></div>
	</div>
	<br>


	<div class="tabRevNav">
		<a href="./?menuType=reservation&mode=basicSet" class="selected">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->



	<div class="tableFo,rWrap">
		<h3>객실기본정보</h3>
		<table class="tableForm">
			<tr>
				<th>객실명</th>
				<td><input type="text" name="r_name"></td>
			</tr>
			<tr>
				<th>객실유형</th>
				<td>
					<select name="r_type">
					<option value="">선택해주세요</option>
					<?while($rowAdd = mysql_fetch_array($resultAdd)){?>
						<?if($rowAdd['AM_TYPE']=="객실유형"){?>
						<option value="<?echo $rowAdd['AM_DEV'];?>"><?echo $rowAdd['AM_DEV'];?></option>
					<?}?>
					<?}?>
					</select>
				</td>
			</tr>
			<tr>
				<th>객실면적</th>
				<td>
					<input type="text" name="area1" class="_w50" onkeyup="goCalcArea1(this)"> ㎡ ≒ <input type="text" name="area2" class="_w50" onkeyup="goCalcArea2(this)"> 평
					<p>하나만 입력해 주세요.</p>
				</td>
			</tr>
			<tr>
				<th>기준/최대인원</th>
				<td>기준 <input type="text" name="r_st_per" class="_w50"> 명 / 최대 <input type="text" name="r_max_per" class="_w50"> 명</td>
			</tr>
			<tr>
				<th>출력여부</th>
				<td>
					<input type="radio" name="r_print">출력함
					<input type="radio" name="r_print">출력안함
				</td>
			</tr>
			<tr>
				<th>출력순서</th>
				<td>
					<input type="text" name="r_order" class="_w50">
				</td>
			</tr>
		</table>

		<h3 class="mt30">객실요금설정</h3>
		<table class="tableList">
			<tr>
				<th rowspan="2">단위(원)</th>
				<th colspan="3">비수기</th>
				<th colspan="3">준성수기</th>
				<th colspan="3">성수기</th>
			</tr>
			<tr>
				<th>주중</th>
				<th>주말</th>
				<th>휴일</th>
				<th>주중</th>
				<th>주말</th>
				<th>휴일</th>
				<th>주중</th>
				<th>주말</th>
				<th>휴일</th>
			</tr>
			<tr>
				<td>객실이용요금</td>
				<td><input type="text" name="r_b_mprice" class="_w50"></td>
				<td><input type="text" name="r_b_wprice" class="_w50"></td>
				<td><input type="text" name="r_b_sprice" class="_w50"></td>
				<td><input type="text" name="r_z_mprice" class="_w50"></td>
				<td><input type="text" name="r_z_wprice" class="_w50"></td>
				<td><input type="text" name="r_z_sprice" class="_w50"></td>
				<td><input type="text" name="r_s_mprice" class="_w50"></td>
				<td><input type="text" name="r_s_wprice" class="_w50"></td>
				<td><input type="text" name="r_s_sprice" class="_w50"></td>
			</tr>
			<tr>
				<td>인원추가요금</td>
				<td colspan="3">1인추가시 <input type="text" name="r_b1_price" class="_w50"></td>
				<td colspan="3">1인추가시 <input type="text" name="r_z1_price" class="_w50"></td>
				<td colspan="3">1인추가시 <input type="text" name="r_s1_price" class="_w50"></td>
			</tr>
		</table>


		<h3 class="mt30">객실시설설정</h3>
		<table class="tableForm">
			<?while($rowComm = mysql_fetch_array($resultComm)){?>
			<?
				$param					= "";
				$param['CG_NO']			= $rowComm['CG_NO'];
			?>
			<tr>
				<th><?echo $rowComm['CG_NAME'];?></th>
				<td>
					<?$resultCode = $reservationMgr->getRoomSetFixView4($db,$param);?>
					<?while($rowCode = mysql_fetch_array($resultCode)){?>
					<input type="checkbox" name="checkBaseSetting[]" value="<?echo $rowCode['CC_NAME_KR'];?>"> <?echo $rowCode['CC_NAME_KR'];?>
					<?}?>
				</td>
			</tr>
			<?}?>
			<tr>
				<th>추가설명문구</th>
				<td>
					<input type="hidden" name="BasicSet">
					<textarea name="r_memo" style="width:100%;height:60px;"></textarea>
				</td>
			</tr>
		</table>

	<h3 class="mt30">객실이미지 등록</h3>
		<table class="tableForm">
			<tr>
				<th>목록이미지</th>
				<td>
					<input type="file" name="r_listimage">
				</td>
			</tr>
			<tr>
				<th>이미지등록</th>
				<td>
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="cp_page_text" style="display:none"></textarea>
				</td>
			</tr>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:void(0);" onclick="goAct();"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
			<a class="btn_new_gray" href="./?menuType=reservation&mode=roomList"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		</div>
</div>
