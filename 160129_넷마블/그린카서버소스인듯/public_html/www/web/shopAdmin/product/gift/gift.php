<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00133"] //고객사은품 관리?></h2>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["PW00134"] //설정관리?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00135"] //사은품 사용여부?></th>
				<td>
					<input type="radio" name="gift_use" id="gift_use" value="N" <?=($S_GIFT_USE=="N")?"checked":"";?>> <?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="gift_use" id="gift_use" value="A" <?=($S_GIFT_USE=="A")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00139"] //회원 + 비회원?>
					<input type="radio" name="gift_use" id="gift_use" value="M" <?=($S_GIFT_USE=="M")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00140"] //회원?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00136"] //다중선택 사은품 사용여부?></th>
				<td>
					<input type="radio" name="multi_gift_use" id="multi_gift_use" value="N" <?=($S_MULTI_GIFT_USE=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="multi_gift_use" id="multi_gift_use" value="Y" <?=($S_MULTI_GIFT_USE=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				</td>
			</tr>
			<!--<tr>
				<th><?=$LNG_TRANS_CHAR["PW00137"] //사은품 선택가능한 결제방법?></th>
				<td>
					<input type="radio" name="gift_settle" id="gift_settle" value="A" <?=($S_GIFT_SETTLE=="A")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00141"] //모든결제?>
					<input type="radio" name="gift_settle" id="gift_settle" value="M" <?=($S_GIFT_SETTLE=="M")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00142"] //현금만 결제?>
				</td>
			</tr>//-->
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00138"] //사은품 금액?></th>
				<td>
					<input type="radio" name="gift_price" id="gift_price" value="P" <?=($S_GIFT_PRICE=="P")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00143"] //상품구매금액?>
					<input type="radio" name="gift_price" id="gift_price" value="O" <?=($S_GIFT_PRICE=="O")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00144"] //주문금액?>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goAct('giftSetting');" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["CW00052"] //설정하기?></strong></a>
	</div>
</div>

<div class="tableForm">
	<table>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00145"] //사은품명?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:300px;" id="name" name="name" value=""/>
				<input type="hidden" name="each_use" id="each_use" value="N">
			</td>
		</tr>
		<!--<tr>
			<th><?=$LNG_TRANS_CHAR["PW00146"] //개별 상품기능?></th>
			<td>
				<input type="radio" name="each_use" id="each_use" value="N" checked><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				<input type="radio" name="each_use" id="each_use" value="Y"><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
			</td>
		</tr>//-->
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00147"] //첫구매 사은품?></th>
			<td>
				<input type="radio" name="first_gift" id="first_gift" value="N" checked><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				<input type="radio" name="first_gift" id="first_gift" value="O"><?=$LNG_TRANS_CHAR["PW00159"] //주문기준으로 사용함?>
				<input type="radio" name="first_gift" id="first_gift" value="D"><?=$LNG_TRANS_CHAR["PW00160"] //배송기준으로 사용함?>				
			</td>
		</tr>
		<!--<tr>
			<th><?=$LNG_TRANS_CHAR["PW00148"] //수량별 추가 상품기능?></th>
			<td>
				<input type="radio" name="qty_use" id="qty_use" value="N" checked><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				<input type="radio" name="qty_use" id="qty_use" value="Y"><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
			</td>
		</tr>//-->
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00149"] //구매가격범위?></th>
			<td>
				<input type="text" <?=$nBox?>  style="width:100px;" id="startPrice" name="startPrice" value=""/>
				<select name="price_type" id="price_type">
					<option value="1"><?=$LNG_TRANS_CHAR["PW00157"] //부터(이상)?></option>
					<option value="2"><?=$LNG_TRANS_CHAR["PW00158"] //이상 모든가격?></option>
				</select>
				~
				<input type="text" <?=$nBox?>  style="width:100px;" id="endPrice" name="endPrice" value=""/>
			</td>
		</tr>
		
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00150"] //재고수량?></th>
			<td>
				<input type="radio" name="stock_use" id="stock_use" value="N" checked><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				<input type="radio" name="stock_use" id="stock_use" value="Y"><?=$LNG_TRANS_CHAR["PW00161"] //갯수?>
				<input type="text" <?=$nBox?>  style="width:100px;" id="qty" name="qty" value=""/>
			</td>
		</tr>
		
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00151"] //선택제한?></th>
			<td>
				<input type="radio" name="limit_use" id="limit_use" value="N" checked><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				<input type="radio" name="limit_use" id="limit_use" value="Y"><?=$LNG_TRANS_CHAR["PW00161"] //갯수?>
				<input type="text" <?=$nBox?>  style="width:100px;" id="limit_qty" name="limit_qty" value=""/>
			</td>
		</tr>
		
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00152"] //옵션1?></th>
			<td>
				<table>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00153"] //옵션명?></th>
						<td><input type="text" <?=$nBox?>  style="width:100px;" id="opt_nm1" name="opt_nm1" value=""/></td>
						<th><?=$LNG_TRANS_CHAR["PW00154"] //속성?></th>
						<td><input type="text" <?=$nBox?>  style="width:300px;" id="opt_attr1" name="opt_attr1" value=""/></td>
					</tr>	
				</table>
			</td>
		</tr>
		
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00155"] //옵션2?></th>
			<td>
				<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00153"] //옵션명?></th>
					<td><input type="text" <?=$nBox?>  style="width:100px;" id="opt_nm2" name="opt_nm2" value=""/></td>
					<th><?=$LNG_TRANS_CHAR["PW00154"] //속성?></th>
					<td><input type="text" <?=$nBox?>  style="width:300px;" id="opt_attr2" name="opt_attr2" value=""/></td>
				</tr>	
				</table>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00156"] //사은품이미지?></th>
			<td>
				<input type="file" <?=$nBox?>  id="gift_file" name="gift_file" value=""/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["OW00162"]//사은품 보임?></th>
			<td>
				<input type="radio" name="view" id="view" value="Y" ><?=$LNG_TRANS_CHAR["OW00163"]//면 표시함?>
				<input type="radio" name="view" id="view" value="N" checked><?=$LNG_TRANS_CHAR["OW00164"]//화면 표시 안함?>
			</td>
		</tr>
	</table>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goAct('giftWrite');" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["PW00162"] //사은품 등록?></strong></a>
	</div>
</div>

<div class="tableList">
	<table>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
			<th><?=$LNG_TRANS_CHAR["PW00145"] //사은품명?></th>
			<th><?=$LNG_TRANS_CHAR["OW00165"] //구매시작가?></th>
			<th><?=$LNG_TRANS_CHAR["OW00166"] //구매종료가?></th>
			<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
			<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
		</tr>
		<?
			if ($intTotal > 0) {
				while($giftRow = mysql_fetch_array($result)){
				
		?>
		<tr>
			<td><?=$intListNum?></td>
			<td><?=$giftRow[CG_NAME]?></td>
			<td><?=getFormatPrice($giftRow[CG_ST_PRICE],2)?></td>
			<td><?=($giftRow[CG_PRICE_TYPE]=="2")? "무제한": getFormatPrice($giftRow[CG_END_PRICE],2);?></td>
			<td>
				<?=($giftRow[CG_STOCK]=="N")? "무제한": number_format($giftRow[CG_QTY]);?>
			</td>
			<td>
				<?if ($giftRow[CG_EACH_USE] == "Y"){?>
				<a class="btn_sml" href="javascript:goProdView('<?=$giftRow[CG_NO]?>');"><strong><?=$LNG_TRANS_CHAR["PW00132"]?>(<?=$giftRow[PROD_CNT]?>)</strong></a>
				<a class="btn_sml" href="javascript:goProdSearch('<?=$giftRow[CG_NO]?>');"><strong><?=$LNG_TRANS_CHAR["CW00050"]?></strong></a>
				<?}?>
				<?for($i=0;$i<sizeof($aryUseLng);$i++){?>
					<a class="btn_sml" href="javascript:goModify('<?=$giftRow[CG_NO]?>','<?=$aryUseLng[$i]?>');" id="menu_auth_m"><strong><?=$aryUseLng[$i]?></strong></a>
				<?}?>
				<a class="btn_sml" href="javascript:goDelete('<?=$giftRow[CG_NO]?>');" id="menu_auth_d"><strong><?=$LNG_TRANS_CHAR["CW00004"]?></strong></a>
			</td>
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
<!-******** 컨텐츠 ********* -->