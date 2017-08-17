<script type="text/javascript">
<!--
	$(document).ready(function(){	
		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
	});

	function goExcelDownload() {
		var data = new Array(5);
		data['mode']				= "excel";
		data['act']					= "excelMemberAgeStatics";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();

		C_getAddLocationUrl(data);
	}
//-->
</script>
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00080"] //연령별통계?></h2>
	<div class="clr"></div>
</div>

<div id="contentArea">
	<div class="searchTableWrap">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_today.gif"/></a>
						<a href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_week.gif"/></a>
						<a href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_15.gif"/></a>
						<a href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_month.gif"/></a>
						<a href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_2month.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_all.gif"/></a>
					</span>
					<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>

				</td>
			</tr>
			<?	if ($S_FIX_MEMBER_CATE_USE_YN  == "Y" && $a_admin_type != "S"){?>
			<tr>
				<th>소속</th>
				<td>
					<select name="searchNation" id="c_nation">
						<option value=""<?if($_REQUEST['searchNation'] == ""){ echo " selected";}?>>전체</option>
						<?foreach($aryUseLng as $key => $lng):?>
						<option value="<?=$lng?>"<?if($_REQUEST['searchNation'] == $lng){ echo " selected";}?>><?=$S_ARY_COUNTRY[$lng]?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate1" id="c_cate" no="1">
						<option value=""<?if($_REQUEST['searchCate1'] == ""){ echo " selected";}?>>1차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 1) { continue; } 
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate1'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate2" id="c_cate" no="2">
						<option value=""<?if($_REQUEST['searchCate2'] == ""){ echo " selected";}?>>2차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 2) { continue; }	
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate2'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate3" id="c_cate" no="3">
						<option value=""<?if($_REQUEST['searchCate3'] == ""){ echo " selected";}?>>3차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 3) { continue; }
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate3'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate4" id="c_cate" no="4">
						<option value=""<?if($_REQUEST['searchCate4'] == ""){ echo " selected";}?>>4차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 4) { continue; }
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate4'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
				</td>
			</tr>
			<?}?>

		</table>
	</div>

	<div class="right mt10">
		<a class="btn_excel_big" href="javascript:goExcelDownload();" id="menu_auth_e" style="display:none:"><strong>Excel Down</strong></a>
	</div>

	<div class="tableList mt30">
		<table>
			<colgroup>
				<col style="width:80px;"/>				
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th>10</th>
				<th>20</th>
				<th>30</th>
				<th>40</th>
				<th>50</th>
				<th><?=$LNG_TRANS_CHAR["EW00081"] //60이상?></th>
				<th>선택없음</th>
				<th>합계</th>
			</tr>
			<?php if(!$aryMemberList):?>
			<tr>
				<td colspan="8">등록된 내용이 없습니다.</td>
			</tr>
			<?php else:?>
			<?php $arySum = '';?>
			<?php foreach($aryMemberList as $key => $row):

					$row['M_ETC_CNT7'] = $row['M_TOTAL_CNT7'] - ( $row['M_CNT1'] + $row['M_CNT2'] + $row['M_CNT3'] + $row['M_CNT4'] + $row['M_CNT5'] + $row['M_CNT6'] );
			
					$arySum['M_CNT1'] = $arySum['M_CNT1'] + $row['M_CNT1'];
					$arySum['M_CNT2'] = $arySum['M_CNT2'] + $row['M_CNT2'];
					$arySum['M_CNT3'] = $arySum['M_CNT3'] + $row['M_CNT3'];
					$arySum['M_CNT4'] = $arySum['M_CNT4'] + $row['M_CNT4'];
					$arySum['M_CNT5'] = $arySum['M_CNT5'] + $row['M_CNT5'];
					$arySum['M_ORDER_CNT6'] = $arySum['M_ORDER_CNT6'] + $row['M_ORDER_CNT6'];
					$arySum['M_ETC_CNT7'] = $arySum['M_ETC_CNT7'] + $row['M_ETC_CNT7'];
					$arySum['M_TOTAL_CNT7'] = $arySum['M_TOTAL_CNT7'] + $row['M_TOTAL_CNT7'];
			?>
			<tr>
				<td><?php echo $row['M_REG_DT'];?></td>
				<td><?php echo number_format($row['M_CNT1']);?></td>
				<td><?php echo number_format($row['M_CNT2']);?></td>
				<td><?php echo number_format($row['M_CNT3']);?></td>
				<td><?php echo number_format($row['M_CNT4']);?></td>
				<td><?php echo number_format($row['M_CNT5']);?></td>
				<td><?php echo number_format($row['M_ORDER_CNT6']);?></td>
				<td><?php echo number_format($row['M_ETC_CNT7']);?></td>
				<td><?php echo number_format($row['M_TOTAL_CNT7']);?></td>
			</tr>
			<?php endforeach;?>
			<tr>
				<td>합계</td>
				<td><?php echo number_format($arySum['M_CNT1']);?></td>
				<td><?php echo number_format($arySum['M_CNT2']);?></td>
				<td><?php echo number_format($arySum['M_CNT3']);?></td>
				<td><?php echo number_format($arySum['M_CNT4']);?></td>
				<td><?php echo number_format($arySum['M_CNT5']);?></td>
				<td><?php echo number_format($arySum['M_ORDER_CNT6']);?></td>
				<td><?php echo number_format($arySum['M_ETC_CNT7']);?></td>
				<td><?php echo number_format($arySum['M_TOTAL_CNT7']);?></td>
			</tr>
			<?php endif;?>
		</table>
		<p>* 선택없음은 등록된 생년월일이 없거나 잘못 입력된 회원수 입니다.</p>
	</div>
	<!-- tableList -->

	
</div>
