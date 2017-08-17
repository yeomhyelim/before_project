<script type="text/javascript">
<!--

	$(document).ready(function(){
		$("select[name=pageLine]").change(function() {
			var data							= new Array(30);
			data['pageLine']					= $(this).val();
			data['page']						= 1;
			C_getAddLocationUrl(data);	
		});
	});

//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MW00241"] //회원정보?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<?include "search.inc.php";?>
	</div>


			<div class="tableFormWrap">
				<table class="tableForm">
					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<col width="300"/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["EW00132"]//회원수?></th>
						<td><?=number_format($intTotal)?><?=$LNG_TRANS_CHAR["EW00133"]//명?></td>
						<th><?=$LNG_TRANS_CHAR["MW00105"] //이번달 가입한 회원수?></th>
						<td><?=number_format($memberTotRow['TOT_MONTH_CNT'])?></td>
						<th><?=$LNG_TRANS_CHAR["MW00106"] //오늘 가입한회원수?></th>
						<td><?=number_format($memberTotRow['TOT_NOW_CNT'])?></td>
						<td>
							<ul class="listUlWrap">
									<li><a class="btn_excel_big" href="javascript:goExcel('excelMemberList');" id="menu_auth_e" style="display: inline-block;"><strong>Download</strong></a></li>
									<li>
										<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
										<select name="pageLine" style="vertical-align:middle;" >
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
									</li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		</div>

	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col style="width:30px;"/>
				<col style="width:60px;"/>
				<col style="width:80px;"/>
				<col style="width:80px;"/>
				<col style="width:80px;"/>
				<col/>
				<col/>
				<!-- <col style="width:100px;"/> -->
				<col/>
				<col/>
				<col style="width:120px;"/>
			<colgroup/>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>				
				<th><?=$LNG_TRANS_CHAR["ET00001"] //사이트?></th>
				<th>회원구분</th>
				<th><?=$LNG_TRANS_CHAR["MW00002"] //회원명?></th>
				<th><?=$LNG_TRANS_CHAR["CW00024"] //아이디?></th>
				<th><?=$LNG_TRANS_CHAR["MW00003"] //이메일?></th>
				<!-- <th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th> -->
				<th><?=$LNG_TRANS_CHAR["MW00108"] //구매?></th>
				<?if ($strSearchOut == "Y"){?>
					<th><?=$LNG_TRANS_CHAR["MW00109"] //탈퇴/삭제일?></th>
				<?}else{?>
					<th><?=$LNG_TRANS_CHAR["MW00007"] //가입일?></th>
				<?}?>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="10"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){

					$newImg = "";
					if ($row[M_SEX] == "W") $strMemberSexImg = "/shopAdmin/himg/common/photo_img_2.gif";
					else $strMemberSexImg = "/shopAdmin/himg/common/photo_img_1.gif";

					If(!strcmp(substr($row[M_REG_DT],0,10),date("Y-m-d"))) $newImg = "<img src=\"/himg/board/A0001/icon_bbs_new.png\" align=\"absmiddle\">";
				
					$strMemberCateList = $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
					if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){

						$param								= "";
						$param['M_NO']						= $row['M_NO'];
						$param['ORDER_BY']					= "C.C_CODE ASC";
						$param['MEMBER_CATE_MGR_JOIN']		= "Y";
						$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYTOTAL", $param);
						
						if (is_array($aryMemberCateList)){
							foreach($aryMemberCateList as $key => $memberCateRow){
								//if ($key > 0) continue;
								$intMemberCateLevel	= strlen($memberCateRow['C_CODE']) / 3;
								//$strMemberCateList	= "";
								for($i = 1; $i<=3; $i++):
									if($intMemberCateLevel >= $i):
										$strCateCode		 = substr($memberCateRow['C_CODE'], 0, $i*3);
										${"strMemberCateName_".$i} = $MEMBER_CATE[$strCateCode]['C_NAME'];								
									endif;
								endfor;

								$strMemberCateList .= "<li>";
								$strMemberCateList .= $strMemberCateName_1;
								$strMemberCateList .= ($strMemberCateName_2)? " > {$strMemberCateName_2}":"";
								$strMemberCateList .= ($strMemberCateName_3)? " > {$strMemberCateName_3}":"";
								$strMemberCateList .= "</li>";
							}
						}				
					}
					/* 회원 소속 */
				
				?>
			<tr>
				<td><input type="checkbox" name="chkNo[]" id="chkNo[]" value="<?=$row[M_NO]?>"></td>
				<td><?=number_format($intListNum);?></td>
				<td><?=$aryCountryList[$row[M_LNG]];?></td>
				<td><?=$aryGroupName[$row[M_GROUP]];?> </td>
				<td class="alignLeft">
					<strong><?=$row[M_F_NAME]?> <?=$row[M_L_NAME]?></strong><?=$newImg?><?if($strSearchOut == "Y"){ echo "(Memo:{$row['M_OUT_TXT']})"; } // 회원탈퇴사유 ?>
				</td>
				<td class="alignLeft"><?=$row[M_ID]?></td>
				<td class="alignLeft"><a href="javascript:goMemberCrmView('<?=$row['M_NO']?>', 'memberMailSend')"><?=$row[M_MAIL]?></a></td>
				<!-- <td>
					<ul>
						<li>
							<?=$LNG_TRANS_CHAR["MW00176"] //Point?>: <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?> <?=number_format($row['M_POINT']);?><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
						</li>
						<li>
							<a class="btn_sml" href="javascript:goMemberPointWrite(<?=$row[M_NO]?>);" id="menu_auth_p" style="display:none"><span>+/-</span></a><a class="btn_sml" href="javascript:goMemberPointList('<?=$row[M_NO]?>');" id="menu_auth_p" style="display:none"><span><?=$LNG_TRANS_CHAR["CW00070"] //상세?></span></a>
						</li>
					</ul>
				</td> -->
				<td class="alignRight">
						<?if ($strOrderMgrJoin == "Y"){?>
							<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?><?=(!$row['OM_TOT_PRICE'])?0:number_format($row['OM_TOT_PRICE']);?><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
						<?}else{?>
							<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?><?=(!$row['M_BUY_PRICE'])?0:number_format($row['M_BUY_PRICE']);?><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
						<?}?>
				</td>
				<?if ($strSearchOut == "Y"){?>
					<td><?=$row[M_OUT_DT]?><?}else{?><td><?=$row[M_REG_DT]?></td>
				<?}?>
				<td>
					<?if ($strSearchOut == "Y"){?>
						<?if ($row[M_OUT_DAY] < $settingRow['J_RE_DAY']){?>
							<a class="btn_sml" href="javascript:goMemberRecovery(<?=$row[M_NO]?>);" id="menu_auth_e1" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00005"] //복원?></strong></a>
						<?}?>
					<?}else {?>
					<?if ($settingRow[J_CERITY] == "Y" && $row[M_AUTH] != "Y"){?>
						<a class="btn_blue_sml" href="javascript:goMemberAuth(<?=$row[M_NO]?>);" id="menu_auth_e1" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00006"] //승인?></strong></a>
					<?}?>
					</strong></a>
					<!-- a class="btn_sml" href="javascript:goMemberModify('<?=$row[M_NO]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a -->
					<a class="btn_blue_sml" href="javascript:goMemberCrmView('<?=$row[M_NO]?>', 'memberOrderList');" id="menu_auth_m" style="display:none"><strong><?="CRM" //CRM?></strong></a>
					<a class="btn_sml" href="javascript:goMemberDelete('<?=$row[M_NO]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					
					<?}?>
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<!-- tableList -->


			<!-- Pagenate object --> 
				<div class="paginate">  
					<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"goPostPageMoveEvent","")?>  
				</div>  
			<!-- Pagenate object -->

			<div class="buttonBoxWrap">
				<a class="btn_new_blue" href="#"><strong><?=$LNG_TRANS_CHAR["MM00021"] //회원추가등록?></strong></a>
			</div>



			<?if ($strSearchOut == "Y"){?>
			<div class="noticeInfoWrap">
				<ul>
					<li>- <?=$LNG_TRANS_CHAR["MS00048"] //쇼핑몰의 탈퇴/삭제회원을 관리합니다.?> </li>
				</ul>
			</div>
			<?}else{?>
			<div class="noticeInfoWrap">
				<ul>
					<li>- <?=$LNG_TRANS_CHAR["MS00049"] //쇼핑몰의 모든 회원을 관리합니다.?> </li>
					<li>- <?=$LNG_TRANS_CHAR["MS00050"] //회원삭제(탈퇴)시 데이터가 삭제되는것이 아니라 탈퇴 상태로 변경됩니다.  삭제(탈퇴)된 회원은 "회원탈퇴/삭제목록"에서 확인 가능합니다.?> </li>
					<li>- <?=$LNG_TRANS_CHAR["MS00051"] //회원명 또는 CRM버튼을 클릭하시면 해당 회원의 상세정보 및 관리를 하실 수 있습니다.?> </li>
				</ul>
			</div>
			<?}?>
		</div>


</div>



<input type="hidden" name="pp_title"/>
<input type="hidden" name="pp_text"/>
<input type="hidden" name="sendType"/>