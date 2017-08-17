
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00096"] //관련상품관리?></h2>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
				<td colspan="3">
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00030"] //검색어?></th>
				<td colspan="3">
					<select name="searchField" id="searchField">
						<option value="N"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
						<option value="C"><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
						<option value="M"><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
						<option value="O"><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
						<option value="D"><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
					</select>
					<input type="text" <?=$nBox?>  style="width:150px;" id="searchKey" name="searchKey"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchStartDt" name="searchLaunchStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchEndDt" name="searchLaunchEndDt" maxlength="10"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepStartDt" name="searchRepStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepEndDt" name="searchRepEndDt" maxlength="10"/>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="./?menuType=product&mode=prodGrpList"><strong><?=$LNG_TRANS_CHAR["CW00022"] //전체?></strong></a>
					</span>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td colspan="3">
					<input type="checkbox" id="searchWebView" name="searchWebView" value="Y"><?=$LNG_TRANS_CHAR["PW00011"] //웹보임?>
					<input type="checkbox" id="searchMobileView" name="searchMobileView" value="Y"><?=$LNG_TRANS_CHAR["PW00012"] //모바일보임?>
					<a class="btn_blue_big" href="javascript:goSearch('prodGrpList');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<div class="tableList">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></th>
				<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></th>
				<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
				<th><?=$LNG_TRANS_CHAR["PW00008"] //출시일?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="9"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
				
				?>
			<tr>
				<td><?=$intListNum?></td>
				<td style="text-align:left">
					<img src="..<?=$row[PM_REAL_NAME]?>" style="width:50px;height:50px;">
					<?=$row[P_NAME]?>
				</td>
				<td><?=$row[P_NUM]?></td>
				<td><?=number_format($row[P_SALE_PRICE])?></td>
				<td><?=number_format($row[P_QTY])?></td>
				<td><?=$row[P_LAUNCH_DT]?></td>
				<td><?=$row[P_REP_DT]?></td>
				<td>
					<a class="btn_blue_sml" href="javascript:goPopup('popProdGrpList','<?=$LNG_TRANS_CHAR["PW00097"]?>',700,700,'&prodCode=<?=$row[P_CODE]?>');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00097"] //관련상품등록?></strong></a>
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate" style="width:300px;margin:20px;">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->