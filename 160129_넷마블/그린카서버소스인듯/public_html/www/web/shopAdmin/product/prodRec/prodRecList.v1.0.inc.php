<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00056"]//추천상품관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<? include "search.skin.v1.0.inc.php";?>
	</div>
	
	<div class="tableListWrap">
		<div class="tableListTopWrap">
			<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["PS00028"],array($intTotal))?><!--총 <strong><?=$intListNum?>개</strong>의 상품이 있습니다.//--></span>
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["PW00117"] //목록수?>:</span>
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
				<input type="hidden" name="order" id="order" value="<?=$strProdOrder?>">
			</div>
		<div class="clear"></div>
	</div>

	<div>
		<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col/>
				<col/>
				<col/>
				<col/>
				<?
					for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
					?>
					<col/>
				<?}}?>
				<?
					for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
					?>
					<col/>
				<?}}?>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2">
					<?=$LNG_TRANS_CHAR["PW00002"] //상품명?>
					<a href="javascript:goSearch('ND');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goSearch('NA');" class="btn_down"><span>▼</span></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["PW00026"] //상품우선순위?>
					<a href="javascript:goSearch('OD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goSearch('OA');" class="btn_down"><span>▼</span></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["PW00010"] //상품출력?>
					<a href="javascript:goSearch('VD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goSearch('VA');" class="btn_down"><span>▼</span></a>
				</th>
				<?
					for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
					?>
					<th><?=$aryProdMainDisplayList[$i][IC_NAME]?></th>
				<?}}?>
				<?
					for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
					?>
					<th><?=$aryProdSubDisplayList[$i][IC_NAME]?></th>
				<?}}?>

			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="14"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		{	
						$row[P_NUM] = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
						
						/* 상품공유카테고리리스트 */
						$productMgr->setP_CODE($row[P_CODE]);
						$aryProdShareList  = $productMgr->getProdShareList($db);

						$strProdView = 	($row[P_WEB_VIEW] == "Y" || $row[P_MOBILE_VIEW] == "Y") ? "<img src=\"/shopAdmin/himg/common/ico_w_view_Y.gif\">":"<img src=\"/shopAdmin/himg/common/ico_w_view_N.gif\">"; 

				/* PHP CODE */
			?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[P_CODE]?>"></td>
				<td><?=$intListNum?></td>
				<td style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$row[P_CODE]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clear"></div>
				</td>
				<td><?=$row['P_ORDER']?></td>
				<td><?=$strProdView?></td>
				<?
					for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "prodIcon".($i+1)."_".$row[P_CODE];
					?>
					<td>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="Y" <?=($row["ICON".($i+1)] == "Y") ? "checked":""; ?>>
					</td>
				<?}}?>
				<?
					for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "prodIcon".($i+6)."_".$row[P_CODE];
					?>
					<td>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="Y" <?=($row["ICON".($i+6)] == "Y") ? "checked":""; ?>>
					</td>
				<?}}?>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate mt20">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div class="tableFormWrapmt20">
		<table class="tableForm">
			<tr>
				<td>
					<a class="btn_big" href="javascript:goAutoRecUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR['MS00086']//클릭하신 상품의 추천 상태를 변경하시려면 클릭해주세요.?></strong></a>
				</td>
			</tr>
			<tr>
				<td>
					<?for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "chkIcon".($i+1);
						?>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="Y"><?=$aryProdMainDisplayList[$i][IC_NAME]?>
					<?}}?>
					<?for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "chkIcon".($i+6);
						?>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="Y"><?=$aryProdSubDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
			<tr>
				<td>
					<a class="btn_big" href="javascript:goRecChoick();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00160"]//선택수정?></strong></a>
					<a class="btn_big" href="javascript:goRecAll();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["MM00131"]//일괄수정?></strong></a>
					<a class="btn_big" href="javascript:goRecClear();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["EW00136"]//선택해제?></strong></a>
				</td>
			</tr>
		</table>
	</div>

</div>
<!-- ******** 컨텐츠 ********* -->