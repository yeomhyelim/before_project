<?php
	/**
	 * eumshop app - communityWrite - dataBasicSkin
	 *
	 * 커뮤니티 쓰기폼 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityWrite/communityWrite.dataBasicSkin.php
	 * @manual		menuType=app&mode=communityWrite&skin=dataBasicSkin
	 * @history
	 *				2014.07.18 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_WRITE_{$intAppID}";
	endif;

	## 스크립트 설정
	if($S_COMMUNITY_EDTOR != "eumEditor2"):
	$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
	else:
	$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
	endif;
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	$aryScriptEx[]				= "/common/js/app/communityWrite/communityWrite.dataBasicSkin.js";

	## 커뮤니티 코드 설정
	$strAppBCode = $EUMSHOP_APP_INFO['b_code'];
	if(!$strAppBCode) { $strAppBCode = $_GET['b_code']; }
	if(!$strAppBCode) { return; }
	$strAppBCodeLower = strtolower($strAppBCode);

	## 언어 설정
	$strLang = $S_SITE_LNG;
	$strLangS = $S_ST_LNG;
	$strLangLower = strtolower($strLang);
	$strLangSLower = strtolower($strLangS);

	## 커뮤니티 보드 설정
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	if(!$aryAppBoardInfo):
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfo = $BOARD_INFO[$strAppBCode];
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangSLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfoS = $BOARD_INFO[$strAppBCode];
		foreach($aryAppBoardInfoS as $key => $data):
			$strTemp = $aryAppBoardInfo[$key];
			if($strTemp) { continue; }
			$aryAppBoardInfo[$key] = $data;
		endforeach;
	endif;

	## 기본 설정	
	$strAppPCode = $EUMSHOP_APP_INFO['pCode'];
	$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strLangLower}";
	$strCommunityCateFile = "category.{$strBCode}.info.php"; 
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;
	$strMemberName = $g_member_name; // 영문 - 이름, 한글 - 기록 안됨
	$strMemberLastName = $g_member_last_name; // 영문 - 성, 한글 - 성 + 이름
	$strMemberEmail = $g_member_email;
	$arySessionFileList = $_SESSION['FILE']; // 세션에 등록된 파일 리스트
//	$strLayout = $_GET['layout']; // 상단에서 처리하고 있음.
	$strEditorDir = "community/{$strAppBCodeLower}";

	## 체크
	if(!$strAppBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		getDebug($param);
		return;
	endif;
	if(!$aryAppBoardInfo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "boardInfo가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 회원인경우 추가 설정.
	$strUbName = "";
	if($intMemberNo):
		## 이름 설정. 세션정보에서 다시 가져옵니다.
		if($strMemberName && $strMemberLastName) { $strUbName = "{$strMemberName} {$strMemberLastName}"; }
		else if($strMemberLastName) { $strUbName = $strMemberLastName; }
		else if($strMemberName) { $strUbName = $strMemberName; }
	endif;

	## 커뮤니티 설정
	$strB_CSS = $aryAppBoardInfo['B_CSS'];
	$strBI_DATAWRITE_FORM = $aryAppBoardInfo['BI_DATAWRITE_FORM']; // 글쓰기 폼 설정
	$strBI_CATEGORY_USE = $aryAppBoardInfo['BI_CATEGORY_USE']; // 카테고리 사용 - 사용(모든사용자) = Y, 사용(관리자만) = A, 사용안함 = N
	$strBI_DATAWRITE_LOCK_USE = $aryAppBoardInfo['BI_DATAWRITE_LOCK_USE']; // 비밀글 사용 - 사용자선택 = C, 무조건 = E
	$strBI_DATAWRITE_USE = $aryAppBoardInfo['BI_DATAWRITE_USE']; // 쓰기권한(모든회원/비회원-A, 회원전용-M)
	$aryBI_DATAWRITE_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAWRITE_MEMBER_AUTH']; // 쓰기권한 그룹 리스트
	$intBI_ATTACHEDFILE_USE = $aryAppBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
	$aryBI_ATTACHEDFILE_NAME = $aryAppBoardInfo['BI_ATTACHEDFILE_NAME']; // 첨부파일 이름
	$aryBI_ATTACHEDFILE_KEY = $aryAppBoardInfo['BI_ATTACHEDFILE_KEY']; // 첨부파일 키
	$strBI_START_MODE = $aryAppBoardInfo['BI_START_MODE']; // 시작페이지 
	$strBI_DATAWRITE_END_MOVE = $aryAppBoardInfo['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동 
	$aryBI_DATALIST_FIELD_USE = $aryAppBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목 표시 여부
	$aryBI_DATALIST_WRITER_SHOW = $aryAppBoardInfo['BI_DATALIST_WRITER_SHOW']; // 작성자 표시 항목

	## 사용권한 체크
	if($strBI_DATAWRITE_USE == "M"): // 회원전용인경우
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login&layout={$strLayout}");
			return;		
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATAWRITE_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;
		endif;
	endif;

	## 커뮤니티 카테고리 설정 파일
	include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
	$aryCategoryList = $CATEGORY_LIST;

	## 카테고리 설정
	$isCategory = false;
	if($strBI_CATEGORY_USE == "Y") { $isCategory = true; }

	## 공지사항 설정
	$isNotice = false;
	if(in_array($strMemberGroup, array("001"))) { $isNotice = true; } // 관리자그룹(001)

	## 비밀글 설정
	$isLock = false;
	if(in_array($strBI_DATAWRITE_LOCK_USE, array("C","E"))) { $isLock = true; }

	## 비밀번호 설정
	$isPassword = true;
	if($intMemberNo) { $isPassword = false; } // 회원인경우 비밀번호 입력 폼을 숨김.

	## 첨부파일 사용유무
	$isFile = true;
	if(!$intBI_ATTACHEDFILE_USE) { $isFile = false; }

	## 목록 설정
	$aryAppColumn = array();
//	$aryAppColumn[] = "제목";
//	if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryAppColumn[] = "번호"; }
//	if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryAppColumn[] = "작성자"; }
//	if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryAppColumn[] = "등록일"; }
//	if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryAppColumn[] = "조회수"; }
	if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryAppColumn[] = "점수"; }
//	if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryAppColumn[] = "카테고리"; }
//	if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryAppColumn[] = "리스트이미지"; }

	## 작성자 설정
//	if(in_array("작성자", $aryAppColumn)):
//		if($aryBI_DATALIST_WRITER_SHOW[0] == "Y") { $aryAppColumn[] = "성명"; }
//		if($aryBI_DATALIST_WRITER_SHOW[1] == "Y") { $aryAppColumn[] = "아이디"; }
//		if($aryBI_DATALIST_WRITER_SHOW[2] == "Y") { $aryAppColumn[] = "닉네임"; }
//	endif;

	## 취소 버튼 표시 여부
	## 시작페이지, 글쓰기후 이동이 모두 글쓰기로 이동이면, 취소 버튼을 숨김 처리
	$isCancelBtnShow = true;
	if($strBI_START_MODE == "dataWrite" && $strBI_DATAWRITE_END_MOVE == "dataWrite") { $isCancelBtnShow = false; } 

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['MW00103']	= $LNG_TRANS_CHAR['MW00103']; // 필수항목
	$aryLanguage['MS00104']	= $LNG_TRANS_CHAR['MS00104']; // {{단어1}}을 입력하세요.
	$aryLanguage['MS00107']	= $LNG_TRANS_CHAR['MS00107']; // {{단어1}}은 필수 항목입니다.
	$aryLanguage['MS00119']	= $LNG_TRANS_CHAR['MS00119']; // 첨부파일을 선택하세요.
	$aryLanguage['BS00001']	= $LNG_TRANS_CHAR['BS00001']; // 등록되었습니다.

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['LANG'] = $strLang;
	$aryAppParam['BI_DATAWRITE_END_MOVE'] = $strBI_DATAWRITE_END_MOVE;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

	if($strAppView == "N") { return; }	
?>
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<!--h2>
		<span><?php echo $strB_NAME;?></span>
	</h2-->
	<div class="tableFormWrap">
		<form name="writeForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
		<input type="hidden" name="menuType" value="<?php echo $strMenuType;?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="b_code" value="<?php echo $strAppBCode;?>">
		<input type="hidden" name="ub_lng" value="<?php echo $strLang;?>">
		<input type="hidden" name="ub_p_code" value="<?php echo $strAppPCode;?>">
		<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
		<table class="tableForm">
			<colgroup>
				<col width="150">
				<col>
			</colgroup>
			<tbody>
				<?php if($isCategory):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00064"]; // 카테고리?><span>*</span></th>
					<td><select name="ub_bc_no" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00064"]; // 카테고리?>">
							<option value=""><?php echo $LNG_TRANS_CHAR["MS00103"]; // 선택하세요.?></option>
							<?php foreach($aryCategoryList as $key => $data):
							
									## 기본설정
									$strBC_NAME = $data['bc_name'];							
							?>
							<option value="<?php echo $key;?>"><?php echo $strBC_NAME;?></option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?><span>*</span></th>
					<td><input type="text" name="ub_name" value="<?php echo $strUbName;?>" maxlength="10" class="_w300" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?>"<?php if($intMemberNo){echo " readonly";}?>></td>
				</tr>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00010"]; // 이메일?></th>
					<td><input type="text" name="ub_mail" value="<?php echo $strMemberEmail;?>" maxlength="25" class="_w300"></td>
				</tr>
				<?php include "communityWrite.dataBasicSkin.userfield.inc.php";?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?><span>*</span></th>
					<td><input type="text" name="ub_title" style="width:98%;" maxlength="100" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?>">
						<?php if($isNotice):?>
						<input type="checkbox" name="ub_func_notice"><?php echo $LNG_TRANS_CHAR["CW00068"]; // 공지글?>
						<?php endif;?>
						<?php if($isLock):?>
						<input type="checkbox" name="ub_func_lock" value="Y"<?php if($strBI_DATAWRITE_LOCK_USE=="E"){echo " checked disabled";}?>><?php echo $LNG_TRANS_CHAR["CW00070"]; // 비밀글?>
						<?php endif;?>
					</td>
				</tr>
				<?php if(in_array("점수",$aryAppColumn)):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00056"]; // 평점?></th>
					<td><?php for($i=1;$i<=5;$i++):?>
						<input type="radio" name="ub_p_grade" value="<?php echo $i;?>"<?php if($i==5){echo " checked";}?>>
						<img src="/himg/board/icon/icon_star_<?php echo $i;?>.png">
						<?php endfor;?>	
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?><span>*</span></th>
					<td><?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
						<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
						<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="내용"></textarea>
						<?php else:?>
						<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:300px;" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?>"></textarea>
						<?php endif;?>
					</td>
				</tr>
				<?php if($isPassword):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?><span>*</span></th>
					<td><input type="password" name="ub_pass" class="_w300" maxlength="12" check="empty" alt="<?php echo $LNG_TRANS_CHAR["MW00002"]; // 비밀번호?>"></td>
				</tr>
				<?php endif;?>
				<?php if($isFile):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?><span>*</span></th>
					<td><a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcFormToggleEvent('<?php echo $strAppID;?>');" class="btn_board_write btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?></strong></a>
						<div style="position:relative">
							<div class="atcFileList">
								<?php if($arySessionFileList):?>
								<ul>
									<?php foreach($arySessionFileList as $key => $data):
			
											## 기본 설정
											$isDEL = $data['DEL'];
											$intATC_FL_NO = $data['ATC_FL_NO'];
											$intATC_UB_NO = $data['ATC_UB_NO'];
											$strATC_KEY = $data['ATC_KEY'];
											$strATC_DIR = $data['ATC_DIR'];
											$strATC_FILE = $data['ATC_FILE'];
											$aryRealName = explode("_@_", $strATC_FILE);
											$strHtmlTemp = $aryRealName[1];

											## 이미지 설정
											if(in_array($strATC_KEY, array("listImage", "image", "bigImage"))):
												$strHtmlTemp = "<img src='{$strATC_DIR}/{$strATC_FILE}' style='width:50px;height:50px;'>";
											endif;
									?>
									<li class="left">
										<?php echo $strHtmlTemp;?>
										<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcDeleteActEvent('<?php echo $strAppID;?>', <?php echo $key;?>)">[X]</a>
									</li>
									<?php endforeach;?>
									<div class="clr"></div>
								</ul>
								<?php endif;?>
							</div>
							<div class="atcForm hide" style="position:absolute;background:#ffffff;width:300px;height:300px;border:4px solid #afafaf;top:-345px;">
								<div class="tableForm">
									<table class="tableForm">
										<colgroup>
											<col width="150">
											<col>
										</colgroup>
										<tbody>
											<?php for($i=0;$i<$intBI_ATTACHEDFILE_USE;$i++):
											
													## 기본 설정
													$strAtcName = $aryBI_ATTACHEDFILE_NAME[$i];
											?>
											<tr>
												<th><?php echo $strAtcName;?></th>
												<td>
													<input type="file" name="file_<?php echo $i;?>"/>
												</td>
											</tr>
											<?php endfor;?>
										</tbody>
									</table>	
								</div>
								<div class="btnCenter">
									<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcWriteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_red"><strong><?php echo $LNG_TRANS_CHAR["CW00075"]; // 업로드?></strong></a>
									<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinAtcFormToggleEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_cancel btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["CW00034"]; // 닫기?></strong></a>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?php endif;?>
			</tbody>
		</table>
		</form>
	</div>
	<div class="btnCenter mb20">
		<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinWriteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_red"><strong><?php echo $LNG_TRANS_CHAR["CW00052"]; // 글쓰기?></strong></a>
		<?php if($isCancelBtnShow):?>
		<a href="javascript:void(0);" onclick="goCommunityWriteDataBasicSkinCancelMoveEvent();" id="menu_auth_w" class="btn_board_cancel btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["MW00044"]; // 취소?></strong></a>
		<?php endif;?>
	</div>
</div>



