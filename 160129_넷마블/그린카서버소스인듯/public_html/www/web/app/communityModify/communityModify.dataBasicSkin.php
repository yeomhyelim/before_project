<?php
	/**
	 * eumshop app - communityModify - dataBasicSkin
	 *
	 * 커뮤니티 내용을 수정합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityModify/communityModify.dataBasicSkin.php
	 * @manual		menuType=app&mode=communityModify&skin=dataBasicSkin
	 * @history
	 *				2014.07.21 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_VIEW_{$intAppID}";
	endif;

	## 모듈 설정
	$objBoardFileModule = new BoardFileModule($db);
	$objBoardDataModule = new BoardDataModule($db);

	## 스크립트 설정
	if($S_COMMUNITY_EDTOR != "eumEditor2"):
	$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
	else:
	$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
	endif;
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	$aryScriptEx[]				= "/common/js/app/communityModify/communityModify.dataBasicSkin.js";

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo = $EUMSHOP_APP_INFO['ubNo'];
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	$strAppLang = $S_SITE_LNG;
	$strAppLangLower = strtolower($strAppLang);
	$strAppBCodeLower = strtolower($strAppBCode);
	$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strAppLangLower}";
	$strCommunityCateFile = "category.{$strAppBCode}.info.php"; 
	$intMemberNo = $g_member_no;
	$strMemberGroup = $g_member_group;
	$strCommunityTempWebDir = "/upload/community/temp";
	$strCommunityTempDefaultDir = MALL_SHOP . $strCommunityTempWebDir;
	$arySessionFileList = $_SESSION["FILE"];
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
	if(!$intAppUbNo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "ubNo가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 커뮤니티 카테고리 설정 파일
	include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
	$aryCategoryList = $CATEGORY_LIST;

	## 커뮤니티 설정
	$strBI_START_MODE = $aryAppBoardInfo['BI_START_MODE']; 
	$strB_KIND_SKIN = $aryAppBoardInfo['B_KIND_SKIN']; 
	$strB_CSS = $aryAppBoardInfo['B_CSS'];
	$strBI_DATAWRITE_FORM = $aryAppBoardInfo['BI_DATAWRITE_FORM'];
	$strBI_CATEGORY_USE = $aryAppBoardInfo['BI_CATEGORY_USE'];
	$strBI_DATAWRITE_LOCK_USE = $aryAppBoardInfo['BI_DATAWRITE_LOCK_USE']; // 비밀글 사용 - 사용자선택 = C, 무조건 = E
	$aryBI_DATALIST_FIELD_USE = $aryAppBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목 표시 여부
	$aryBI_DATALIST_WRITER_SHOW = $aryAppBoardInfo['BI_DATALIST_WRITER_SHOW']; // 작성자 표시 항목
	$intBI_DATALIST_WRITER_HIDDEN = $aryAppBoardInfo['BI_DATALIST_WRITER_HIDDEN'];
	$strBI_DATAWRITE_USE = $aryAppBoardInfo['BI_DATAVIEW_USE']; // 글보기권한(모든회원/비회원-A, 회원전용-M)
	$aryBI_DATAWRITE_MEMBER_AUTH = $aryAppBoardInfo['BI_DATAVIEW_MEMBER_AUTH'];
	$intBI_ATTACHEDFILE_USE = $aryAppBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
	$aryBI_ATTACHEDFILE_NAME = $aryAppBoardInfo['BI_ATTACHEDFILE_NAME']; // 첨부파일 이름
	$aryBI_ATTACHEDFILE_KEY = $aryAppBoardInfo['BI_ATTACHEDFILE_KEY']; // 첨부파일 키

	## 사용권한 체크
	if($strBI_DATAWRITE_USE == "M"): // 회원전용인경우
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login");
			return;		
		endif;
		if(!in_array($strMemberGroup, $aryBI_DATAWRITE_MEMBER_AUTH)):
			goErrMsg($LNG_TRANS_CHAR["MS00102"]); // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
			return;
		endif;
	endif;

	## 데이터 불러오기
	$param = "";
	$param['B_CODE'] = $strAppBCode;
	$param['UB_NO'] = $intAppUbNo;
	$param['JOIN_MM'] = "Y";
	$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);

	## 데이터 기본 설정
	$strUB_TITLE = $aryBoardDataRow['UB_TITLE'];
	$strUB_NAME = $aryBoardDataRow['UB_NAME'];
	$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
	$strUB_M_ID = $aryBoardDataRow['UB_M_ID'];
	$strUB_TITLE = $aryBoardDataRow['UB_TITLE'];
	$strUB_REG_DT = $aryBoardDataRow['UB_REG_DT'];
	$intUB_READ = $aryBoardDataRow['UB_READ'];
	$intUB_P_GRADE = $aryBoardDataRow['UB_P_GRADE'];
	$intUB_BC_NO = $aryBoardDataRow['UB_BC_NO'];
	$strUB_TEXT = $aryBoardDataRow['UB_TEXT'];
	$strUB_MAIL = $aryBoardDataRow['UB_MAIL'];
	$strUB_PASS = $aryBoardDataRow['UB_PASS'];
	$strUB_FUNC = $aryBoardDataRow['UB_FUNC'];

	## 작성자 권한 체크
	if($intUB_M_NO): 
		##회원글
		if(!$intMemberNo):
			goUrl("", "./?menuType=member&mode=login");
			return;	
		endif;
		if($intMemberNo != $intUB_M_NO):
			goErrMsg($LNG_TRANS_CHAR["MS00111"]); // 게시판을 수정하실 권한이 없습니다.\\n본인글만 수정할 수 있습니다.
			return;
		endif;
	else: 
		##비회원글

		## 기본 설정
		$strCommunityPasswordCode = $_SESSION['communityPasswordCode']; 

		## 체크
		if(!$strCommunityPasswordCode):
			goErrMsg($LNG_TRANS_CHAR["MS00118"]); // 비회원이 작성한 글은 비밀번호가 필요합니다.
			return;
		endif;
		if(!$strUB_PASS):
			goErrMsg($LNG_TRANS_CHAR["MS00116"]); // 비회원글에 비밀번호가 없습니다. 관리자에게 문의하세요.
			return;
		endif;

		## 비밀번호 체크
		$strTemp = "{$strBCode}_{$intUbNo}_{$strUB_PASS}";
		$strTemp = crypt($strTemp, $strCommunityPasswordCode);
		if($strCommunityPasswordCode != $strTemp):
			goErrMsg($LNG_TRANS_CHAR["MS00111"]); // 게시판을 삭제하실 권한이 없습니다.\\n본인글만 삭제할 수 있습니다.
			return;
		endif;

	endif;

	## UB_FUNC 설정(0~9)
	$aryFunc = "";
	$strFuncNotice = $strUB_FUNC[0]; // 공지글
	$strFuncLock = $strUB_FUNC[1]; // 비밀글
//	$aryFunc[] = $strUB_FUNC[3]; // 대기
//	$aryFunc[] = $strUB_FUNC[4]; // 대기
//	$aryFunc[] = $strUB_FUNC[5]; // 대기
//	$aryFunc[] = $strUB_FUNC[6]; // 대기
//	$aryFunc[] = $strUB_FUNC[7]; // 대기
//	$aryFunc[] = $strUB_FUNC[8]; // 대기
//	$aryFunc[] = $strUB_FUNC[9]; // 대기

	## 카테고리 설정
	$isCategory = false;
	if($strBI_CATEGORY_USE == "Y") { $isCategory = true; }

	## 공지사항 설정
	$isNotice = false;
	if(in_array($strMemberGroup, array("001"))) { $isNotice = true; } // 관리자그룹(001)

	## 답변이 있는경우 공지글을 작성할수 없습니다.
	if($isNotice):

		## 답변 개수 불러오기
		$param = "";
		$param['B_CODE'] = $strAppBCode;
		$param['UB_ANS_NO'] = $intAppUbNo;
		$intAnsCnt = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);

		## 체크
		if($intAnsCnt > 1) { $isNotice = false; }
	endif;

	## 비밀글 설정
	$isLock = false;
	if(in_array($strBI_DATAWRITE_LOCK_USE, array("C","E"))) { $isLock = true; }

	## 비밀번호 설정
	$isPassword = true;
	if($intMemberNo) { $isPassword = false; } // 회원인경우 비밀번호 입력 폼을 숨김.

	## 첨부파일 사용유무
	$isFile = false;
	if($intBI_ATTACHEDFILE_USE):
		
		## 첨부파일 사용 설정
		$isFile = true;

		## 첨부파일 불러오기
		$param = "";
		$param['B_CODE'] = $strAppBCode;
		$param['FL_UB_NO'] = $intAppUbNo;
		$aryBoardFileList = $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);

	endif;

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

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['MW00103']	= $LNG_TRANS_CHAR['MW00103']; // 필수항목
	$aryLanguage['MS00104']	= $LNG_TRANS_CHAR['MS00104']; // {{단어1}}을 입력하세요.
	$aryLanguage['MS00107']	= $LNG_TRANS_CHAR['MS00107']; // {{단어1}}은 필수 항목입니다.
	$aryLanguage['BS00002']	= $LNG_TRANS_CHAR['BS00002']; // 수정되었습니다.
	$aryLanguage['MS00119']	= $LNG_TRANS_CHAR['MS00119']; // 첨부파일을 선택하세요.
	$aryLanguage['BS00001']	= $LNG_TRANS_CHAR['BS00001']; // 등록되었습니다.

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['UB_NO'] = $intAppUbNo;
	$aryAppParam['LANG'] = $strAppLang;
	$aryAppParam['BI_DATAWRITE_END_MOVE'] = $strBI_DATAWRITE_END_MOVE;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;	
?>
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.<?php echo $strB_CSS;?>.css"/>
	<!--h2>
		<span><?php echo $strB_NAME;?></span>
	</h2-->
	<div class="tableFormWrap">
		<form name="modifyForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
		<input type="hidden" name="menuType" value="<?php echo $strMenuType;?>">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="b_code" value="<?php echo $strAppBCode;?>">
		<input type="hidden" name="ub_lng" value="<?php echo $strAppLang;?>">
		<input type="hidden" name="ub_no" value="<?php echo $intAppUbNo;?>">
		<input type="hidden" name="ub_p_code" value="">
		<input type="hidden" name="file_del" value="">
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
									$strSelected = "";

									## select 설정
									if($key == $intUB_BC_NO) { $strSelected = " selected"; }
							?>
							<option value="<?php echo $key;?>"<?php echo $strSelected;?>><?php echo $strBC_NAME;?></option>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?><span>*</span></th>
					<td><input type="text" name="ub_name" value="<?php echo $strUB_NAME;?>" maxlength="10" class="_w300" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00053"]; // 작성자?>"<?php if($intMemberNo){echo " readonly";}?>></td>
				</tr>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["MW00010"]; // 이메일?></th>
					<td><input type="text" name="ub_mail" value="<?php echo $strUB_MAIL;?>" maxlength="25" class="_w300"></td>
				</tr>
				<?php include "communityModify.dataBasicSkin.userfield.inc.php";?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?><span>*</span></th>
					<td><input type="text" name="ub_title" value="<?php echo $strUB_TITLE;?>" style="width:98%;" maxlength="100" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00062"]; // 제목?>">
						<?php if($isNotice):?>
						<input type="checkbox" name="ub_func_notice" value="Y"<?php if($strFuncNotice=="Y"){echo " checked";}?>><?php echo $LNG_TRANS_CHAR["CW00068"]; // 공지글?>
						<?php endif;?>
						<?php if($isLock):?>
						<input type="checkbox" name="ub_func_lock" value="Y"<?php if($strFuncLock=="Y"){echo " checked";}?>><?php echo $LNG_TRANS_CHAR["CW00070"]; // 비밀글?>
						<?php endif;?>
					</td>
				</tr>
				<?php if(in_array("점수",$aryAppColumn)):?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00056"]; // 평점?></th>
					<td><?php for($i=1;$i<=5;$i++):?>
						<input type="radio" name="ub_p_grade" value="<?php echo $i;?>"<?php if($i==$intUB_P_GRADE){echo " checked";}?>>
						<img src="/himg/board/icon/icon_star_<?php echo $i;?>.png">
						<?php endfor;?>	
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th class="name"><?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?><span>*</span></th>
					<td><?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
						<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
						<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="내용"><?php echo $strUB_TEXT;?></textarea>
						<?php else:?>
						<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:300px;" check="empty" alt="<?php echo $LNG_TRANS_CHAR["CW00063"]; // 내용?>"><?php echo $strUB_TEXT;?></textarea>
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
					<td><a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinAtcFormToggleEvent('<?php echo $strAppID;?>');" class="btn_board_write btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["CW00058"]; // 첨부파일?></strong></a>
						<div style="position:relative">
							<div class="atcModifyFileList">
								<?php if($aryBoardFileList):?>
								<ul>
									<?php foreach($aryBoardFileList as $key => $data):
									
											## 기본정보
											$intFL_NO = $data['FL_NO'];
											$strFL_KEY = $data['FL_KEY'];
											$strFL_DIR = $data['FL_DIR'];
											$strFL_NAME = $data['FL_NAME'];
											$aryRealName = explode("_@_", $strFL_NAME);
											$strHtmlTemp = $aryRealName[1];

											## 이미지 설정
											if(in_array($strFL_KEY, array("listImage", "image", "bigImage"))):
												$strHtmlTemp = "<img src='{$strFL_DIR}/{$strFL_NAME}' style='width:50px;height:50px;'>";
											endif;
									?>
									<li class="left" idx="<?php echo $intFL_NO;?>">
										<?php echo $strHtmlTemp;?>
										<a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinAtcDataDeleteMoveEvent('<?php echo $strAppID;?>', <?php echo $intFL_NO;?>)">[X]</a>
									</li>
									<?php endforeach;?>
								</ul>
								<?php endif;?>
							</div>
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
										<a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinAtcDeleteActEvent('<?php echo $strAppID;?>', <?php echo $key;?>)">[X]</a>
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
									<a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinAtcWriteActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_red"><strong><?php echo $LNG_TRANS_CHAR["CW00075"]; // 업로드?></strong></a>
									<a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinAtcFormToggleEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_cancel btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["CW00034"]; // 닫기?></strong></a>
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
	<div class="btnCenter">
		<a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinModifyActEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write btn_board_red"><strong><?php echo $LNG_TRANS_CHAR["OW00072"]; // 글수정?></strong></a>
		<a href="javascript:void(0);" onclick="goCommunityModifyDataBasicSkinCancelMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_cancel btn_board_black"><strong><?php echo $LNG_TRANS_CHAR["MW00044"]; // 취소?></strong></a>
	</div>
</div>




