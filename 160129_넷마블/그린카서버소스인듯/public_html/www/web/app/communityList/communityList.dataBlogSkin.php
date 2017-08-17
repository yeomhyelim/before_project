<?php
	/**
	 * eumshop app - communityList - dataBlogSkin
	 *
	 * 커뮤니티 리스트를 불러옵니다.(블로그 스킨)
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityList/communityList.dataBlogSkin.php
	 * @manual		menuType=app&mode=communityList&skin=dataBlogSkin
	 * @history
	 *				2014.08.03 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_LIST_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardFileModule = new BoardFileModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/communityList/communityList.dataBlogSkin.js";

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	$strSiteFacebook = $S_SITE_FACEBOOK;
	$strSiteTwitter = $S_SITE_TWITTER;
	$strSiteFacebookAppID = $S_SITE_FACEBOOK_APP_ID;
	$strSiteFacebookSecret = $S_SITE_FACEBOOK_SECRET;

	## 커뮤니티 설정
	$strBI_DATAVIEW_FACEBOOK_USE = $aryAppBoardInfo['BI_DATAVIEW_FACEBOOK_USE']; // 페이스북 사용 유무
	$strBI_DATAVIEW_TWITTER_USE = $aryAppBoardInfo['BI_DATAVIEW_TWITTER_USE']; // 트위터 사용 유무

	## 페이스북 사용유무
	$isFacebookUse = false;
	if($strSiteFacebook == "Y" && $strBI_DATAVIEW_FACEBOOK_USE == "Y"):
		if($strSiteFacebookAppID && $strSiteFacebookSecret):
			$isFacebookUse = true;
		endif;
	endif;
	if($isFacebookUse):

		## facebook script 정보
		$aryFacebookInfo['APP_ID'] = $strSiteFacebookAppID;
//		$aryFacebookInfo['SECRET'] = $strSiteFacebookSecret;
		$aryFacebookInfo['NAME'] = $strUB_TITLE;
		$aryFacebookInfo['LINK'] = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";
		$aryFacebookInfo['PICTURE'] = "http://{$S_HTTP_HOST}{$S_WEB_LOGO_IMG}";
		$aryFacebookInfo['CAPTION'] = $S_SITE_NM;
		$aryFacebookInfo['DESCRIPTION'] = $S_SITE_URL;

		## script data 만들기
		$aryAppParam['FACEBOOK'] = $aryFacebookInfo;
		$aryScriptData['APP'][$strAppID] = $aryAppParam;	

		## 스크립트 설정
		$aryScriptEx[] = "http://connect.facebook.net/en_US/all.js";
		$aryScriptEx[] = "/common/js/classes/sns/snsClass.js";	
	endif;

	## 트위터 사용유무
	$isTwitterUse = false;
	if($strSiteTwitter == "Y" && $strBI_DATAVIEW_TWITTER_USE == "Y") { $isTwitterUse = true; }

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['PS00018']	= $LNG_TRANS_CHAR['PS00018']; // 삭제하시겠습니까?

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;	

	## 리스트 기본 
	$EUMSHOP_APP_INFO = "";
	$EUMSHOP_APP_INFO['name'] = "커뮤니티_리스트";
	$EUMSHOP_APP_INFO['mode'] = "communityList";
//	$EUMSHOP_APP_INFO['appID'] = $strAppID;
	$EUMSHOP_APP_INFO['skin'] = "dataBasicSkin";
	$EUMSHOP_APP_INFO['view'] = "N";
	$EUMSHOP_APP_INFO['bCode'] = $strBCode;
	$EUMSHOP_APP_INFO['boardInfo'] = $aryAppBoardInfo;
	include MALL_HOME . "/web/app/index.php";
?>

<!-- eumshop app - communityList - dataGallerySkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<h2>
		<span><?php echo $strB_NAME;?></span>
	</h2>
	<div class="boardTopWrap">
		<div class="boardCntWrap"><strong><?php echo $intAppTotal;?></strong>(<span><?php echo $intAppPage;?></span>/<span><?php echo $intAppTotPage;?></span>Page)</div>
		<div class="boardTopSearchWrap" >
			<select id="searchKey" data-select="<?php echo $strAppSearchKey;?>">
				<option value="title"><?php echo $LNG_TRANS_CHAR['CW00062']; // 제목?></option>
				<option value="text"><?php echo $LNG_TRANS_CHAR['CW00063']; // 내용?></option>
				<option value="title_text"><?php echo "{$LNG_TRANS_CHAR['CW00062']}+{$LNG_TRANS_CHAR['CW00063']}"; // 제목+내용?></option>
				<option value="name"><?php echo $LNG_TRANS_CHAR['CW00053']; // 작성자?></option>
				<option value="id"><?php echo $LNG_TRANS_CHAR['MW00001']; // 아이디?></option>
			</select>
			<input type="text" id="searchVal" value="<?php echo $strAppSearchVal;?>" onkeydown="if(event.keyCode==13){goCommunityListDataBasicSkinSearchMoveEvent('<?php echo $strAppID;?>');}">
			<a href="javascript:void(0);" onclick="goCommunityListDataBasicSkinSearchMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btnBoardSearch"><strong>검색</strong></a>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="tableForm">
				<?php if(!$intAppTotal):?>
				<table class="tableForm">
					<tbody>
						<tr>
							<td><?php $LNG_TRANS_CHAR["MS00101"]; // 등록된 내용이 업습니다.?></td>
						<tr>
					</tbody>
				</table>
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
						$strUB_TEXT = $row['UB_TEXT'];	
		
						## 조회수 설정
						$strUB_READ = number_format($intUB_READ);

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

						## 첨부파일 불러오기
						$param = "";
						$param['B_CODE'] = $strAppBCode;
						$param['FL_UB_NO'] = $intUB_NO;
						$aryBoardFileList = $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);
						
						## 첨부파일 설정
						$aryBoardFile = "";
						if($aryBoardFileList):
							foreach($aryBoardFileList as $key => $row):
								
								## 기본설정
								$strFL_KEY = $row['FL_KEY'];

								## 만들기
								$aryBoardFile[$strFL_KEY][] = $row;

							endforeach;
						endif;

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

						## 작성자 권한 체크
						$isModify = false;
						$isDelete = false;
						if($intUB_M_NO): 
							##회원글
							if($intMemberNo && $intMemberNo == $intUB_M_NO):
								$isModify = true;
								$isDelete = true;
							endif;
						else: 
							##비회원글
							$isModify = true;
							$isDelete = true;
						endif;
				?>
				<table class="tableForm">
					<tbody>
						<tr>
							<th class="boardTit" colspan="4"><?php echo $strUB_TITLE;?><?php echo $strLockHtml;?></th>
						</tr>
						<?php if(in_array("카테고리",$aryAppColumn)):?>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["CW00064"]; // 카테고리?></th>
							<td colspan="4" style="text-align:left"><?php echo $strCategoryName;?></td>
						</tr>
						<?php endif;?>
						<?php if(in_array("작성자",$aryAppColumn)):?>
						<tr class="writerInfo">
							<th class="name"><?php echo $LNG_TRANS_CHAR["CW00053"]; //작성자?></th>
							<td class="writerVal" colspan="<?php echo $intWriteColspan;?>">
								<?php if(in_array("성명",$aryAppColumn)):?>
								<span class="txtName"><?php echo $strUB_NAME;?></span>
								<?php endif;?>
								<?php if(in_array("아이디",$aryAppColumn)):?>
								<span class="txtName"><?php echo $strUB_M_ID;?></span>
								<?php endif;?>
								<?php if(in_array("닉네임",$aryAppColumn)):?>
								<span class="txtName"><?php echo $strMM_NICK_NAME;?></span>
								<?php endif;?>
								<span class="txtDate"><?php echo $strRegDate;?></span>
							</td>
						</tr>
						<?php endif;?>
						<?php include "communityList.dataBlogSkin.userfield.inc.php";?>
						<?php if(in_array("점수",$aryAppColumn)):?>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["CW00056"]; // 평점?></th>
							<td colspan="3" style="text-align:left">
								<img src="/himg/board/icon/icon_star_<?php echo $intUB_P_GRADE;?>.png">
							</td>
						</tr>
						<?php endif;?>
						<?php if($aryBoardFile['file']):?>
						<tr>
							<th><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?></th>
							<td colspan="3" style="text-align:left">
								<?php foreach($aryBoardFile['file'] as $key => $row):
										
										## 기본 설정
										$intFL_NO = $row['FL_NO'];
										$intFL_SIZE = $row['FL_SIZE'];
										$strFL_NAME = $row['FL_NAME'];

										## 파일명 설정
										list($strFrontName, $strRealName) = explode("_@_", $strFL_NAME);

										## 파일 크기 설정
										$strUnit = "byte";
										if($intFL_SIZE > 1024):
											$strUnit = "kb";
											$intFL_SIZE = $intFL_SIZE / 1024;
										endif;
										if($intFL_SIZE > 1024):
											$strUnit = "mb";
											$intFL_SIZE = $intFL_SIZE / 1024;
										endif;
										if($intFL_SIZE > 1024):
											$strUnit = "gb";
											$intFL_SIZE = $intFL_SIZE / 1024;
										endif;
										$strFL_SIZE = number_format($intFL_SIZE);
										$strFL_SIZE = "{$strFL_SIZE}{$strUnit}";
								?>
								<p><a href="javascript:void(0);" onclick="goCommunityListDataBlogSkinFileDownEvent('<?php echo $strAppID;?>',<?php echo $intFL_NO;?>)"><?php echo $strRealName;?> <span>(<?php echo $strFL_SIZE;?>)</span></a></p>
								<?php endforeach;?>
							</td>
						</tr>
						<?php endif;?>
					</tbody>
				</table>
				<div class="viewContentArea">
					<?php if($aryBoardFile['image']):?>
					<div class="community-view-image">
						<?php foreach($aryBoardFile['image'] as $key => $row):
									
								## 기본 설정
								$strFL_DIR = $row['FL_DIR'];
								$strFL_NAME = $row['FL_NAME'];

								## 이미지 설정
								$strImageFile = "{$strFL_DIR}/{$strFL_NAME}";
						?>
						<img src="<?php echo $strImageFile;?>">
						<?php endforeach;?>
					</div>
					<?php endif;?>
					<?php echo $strUB_TEXT;?>
				</div>
				<?php if($isTwitterUse || $isFacebookUse):?>
				<div class="snsIcoWrap">
					<?php if($isTwitterUse):?>
					<a href="javascript:void(0);" onclick="goCommunityListDataBlogSkinTwitterMoveEvent('<?php echo $strAppID;?>');"><img src="/images/icon_twitter.png"></a>
					<?php endif;?>
					<?php if($isFacebookUse):?>
					<a href="javascript:void(0);" onclick="goCommunityListDataBlogSkinFacebookMoveEvent('<?php echo $strAppID;?>');"><img src="/images/icon_facebook.png"></a>
					<?php endif;?>
				</div>
				<?php endif;?>
				<div class="btnRight right">
					<?php if($isModify):?>
					<a href="javascript:void(0);" onclick="goCommunityListDataBlogSkinModifyMoveEvent('<?php echo $strAppID;?>',<?php echo $intUB_NO;?>);" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["OW00072"]; // 수정?></strong></a>
					<?php endif;?>
					<?php if($isDelete):?>
					<a href="javascript:void(0);" onclick="goCommunityListDataBlogSkinDeleteActEvent('<?php echo $strAppID;?>',<?php echo $intUB_NO;?>);" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00036"]; // 삭제?></strong></a>
					<?php endif;?>
				</div>
				<?php endwhile;?>
				<?php endif;?>
	</div>
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
	<div class="btnRight right">
		<a href="javascript:void(0);" onclick="goCommunityListDataBasicSkinWriteMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00052"]; // 글쓰기?></strong></a>
	</div>
	<div class="clr"></div>
</div>
<!-- eumshop app - communityList - dataGallerySkin (<?php echo $strAppID?>) -->

