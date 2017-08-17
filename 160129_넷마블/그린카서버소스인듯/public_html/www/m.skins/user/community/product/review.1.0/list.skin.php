<?
	## 설정
	$result			= $_REQUEST['result'][$tableName]['listResult'];
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$list_num		= $_REQUEST['result'][$tableName]['pageResult']['list_num'];
?>
	<table id="data_<?=$_REQUEST['BOARD_INFO']['b_code']?>">
		<colgroup>
			<!--col width=40/-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
			<!--번호--><col width=40/>
			<?endif;?>
			<!--상품이미지--><col width=80/>
			<!--제목--><col />
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><col width=80/>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><col width=80/>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
			<!--작성일--><col width=80/>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
			<!--조회수--><col width=60/>
			<?endif;?>
		</colgroup>
		<tr>
			<!--th><input type="checkbox"></th-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
			<!--번호--><th>번호</th>
			<?endif;?>
			<!--상품이미지--><th>상품</th>
			<!--제목--><th>제목</th>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><th>작성자</th>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><th>아이디</th>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
			<!--작성일--><th>작성일</th>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
			<!--조회수--><th>조회수</th>
			<?endif;?>
		</tr>
		<? if($result <= 0) : ?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) :
			   $aryFunc			= $dataView->getUB_FUNC_DECODER($row);
			   $lock			= $dataView->getLockAuthCheck($row);
			   $intHidden		= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
			   if($intHidden):
			   $row['UB_NAME']	= mb_substr($row['UB_NAME'], 0, $intHidden, "UTF-8");
			   $row['UB_NAME']	= str_pad($row['UB_NAME'], ($intHidden+3), "*");
			   $row['UB_M_ID']	= mb_substr($row['UB_M_ID'], 0, $intHidden, "UTF-8");
			   $row['UB_M_ID']	= str_pad($row['UB_M_ID'], ($intHidden+3), "*");
			   endif;
		?>
		<tr id="dataList_<?=$row['UB_NO']?>">
			<!--td><input type="checkbox"></td-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
			<!--번호--><td><?=$list_num--?></td>
			<?endif;?>
			<!--상품이미지--><td>상품</td>
			<!--제목-->
			<td style="text-align:left;padding-left:10px;">
				<?if($lock['member'] == 1 && $lock['check'] == 0 && $aryFunc['UB_FUNC_LOCK']=="Y"): // 회원글 비밀글?>
				<a href="javascript:alert('권한이 없습니다.')"><img src="/himg/board/A0001/icon_bbs_lock.png"><?=strConvertCut($row['UB_TITLE'],50,'N')?></a>
				<?else:?>
				<a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')">
					<?if($aryFunc['UB_FUNC_LOCK']=="Y"): // 비밀글?><img src="/himg/board/A0001/icon_bbs_lock.png"><?endif;?>
					<?=strConvertCut($row['UB_TITLE'],50,'N')?>
					<?if($lock['member'] && $lock['check']): // 자신글?>[내글]<?endif;?>
				</a>
				<?endif;?>
			</td>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><td><?=$row['UB_NAME']?></td>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><td><?=$row['UB_M_ID']?></td>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
			<!--작성일--><td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
			<!--조회수--><td><?=$row['UB_READ']?></td>
			<?endif;?>
		</tr>
		<tr id="dataView_<?=$row['UB_NO']?>" style="display:none">
			<td colspan="7" style="text-align:left;padding-left:50px;">
				<?=stripslashes($row['UB_TEXT'])?>
				<div><a href="javascript:goDataModifyPopLocationEvent('<?=$row['UB_NO']?>')">[수정]</a>
					 <a href="javascript:goDataDeleteJsonEvent('<?=$row['UB_NO']?>')">[삭제]</a></div>
			</td>
		</tr>
		<? endwhile; 
		   endif; ?>
		<!-- 리스트 폼 -->
		<textarea id="list_form" style="display:none;" alt="리스트">
		<tr id="">
			<!--td><input type="checkbox"></td-->
			<!--번호--><td id="list_num">{list_num}</td>
			<!--상품이미지--><td id="prodImage">상품</td>
			<!--제목--><td style="text-align:left;padding-left:10px;">
						<a href="" id="dataViewShow">
						<span id="ub_title">{ub_title}</span>
						<span id="my_write">[내글]</span>
						</a>
					   </td>
			<!--작성자(성명)--><td id="ub_name">{ub_name}</td>
			<!--작성자(아이디)--><td id="ub_m_id">{ub_m_id}</td>
			<!--작성일--><td id="ub_reg_dt">{ub_reg_dt}</td>
			<!--조회수--><td id="ub_read">{ub_read}</td>
		</tr>
		</textarea>	 
		<!-- 뷰 폼 -->
		<textarea id="view_form" style="display:none;" alt="뷰">
		<tr id="" style="display:none">
			<!--내용--><td colspan="7" style="text-align:left;padding-left:50px;">
						<span id="ub_text"></span>
						<div>
							<a id="dataModifyPopLocation">[수정]</a>
							<a id="dataDeleteJson">[삭제]</a>
						</div>
					   </td>
		</tr>
		</textarea>	
	</table>

