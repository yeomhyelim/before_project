<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
	$field_use		= $_REQUEST['BOARD_INFO']['bi_datalist_datalist_field_use'];
?>
	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col width=40/>
			<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
			<col width=100/>
			<?endif;?>
			<col />
			<?if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 포인트, 쿠폰 사용중..?>
			<col width=80/>
			<col width=80/>
			<?endif;?>
			<col width=80/>
			<col width=80/>
			<col width=100/>
			<col width=100/>
		</colgroup>
		<tr>
			<th><input type="checkbox" id="checkAll"></th>
			<th>번호</th>
			<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
			<th>카테고리</th>
			<?endif;?>
			<th>제목</th>
			<?if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 포인트, 쿠폰 사용중..?>
			<th>포인트</th>
			<th>쿠폰</th>
			<?endif;?>
			<th>점수</th>
			<th>작성자</th>
			<th>작성일</th>
			<th>조회수</th>
		</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) : 
			$aryFunc	= $dataView->getUB_FUNC_DECODER($row);
			/*답변 관련*/
		   if($_REQUEST['buttonLock']['dataAnswer']):
			   $step = "";
			   if($row['UB_ANS_STEP']):
				   $step = explode(",", $row['UB_ANS_STEP']);
				   $step = sizeof($step);
				   $step = str_pad("", $step, " ", STR_PAD_LEFT);	
				   $step = str_replace(" ", "&nbsp;", $step);
			   endif;
			endif;
		   /*답변 관련*/
		?>
		<tr>
			<td><input type="checkbox" name="check[]" id="check" value="<?=$row['UB_NO']?>"></td>
			<td><?=$list_num--?></td>
			<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
			<td><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/category/include.1.0/combobox.row.inc.skin.php" ?></td>
			<?endif;?>
			<td style="text-align:left;padding-left:10px;">
				<?if($step): // 답변깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png"><?endif;?>
				<?if($aryFunc['UB_FUNC_NOTICE']=="Y"): // 공지글?>[공지]<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_widget_icon_use']=="Y" && $aryFunc['UB_FUNC_ICON_WIDGET']=="Y"): // 위젯글?>[추천]<?endif;?>
				<a href="javascript:goDataViewMove2('<?=$row['UB_NO']?>')"><?=$row['UB_TITLE']?></a>
				<?if($aryFunc['UB_FUNC_LOCK']=="Y")		{ echo "L"; }?>
				<?if($aryFunc['UB_FUNC_ICON']=="Y")		{ echo "I"; }?>
			</td>
			<?if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 포인트, 쿠폰 사용중..?>
			<td><?if($row['UB_PT_NO']){?>발급됨<?}?></td>
			<td><?if($row['UB_CI_NO']){?>발급됨<?}?></td>
			<?endif;?>
			<td><?=$row['UB_P_GRADE']?></td>
			<td><?=$row['UB_NAME']?></td>
			<td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<td><?=$row['UB_READ']?></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>



