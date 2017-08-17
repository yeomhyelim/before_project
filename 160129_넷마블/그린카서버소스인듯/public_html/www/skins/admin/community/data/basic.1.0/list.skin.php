<?
	## 설정
	$result					= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total				= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num				= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
	$field_use				= $_REQUEST['BOARD_INFO']['bi_datalist_datalist_field_use'];
	$strADTemp1Name			= $_REQUEST['BOARD_INFO']['bi_ad_temp1_name'];
	$strADTemp1KindDefault	= $_REQUEST['BOARD_INFO']['bi_ad_temp1_kind_default'];

	## 기본 설정
	$aryUseLng = explode("/", $S_USE_LNG);
	$intUseLng = sizeof($aryUseLng);
	$strMemberType = $_REQUEST['member_type']; // S - 입점사
	
	## 필드 사용 유무 체크
	$gradeFieldUse			= "";	// 점수 필드
	$categoryFieldUse		= "";	// 카테고리 필드
	$prodImgFieldUse		= "";	// 상품 이미지 필드
	if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4] == "Y")					{ $gradeFieldUse		= "1"; }
	if(in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("Y","A")))		{ $categoryFieldUse		= "1"; }
	if($_REQUEST['b_code'] == "PROD_REVIEW" || $_REQUEST['b_code'] == "PROD_QNA")	{ $prodImgFieldUse		= "1"; }

	## 카테고리 설정
	if($categoryFieldUse){
		$categoryFile	= "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
		if(is_file($categoryFile)) { include_once $categoryFile; }
	}

	## 내용 보기 기능 사용 유무
	$textShow			= true;

	## USER_REPORT는 상담상태(AD_TEMP1) 필드를 보여준다.
	$isADTempShow		= false;
	if($_REQUEST['b_code'] == "USER_REPORT"):
		$isADTempShow		= true;
	endif;

?>

	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col width=40/>
			<col width=80/>
			<?if($categoryFieldUse):?>
			<col width=100/>
			<?endif;?>
			<?if($prodImgFieldUse):?>
			<col width=50/>
			<?endif;?>
			<col />
			<?if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 포인트, 쿠폰 사용중..?>
			<col width=80/>
			<col width=80/>
			<?endif;?>
			<?if($gradeFieldUse):?>
			<col width=80/>
			<?endif;?>
			<?if($isADTempShow):?>
			<col width=100/>
			<?endif;?>
			<col width=180/>
			<col width=150/>
			<col width=80/>
		</colgroup>
		<tr>
			<th><input type="checkbox" id="checkAll"></th>
			<th>번호</th>
			<th>작성언어</th>
			<?if($categoryFieldUse):?>
			<th>카테고리</th>
			<?endif;?>
			<?if($prodImgFieldUse):?>
			<th>상품</th>
			<?endif;?>
			<th>제목</th>
			<?if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 포인트, 쿠폰 사용중..?>
			<th>포인트</th>
			<th>쿠폰</th>
			<?endif;?>
			<?if($gradeFieldUse):?>
			<th>점수</th>
			<?endif;?>
			<?if($isADTempShow):?>
			<th><?=$strADTemp1Name?></th>
			<?endif;?>
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

				## 기본 설정
				$no				= $row['UB_NO'];
				$text			= $row['UB_TEXT'];
				$title_text		= $row['UB_TITLE'];
				$strUB_LNG		= $row['UB_LNG'];
				$step			= $row['UB_ANS_STEP'];
				$aryFunc		= $dataView->getUB_FUNC_DECODER($row);	// 기능 설정
				$strUB_NAME		= $row['UB_NAME'];

				## 댓글 제목 만들기
				if($step):
					$step			= explode(",", $step);
					$step			= sizeof($step);
					$step			= str_pad("", $step, " ", STR_PAD_LEFT);
					$step			= str_replace(" ", "&nbsp;", $step);
					$title_text		= "{$step}<img src='/himg/board/A0001/icon_bbs_reply2.png'> {$title_text}";
				endif;

				## 기능별 제목 붙이기
				if($aryFunc['UB_FUNC_NOTICE'] == "Y")		{ $title_text = "{$title_text}[공지]";		}
				if($aryFunc['UB_FUNC_ICON_WIDGET'] == "Y")	{ $title_text = "{$title_text}[추천]";		}
				if($aryFunc['UB_FUNC_LOCK'] == "Y")			{ $title_text = "{$title_text} <img src=\"/himg/board/A0001/icon_bbs_lock.png\">";	}

				## 댓글 개수 붙이기
				if($_REQUEST['BOARD_INFO']['bi_comment_use'] != "N"):
					if(!$row['CMT_CNT']) { $row['CMT_CNT'] = 0; }
					$title_text		= "{$title_text}({$row['CMT_CNT']})";
				endif;
				
				## 제목 링크 붙이기
					$title_text			= "<a href=\"javascript:goDataViewMove2('{$no}')\">{$title_text}</a>";
					$textShowBtn		= "";
				if($textShow):
					$textShowBtn		= "<a href=\"javascript:goDataViewShowEvent('{$no}')\" class='btn_sml' ><span style=\"letter-spacing:0px\">Open Content (No.{$no})</span></a>";
				endif;

				## USER_REPORT 는 내용이 제목입니다.
				if($_REQUEST['b_code'] == "USER_REPORT"):
					$title_text			= "<a href=\"javascript:goDataViewMove2('{$no}')\"><strong>(No.{$no})</strong> {$text}</a>";
					$textShowBtn		= "";
				endif;

				##  사용자 테이블 ad_temp1 설정
				$strADTemp1							= $row['AD_TEMP1'];
				if(!$strADTemp1) { $strADTemp1		= $strADTemp1KindDefault; } 

				## CRM 버튼 설정
				$isBtnUseCrn = true;
				if(!$row['UB_M_NO']) { $isBtnUseCrn = false; } /* 회원글이 아닌 경우 */
				if($strMemberType == "S") {  $isBtnUseCrn = false; } /*최고 관리자가 아닌경우 숨김 처리 */

				## 언어 설정
				$strUB_LNG_NAME = $S_ARY_COUNTRY[$strUB_LNG];
				if(!$strUB_LNG_NAME) { $strUB_LNG_NAME = "-"; }

				## 2014.08.28 kim hee sung
				## 입점사는 작성자를  숨김 처리합니다.
				if($strMemberType == "S"):
					$intCnt	= mb_strlen($strUB_NAME, "UTF-8");
					$strUB_NAME = mb_substr($strUB_NAME, 0, 1, "UTF-8");
					for($i=0;$i<3;$i++) { $strUB_NAME .= "*"; }
				endif;

		?>
		<tr>
			<td><input type="checkbox" name="check[]" id="check" value="<?=$row['UB_NO']?>"></td>
			<td><?=$list_num--?></td>
			<td><?php echo $strUB_LNG_NAME;?></td>
			<?if($categoryFieldUse):?>
			<td><?=$CATEGORY_LIST[$row['UB_BC_NO']]['bc_name']?></td>
			<?endif;?>
			<?if($prodImgFieldUse):?>
			<td>
				<?if($row['PM_REAL_NAME']):?>
				<a href="/kr/?menuType=product&mode=view&prodCode=<?=$row['UB_P_CODE']?>" target="_blank"><img src="<?=$row['PM_REAL_NAME']?>" style="width:50px;height:50px"/></a>
				<?else:?>
				<img src="/himg/product/A0001/no_img.gif" style="width:50px;height:50px"/>
				<?endif;?>
			</td>
			<?endif;?>
			<td style="text-align:left;padding-left:10px;"> <?=$title_text?> <p class="btn_sView"><?=$textShowBtn?></p></td>
			<?if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 포인트, 쿠폰 사용중..?>
			<td><?if($row['UB_PT_NO']){?>발급됨<?}?></td>
			<td><?if($row['UB_CI_NO']){?>발급됨<?}?></td>
			<?endif;?>
			<?if($gradeFieldUse):?>
			<td><?=$row['UB_P_GRADE']?></td>
			<?endif;?>
			<?if($isADTempShow):?>
			<td><?=$strADTemp1?></td>
			<?endif;?>
			<td class="txtLeft">
				<?if($isBtnUseCrn):?>
					<a href="javascript:goMemberCrmView(<?=$row['UB_M_NO']?>);" class='btn_blue_sml'><span>CRM</span></a>
				<?endif;?>

				<?php echo $strUB_NAME;?>


			</td>
			<td><?=$row['UB_REG_DT']?></td>
			<td><?=$row['UB_READ']?></td>
		</tr>
		<?if($textShow):?>
		<tr id="textShow_<?=$no?>" style="display:none">
			<td colspan="20" class="bbs_open_view"><?=$text?></td>
		</tr>
		<?endif;?>
		<? endwhile; 
		   endif; ?>
	</table>



