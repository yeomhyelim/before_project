
<input type="hidden" name="ha_no" id="ha_no" value=""/>

<div id="contentArea">
	<div class="contentTop">
		<h2>수기주문목록</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=100/>
				<col width=100/>
				<col width=150/>
				<col width=150/>
				<col />
				<col />
				<col width=150/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th>번호</th>
				<th>주문키</th>
				<th>주문일자</th>
				<th>상품정보</th>
				<th>주문정보</th>
				<th>배송정보</th>
				<th>관리</th>
			</tr>
			<?	if ($intTotal == 0):?>
			<tr>
			<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	else:
					while($row = mysql_fetch_array($orderListResult)):	
						/* 주문내역 가지고 오기*/
						$orderMgr->setO_NO($row[O_NO]);
						$orderMgr->setOC_LIST_ARY("Y");
						$aryOrderCartList = $orderMgr->getOrderCartList($db);				?>
			<tr>
				<td><input type="checkbox" name="chkBox[]" id="chkBox" value="<?=$row['HA_NO']?>" /></td>
				<td><?=$intTotal--?></td>
				<td><?=$row['O_KEY']?></td>
				<td><?=date("Y-m-d", strtotime($row['O_REG_DT']))?></td>
				<td><?=$row['O_J_TITLE']?></td>
				<td style="text-align:left;padding-left:10px;">
				이름 :		<?=$row['O_B_NAME']?> (<?=$row['O_B_PHONE']?>, <?=$row['O_B_HP']?>)
				</td>
				<td style="text-align:left;padding-left:10px;">
				이름 :		<?=$row['O_B_NAME']?>(<?=$row['O_B_PHONE']?>, <?=$row['O_B_HP']?>)<br>
				주소 :		(<?=$row['O_B_ZIP']?>) <?=$row['O_B_ADDR1']?> <?=$row['O_B_ADDR2']?>
				</td>				
				<td>
				</td>
			</tr>
			<?		endwhile;
				endif;
			?>

		</table>
	</div><br>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  


</div>
