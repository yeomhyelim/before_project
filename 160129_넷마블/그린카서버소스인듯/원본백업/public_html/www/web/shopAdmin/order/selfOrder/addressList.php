
<input type="hidden" name="ha_no" id="ha_no" value=""/>

<div id="contentArea">
	<div class="contentTop">
		<h2>주소록 관리</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=40/>
				<col width=100/>
				<col width=100/>
				<col />
				<col width=150/>
				<col width=150/>
				<col width=120/>	
				<col width=300/>
				<col width=100/>
				<col width=100/>
				<col width=205/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th>번호</th>
				<th>그룹</th>
				<th>성명</th>
				<th>주소</th>
				<th>이메일</th>
				<th>연락처</th>
				<th>휴대폰</th>
				<th>메모</th>
				<th>최근작성일</th>
				<th>관리</th>
			</tr>
			<?	if ($intTotal == 0):?>
			<tr>
			<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	else:
					while($row = mysql_fetch_array($orderHandAddrResult)):	
					if(!$row['AG_NAME']) { $row['AG_NAME']= "-"; }				?>
			<tr>
				<td><input type="checkbox" name="chkBox[]" id="chkBox" value="<?=$row['HA_NO']?>" /></td>
				<td><?=$intTotal--?></td>
				<td><?=$row['AG_NAME']?></td>
				<td><?=$row['HA_NAME']?></td>
				<td style="text-align:left;padding-left:10px;">우편번호 : <?=$row['HA_ZIP']?><br>
					주소 : <?=$row['HA_ADDR1']?> <?=$row['HA_ADDR2']?>
				</td>
				<td><?=$row['HA_EMAIL']?></td>
				<td><?=$row['HA_PHONE1']?></td>
				<td><?=$row['HA_PHONE2']?></td>
				<td style="text-align:left;padding-left:10px;"><?=$row['HA_MEMO']?></td>
				<td><?=date("Y-m-d", strtotime($row['HA_MOD_DT']))?></td>
				<td><a class="btn_sml" href="javascript:goAddressModifyMove('<?=$row['HA_NO']?>');"><strong>수정</strong></a>
					<a class="btn_sml" href="javascript:goAddressDeleteAct('<?=$row['HA_NO']?>');"><strong>삭제</strong></a>
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

	<!-- Pagenate object --> 
	<a class="btn_big" href="javascript:goAddressWriteMove();"><strong>주소록 등록</strong></a>
</div>
