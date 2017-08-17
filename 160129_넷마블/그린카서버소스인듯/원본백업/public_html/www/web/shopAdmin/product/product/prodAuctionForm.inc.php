		<?	if ($S_PRODUCT_AUCTION_USE == "Y" && (substr($strMode,0,11) == "prodAuction"))
			{
				$strProdAucStDt				= $strProdAucStHour			= $strProdAucStMinute	= "";
				$strProdAucEndDt			= $strProdAucEndHour		= $strProdAucEndMinute	= "";
				$intProdAucStPrice			= $intProdAucRightPrice		= "";
				$strProdAucStatus			= "1";
				
				if ($strMode == "prodAuctionModify"){
					$strProdAucStDt			= substr($prodRow['P_AUC_ST_DT'],0,10);
					$strProdAucStHour		= (int)substr($prodRow['P_AUC_ST_DT'],11,2);
					$strProdAucStMinute		= (int)substr($prodRow['P_AUC_ST_DT'],14,2);
					$strProdAucEndDt		= substr($prodRow['P_AUC_END_DT'],0,10);
					$strProdAucEndHour		= (int)substr($prodRow['P_AUC_END_DT'],11,2);
					$strProdAucEndMinute	= (int)substr($prodRow['P_AUC_END_DT'],14,2);

					$intProdAucStPrice		= getCurToPriceSave($prodRow['P_AUC_ST_PRICE'],$S_ST_LNG);
					$intProdAucRightPrice	= getCurToPriceSave($prodRow['P_AUC_RIGHT_PRICE'],$S_ST_LNG);
					$strProdAucStatus		= $prodRow['P_AUC_STATUS'];
				}
			
			?>
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["PW00207"] //경매관리?></h3>
		<table>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00208"] //경매기간?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodAucStDt" name="prodAucStDt" value="<?=$strProdAucStDt?>"/>
					<select name="prodAucStHour" id="prodAucStHour">
						<?for($i=0;$i<24;$i++){?>
						<option value="<?=$i?>" <?=($i==$strProdAucStHour)?"selected":"";?>><?=($i<10)?"0".$i:$i?></option>	
						<?}?>
					</select>
					<select name="prodAucStMinute" id="prodAucStMinute">
						<?for($i=0;$i<60;$i++){?>
						<option value="<?=$i?>" <?=($i==$strProdAucStMinute)?"selected":"";?>><?=($i<10)?"0".$i:$i?></option>	
						<?}?>
					</select>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodAucEndDt" name="prodAucEndDt" value="<?=$strProdAucEndDt?>"/>
					<select name="prodAucEndHour" id="prodAucEndHour">
						<?for($i=0;$i<24;$i++){?>
						<option value="<?=$i?>" <?=($i==$strProdAucEndHour)?"selected":"";?>><?=($i<10)?"0".$i:$i?></option>	
						<?}?>
					</select>
					<select name="prodAucEndMinute" id="prodAucEndMinute">
						<?for($i=0;$i<60;$i++){?>
						<option value="<?=$i?>" <?=($i==$strProdAucEndMinute)?"selected":"";?>><?=($i<10)?"0".$i:$i?></option>	
						<?}?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00209"] //경매시작가?></th>
				<td colspan="3">
					<?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodAucStPrice" name="prodAucStPrice" value="<?=$intProdAucStPrice?>"/>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00210"] //즉시구매가?></th>
				<td colspan="3">
					<?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodAucRightPrice" name="prodAucRightPrice" value="<?=$intProdAucRightPrice?>"/>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00211"] //경매상태?></th>
				<td colspan="3">
					<input type="radio"  value="1" name="prodAucStatus" id="prodAucStatus" <?=($strProdAucStatus=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00212"] //경매시작전?>
					<input type="radio"  value="2" name="prodAucStatus" id="prodAucStatus" <?=($strProdAucStatus=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00213"] //경매중?>
					<input type="radio"  value="3" name="prodAucStatus" id="prodAucStatus" <?=($strProdAucStatus=="3")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00214"] //경매중지?>
					<input type="radio"  value="4" name="prodAucStatus" id="prodAucStatus" <?=($strProdAucStatus=="4")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00215"] //경매완료?>
					<input type="radio"  value="5" name="prodAucStatus" id="prodAucStatus" <?=($strProdAucStatus=="5")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00216"] //경매종료?>
				</td>
			</tr>
		</table>
		<?}?>