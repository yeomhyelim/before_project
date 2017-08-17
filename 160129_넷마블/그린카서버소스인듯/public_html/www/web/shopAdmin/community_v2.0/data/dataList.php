<?php
	## 스크립트 설정
	$aryScriptEx[] = "./common/js/community_v2.0/data/dataList.js";
?>
<div class="contentTop">
	<h2><?php echo $strB_NAME;?></h2>
	<div class="clr"></div>
</div>

<br>

<!--
<div class="tabImgWrap">
<?php// include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>
<br>
<?php include MALL_HOME . "/web/shopAdmin/include/tab_language.inc.php";?>
-->

<div class="tableListWrap">
	<input type="hidden" name="b_code" value="<?php echo $strBCode;?>">
	<table  class="tableList">
		<colgroup>
			<col width="40/">
			<col width="80/">
			<?php if(in_array("상품이미지", $aryColumn)):?>
			<col width="80/">
			<?php endif;?>
			<?php if(in_array("리스트이미지", $aryColumn)):?>
			<col width="80/">
			<?php endif;?>
			<?php if(in_array("카테고리", $aryColumn)):?>
			<col width="100/">
			<?php endif;?>
			<col>
			<?php if(in_array("점수", $aryColumn)):?>
			<col width="80/">
			<?php endif;?>
			<col width="180/">
			<col width="150/">
			<!--
			<?php if(in_array("조회수", $aryColumn)):?>
				<col width="80/">
			<?php endif;?>
			-->
		</colgroup>
		<tbody>
			<tr>
				<th><input type="checkbox" id="chkAll" data_target="check"></th>
				<th><?= $LNG_TRANS_CHAR["CW00009"]; //번호 ?></th>
				<?php if(in_array("상품이미지", $aryColumn)):?>
				<th>상품</th>
				<?php endif;?>
				<?php if(in_array("리스트이미지", $aryColumn)):?>
				<th>이미지</th>
				<?php endif;?>
				<?php if(in_array("카테고리", $aryColumn)):?>
				<th>카테고리</th>
				<?php endif;?>
				<th><?= $LNG_TRANS_CHAR["MW00158"]; //제목 ?></th>
				<?php if(in_array("점수", $aryColumn)):?>
				<th>점수</th>
				<?php endif;?>
				<th><?= $LNG_TRANS_CHAR["BW00189"]; //작성자 ?></th>
				<th><?= $LNG_TRANS_CHAR["BW00190"]; //작성일 ?></th>
				<!--
				<?php if(in_array("조회수", $aryColumn)):?>
				<th><?= $LNG_TRANS_CHAR["BW00191"]; //조회수 ?></th>
				<?php endif;?>
				-->

			</tr>
			<?php if(!$intTotal):?>
			<tr>
				<td colspan="9"><?= $LNG_TRANS_CHAR["BS00088"]; //내용이 없습니다. ?></td>
			</tr>
			<?php else:?>
			<?php while($row = mysql_fetch_array($resResult)):

						## 기본 설정
						$intUB_NO = $row['UB_NO'];
						$intUB_BC_NO = $row['UB_BC_NO'];
						$strUB_NAME = $row['UB_NAME'];
						$intUB_M_NO = $row['UB_M_NO'];
						$strUB_M_ID = $row['UB_M_ID'];
						$strMM_NICK_NAME = $row['MM_NICK_NAME'];
						$strUB_TITLE = $row['UB_TITLE'];
						$strUB_TEXT = $row['UB_TEXT'];
						$strUB_REG_DT = $row['UB_REG_DT'];
						$intUB_READ = $row['UB_READ'];
						$strP_CODE = $row['UB_P_CODE'];
						$intUB_P_GRADE = $row['UB_P_GRADE'];
						$strUB_DEL = $row['UB_DEL'];
						$strFL_DIR = $row['FL_DIR'];
						$strFL_NAME = $row['FL_NAME'];
						$intUB_ANS_NO = $row['UB_ANS_NO'];
						$intUB_ANS_DEPTH = $row['UB_ANS_DEPTH'];
						$strUB_ANS_STEP = $row['UB_ANS_STEP'];
						$intUB_ANS_M_NO = $row['UB_ANS_M_NO'];
						$strUB_FUNC = $row['UB_FUNC'];
						$strPM_REAL_NAME = $row['PM_REAL_NAME'];
						$strFL_DIR = $row['FL_DIR'];
						$strFL_NAME = $row['FL_NAME'];

						## UB_FUNC 설정(0~9)
						$aryFunc = "";
						$strFuncNotice = $strUB_FUNC[0]; // 공지글
						$strFuncLock = $strUB_FUNC[1]; // 비밀글
						$strFuncText = $strUB_FUNC[2]; // text
					//	$aryFunc[] = $strUB_FUNC[3]; // 대기
					//	$aryFunc[] = $strUB_FUNC[4]; // 대기
					//	$aryFunc[] = $strUB_FUNC[5]; // 대기
					//	$aryFunc[] = $strUB_FUNC[6]; // 대기
					//	$aryFunc[] = $strUB_FUNC[7]; // 대기
					//	$aryFunc[] = $strUB_FUNC[8]; // 대기
					//	$aryFunc[] = $strUB_FUNC[9]; // 대기

						## 제목 설정
						if($intBI_DATALIST_TITLE_LEN):
							$strUB_TITLE = strHanCutUtf2($strUB_TITLE, 50);
						endif;

						## 카테고리 설정
						$strCategoryName = $aryCategoryList[$intUB_BC_NO]['bc_name'];

						## 작성일 설정
						$strUB_REG_DT = date("Y.m.d", strtotime($strUB_REG_DT));

						## 조회수 설정
						$strUB_READ = number_format($intUB_READ);

						## 상품이미지 설정
						if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img2.png"; }

						## 첨부파일 설정
						$strListImage = "";
						if($strFL_DIR && $strFL_NAME) { $strListImage = "{$strFL_DIR}/{$strFL_NAME}"; }

						## 답변 표시
						$strAnsHtml = "";
						$isAnswer = false; // 답변글인경우 true 변경됩니다.
						$isPGrade = true; // 평점은 답변인경우 출력하지 않습니다.
						if($intUB_ANS_DEPTH > 1):
							$strAnsHtml = str_pad("", $intUB_ANS_DEPTH, " ");
							$strAnsHtml = str_replace(" ", "&nbsp;", $strAnsHtml);
							$strAnsHtml = "{$strAnsHtml}<img src='/himg/community/comment/ico_reply.png'> ";

							$isPGrade = false;
							$isAnswer = true;
						endif;

						## 내용 설정
						## 모바일에서 글작성을 하면, html 편집기로 작성을 하지 않기 때문에, 엔터값(\n) 을 br 테그로 변환 해줘야 합니다.
						if($strFuncText == "Y"):
							$strUB_TEXT = strConvertCut2($strUB_TEXT, 0, "N");
						endif;
			?>
			<tr list-idx="<?php echo $intUB_NO;?>">
				<td><input type="checkbox" name="check[]" id="check" value="<?php echo $intUB_NO;?>"></td>
				<td><?php echo $intListNum--;?></td>
				<?php if(in_array("상품이미지", $aryColumn)):?>
				<td><a href="/<?php echo $strLangLower;?>/?menuType=product&mode=view&prodCode=<?php echo $strP_CODE;?>" target="_blank"><img src="<?php echo $strPM_REAL_NAME;?>" style="width:70px;height:70px;"></a></td>
				<?php endif;?>
				<?php if(in_array("리스트이미지", $aryColumn)):?>
				<td><img src="<?php echo $strListImage;?>" style="width:70px;height:70px;"></td>
				<?php endif;?>
				<?php if(in_array("카테고리", $aryColumn)):?>
				<td><?php echo $strCategoryName;?></td>
				<?php endif;?>
				<td style="text-align:left;padding-left:10px;">
					<?php echo $strAnsHtml;?><a href="javascript:void(0);" onclick="goCommunityDataListViewMoveEvent('<?php echo $intUB_NO;?>')"><?php echo $strUB_TITLE;?></a><?=$strFuncNotice=='Y'? '&nbsp; - <b>'.$LNG_TRANS_CHAR["BW00196"].'</b>'  :''?>
					<p class="btn_sView"><a href="javascript:void(0);" onclick="goCommunityDataListTextToggleEvent(<?php echo $intUB_NO;?>)" class="btn_sml"><span style="letter-spacing:0px">Open Content</span></a></p>
				</td>
				<?php if(in_array("점수", $aryColumn)):?>
				<td><?php if($isPGrade):?>
					<img src="/himg/board/icon/icon_star_<?php echo $intUB_P_GRADE;?>.png"/>
					<?php endif;?>
				</td>
				<?php endif;?>
				<td class="txtLeft">
					<?if($isBtnUseCrn):?>
					<a href="javascript:void(0);" onclick="goCommunityDataListCrmViewEvent(<?php echo $intUB_M_NO;?>);" class="btn_blue_sml"><span>CRM</span></a>
					<?php endif;?>
					<?php echo $strUB_NAME;?>
				</td>
				<td><?php echo $strUB_REG_DT;?></td>
				<!--
				<?php if(in_array("조회수", $aryColumn)):?>
					<td><?php echo $strUB_READ;?></td>
				<?php endif;?>
				-->

			</tr>
			<tr text-idx="<?php echo $intUB_NO;?>" class="hide">
				<td colspan="9" class="bbs_open_view"><?php echo $strUB_TEXT;?></td>
			</tr>
			<?php endwhile;?>
			<?php endif;?>
		</tbody>
	</table>
</div>

<div class="paginate">
	<a href="javascript:void(0);" onclick="goCommunityDataListMoveEvent(<?php echo $intPrevBlock;?>)" class="btn_board_prev direction "><span><?= $LNG_TRANS_CHAR["BW00192"]; //이전 ?></span></a>
	<?php for($i=$intFirstBlock;$i<=$intLastBlock;$i++):?>
	<?php if($i == $intPage):?>
	<strong><span class="chkPage"><?php echo $i;?></span></strong>
	<?php else:?>
	<a href="javascript:void(0);" onclick="goCommunityDataListMoveEvent(<?php echo $i;?>)" ><span class="pageCnt"><?php echo $i;?></span></a>
	<?php endif;?>
	<?php endfor;?>
	<a href="javascript:void(0);" onclick="goCommunityDataListMoveEvent(<?php echo $intNextBlock;?>)" class="btn_board_next direction"><span><?= $LNG_TRANS_CHAR["BW00193"]; //다음 ?></span></a>
</div>

<?
//입점사공지사항일 때 입점사는 글쓰기기 금지.
if($strBCode=='S_NOTICE'){
	if($a_admin_type=='A'){?>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:void(0);" onclick="goCommunityDataListWriteMoveEvent();" id="menu_auth_w" style=""><strong class="ico_write"><?= $LNG_TRANS_CHAR["BW00187"]; //글쓰기 ?></strong></a>
		<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataListDeleteActEvent();" id="menu_auth_w" style=""><strong class="ico_del"><?= $LNG_TRANS_CHAR["BW00188"]; //선택내용삭제 ?></strong></a>
	</div>
	<?
	}
}else{
?>
<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="goCommunityDataListWriteMoveEvent();" id="menu_auth_w" style=""><strong class="ico_write"><?= $LNG_TRANS_CHAR["BW00187"]; //글쓰기 ?></strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataListDeleteActEvent();" id="menu_auth_w" style=""><strong class="ico_del"><?= $LNG_TRANS_CHAR["BW00188"]; //선택내용삭제 ?></strong></a>
</div>
<?}?>


