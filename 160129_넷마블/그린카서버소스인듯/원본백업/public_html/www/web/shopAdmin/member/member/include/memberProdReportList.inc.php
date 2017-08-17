<?
	// 1:1 게시판 

	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardData.module.php";
	$boardData						= new BoardDataModule($db);

	## 기본 설정
	$bCode							= "USER_REPORT";
	$intPage						= $_GET['page'];
	$intMemberNo					= $_GET['memberNo'];
	$searchField2					= $_GET['searchField2'];
	$searchKey2						= $_GET['searchKey2'];
	$searchRegStartDt				= $_GET['searchRegStartDt'];
	$searchRegEndDt					= $_GET['searchRegEndDt'];
	$searchResultState				= $_GET['searchResultState'];
	$searchCategoryState			= $_GET['searchCategoryState'];
//	$strResultField					= "AD_TEMP13"; // 2014.03.31 kim hee sung 잘못된듯...
	$strResultField					= "AD_TEMP1";
	$strResultFieldLower			= strtolower($strResultField);

	## 설정 파일 불러오기
	if($bCode && !$aryBoardInfo):
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$bCode}.info.php";
		$aryBoardInfo				= $BOARD_INFO[$bCode];
		if(!$aryBoardInfo):
			echo "설정 파일이 없습니다.";
			exit;
		endif;
	endif;

	## 처리결과 설정
	$resultUse						= false;
	$userfieldUse					= $aryBoardInfo["bi_userfield_use"];
	$userfieldFieldUse				= $aryBoardInfo["bi_{$strResultFieldLower}_use"];
	$userfieldName					= $aryBoardInfo["bi_{$strResultFieldLower}_name"];
	$userfieldSort					= $aryBoardInfo["bi_{$strResultFieldLower}_sort"];
	$userfieldEssential				= $aryBoardInfo["bi_{$strResultFieldLower}_essential"];
	$userfieldKind					= $aryBoardInfo["bi_{$strResultFieldLower}_kind"];
	$userfieldKindData				= $aryBoardInfo["bi_{$strResultFieldLower}_kind_data"];
	$userfieldKindDefault			= $aryBoardInfo["bi_{$strResultFieldLower}_kind_default"];

	## 처리결과 설정 체크
	if($userfieldUse == "Y" && $userfieldFieldUse == "Y"):
		$resultUse					= true;
		$userfieldKindDataArray		= explode(";", $userfieldKindData);
	endif;

	## null 값 포함하여 검색 여부 체크
	if($searchResultState && ($searchResultState == $userfieldKindDefault)):
		$searchResultStateNull = "Y";
	endif;

	## 데이터 불러오기
	$param							= "";
	$param['B_CODE']				= $bCode;
	$param['UB_M_NO']				= $intMemberNo;
//	$param['UB_ANS_M_NO']			= $intMemberNo;
	$param['searchField']			= $searchField2;
	$param['searchKey']				= $searchKey2;
	$param['searchRegDTStart']		= $searchRegStartDt;
	$param['searchRegDTEnd']		= $searchRegEndDt;
	$param['AD_TEMP1_NULL']			= $searchResultStateNull;
	$param['AD_TEMP1']				= $searchResultState;
	$param['UB_BC_NO']				= $searchCategoryState;
	$param['BOARD_AD_JOIN']			= "Y";
	$param['MEMBER_MGR_UB_REG_NO_JOIN'] = "Y";
	$param['BOARD_CATEGORY_JOIN']	= "Y";
	$param['ORDER_MGR_JOIN']		= "Y";
	$param['ORDER_BY']				= "UB.UB_ANS_NO DESC, UB.UB_ANS_STEP ASC";
	$intTotal						= $boardData->getBoardDataSelectEx("OP_COUNT", $param);						// 데이터 전체 개수 

	$intPageLine					= 10;																		// 리스트 개수 
	$intPage						= ( $intPage )				? $intPage		: 1;
	$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param['LIMIT']					= "{$intFirst},{$intPageLine}";
	$boardDataResult				= $boardData->getBoardDataSelectEx("OP_LIST", $param);

	$intPageBlock					= 10;																		// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );

	## 페이징 링크 주소
	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$linkPage		= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($linkPage)		{ $linkPage .= "&"; }
		$linkPage		   .= $string;
	endforeach;
	$linkPage		= "./?{$linkPage}&page=";



?>


<div id="contentArea">
	<div class="searchTableWrap mt20" style="margin:0 10px 0 10px;">
		<?include "memberProdReportList.search.inc.php";?>
	</div>

	<div class="tableList" style="margin:10px 10px 0 10px">
		<table>
			<caption></caption>
			<colgroup>
				<col class="no" style="width:40px"/>
				<col class="category" style="width:80px"/>
				<col class="title"/>
				<col class="regName" style="width:60px"/>
				<col class="date" style="width:130px"/>
				<?if($resultUse):?>
				<col class="result" style="width:100px"/>
				<?endif;?>
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>카테고리</th>
					<th>내용</th>
					<th>작성자</th>
					<th>작성일</th>
					<?if($resultUse):?>
					<th><?=$userfieldName?></th>
					<?endif;?>
				</tr>
			</thead>
			<tbody>
				<?while($row = mysql_fetch_array($boardDataResult)):
		
					## 기본 설정
					$no					= $row['UB_NO'];
					$name				= $row['UB_NAME'];
					$title				= $row['UB_TITLE'];
					$text				= $row['UB_TEXT'];
					$regDt				= $row['UB_REG_DT'];
					$read				= $row['UB_READ'];
					$step				= $row['UB_ANS_STEP'];
					$regFName			= $row['REG_M_F_NAME'];
					$refLName			= $row['REG_M_L_NAME'];
					$cateName			= $row['BC_NAME'];
					$strOrderKey		= $row['O_KEY'];
					$resultState		= $row[$strResultField];

					## 이름 정의
					$regName			= "";
					if($regFName):
						$regName		= $regFName; 
					endif;
					if($refLName):
						if($regName) { $regName = "{$regName} "; }
						$regName = "{$regName}{$refLName}"; 
					endif;

					## 답변 정의
					if($step):
						$step			= explode(",", $step);
						$step			= sizeof($step);
						$step			= str_pad("", $step, " ", STR_PAD_LEFT);
						$step			= str_replace(" ", "&nbsp;", $step);
						$title			= "{$step}<img src='/himg/board/A0001/icon_bbs_reply.png'>{$title}";
					endif;

					## 내용 정의
					if($strOrderKey) { $text = "<span class=\'orderKey\'>(주문번호: {$strOrderKey})</span> {$text}"; }
					
					##작성일 설정
					$regDt		= date("Y.m.d H:i:m", strtotime($regDt));		?>
				<tr id="reportList_<?=$no?>">
					<td class="no"><?=$intListNum--?></td>
					<td class=""><?=$cateName?></td>
					<td class="" style="text-align:left"><a href="javascript:goResultModifyMoveEvent('<?php echo $no;?>')"><?=$text?></a></td>
					<td class="regName"><?=$regName?></td>
					<td class="date"><?=$regDt?></td>
					<?if($resultUse):?>
					<td class="result">
						<?if($userfieldKind=="text"):?>
							<input type="text" name="resultState" value="<?=$resultState?>" style="width:100px">
							<a class="btn_sml" href="javascript:goResultStateChangeActEvent('<?=$no?>')" id="btn_postSms_insert"><strong>저장</strong></a>
						<?elseif($userfieldKind=="select"):?>
							<?if($userfieldKindDataArray):?>
							<select name="resultState" onchange="goResultStateChangeActEvent('<?=$no?>')">
								<?foreach($userfieldKindDataArray as $key => $data):?>
								<option value="<?=$data?>"<?if($resultState==$data){echo " selected";}?>><?=$data?></option>
								<?endforeach;?>
							</select>
							<?endif;?>
						<?endif;?></td>
					<?endif;?>
				</tr>
				<?endwhile;?>
			</tbody>
		</table>
	</div>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<input type="hidden" name="b_code"	 value="<?=$bCode?>">
