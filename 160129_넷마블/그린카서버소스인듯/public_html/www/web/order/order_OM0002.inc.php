<!-- (2) 상단 서브 카테고리 -->
<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
<!-- (2) 상단 서브 카테고리 -->

<div class="cartWrap">
		<div class="joinWrap mt20">
		<!-- (1) 기본정보 입력  -->
			<div class="regWrap">
				<table>
					<colgroup>
						<col style="width:110px;"/>
						<col/>
					</colgroup>
					<tr>
						<th>  아이디</th>
						<td><strong><?=$memberRow[M_ID]?></strong></td>
					</tr>
					<tr>
						<th> 비밀번호 </th>
						<td>
							<input type="password" name="pwd1" id="pwd1" class="defInput"/>
							<span>영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용 </span>
						</td>
					</tr>
					<tr>
						<th> 비밀번호 확인 </th>
						<td>
							<input type="password" name="pwd12" id="pwd2" class="defInput"/>
							<span>비밀번호를 한번더 입력해 주세요. </span>
						</td>
					</tr>
					<tr>
						<th> 이름 </th>
						<td><?=$memberRow[M_NAME]?></td>
					</tr>
					<?if ($S_JOIN_NICK_NAME_USE == "Y"){?>
					<tr>
						<th> 닉네임</th>
						<td><?=$memberRow[M_NICK_NAME]?></td>
					</tr>
					<?}?>
					<tr>
						<th> 생년월일/성별</th>
						<td><?=$row[M_BIRTH]?>(<?=($row[M_SEX]=="M")?"남성":"여성";?>)</td>
					</tr>
					<tr>
						<th> 핸드폰 </th>
						<td>				
							<input type="input" id="hp1" name="hp1" class="defInput _w50" maxlength="3" value="<?=$aryHp[0];?>" /> -
							<input type="input" id="hp2" name="hp2" class="defInput _w50" maxlength="4" value="<?=$aryHp[1];?>" /> -
							<input type="input" id="hp3" name="hp3" class="defInput _w50" maxlength="4" value="<?=$aryHp[2];?>"/>
							<span><input type="checkbox" name="smsYN" id="smsYN" value="Y" <?=$arySmsYN;?> /> SMS 정보를 수신합니다. </span>

						</td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>
							<input type="input" id="phone1" name="phone1" class="defInput _w50" maxlength="3" value="<?=$aryPhone[0];?>"/>
							 -
							<input type="input" id="phone2" name="phone2" class="defInput _w50" maxlength="4" value="<?=$aryPhone[1];?>"/> -
							<input type="input" id="phone3" name="phone3" class="defInput _w50" maxlength="4" value="<?=$aryPhone[2];?>"/>
						</td>
					</tr>
					<tr>
						<th> 이메일 </th>
						<td>
							<input type="input" id="mail" name="mail" class="defInput _w300" value="<?=$memberRow[M_MAIL];?>" maxlength="30" />
							<span><input type="checkbox" id="mailYN" name="mailYN" value="Y" <?=$aryMailYN;?>/> 메일 정보를 수신합니다. </span>
						</td>
					</tr>
					<tr>
						<th> 주소 </th>
						<td>
							<dl>
								<dd><input type="input" id="zip1" name="zip1" class="defInput _w30" maxlength="3" value="<?=$aryZip[0];?>" readonly/> - <input type="input" id="zip2" name="zip2" class="defInput _w30" maxlength="3" value="<?=$aryZip[1];?>" readonly/> <a href="javascript:goZip(1);" ><img src="../himg/member/A0001/btn_search_zip.gif"/></a></dd>
								<dd><input type="input" id="addr1" name="addr1" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_ADDR];?>" readonly/></dd>
								<dd><input type="input" id="addr2" name="addr2" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_ADDR2];?>"/></dd>
							</dl>
						</td>
					</tr>
				</table>
			</div><!-- regWrap -->
		<!-- (1) 기본정보 입력  -->

		<!-- (2) 추가정보 입력  -->
		<!-- 2012.07.31 no use
			<h4 class="mt30"><img src="/himg/STL.AT001/member/tit_mem_reg_2.gif"/></h4>
			<div class="regWrap">
				<table>
					<colgroup>
						<col style="width:110px;"/>
						<col/>
					</colgroup>
					<tr>
						<th>결혼여부</th>
						<td><input type="radio" id="weddingYN" name="weddingYN" value="N"/> 미혼 <input type="radio" id="weddingYN" name="weddingYN" value="Y"/> 기혼</td>
					</tr>
					<tr>
						<th>결혼기념일</th>
						<td>
							<input type="input" id="weddingDay1" name="weddingDay1" class="defInput _w50" maxlength="4"/>년
							<input type="input" id="weddingDay2" name="weddingDay2" class="defInput _w30" maxlength="2"/>월
							<input type="input" id="weddingDay3" name="weddingDay3" class="defInput _w30" maxlength="2"/>일
						</td>
					</tr>
					<tr>
						<th>직업</th>
						<td>
							<?=drawSelectBoxMore("job",$aryJob,"",$design ="defSelect",$onchange="",$etc="id=\"job\"",$firstItem="-- 직업선택 --",$html="N")?>
						</td>
					</tr>
					<tr>
						<th>관심분야</th>
						<td>
							<ul>
							<?=drawCheckBoxMulti("concern",$aryConcern,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick="")?>
							</ul>
						</td>
					</tr>
					<tr>
						<th>남기는 말씀</th>
						<td><textarea id="memo" name="memo" class="defInput" style="width:100%;height:50px;"></textarea></td>
					</tr>
				</table>
				<div class="etcBtn"><a href="#">회원탈퇴</a></div>
			</div>
		2012.07.31 no use --!>
			<!-- regWrap -->				
		<!-- (2) 추가정보 입력  -->
	</div><!-- loginFormWrap -->
	<div class="btnCenter">
		<a href="javascript:goMyInfoModify();"><img src="/himg/mypage/A0001/btn_myinfo_modify.gif"/></a>
		<a href="javascript:C_getMoveUrl('buyList','get','<?=$PHP_SELF?>');"><img src="/himg/member/A0001/btn_page_prev.gif"/></a>
		<!--
		<a href="join_form_end.php"><img src="/himg/STL.AT001/mypage/btn_myinfo_modify.gif"/></a>
		<a href="join_form.php"><img src="/himg/STL.AT001/member/btn_page_prev.gif"/></a>
		-->
	</div>
</div>
 <div class="clear"></div>