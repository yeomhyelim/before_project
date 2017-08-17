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
				<th colspan="5" style="border-bottom:1px solid #e5e5e5;color:#FFF;">언어</th>
			</tr>
			<tr>
				<th>미국</th>
				<th>중국</th>
				<th>일본</th>
				<th>인도네시아</th>
				<th>프랑스</th>
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
				<?
					for($i=0;$i<sizeof($aryUseLng);$i++){
						if ($aryUseLng[$i] != "KR"){
				?>
				<td>
					<input type="text" name="mn_name_<?=strtolower($aryUseLng[$i])?>_<?=$menuRow01[MN_NO]?>" id="mn_name_<?=strtolower($aryUseLng[$i])?>_<?=$menuRow01[MN_NO]?>" value="<?=$menuRow01["MN_NAME_".$aryUseLng[$i]]?>">
				</td>
				<?}}?>
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
				<?
					for($i=0;$i<sizeof($aryUseLng);$i++){
						if ($aryUseLng[$i] != "KR"){
				?>
				<td>
					<input type="text" name="mn_name_<?=strtolower($aryUseLng[$i])?>_<?=$menuRow02[MN_NO]?>" id="mn_name_<?=strtolower($aryUseLng[$i])?>_<?=$menuRow02[MN_NO]?>" value="<?=$menuRow02["MN_NAME_".$aryUseLng[$i]]?>">
				</td>
				<?}}?>
				
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
				<?
					for($i=0;$i<sizeof($aryUseLng);$i++){
						if ($aryUseLng[$i] != "KR"){
				?>
				<td>
					<input type="text" name="mn_name_<?=strtolower($aryUseLng[$i])?>_<?=$menuRow03[MN_NO]?>" id="mn_name_<?=strtolower($aryUseLng[$i])?>_<?=$menuRow03[MN_NO]?>" value="<?=$menuRow03["MN_NAME_".$aryUseLng[$i]]?>">
				</td>
				<?}}?>
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
	<a class="btn_big" href="javascript:goAct('modify2');"><strong>Modify</strong></a>
</div>