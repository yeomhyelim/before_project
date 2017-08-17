<?php
	
	## 언어설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }
	$strLangLower = strtolower($strLang);

	## 홈페이지 주소 필터링
	$strSiteUrl = $S_SITE_URL;
	$strSiteUrl = trim($strSiteUrl, '/');
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00195"]	 //기획전관리?></h2>
		<div class="clr"></div>
	</div>
	<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
	<!-- 언어 선택 탭-->

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap mt20">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00196"]	//기획전명?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?> value="<?=$strSearchKey?>"/>
			<a class="btn_blue_big" href="javascript:goSearch('prodPlanList');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th>기간</th>
				<td>
					<input type="text" id="searchStartDt" value="<?=$_REQUEST['searchStartDt']?>" data-simple-datepicker readOnly style="width:80px"> -
					<input type="text" id="searchEndDt"   value="<?=$_REQUEST['searchEndDt']?>" data-simple-datepicker readOnly  style="width:80px">
					<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchStartDt','searchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchStartDt','searchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchStartDt','searchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchStartDt','searchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchStartDt','searchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
					<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchStartDt','searchEndDt');"><strong>전체</strong></a>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00051"] //사용여부?></th>
				<td>
					<input type="checkbox" id="searchViewY" name="searchViewY" value="Y" <?=($_REQUEST['searchViewY']=="Y")?"checked":"";?>>사용
					<input type="checkbox" id="searchViewN" name="searchViewN" value="N" <?=($_REQUEST['searchViewN']=="N")?"checked":"";?>>미사용
				</td>
			</tr>
		</table>
	</div>

	<div class="tableListWrap mt20">
		<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col/>
				<col/>
				
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th>기획전명</th>
				<th>기간</th>
				<th>사용여부</th>
				<th>관리</th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		{	

						## 링크 
						$strLink = $strSiteUrl . '/' . $strLangLower . '/?menuType=product&mode=planMain&planNo=' . $row['PL_NO'];
	
				/* PHP CODE */
			?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[P_CODE]?>"></td>
				<td><?=$intListNum?></td>
				<td class="prodListInfo">
					<ul>
						<li class="title"><?=$row[PL_NAME]?></li>
						<li><span>링크:</span><a href="<?php echo $strLink;?>" target="_blank"><?=$S_SITE_URL?>/<?php echo $strLangLower;?>/?menuType=product&mode=planMain&planNo=<?=$row['PL_NO']?></a></li>
					</ul>
					
				</td>
				<td><?=SUBSTR($row['PL_START_DT'],0,10)?> ~ <?=SUBSTR($row['PL_END_DT'],0,10)?></td>
				<td><?=($row['PL_USE']=="Y")?"사용중":"미사용";?></td>
				<td>
					<a class="btn_sml" href="javascript:goProdPlanModify(<?=$row['PL_NO']?>,'<?=$strStLng?>');" id="menu_auth_m"><strong><?=$LNG_TRANS_CHAR['CW00003'] // 수정?></strong>
					<a class="btn_sml" href="javascript:goProdPlanDelete(<?=$row['PL_NO']?>);" id="menu_auth_d"><strong><?=$LNG_TRANS_CHAR['CW00004'] // 삭제?></strong>
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goProdPlanWrite();" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->