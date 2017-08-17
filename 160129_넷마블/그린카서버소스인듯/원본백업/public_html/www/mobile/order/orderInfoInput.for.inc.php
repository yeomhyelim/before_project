<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm mt10">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00091"] //주문자 정보?></span></div>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00038"] //주문자명(FIRST)?></th>
					<td><input type="input" id="j_f_name" name="j_f_name" class="defInput _w200" maxlength="30" value="<?=$strJFName?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00039"] //주문자명(LAST)?></th>
					<td><input type="input" id="j_l_name" name="j_l_name" class="defInput _w200" maxlength="30" value="<?=$strJLName?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
					<td>
						<input type="input" id="jphone1" name="jphone2" class="defInput _w200" maxlength="30" value="<?=$strJPhone?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
					<td>
						<input type="input" id="jhp1" name="jhp1" class="defInput _w200" maxlength="30" value="<?=$strJHp?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00011"] //이메일?></th>
					<td><input type="email" id="jmail" name="jmail" class="defInput _w200" maxlength="50" value="<?=$strJMail?>"/></td>
				</tr>
			</table>
		</div>
		<!-- tableOrderForm -->						
		<!-- (1) 주문자 정보 -->

		<!-- (2) 베송지 정보 -->
		<div class="tableOrderForm mt30">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00092"] //배송지 정보?></span></div>
			
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00029"] //배송지 확인?></th>
					<td>
						<span>
							<?if ($g_member_no){
								for($i=0;$i<3;$i++){
									if (is_array($aryMemberAddrList)){
										if ($aryMemberAddrList[$i][MA_NO] > 0){
								?>
								<input type="radio" id="basicAddr" name="basicAddr" value="<?=$aryMemberAddrList[$i][MA_NO]?>" <?=($aryMemberAddrList[$i][MA_TYPE]=="1")?"checked":"";?>/> <?=$aryMemberAddrList[$i][MA_NAME]?><?=($aryMemberAddrList[$i][MA_TYPE]=="1")?"(".$LNG_TRANS_CHAR["OW00086"].")":""; //기본배송지?><br/> 
								<?}}}?>
								<input type="radio" id="basicAddr" name="basicAddr" value="Y" onclick=""/><?=$LNG_TRANS_CHAR["OW00088"] //새로입력?>
								<a href="javascript:goMemberAddrList();">[<?=$LNG_TRANS_CHAR["OW00085"] //주소록?>]</a><br/>
							<?} else {?>
								<input type="checkbox" id="jInfoYN" name="jInfoYN" value="Y" onclick="javascript:goOrderDeliveryChk();"/> <?=$LNG_TRANS_CHAR["OS00039"] //주문고객 정보와 동일합니다?> <?}?><br/>
						</span>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00017"] //받는사람명?></th>
					<td><input type="input" id="bname" name="bname" class="defInput _w200" maxlength="50" value="<?=$strJName?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00018"] //전화번호?></th>
					<td>
						<input type="input" id="bphone1" name="bphone1" class="defInput _w200" maxlength="30" value="<?=$strJPhone?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00019"] //핸드폰?></th>
					<td>
						<input type="input" id="bhp1" name="bhp1" class="defInput _w200" maxlength="30" value="<?=$strJHp?>"/>
					</td>
				</tr>
				<!--<tr>
					<th><?=$LNG_TRANS_CHAR["OW00020"] //이메일?></th>
					<td><input type="email" id="bmail" name="bmail" class="defInput _w200" maxlength="50"/></td>
				</tr>//-->

				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00040"] //국가?></th>
					<td>
						<?=drawSelectBoxMore("bcountry",$aryCountryList,$strJCountry,$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?></th>
					<td>
						<input type="input" id="baddr1" name="baddr1" class="defInput _w200"  value="<?=$strJAddr1?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00023"] //상세주소?></th>
					<td>
						<input type="input" id="baddr2" name="baddr2" class="defInput _w200"  value="<?=$strJAddr2?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00041"] //City?></th>
					<td>
						<input type="input" id="bcity" name="bcity" class="defInput _w200"  value="<?=$strJCity?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00042"] //State?></th>
					<td>
						<div id="divState1" <?=($strJCountry=="US")?"style=\"display:none\"":"";?>>
							<input type="input" id="bstate_1" name="bstate_1" class="defInput _w200" maxlength="50" value="<?=($strJState)? $strJState: "N/A";?>"/>
						</div>
						<div id="divState2" <?=($strJCountry!="US")?"style=\"display:none\"":"";?>>
							<?=drawSelectBoxMore("bstate_2",$aryCountryState,$strJState,$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
						</div>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00021"] //우편번호?></th>
					<td>
						<input type="input" id="bzip1" name="bzip1" class="defInput _w200"  value="<?=$strJZip?>"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?> </th>
					<td>
						<textarea name="bmemo" id="bmemo" style="width:100%;height:80px"/></textarea>
					</td>
				</tr>
			</table>
		</div>
		<!-- tableOrderForm -->
		<!-- (2) 배송지 정보 -->