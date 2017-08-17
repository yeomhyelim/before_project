<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];

	## 기본 설정
	$no = $dataSelectRow['UB_NO'];
	$strUB_LNG = $dataSelectRow['UB_LNG'];
	$aryUseLng = explode("/", $S_USE_LNG);
	$intUseLng = sizeof($aryUseLng);
	$strUB_LNG_NAME = $S_ARY_COUNTRY[$strUB_LNG];

	## 카테고리 필드 설정
	$category_field_use = "";
	if(in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("Y","A"))) { $category_field_use = "Y"; }

	## 추가 필드 설정
	$user_field_use = "";
	if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y") { $user_field_use = "Y"; }

	## 링크 필드 설정
	$like_field_use = "";
	if($dataSelectRow['UB_URL'] && $dataSelectRow['UB_URL'] != "http://") { $link_field_use = "Y"; }

	## 평점 필드 설정
	$average_field_use = "";
	if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4] == "Y") { $average_field_use = "Y"; }

	## 웹 글 필드 설정
	$web_text_field_use = "";
	if($dataSelectRow['UB_TEXT']) { $web_text_field_use = "Y"; }

	## 모바일 글 필드 설정
	$mobile_text_field_use = "";
	if($dataSelectRow['UB_TEXT_MOBILE']) { $mobile_text_field_use = "Y"; }

	## 첨부파일 필드 설정
	$attachedfile_field_use = "";
	if($_REQUEST['list_total']['AttachedfileMgr']) { $attachedfile_field_use = "Y"; }

//	print_r($_REQUEST);

	## 카테고리 내용 설정
	if($category_field_use == "Y"):
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
		$ub_bc_no		= $dataSelectRow['UB_BC_NO'];
		$category_text	= $CATEGORY_LIST[$ub_bc_no]['bc_name'];
	endif;

	## 작성일 내용 설정
	$reg_dt_text		= date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']));

	## 작성자 내용 설정
	$writer_text		= $dataSelectRow['UB_NAME'];
	if($dataSelectRow['UB_M_ID']):
		if($writer_text)	{ $writer_text = "{$writer_text}({$dataSelectRow['UB_M_ID']})";		}
		else				{ $writer_text = $dataSelectRow['UB_M_ID'];							}
	endif;
	## 2014.08.28 kim hee sung
	## 입점사는 작성자를  숨김 처리합니다.
	if($strMemberType == "S"):
		$intCnt	= mb_strlen($writer_text, "UTF-8");
		$writer_text = mb_substr($writer_text, 0, 1, "UTF-8");
		for($i=0;$i<3;$i++) { $writer_text .= "*"; }
	endif;

	## 제목 내용 설정
	$title_text			= stripslashes($dataSelectRow['UB_TITLE']);
	if($dataSelectRow['UB_FUNC']['UB_FUNC_NOTICE'] == "Y")	{ $title_text = "[공지사항]{$title_text}";	}
	if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y")		{ $title_text = "{$title_text} [비밀글]";	}
	if($dataSelectRow['UB_FUNC']['UB_FUNC_ICON']=="Y")		{ $title_text = "{$title_text} {아이콘]";	}


//	## 웹 내용 설정
//	if($web_text_field_use == "Y"):
//		$type = "Y";
////		if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full") { $type = "N"; }
//		if($dataSelectRow['UB_M_NO'] != 1) { $type = "N"; }
//
//		if(substr_count($dataSelectRow['UB_TEXT'], "<P>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<p>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<DIV>") > 0)			{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<div>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "&nbsp;") > 0)			{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<img") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<embed ") > 0)		{ $type = "Y"; }
//
//		$web_text = strConvertCut($dataSelectRow['UB_TEXT'],0,$type);
//	endif;
//
//	if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "textWrite"):
//		$web_text			= strConvertCut($dataSelectRow['UB_TEXT'],0,"N");
//		$mobile_text		= strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,"N");
//	else:
//		$web_text			= strConvertCut($dataSelectRow['UB_TEXT'],0,"Y");
//		$mobile_text		= strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,"Y");
//	endif;

//	## 모바일 내용 설정
//	if($mobile_text_field_use == "Y"):
//		$type = "Y";
//		if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full") { $type = "N"; }
//		$mobile_text = strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,$type);
//	endif;

	## CRM 버튼 설정
	$isBtnUseCrn = true;
	if(!$dataSelectRow['UB_M_NO']) { $isBtnUseCrn = false; } /* 회원글이 아닌 경우 */
	if($_REQUEST['member_type'] == "S") {  $isBtnUseCrn = false; } /*최고 관리자가 아닌경우 숨김 처리 */

	$type = "N";
	if(substr_count($dataSelectRow['UB_TEXT'], "<P") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<br") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<p") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<DIV") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<div") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "&nbsp;") > 0)		{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<img") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<IMG") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<embed ") > 0)		{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<EMBED ") > 0)		{ $type = "Y"; }

	$web_text			= strConvertCut($dataSelectRow['UB_TEXT'],0,$type);
	$mobile_text		= strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,$type);
	
?>

	<table>
		<tr>
			<th>등록번호</th>
			<td><?=$no?></td>
		</tr>
		<tr>
			<th>작성언어</th>
			<td><?=$strUB_LNG_NAME?></td>
		</tr>
		<?if($category_field_use == "Y"):?>
		<tr>
			<th>카테고리</th>
			<td><?=$category_text?></td>
		</tr>
		<?endif;?>
		<tr>
			<th>작성일시</th>
			<td><?=$reg_dt_text?></td>
		</tr>
		<tr>
			<th>작성자 (아이디)</th>
			<td>
				<?=$writer_text?>
				<?if($isBtnUseCrn):?>
				 <a href="javascript:goMemberCrmView(<?=$dataSelectRow['UB_M_NO']?>);" class='btn_blue_sml'><span>CRM</span></a>
				<?endif;?>
			</td>
		</tr>
		<?if($dataSelectRow['UB_MAIL']):?>
		<tr>
			<th>이메일</th>
			<td>
				<?=$dataSelectRow['UB_MAIL']?>
			</td>
		</tr>
		<?endif;?>
		<? include "userfield.view.skin.php" ?>
		<?if($like_field_use):?>
		<tr>
			<th>링크</th>
			<td>
				<a href="<?=$dataSelectRow['UB_URL']?>" target="_blank"><?=$dataSelectRow['UB_URL']?></a>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>제목</th>
			<td><?=$title_text?></td>
		</tr>
		<?if($average_field_use =="Y"):?>
		<tr>
			<th>평점</th>
			<td>
				<?=$dataSelectRow['UB_P_GRADE']?>
			</td>
		</tr>
		<?endif;?>
		<?if($web_text_field_use == "Y" && $mobile_text_field_use == "Y"):?>
		<tr>
			<th></th>
			<td>
				<a data-mouseEnter-show2="viewEditWeb">웹편집</a>
				<a data-mouseEnter-show2="viewEditMobile">모바일편집</a>
			</td>
		</tr>
		<?endif;?>
		<?if($web_text_field_use == "Y"):?>
		<tr id="viewEditWeb" group="viewEdit">
			<th>내용</th>
			<td><div class="viewContentArea"><?=$web_text?></div></td>
		</tr>
		<?endif;?>
		<?if($mobile_text_field_use == "Y"):?>
		<tr id="viewEditMobile" group="viewEdit" style="display:none">
			<th>내용(모바일)</th>
			<td><?=$mobile_text?></td>
		</tr>
		<?endif;?>
		<tr>
			<th>IP</th>
			<td>
				<?=$dataSelectRow['UB_IP']?>
			</td>
		</tr>
		<?if($attachedfile_field_use == "Y"):?>
		<tr>
			<th>첨부파일</th>
			<td colspan="5">
				<ul class="attachList">
				<? while($row = mysql_fetch_array($attachedfileViewListResult)) : ?>
				<?if($row['FL_KEY']=="file"):?>
				<li><a href="javascript:goDataDownloadMoveEvent('<?=$_REQUEST['b_code']?>','<?=$row['FL_NO']?>')"><?=$row['FL_NAME']?></a></li>
				<?else:?>
				<li><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:100px;" /></li>
				<?endif;?>
				<? endwhile; ?>
				</ul>
			</td>
		</tr>
		<?endif;?>
	</table>
