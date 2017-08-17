<?php

	/**
	 * eumshop app - communityList - dataBasicSkin
	 *
	 * 커뮤니티 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/home/shop_eng/www/web/app/communityList/communityList.dataBasicSkin.php
	 * @manual		menuType=app&mode=communityList&skin=dataBasicSkin
	 * @history
	 *				2014.07.15 kim hee sung - 개발 완료
	 *				2014.08.03 kim hee sung - communityList.dataGallerySkin 에서 php 소스 공동 사용.
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_LIST_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[] = "/common/js/app/communityList/communityList.dataBasicSkin.js";

	## 모듈 설정
	$objBoardDataModule = new BoardDataModule($db);

	## 기본 설정
	$strAppPCode = $EUMSHOP_APP_INFO['pCode'];
	
	$intAppAnsMemberNo = $EUMSHOP_APP_INFO['ansMemberNo'];
	$aryBCode = array('MY_QNA','PROD_QNA');
	if(in_array($EUMSHOP_APP_INFO['bCode'],$aryBCode)){
	if(!$intAppAnsMemberNo) $intAppAnsMemberNo = $g_member_no;
	}
	$intAppPageLine = $EUMSHOP_APP_INFO['pageLine'];
	$intAppPage	= $_GET['page'];
	$strAppSearchKey = $_GET['searchKey'];
	$strAppSearchVal = $_GET['searchVal'];
	$strAppLang = $S_SITE_LNG;
	$strAppLangS = $S_ST_LNG;
	$strAppLangLower = strtolower($strAppLang);
	$strAppLangSLower = strtolower($strAppLangS);
	$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strAppLangLower}";
	$strCommunityCateFile = "category.{$strBCode}.info.php"; 
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;
	$strAppPageBlock = 10;

	## bCode 설정
 	$strBCode = $EUMSHOP_APP_INFO['bCode'];
	if(!$strBCode) { $strBCode = $_GET['b_code']; }
	if(!$strBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		getDebug($param);
		return;
	endif;

	## 커뮤니티 설정 파일
	$aryBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	if(!$aryBoardInfo):
		include MALL_SHOP . "/conf/community/{$strAppLangLower}/board.{$strBCode}.info.php";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		include MALL_SHOP . "/conf/community/{$strAppLangSLower}/board.{$strBCode}.info.php";
		$aryBoardInfoS = $BOARD_INFO[$strBCode];
		foreach($aryBoardInfoS as $key => $data):
			$strTemp = $aryBoardInfo[$key];
			if($strTemp) { continue; }
			$aryBoardInfo[$key] = $data;
		endforeach;
	endif;
	if(!$aryBoardInfo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "boardInfo가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 커뮤니티 설정
	$strBI_START_MODE = $aryBoardInfo['BI_START_MODE']; 
	$strB_KIND_SKIN = $aryBoardInfo['B_KIND_SKIN']; 
	$strB_CSS = $aryBoardInfo['B_CSS'];
	$strBI_CATEGORY_USE = $aryBoardInfo['BI_CATEGORY_USE'];
	$aryBI_DATALIST_FIELD_USE = $aryBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목
	$aryBI_DATALIST_WRITER_SHOW = $aryBoardInfo['BI_DATALIST_WRITER_SHOW'];
	$intBI_DATALIST_WRITER_HIDDEN = $aryBoardInfo['BI_DATALIST_WRITER_HIDDEN'];
	$strBI_DATALIST_USE = $aryBoardInfo['BI_DATALIST_USE']; // 목록권한(모든회원/비회원-A, 회원전용-M)
	$strBI_DATAANSWER_USE = $aryBoardInfo['BI_DATAANSWER_USE']; // 답변권한(모든회원/비회원-A, 회원전용-M, 사용안함-N)
	$aryBI_DATALIST_MEMBER_AUTH = $aryBoardInfo['BI_DATALIST_MEMBER_AUTH'];
	$intBI_COLUMN_DEFAULT = $aryBoardInfo['BI_COLUMN_DEFAULT']; // 5 칸
	$intBI_LIST_DEFAULT = $aryBoardInfo['BI_LIST_DEFAULT']; // 목록수
	$intBI_DATALIST_TITLE_LEN = $aryBoardInfo['BI_DATALIST_TITLE_LEN']; // 타이틀 표시 방법
	$strBI_DATALIST_ORDERBY = $aryBoardInfo['BI_DATALIST_ORDERBY']; // 리스트 정렬 설정
	$strBI_DATADELETE_AFTER = $aryBoardInfo['BI_DATADELETE_AFTER']; // 삭제후설정
	$strBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
	$strBI_DATAWRITE_USE = $aryBoardInfo['BI_DATAWRITE_USE']; // 글쓰기권한(모든회원/비회원-A, 회원전용-M)
	$aryBI_DATAWRITE_MEMBER_AUTH = $aryBoardInfo['BI_DATAWRITE_MEMBER_AUTH'];
	$strBI_DATAWRITE_LOCK_USE = $aryBoardInfo['BI_DATAWRITE_LOCK_USE']; //비밀글(무조건비밀글-E)

	## 글쓰기 버튼 활성화 설정
	$isWriteBtn = false;
	if($strBI_DATAWRITE_USE == "A") { $isWriteBtn = true; }
	if($strBI_DATAWRITE_USE == "M"):
		if(in_array($strMemberGroup, $aryBI_DATAWRITE_MEMBER_AUTH)):
			$isWriteBtn = true;
		endif;	
		if(is_array($aryBI_DATAWRITE_MEMBER_AUTH)):
			foreach($aryBI_DATAWRITE_MEMBER_AUTH as $key => $data):
				if($data == '001') { continue; } 
				$isWriteBtn = true;
				break;
			endforeach;
		endif;
	endif;
	if($strB_KIND_SKIN == 'data_gallery') $isWriteBtn = false;

	## 2015.03.18 kim hee sung 상품리뷰, 상품QNA는 상품번호가 있어야 글쓰기가 가능합니다.
	if(in_array($strBCode, array('PROD_REVIEW','PROD_QNA')) && !$strAppPCode)
	{
		$isWriteBtn = false;
		
	}

	## 사용권한 체크
	if($strBI_DATALIST_USE == "M"): // 회원전용인경우
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login");
			return;		
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATALIST_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;
		endif;
	endif;

	## 목록수 설정
	if(!$intBI_COLUMN_DEFAULT) { $intBI_COLUMN_DEFAULT = 1; }
	if(!$intAppPageLine) { $intAppPageLine = $intBI_LIST_DEFAULT * $intBI_COLUMN_DEFAULT; }

	## 커뮤니티 카테고리 설정 파일
	include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
	$aryCategoryList = $CATEGORY_LIST;

	## 검색 키워드 설정
	if($strAppSearchKey) { $aryAppSearchKey = explode("_", $strAppSearchKey); }

	## 정렬 설정
	$strAppOrderBy						= $strBI_DATALIST_ORDERBY;
	if(!$strAppOrderBy) { $strAppOrderBy = "defaultDesc"; }

	## 삭제된 데이터 숨김 처리
	## 2015.01.19 kim hee sung 삭제글은 무조건 숨김처리하도록 변경함.(요청사항)
	$strUbDelNot = "Y";
	if($strBI_DATADELETE_AFTER == "hide") { $strUbDelNot = "Y"; }

	## 답변 권한이 사용안함 일때, 답변 정보는 DB에서 가져오지 않습니다.
	$intUbAnsDepth = null;
	if($strBI_DATAANSWER_USE == "N"):
		$intUbAnsDepth = 1;
	endif;

	## 목록 설정
	$aryAppColumn = "";
	$aryAppColumn[] = "제목";
	if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryAppColumn[] = "번호"; }
	if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryAppColumn[] = "작성자"; }
	if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryAppColumn[] = "등록일"; }
	if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryAppColumn[] = "조회수"; }
	if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryAppColumn[] = "점수"; }
	if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryAppColumn[] = "카테고리"; }
	if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryAppColumn[] = "리스트이미지"; }
	if($aryBI_DATALIST_FIELD_USE[7] == "Y") { $aryAppColumn[] = "상품이미지"; }

	## 작성자 설정
	if(in_array("작성자", $aryAppColumn)):
		if($aryBI_DATALIST_WRITER_SHOW[0] == "Y") { $aryAppColumn[] = "성명"; }
		if($aryBI_DATALIST_WRITER_SHOW[1] == "Y") { $aryAppColumn[] = "아이디"; }
		if($aryBI_DATALIST_WRITER_SHOW[2] == "Y") { $aryAppColumn[] = "닉네임"; }
	endif;

	## 작성자/조회수 컬럼 설정
	$intWriteColspan = 1;
	if(!in_array("작성자",$aryAppColumn)) { $intWriteColspan += 2; }
	if(!in_array("조회수",$aryAppColumn)) { $intWriteColspan += 2; }
	if($intWriteColspan < 5) { $aryAppColumn[] = "작성자,조회수"; }

	## 상품 이미지 join 설정
	$strProductImgJoin = "";
	if(in_array("상품이미지", $aryAppColumn)) { $strProductImgJoin = "Y"; }

	## 첨부파일 join 설정
	$strAttchedfile = "";
	if($strBI_ATTACHEDFILE_USE) { $strAttchedfile = "Y"; }



	## 데이터 불러오기
	$param								= "";

	$param['B_CODE']					= $strBCode;
	$param['UB_LNG_IN'][]				= "--";
	$param['UB_LNG_IN'][]				= $strAppLang;
	$param['UB_DEL_NOT']				= $strUbDelNot;
	$param['UB_ANS_DEPTH']				= $intUbAnsDepth;
	$param['UB_P_CODE']					= $strAppPCode;
	$param['UB_ANS_M_NO']				= $intAppAnsMemberNo;
	$param['searchKey']					= $aryAppSearchKey;
	$param['searchVal']					= $strAppSearchVal;
	$intAppTotal						= $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);					// 데이터 전체 개수 
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10;								// 리스트 개수 
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['JOIN_MM']					= "Y";
	$param['JOIN_FL']					= $strAttchedfile;
	$param['JOIN_PM']					= $strProductImgJoin;
	$param['ORDER_BY']					= $strAppOrderBy;
	$param['LIMIT']						= "{$intAppFirst},{$intAppPageLine}";

	$resAppResult						= $objBoardDataModule->getBoardDataSelectEx2("OP_LIST", $param);
	$intAppPageBlock					= $strAppPageBlock;																	// 블럭 개수 
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );							// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );
//	echo $db->query;

	## 리스트 번호 재정의(답변은 리스트 번호에서 제외)
	## 시간이 없어서 뒤로 미룸
//	$param['UB_ANS_DEPTH']				= 1;
//	$intAppQueTotal						= $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);					// 데이터 전체 개수 
//	$intAppListNum						= $intAppTotal - ($intAppTotal - $intAppQueTotal) - ($intAppPageLine * ($intAppPage-1));	

	## paging 설정
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
	$intAppPrevBlock		= (($intAppBlock - 2) * $intAppPageBlock) + 1;	// 이전 블럭
	$intAppNextBlock		= ($intAppBlock * $intAppPageBlock) + 1;		// 다음 블럭
	$intAppFirstBlock		= (($intAppBlock - 1) * $intAppPageBlock) + 1;	// 현재 블럭 시작 시저
	$intAppLastBlock		= $intAppBlock * $intAppPageBlock;				// 현재 블럭 종료 시점

	if($intAppFirstBlock <= 0) { $intAppFirstBlock	= 1; }
	if($intAppPrevBlock  <= 0) { $intAppPrevBlock	= 1; }
	if($intAppNextBlock >= $intAppTotPage) { $intAppNextBlock	= $intAppTotPage; }
	if($intAppLastBlock >= $intAppTotPage) { $intAppLastBlock	= $intAppTotPage; }

	## 페이지 시작/마지막 번호 설정
	$intAppFirstNo			= ($intAppPage <= 1) ? $intAppPage : (($intAppPage - 1) * $intAppPageLine);
	$intAppLastNo			= $intAppPage * $intAppPageLine;
	if(!$intAppFirstNo) { $intAppFirstNo = ""; }
	if($intAppLastNo > $intAppTotal) { $intAppLastNo = $intAppTotal; }

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['OS00013']	= $LNG_TRANS_CHAR['OS00013'];
	$aryLanguage['PW00010']	= $LNG_TRANS_CHAR['PW00010'];
	$aryLanguage['PW00009']	= $LNG_TRANS_CHAR['PW00009'];
	$aryLanguage['OS00029']	= $LNG_TRANS_CHAR['OS00029'];
	$aryLanguage['CW00034']	= $LNG_TRANS_CHAR['CW00034'];
	$aryLanguage['CW00001']	= $LNG_TRANS_CHAR['CW00001'];

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strBCode;
	$aryAppParam['PAGE'] = $intAppPage;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

	if($strAppView == "N") { return; }
?>
<!-- eumshop app - communityList - dataBasicSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<!--h2>
		<span><?php echo $strB_NAME;?></span>
	</h2-->
	<div class="boardTopWrap">
		<div class="boardCntWrap"><strong><?php echo $intAppTotal;?></strong>(<span><?php echo $intAppPage;?></span>/<span><?php echo $intAppTotPage;?></span>Page)</div>
		<div class="boardTopSearchWrap" >
			<select id="searchKey" data-select="<?php echo $strAppSearchKey;?>">
				<option value="title"><?php echo $LNG_TRANS_CHAR['CW00062']; // 제목?></option>
				<option value="text"><?php echo $LNG_TRANS_CHAR['CW00063']; // 내용?></option>
				<option value="title_text"><?php echo "{$LNG_TRANS_CHAR['CW00062']}+{$LNG_TRANS_CHAR['CW00063']}"; // 제목+내용?></option>
				<?
				if(!($strBCode == 'NOTICE' || $strBCode == 'FAQ')){
				?>
				<option value="name"><?php echo $LNG_TRANS_CHAR['CW00053']; // 작성자?></option>
				<option value="id"><?php echo $LNG_TRANS_CHAR['MW00001']; // 아이디?></option>
				<?}?>
			</select>
			<input type="text" id="searchVal" value="<?php echo $strAppSearchVal;?>" onkeydown="if(event.keyCode==13){goCommunityListDataBasicSkinSearchMoveEvent('<?php echo $strAppID;?>');}">
			<a href="javascript:void(0);" onclick="goCommunityListDataBasicSkinSearchMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btnBoardSearch"><strong>검색</strong></a>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="tableList">
		<table class="bbsListTable">
			<thead>
				<tr>
					<?php if(in_array("번호", $aryAppColumn)):?>
					<th class="numDiv"><?php echo $LNG_TRANS_CHAR["CW00006"]; //번호?></th>
					<?php endif;?>
					<?php if(in_array("카테고리", $aryAppColumn)):?>
					<th class="cateDiv"><?php echo $LNG_TRANS_CHAR["CW00064"]; //카테고리?></th>
					<?php endif;?>
					<?php if(in_array("상품이미지", $aryAppColumn)):?>
					<th class="listImageDiv"><?php echo $LNG_TRANS_CHAR["CW00057"]; //상품?></th>
					<?php endif;?>
					<?php if(in_array("리스트이미지", $aryAppColumn)):?>
					<th class="listImageDiv"><?php echo $LNG_TRANS_CHAR["MW00101"]; //이미지?></th>
					<?php endif;?>
					<?php if(in_array("제목", $aryAppColumn)):?>
					<th class="titleDiv"><?php echo $LNG_TRANS_CHAR["CW00062"]; //제목?></th>
					<?php endif;?>
					<?php if(in_array("성명", $aryAppColumn)):?>
					<th class="writerDiv"><?php echo $LNG_TRANS_CHAR["CW00053"]; //작성자?></th>
					<?php endif;?>
					<?php if(in_array("아이디", $aryAppColumn)):?>
					<th class="idDiv"><?php echo $LNG_TRANS_CHAR["MW00001"]; //아이디?></th>
					<?php endif;?>
					<?php if(in_array("닉네임", $aryAppColumn)):?>
					<th class="idDiv"><?php echo $LNG_TRANS_CHAR["MW00005"]; //닉네임?></th>
					<?php endif;?>
					<?php if(in_array("점수", $aryAppColumn)):?>
					<th class="rateNum"><?php echo $LNG_TRANS_CHAR["CW00056"]; //평점?></th>
					<?php endif;?>
					<?php if(in_array("등록일", $aryAppColumn)):?>
					<th class="dateDiv"><?php echo $LNG_TRANS_CHAR["CW00054"]; //작성일?></th>
					<?php endif;?>
					<?php if(in_array("조회수", $aryAppColumn)):?>
					<th class="readDiv"><?php echo $LNG_TRANS_CHAR["CW00055"]; //조회수?></th>
					<?php endif;?>
				</tr>
			</thead>
			<tbody>
				<?php if(!$intAppTotal):?>
				<tr>
					<td colspan="10"><?php $LNG_TRANS_CHAR["MS00101"]; // 등록된 내용이 업습니다.?></td>
				<tr>
				<?php else:?>
				<?php while($row = mysql_fetch_array($resAppResult)):

						## 기본 설정
						$intUB_NO = $row['UB_NO'];
						$intUB_BC_NO = $row['UB_BC_NO'];
						$strUB_NAME = $row['UB_NAME'];
						$intUB_M_NO = $row['UB_M_NO'];
						$strUB_M_ID = $row['UB_M_ID'];
						$strMM_NICK_NAME = $row['MM_NICK_NAME'];
						$strUB_TITLE = $row['UB_TITLE'];
						$strUB_REG_DT = $row['UB_REG_DT'];
						$intUB_READ = $row['UB_READ'];
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
						$strUB_P_CODE = $row['UB_P_CODE'];

						## 제목 설정
						if($intBI_DATALIST_TITLE_LEN):
							$strUB_TITLE = strHanCutUtf2($strUB_TITLE, $intBI_DATALIST_TITLE_LEN);
						endif;

						## 카테고리 설정
						$strCategoryName = $aryCategoryList[$intUB_BC_NO]['bc_name'];

						## 작성자(성명) 설정
						if($intBI_DATALIST_WRITER_HIDDEN):		
							$strUB_NAME = strHanCutUtf2($strUB_NAME, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
						endif;					

						## 아이디 설정
						if($intBI_DATALIST_WRITER_HIDDEN):
							$strUB_M_ID = strHanCutUtf2($strUB_M_ID, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
						endif;	

						## 닉네임 설정
						if(!$strMM_NICK_NAME) { $strMM_NICK_NAME = $LNG_TRANS_CHAR["MW00100"]; /* 손님 */ }
						if($intBI_DATALIST_WRITER_HIDDEN):
							$strMM_NICK_NAME = strHanCutUtf2($strMM_NICK_NAME, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
						endif;	

						## 작성일 설정
						$strUB_REG_DT = date("Y.m.d", strtotime($strUB_REG_DT));

						## 리스트이미지 설정
						$strListImage = "";
						if($strFL_DIR && $strFL_NAME) { $strListImage = "{$strFL_DIR}/{$strFL_NAME}"; }

						## 삭제글 설정
						if($strUB_DEL == "Y"):
							$strCategoryName = "";
							$strListImage = "";
							$intUB_NO = "";
							$strUB_TITLE = "삭제된 글입니다.";
							$strUB_NAME = "";
							$strUB_M_ID = "";
							$strMM_NICK_NAME = "";
							$intUB_P_GRADE = 0;
							$strUB_REG_DT = "";
							$intUB_READ = "";
						endif;

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

						## UB_FUNC 설정
						$aryFunc = "";
						$strFuncNotice = $strUB_FUNC[0]; // 공지글
						$strFuncLock = $strUB_FUNC[1]; // 비밀글
//						$aryFunc[] = $strUB_FUNC[3]; // 대기
//						$aryFunc[] = $strUB_FUNC[4]; // 대기
//						$aryFunc[] = $strUB_FUNC[5]; // 대기
//						$aryFunc[] = $strUB_FUNC[6]; // 대기
//						$aryFunc[] = $strUB_FUNC[7]; // 대기
//						$aryFunc[] = $strUB_FUNC[8]; // 대기
//						$aryFunc[] = $strUB_FUNC[9]; // 대기

						## 공지글 설정
						$strAppListNum = $intAppListNum;
						if($strFuncNotice == "Y"):
							$strAppListNum = "<img src='/himg/board/icon/ico_notice.png'>";
						endif;

						## 무조건 비밀글 설정인경우
						if($strBI_DATAWRITE_LOCK_USE == "E") { $strFuncLock = "Y"; }

						## 비밀글 설정
						$strLockHtml = "";
						$strLockAuth = "";
						if($strFuncLock == "Y"):
							$strLockHtml = "<img src='/himg/board/icon/icon_bbs_lock.png'> "; 

							if($intUB_M_NO): 
							## 회원글

								## 비회원 || 자신의 글이 아닌 경우
								if(!$intMemberNo || $intUB_M_NO != $intMemberNo) { $strLockAuth = "memberLock"; };
			
							else:
							## 비회원글

								$strLockAuth = "lock";

							endif;

							## 답변글인경우, 질문자 회원도 체크 합니다.
							if($strLockAuth && $isAnswer):
		
								## 다시 정의 합니다.
								$strLockAuth = "";
								
								if($intUB_ANS_M_NO): 
								## 회원글

									## 비회원 || 자신의 글이 아닌 경우
									if(!$intMemberNo || $intUB_ANS_M_NO != $intMemberNo) { $strLockAuth = "memberLock"; };
									
								else:
								## 비회원글

									$strLockAuth = "lock";

								endif;
							endif;

							## 관리자 그룹(001) 은 모든 내용을 볼수 있습니다.
							if(in_array($strMemberGroup, array("001"))) { $strLockAuth = ""; }
						endif;

				?>
				<tr>
					<?php if(in_array("번호", $aryAppColumn)):?>
					<td><?php echo $strAppListNum;?></td>
					<?php endif;?>
					<?php if(in_array("카테고리", $aryAppColumn)):?>
					<td><?php echo $strCategoryName;?></td>
					<?php endif;?>
					<?php if(in_array("상품이미지", $aryAppColumn)):?>
					<td><?php if($strPM_REAL_NAME):?>
						<a href="./?menuType=product&mode=view&prodCode=<?php echo $strUB_P_CODE;?>" target="_blank"><img src="<?php echo $strPM_REAL_NAME;?>" class="prodImg"></a>
						<?php endif;?>
					</td>
					<?php endif;?>
					<?php if(in_array("리스트이미지", $aryAppColumn)):?>
					<td><?php if($strListImage):?>
						<img src="<?php echo $strListImage;?>" class="listImg">
						<?php endif;?>
					</td>
					<?php endif;?>
					<?php if(in_array("제목", $aryAppColumn)):?>
					<td class="alignLeft"><?php echo $strAnsHtml;?><a href="javascript:void(0);" onclick="goCommunityListDataBasicSkinViewMoveEvent('<?php echo $strAppID;?>', <?php echo $intUB_NO;?>, '<?php echo $strLockAuth;?>')"><?php echo $strUB_TITLE;?></a><?php echo $strLockHtml;?></td>
					<?php endif;?>
					<?php if(in_array("성명", $aryAppColumn)):?>
					<td><?php echo $strUB_NAME;?></td>
					<?php endif;?>
					<?php if(in_array("아이디", $aryAppColumn)):?>
					<td><?php echo $strUB_M_ID;?></td>
					<?php endif;?>
					<?php if(in_array("닉네임", $aryAppColumn)):?>
					<td><?php echo $strMM_NICK_NAME;?></td>
					<?php endif;?>
					<?php if(in_array("점수", $aryAppColumn)):?>
					<td><?php if($isPGrade):?>
						<img src="/himg/board/icon/icon_star_<?php echo $intUB_P_GRADE;?>.png"/>
						<?php endif;?>
					</td>
					<?php endif;?>
					<?php if(in_array("등록일", $aryAppColumn)):?>
					<td><?php echo $strUB_REG_DT;?></td>
					<?php endif;?>
					<?php if(in_array("조회수", $aryAppColumn)):?>
					<td><?php echo $intUB_READ;?></td>
					<?php endif;?>
				</tr>
				<?php $intAppListNum--;?>
				<?php endwhile;?>
				<?php endif;?>
			</tbody>
		</table>
	</div>
	<?php if($intAppTotal):?>
	<div class="paginate_left">
		<a href="javascript:goCommunityListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $intAppPrevBlock;?>)" class="btn_board_prev direction"><span><?php echo $LNG_TRANS_CHAR['MW00052'];?></span></a>
		<?php for($i=$intAppFirstBlock;$i<=$intAppLastBlock;$i++):?>
		<?php if($i == $intAppPage):?>
		<strong><span class="chkPage"><?php echo $i;?></span></strong>
		<?php else:?>
		<a href="javascript:goCommunityListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $i;?>)" ><span class="pageCnt"><?php echo $i;?></span></a>
		<?php endif;?>
		<?php endfor;?>
		<a href="javascript:goCommunityListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $intAppNextBlock;?>)" class="btn_board_next direction"><span><?php echo $LNG_TRANS_CHAR['MW00043'];?></span></a>
	</div>
	<?php endif;?>
	<?php if($isWriteBtn):?>
	<div class="btnRight right">
		<a href="javascript:void(0);" onclick="goCommunityListDataBasicSkinWriteMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_red"><strong><?php echo $LNG_TRANS_CHAR["CW00052"]; // 글쓰기?></strong></a>
	</div>
	<?php endif;?>
	<div class="clr"></div>
</div>
<!-- eumshop app - communityList - dataBasicSkin (<?php echo $strAppID?>) -->

