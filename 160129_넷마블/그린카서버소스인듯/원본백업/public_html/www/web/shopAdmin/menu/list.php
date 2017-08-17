<div id="contentArea">
	<div class="contentTop">
		<h2>Menu</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<tr>
				<th rowspan="2">1차메뉴</th>
				<th rowspan="2">2차메뉴</th>
				<th rowspan="2">3차메뉴</th>
				<th rowspan="2">순서</th>
				<th rowspan="2">사용여부</th>
				<th colspan="14" style="border-bottom:1px solid #e5e5e5;color:#FFF;">관리</th>
				<th rowspan="2">링크</th>
			</tr>
			<tr>
				<th>목록</th>
				<th>등록</th>
				<th>수정</th>
				<th>삭제</th>
				<th>엑셀</th>
				<th>정산</th>
				<th>SMS</th>
				<th>UPLOAD</th>
				<th>포인트</th>
				<th>기타<BR>기능1</th>
				<th>기타<BR>기능2</th>
				<th>기타<BR>기능3</th>
				<th>기타<BR>기능4</th>
				<th>기타<BR>기능5</th>
			</tr>
			<?
				while ($menuRow01 = mysql_fetch_array($menuRet01)){

					$menuMgr->setMN_HIGH_01($menuRow01[MN_CODE]);
					$menuRet02 = $menuMgr->getList02($db);

			?>
			<tr>
				<td>
					<input type="text" name="mn_name_kr_<?=$menuRow01[MN_NO]?>" id="mn_name_kr_<?=$menuRow01[MN_NO]?>" value="<?=$menuRow01["MN_NAME_KR"]?>">
				</td>
				<td></td>
				<td></td>
				<td><input type="text" name="mn_order_<?=$menuRow01[MN_NO]?>" id="mn_order_<?=$menuRow01[MN_NO]?>" value="<?=$menuRow01[MN_ORDER]?>" style="width:30px"></td>
				<td>
					<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$menuRow01[MN_NO]?>" <?=($menuRow01[MN_USE] == "Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_l_<?=$menuRow01[MN_NO]?>" id="mn_auth_l_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_L]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_w_<?=$menuRow01[MN_NO]?>" id="mn_auth_w_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_W]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_m_<?=$menuRow01[MN_NO]?>" id="mn_auth_m_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_M]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_d_<?=$menuRow01[MN_NO]?>" id="mn_auth_d_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_D]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e_<?=$menuRow01[MN_NO]?>" id="mn_auth_e_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_E]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_c_<?=$menuRow01[MN_NO]?>" id="mn_auth_c_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_C]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_s_<?=$menuRow01[MN_NO]?>" id="mn_auth_s_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_S]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_u_<?=$menuRow01[MN_NO]?>" id="mn_auth_u_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_U]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_p_<?=$menuRow01[MN_NO]?>" id="mn_auth_p_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_P]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e1_<?=$menuRow01[MN_NO]?>" id="mn_auth_e1_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_E1]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e2_<?=$menuRow01[MN_NO]?>" id="mn_auth_e2_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_E2]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e3_<?=$menuRow01[MN_NO]?>" id="mn_auth_e3_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_E3]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e4_<?=$menuRow01[MN_NO]?>" id="mn_auth_e4_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_E4]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e5_<?=$menuRow01[MN_NO]?>" id="mn_auth_e5_<?=$menuRow01[MN_NO]?>" value="Y" <?=($menuRow01[MN_AUTH_E5]=="Y")?"checked":"";?>>
				</td>
				<td><input type="text" name="mn_url_<?=$menuRow01[MN_NO]?>" id="mn_url_<?=$menuRow01[MN_NO]?>" value="<?=$menuRow01[MN_URL]?>" style="width:450px"></td>
			</tr>
			<?	
					while($menuRow02 = mysql_fetch_array($menuRet02)){
						$menuMgr->setMN_HIGH_02($menuRow02[MN_CODE]);
						$menuRet03 = $menuMgr->getList03($db);

					?>
			<tr>
				<td></td>
				<td>
					<input type="text" name="mn_name_kr_<?=$menuRow02[MN_NO]?>" id="mn_name_kr_<?=$menuRow02[MN_NO]?>" value="<?=$menuRow02["MN_NAME_KR"]?>">
				</td>
				<td></td>
				<td><input type="text" name="mn_order_<?=$menuRow02[MN_NO]?>" id="mn_order_<?=$menuRow02[MN_NO]?>" value="<?=$menuRow02[MN_ORDER]?>" style="width:30px"></td>
				<td>
					<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$menuRow02[MN_NO]?>" <?=($menuRow02[MN_USE] == "Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_l_<?=$menuRow02[MN_NO]?>" id="mn_auth_l_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_L]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_w_<?=$menuRow02[MN_NO]?>" id="mn_auth_w_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_W]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_m_<?=$menuRow02[MN_NO]?>" id="mn_auth_m_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_M]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_d_<?=$menuRow02[MN_NO]?>" id="mn_auth_d_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_D]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e_<?=$menuRow02[MN_NO]?>" id="mn_auth_e_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_E]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_c_<?=$menuRow02[MN_NO]?>" id="mn_auth_c_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_C]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_s_<?=$menuRow02[MN_NO]?>" id="mn_auth_s_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_S]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_u_<?=$menuRow02[MN_NO]?>" id="mn_auth_u_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_U]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_p_<?=$menuRow02[MN_NO]?>" id="mn_auth_p_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_P]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e1_<?=$menuRow02[MN_NO]?>" id="mn_auth_e1_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_E1]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e2_<?=$menuRow02[MN_NO]?>" id="mn_auth_e2_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_E2]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e3_<?=$menuRow02[MN_NO]?>" id="mn_auth_e3_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_E3]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e4_<?=$menuRow02[MN_NO]?>" id="mn_auth_e4_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_E4]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e5_<?=$menuRow02[MN_NO]?>" id="mn_auth_e5_<?=$menuRow02[MN_NO]?>" value="Y" <?=($menuRow02[MN_AUTH_E5]=="Y")?"checked":"";?>>
				</td>
				<td><input type="text" name="mn_url_<?=$menuRow02[MN_NO]?>" id="mn_url_<?=$menuRow02[MN_NO]?>" value="<?=$menuRow02[MN_URL]?>" style="width:450px"></td>
			</tr>
					<?	
						while($menuRow03 = mysql_fetch_array($menuRet03)){
					?>
			<tr>
				<td></td>
				<td></td>
				<td>
					<input type="text" name="mn_name_kr_<?=$menuRow03[MN_NO]?>" id="mn_name_kr_<?=$menuRow03[MN_NO]?>" value="<?=$menuRow03["MN_NAME_KR"]?>">
				</td>
				<td><input type="text" name="mn_order_<?=$menuRow03[MN_NO]?>" id="mn_order_<?=$menuRow03[MN_NO]?>" value="<?=$menuRow03[MN_ORDER]?>" style="width:30px"></td>
				<td>
					<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$menuRow03[MN_NO]?>" <?=($menuRow03[MN_USE] == "Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_l_<?=$menuRow03[MN_NO]?>" id="mn_auth_l_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_L]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_w_<?=$menuRow03[MN_NO]?>" id="mn_auth_w_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_W]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_m_<?=$menuRow03[MN_NO]?>" id="mn_auth_m_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_M]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_d_<?=$menuRow03[MN_NO]?>" id="mn_auth_d_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_D]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e_<?=$menuRow03[MN_NO]?>" id="mn_auth_e_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_E]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_c_<?=$menuRow03[MN_NO]?>" id="mn_auth_c_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_C]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_s_<?=$menuRow03[MN_NO]?>" id="mn_auth_s_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_S]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_u_<?=$menuRow03[MN_NO]?>" id="mn_auth_u_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_U]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_p_<?=$menuRow03[MN_NO]?>" id="mn_auth_p_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_P]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e1_<?=$menuRow03[MN_NO]?>" id="mn_auth_e1_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_E1]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e2_<?=$menuRow03[MN_NO]?>" id="mn_auth_e2_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_E2]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e3_<?=$menuRow03[MN_NO]?>" id="mn_auth_e3_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_E3]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e4_<?=$menuRow03[MN_NO]?>" id="mn_auth_e4_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_E4]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e5_<?=$menuRow03[MN_NO]?>" id="mn_auth_e5_<?=$menuRow03[MN_NO]?>" value="Y" <?=($menuRow03[MN_AUTH_E5]=="Y")?"checked":"";?>>
				</td>
				<td><input type="text" name="mn_url_<?=$menuRow03[MN_NO]?>" id="mn_url_<?=$menuRow03[MN_NO]?>" value="<?=$menuRow03[MN_URL]?>" style="width:450px"></td>
			</tr>
					<?
						}
					}
				}
			?>
		</table>
	</div>
	<!-- tableList -->
</div>
<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goMoveUrl('write');" id="menu_auth_w"><strong>Insert</strong></a>
	<a class="btn_big" href="javascript:goAct('modify');"><strong>Modify</strong></a>
</div>