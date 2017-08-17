<?
	## 설정
	$listImg		= "";
	$result			= $_REQUEST['result'][$tableName]['listResult'];
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$list_num		= $_REQUEST['result'][$tableName]['pageResult']['list_num'];
	if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):
		if(in_array("listImage", $_REQUEST['BOARD_INFO']['bi_attachedfile_key']) ) { $listImg = 1; } /* 리스트 이미지 사용 할 때 */
	endif;

	## 첨부 파일 정보
	$attachedfileView					= new CommunityAttachedfileView($db, $_REQUEST);

	## 카테고리 설정
	if(in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("A","Y"))):
		$categoryFile	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
		if(is_file($categoryFile)):
			include_once $categoryFile;
		endif;
	endif;

	## 작성자/아이디 암호화 설정
	$intHidden		= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden']; 
?>

	<table class="bbsListTable">
		<thead>
			<tr>
				<!--th><input type="checkbox"></th-->
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
						<th  class="numDiv"><?=$LNG_TRANS_CHAR["CW00006"] //번호?></th>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][5]=="Y"):?>
				<th><?=$LNG_TRANS_CHAR["CW00064"] //카테고리?></th>
				<?endif;?>
				<?if($listImg):?>
					<th  class="listImageDiv"></th>
				<?endif;?>
						<th  class="titleDiv"><?=$LNG_TRANS_CHAR["CW00062"] //제목?></th>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
					<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
							<th  class="writerDiv"><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
					<?endif;?>
					<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
						<th  class="idDiv"><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></th>
					<?endif;?>
					<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][2]=="Y"):?>
						<th  class="idDiv"><?=$LNG_TRANS_CHAR["MW00005"] //닉네임?></th>
					<?endif;?>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]=="Y"):?>
				<th class="rateNum"><?=$LNG_TRANS_CHAR["CW00056"] //평점?></th>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
						<th  class="dateDiv"><?=$LNG_TRANS_CHAR["CW00054"] //작성일?></th>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
						<th class="readDiv"><?=$LNG_TRANS_CHAR["CW00055"] //조회수?></th>
				<?endif;?>
			</tr>
		</thead>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="7" class="noListWrap"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 내용이 없습니다.?></td>
		</tr>
		<? else: 

		   while($row = mysql_fetch_array($result)) :

				## 기본설정
				$strUB_NAME = trim($row['UB_NAME']);
				$strUB_M_ID = trim($row['UB_M_ID']);

				## 작성자 암호화
				if($intHidden):
					$intCnt	= mb_strlen($strUB_NAME, "UTF-8");
					$strUB_NAME = mb_substr($strUB_NAME, 0, $intHidden, "UTF-8");
					for($i=0;$i<3;$i++) { $strUB_NAME .= "*"; }
				endif;
				## 아이디 암호화
				if($intHidden):
					$intCnt	= mb_strlen($strUB_M_ID, "UTF-8");
					$strUB_M_ID = mb_substr($strUB_M_ID, 0, $intHidden, "UTF-8");
					for($i=0;$i<3;$i++) { $strUB_M_ID .= "*"; }
				endif;


			   $aryFunc			= $dataView->getUB_FUNC_DECODER($row);
			   $lock			= $dataView->getLockAuthCheck($row);
			   /*답변 관련*/
//			   if($_REQUEST['buttonLock']['dataAnswer']):
				   $step = "";
				   if($row['UB_ANS_STEP']):
					   $step = explode(",", $row['UB_ANS_STEP']);
					   $step = sizeof($step);
					   $step = str_pad("", $step, " ", STR_PAD_LEFT);	
					   $step = str_replace("", "", $step);
				   endif;
//				endif;
			   /*답변 관련*/
			   /* 링크 권한 설정*/
			   $linkMode = "1";
			   if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use'] == "E"):
					// 무조건 비밀글
					$aryFunc['UB_FUNC_LOCK'] = "Y";
			   endif;
			   if($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "A"):			// 모든회원/비회원=A
					if($aryFunc['UB_FUNC_LOCK'] == "Y"): // 비밀글 인경우
						if($lock['member'] == "1" && $lock['check'] == "1")			{ $linkMode = "1"; }
						else if($lock['member'] == "1" && $lock['check'] == "0")	{ $linkMode = "2"; }
						else														{ $linkMode = "0"; }; 
						## 관리자회원은 페이지 이동
						if($_REQUEST['member_group'] == "001")						{ $linkMode = "1"; }
					endif;
			   elseif($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "M"):		// 회원전용=M
					## 회원 전용 페이지에서 로그인을 하지 않은 회원은 로그인 페이지로 이동					
					if(!$_REQUEST['member_login']) { $linkMode = "2"; }
					else {
						## 비밀글이라면 메시지 출력
						if($aryFunc['UB_FUNC_LOCK'] == "Y") { $linkMode = "3"; }
						## 나의 글이라면 페이지 이동
						if($lock['check'] == 1) { $linkMode = "1"; }
						## 관리자회원은 페이지 이동
						if($_REQUEST['member_group'] == "001") { $linkMode = "1"; }
					}
			   endif;

			   if($linkMode == "1" && $COMMUNITY_LIST_OP[$_REQUEST['b_code']]['SPREAD'] == "Y"):
					// 펼침 기능을 사용하는 경우
					$linkMode = "4";	

					// 첨부파일
					$param = "";
					$param['b_code']	= $_REQUEST['b_code'];
					$param['fl_ub_no']	= $row['UB_NO'];
					$imgResult			= $attachedfileView->getListNoPageEx("OP_LIST", $param);
			   endif;
			   /* 링크 권한 설정*/
		?>
		<tr>
			<!--td><input type="checkbox"></td-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
				<td><?echo $list_num--;?></td>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][5]=="Y"):?>
				<td><?=$CATEGORY_LIST[$row['UB_BC_NO']]['bc_name']?></td>
			<?endif;?>
			<?if($listImg):?>
				<td class="listImg"><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" alt="list image"></td>
			<?endif;?>
			<td class='titleList Qlist'>
				<?if($_REQUEST['b_code'] == "PROD_REVIEW" && $_REQUEST['myTarget'] != "iframe"): // 2013.07.04 kim hee sung 리뷰페이지는 상품 이미지 출력함.?>
					<?if($row['PM_REAL_NAME']):?>
						<a href="./?menuType=product&mode=view&prodCode=<?=$row['UB_P_CODE']?>"><img src="<?=$row['PM_REAL_NAME']?>" class="prodImg"></a>
					<?endif;?>
				<?endif;?>
				<?if($step): // 답변깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png" class="ico_Re"><?endif;?>
				<?if($aryFunc['UB_FUNC_NOTICE']=="Y"): // 공지글?><img src="/himg/board/A0001/icon_bbs_notice.png"><?endif;?>
				<?if($linkMode==0):?>
					<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goDataViewPassMoveEvent('<?=$row['UB_NO']?>')" ><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
				<?elseif($linkMode==1):?>
					<a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')" class="titTxt"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
				<?elseif($linkMode==2):?><? // <a onClick="goLoginPageMoveEvent('S_MAIN_LAYERPOP_LOGIN_USE')"> ?>
					<img src="/himg/board/A0001/icon_bbs_lock.png"> <a href="javascript:void(0);" onClick="if(confirm('로그인 후 이용이 가능합니다. 로그인페이지로 이동 하시겠습니까?')){location.href='./?menuType=member&mode=login';}"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
				<?elseif($linkMode==3):?>
					<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goSecretTextMoveEvent()"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
				<?elseif($linkMode==4):?>
					<a href="javascript:goDataViewMoveEvent2('<?=$row['UB_NO']?>')"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
				<?endif;?>
				<!--2013.07.01 이미지가 있는 경우 이미지 아이콘 표시 -->
				<?if($row['FILE_CNT'] > 0):?>
					<img src="/upload/images/icon_photo.gif"/>
				<?endif;?>
				<!--2013.05.09 코멘트 개수-->
				<?if($_REQUEST['BOARD_INFO']['bi_comment_use']!="N"):?>
				<?if($row['CMT_CNT'] > 0) {?>
					<span class="cntComment">(<?=$row['CMT_CNT']?>)</span>
				<?}?>
				<?endif;?>				
				<!--2013.05.09 코멘트 개수-->	
			</td>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><td><?php echo $strUB_NAME;?></td>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><td><?php echo $strUB_M_ID;?></td>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][2]=="Y"):?>
				<!--작성자(닉네임)--><td><?=$row['M_NICK_NAME']?></td>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]=="Y"):?>
			<!--평점--><td><img src="/himg/board/icon/icon_star_<?=$row['UB_P_GRADE']?>.png"/></td>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
			<!--작성일--><td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
			<!--조회수--><td><?=NUMBER_FORMAT($row['UB_READ'])?></td>
			<?endif;?>
		</tr>
		<?if($linkMode == 4):?>
		<tr id="Alist_<?=$row['UB_NO']?>" style="display:none">
			<td colspan="10" class='Alist'>
				<?while($imgRow = mysql_fetch_array($imgResult)):?>
					<?if(in_array($imgRow['FL_KEY'], array("image"))):?>
				<div class="attImg">
				<img src="<?=$imgRow['FL_DIR'].$imgRow['FL_NAME']?>">
				</div>
					<?endif;?>
				<?endwhile;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full"):?>
					<?=strConvertCut($row['UB_TEXT'],0,"Y")?>
				<?else:?>
					<?=strConvertCut($row['UB_TEXT'],0,"Y")?>
				<?endif;?>	
				<?if($lock['check']==0):?>
				<?else:?>
				<div><a href="javascript:goDataModifyMove2('<?=$row['UB_NO']?>')">[수정]</a>
					 <a href="javascript:goDataDeleteAct2Event('<?=$row['UB_M_NO']?>','<?=$row['UB_NO']?>')">[삭제]</a></div>
				<?endif;?>				
			</td>
		</tr>
		<?endif;?>
		<? endwhile; 
		   endif; ?>
	</table>

	<textarea id="passwordForm" style="display:none;">
		<div id="passwordForm" style="position:absolute;left:0px;top:0px;">
			<ul>
				<li class="title"><?=$LNG_TRANS_CHAR["PS00002"] //비밀번호를 입력해 주세요.?></li>
				<li><input type="password" name="pass_ub_pass" id="pass_ub_pass" check="password"/>
					<a href="javascript:goDataViewPassActEvent();" id="menu_auth_w" class="btnLayerOk"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
					<a href="javascript:goDataViewPassCancelMoveEvent();" id="menu_auth_w" class="btnLayerClose"><span><?=$LNG_TRANS_CHAR["MW00044"] //취소?></span></a></li>
			</ul>
			<input type="hidden" name="pass_ub_no" id="pass_ub_no">
		</div>
	</textarea>

	<textarea id="secretTextForm" style="display:none">
		<div id="secretTextForm" style="position:absolute;left:0px;top:0px;">
			<ul>
				<li>
					<?=$LNG_TRANS_CHAR["PS00017"] //본인의 글만 조회 가능합니다.?>
					<a href="javascript:goSecretTextCancelMoveEvent();" id="menu_auth_w" class="btnLayerClose"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
				</li>
			</ul>
		</div>
	</textarea>