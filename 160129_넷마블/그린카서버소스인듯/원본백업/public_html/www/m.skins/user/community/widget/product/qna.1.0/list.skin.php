<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
	if($_REQUEST['myTarget'] == "widget"):
	$field_use		= $_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'];
	endif;
?>
	<table id="data_<?=$_REQUEST['BOARD_INFO']['b_code']?>">
		<colgroup>
			<?if($field_use[0]!="N"):?>
				<col  class="numDiv"/>
			<?endif;?>
				<!--col class="imgDiv"/--><!--2013.04.16 상품 이미지 리스트에서 삭제(회의결과) -->
				<col />
			<?if($field_use[1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<col  class="writerDiv"/>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<col  class="idDiv"/>
				<?endif;?>
			<?endif;?>
			<?if($field_use[4]!="N"): // 점수?>
				<col class="gradeDiv"/>
			<?endif;?>
			<?if($field_use[2]!="N"):?>
				<col  class="dateDiv"/>
			<?endif;?>
			<?if($field_use[3]!="N"):?>
				<col class="readDiv"/>
			<?endif;?>
		</colgroup>
		<tr>
			<!--th><input type="checkbox"></th-->
			<?if($field_use[0]!="N"):?>
					<th><?=$LNG_TRANS_CHAR["CW00006"] //번호?></th>
			<?endif;?>
					<!--th><?=$LNG_TRANS_CHAR["CW00057"] //상품?></th--><!--2013.04.16 상품 이미지 리스트에서 삭제(회의결과) -->
					<th><?=$LNG_TRANS_CHAR["CW00062"] //제목?></th>
			<?if($field_use[1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
						<th><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
						<th><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></th>
				<?endif;?>
			<?endif;?>
			<?if($field_use[4]!="N"): // 점수?>
				<th>평점</th>
			<?endif;?>
			<?if($field_use[2]!="N"):?>
				<th><?=$LNG_TRANS_CHAR["CW00054"] //작성일?></th>
			<?endif;?>
			<?if($field_use[3]!="N"):?>
				<th><?=$LNG_TRANS_CHAR["CW00055"] //조회수?></th>
			<?endif;?>
		</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="8" class="noListWrap"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 내용이 없습니다.?></td>
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
		<tr id="dataList_<?=$_REQUEST['b_code']?>_<?=$row['UB_NO']?>">
			<!--td><input type="checkbox"></td-->
			<?if($field_use[0]!="N"):?>
			<!--번호--><td><?=$list_num--?></td>
			<?endif;?>
			<!--상품이미지--><!--td><img src="<?=$row['PM_REAL_NAME']?>" style="width:70px;height;70px"/></td--><!--2013.04.16 상품 이미지 리스트에서 삭제(회의결과) -->
			<!--제목-->
			<td style="text-align:left;padding-left:10px;">
				<?if($lock['member'] == 1 && $lock['check'] == 0 && $aryFunc['UB_FUNC_LOCK']=="Y"): // 회원글 비밀글?>
				<a href="javascript:alert('권한이 없습니다.')"><img src="/himg/board/A0001/icon_bbs_lock.png"><?=strConvertCut($row['UB_TITLE'],50,'N')?></a>
				<?else:?>
				<a href="javascript:goDataViewMoveEvent('<?=$_REQUEST['b_code']?>','<?=$row['UB_NO']?>')">
					<?if($aryFunc['UB_FUNC_LOCK']=="Y"): // 비밀글?><img src="/himg/board/A0001/icon_bbs_lock.png"><?endif;?>
					<?=strConvertCut($row['UB_TITLE'],50,'N')?>
				</a>
				<?endif;?>
			</td>
			<?if($field_use[1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><td><?=$row['UB_NAME']?></td>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><td><?=$row['UB_M_ID']?></td>
				<?endif;?>
			<?endif;?>
			<?if($field_use[4]!="N"): // 점수?>
			<!--점수--><td><?=$row['UB_P_GRADE']?></td>
			<?endif;?>
			<?if($field_use[2]!="N"):?>
			<!--작성일--><td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<?endif;?>
			<?if($field_use[3]!="N"):?>
			<!--조회수--><td><?=$row['UB_READ']?></td>
			<?endif;?>
		</tr>
		<tr id="dataView_<?=$_REQUEST['b_code']?>_<?=$row['UB_NO']?>" style="display:none">
			<td colspan="8" style="text-align:left;padding-left:50px;">
				<?=strConvertCut($row['UB_TEXT'],0,'N')?>
				<?=strConvertCut($row['UB_TEXT'],0,'N')?>
				<?if($lock['member'] == 1 && $lock['check'] == 0): // 다른 회원이 작성한 글?>
				<?else: // 비회원 혹인 자신 글 ?>
				<div><a href="javascript:goDataModifyMoveEvent('<?=$_REQUEST['b_code']?>','<?=$row['UB_NO']?>')">[수정]</a>
					 <a href="javascript:goDataDeleteActEvent('<?=$_REQUEST['b_code']?>','<?=$row['UB_NO']?>')">[삭제]</a></div>
				<?endif;?>
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

