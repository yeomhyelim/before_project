<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MW00052"] //회원가입관리?></h2>
	<div class="clr"></div>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableFormWrap">
	<table class="tableForm">
		<!-- tr>
			<th><?=$LNG_TRANS_CHAR["MW00040"] //인증절차?></th>
			<td>
				<input type="radio" id="cerity" name="cerity" value="N" <?=($row[J_CERITY]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				<input type="radio" id="cerity" name="cerity" value="Y" <?=($row[J_CERITY]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["MW00051"] //관리자 인증 후 가입?>
			</td>
		</tr -->
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00041"] //재가입기간?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:50px;" id="re_day" name="re_day" maxlength="3" value="<?=$row[J_RE_DAY]?>"/><?=$LNG_TRANS_CHAR["CW00014"] //일?>
				(<?=$LNG_TRANS_CHAR["MS00005"] //회원탈퇴 및 회원 삭제 후 입력하신 기간 이후 재가입 가능합니다.?>)
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00042"] //가입불가ID?></th>
			<td>
				<textarea id="no_id" name="no_id" style="width:50%;height:50px"><?=$row[J_NO_ID]?></textarea>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00043"] //가입시적립금지급유무?></th>
			<td>
				<input type="text" id="point" name="point" style="width:100px;" value="<?=$row[J_POINT]?>"/>
			</td>
		</tr>
		<!-- tr>
			<th><?=$LNG_TRANS_CHAR["MW00044"] //가입시쿠폰지급?></th>
			<td>
				<input type="radio" id="coupon" name="coupon" value="Y" <?=($row[J_COUPON]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				<input type="radio" id="coupon" name="coupon" value="N" <?=($row[J_COUPON]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
			</td>
		</tr -->
		<!--tr>
			<th><?=$LNG_TRANS_CHAR["MW00045"] //가입시그룹?></th>
			<td>
				<select name="joinGroup" id="joinGroup">
				<?
					if (is_array($aryMemberGroup)){
						for($i=0;$i<sizeof($aryMemberGroup);$i++){
							$strSelected = ($row[J_GROUP] == $aryMemberGroup[$i][G_CODE]) ? "selected":"";

							echo "<option value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strSelected.">".$aryMemberGroup[$i][G_NAME]."</option>";
						}
					}
				?>
				</select>
			</td>
		</tr> //-->	
		<!-- tr>
			<th><?=$LNG_TRANS_CHAR["MW00046"] //추천인?></th>
			<td>
				<?=$LNG_TRANS_CHAR["MS00006"] //신규가입회원 지급 금액?> <input type="text" <?=$nBox?>  style="width:100px;" id="rec_point1" name="rec_point1" value="<?=$row[J_REC_POINT1]?>"/>

				<?=$LNG_TRANS_CHAR["MS00007"] //신규가입 추천인 지급 금액?> <input type="text" <?=$nBox?>  style="width:100px;" id="rec_point2" name="rec_point2" value="<?=$row[J_REC_POINT2]?>"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00047"] //실명확인여부?></th>
			<td>
				<input type="radio" id="jumin" name="jumin" value="Y" <?=($row[J_JUMIN]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				<input type="radio" id="jumin" name="jumin" value="N" <?=($row[J_JUMIN]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00048"] //아이핀사용여부?></th>
			<td>
			
				<input type="radio" id="ipin" name="ipin" value="Y" <?=($row[J_IPIN]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				<input type="radio" id="ipin" name="ipin" value="N" <?=($row[J_IPIN]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00049"] //회원그룹노출여부?></th>
			<td>
				<input type="radio" id="group_view" name="group_view" value="Y" <?=($row[J_GROUP_VIEW]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				<input type="radio" id="group_view" name="group_view" value="N" <?=($row[J_GROUP_VIEW]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00050"] //회원휴대폰인증여부?></th>
			<td>
				<input type="radio" id="phone" name="phone" value="Y" <?=($row[J_PHONE]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				<input type="radio" id="phone" name="phone" value="N" <?=($row[J_PHONE]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
			</td>
		</tr>//-->
	</table>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:javascript:goSettingModify();" id="menu_auth_m" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_new_gray" href="#"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->