<?php
	## 스크립트 설정 
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	if($S_COMMUNITY_EDTOR == "eumEditor2"):
	$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
	else:
	$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
	endif;
	$aryScriptEx[]				= "./common/js/community_v2.0/data/dataModify.js";

?>
<div class="contentTop">
	<h2><?php echo $strB_NAME;?></h2>
	<div class="clr"></div>
</div>
<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>
<div class="tableFormWrap">
	<form name="modifyForm" id="modifyForm" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="community_v2.0">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="b_code" value="<?php echo $strBCode;?>">
	<input type="hidden" name="ub_p_code" value="<?php echo $strPCode;?>">
	<input type="hidden" name="ub_no" value="<?php echo $intUbNo;?>">
	<input type="hidden" name="file_del" value="">
	<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
	<table class="tableForm">
		<tr>
			<th>등록번호</th>
			<td><?php echo $intUB_NO;?></td>
		</tr>
		<tr>
			<th>작성언어</th>
			<td><select name="ub_lng">
					<option value="--">언어선택</option>
					<option value="--"<?php if($strUB_LNG=="--"){echo " selected";}?>>전체</option>
					<?php foreach($aryUseLang as $lng):
							
							## 기본 설정
							$strLngName = $S_ARY_COUNTRY[$lng];
					?>
					<option value="<?php echo $lng;?>"<?php if($strUB_LNG==$lng){echo " selected";}?>><?php echo $strLngName;?></option>
					<?php endforeach;?>
				</select>					
			</td>
		</tr>
		<?php if(in_array("카테고리", $aryColumn)):?>
		<tr>
			<th>카테고리</th>
			<td>
				<select name="ub_bc_no">
					<option value="">카테고리 선택</option>
					<?php foreach($aryCategoryList as $key => $data):
					
							## 기본설정
							$strBC_NAME = $data['bc_name'];
					?>
					<option value="<?php echo $key;?>"<?php if($intUB_BC_NO==$key){echo " selected";}?>><?php echo $strBC_NAME;?></option>
					<?php endforeach;?>
				</select>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<th>작성일시</th>
			<td><?php echo $strUB_REG_DT;?></td>
		</tr>
		<tr>
			<th>작성자 (아이디)</th>
			<td>
				<?php echo $strUB_NAME;?>
				<?if($isBtnUseCrn):?>
				 <a href="javascript:void(0);" onclick="goCommunityDataViewCRMMoveEvent(<?php echo $intUB_M_NO;?>);" class='btn_blue_sml'><span>CRM</span></a>
				<?endif;?>
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td><input type="text" name="ub_mail" value="<?php echo $strUB_MAIL;?>" maxlength="25" class="_w300"></td>
			<!-- td><?php echo $strUB_MAIL;?></td //-->
		</tr>
		<? include "dataModify.userfield.inc.php"; ?>
		<tr>
			<th class="name">제목<span>*</span></th>
			<td><input type="text" name="ub_title" style="width:98%;" maxlength="100" check="empty" alt="제목" value="<?php echo $strUB_TITLE;?>"><br>
				<input type="checkbox" name="ub_func_notice" value="Y"<?php if($strFuncNotice=="Y"){echo " checked";}?>>공지글
				<input type="checkbox" name="ub_func_lock" value="Y"<?php if($strFuncLock=="Y"){echo " checked";}?>> 비밀글
			</td>
		</tr>
		<?php if(in_array("점수",$aryColumn)):?>
		<tr>
			<th class="name">평점</th>
			<td><?php for($i=1;$i<=5;$i++):?>
				<input type="radio" name="ub_p_grade" value="<?php echo $i;?>"<?php if($i==$intUB_P_GRADE){echo " checked";}?>>
				<img src="/himg/board/icon/icon_star_<?php echo $i;?>.png">
				<?php endfor;?>	
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<th>내용</th>
			<td>
				<?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
				<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
				<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="내용"><?php echo $strUB_TEXT;?></textarea>
				<?php else:?>
				<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:300px;" check="empty" alt="내용"><?php echo $strUB_TEXT;?></textarea>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>IP</th>
			<td><?php echo $strUB_IP;?></td>
		</tr>
		<?php if($isFile):?>
		<tr>
			<th class="name">첨부파일<span>*</span></th>
			<td><a href="javascript:void(0);" onclick="goCommunityDataModifyAtcFormToggleEvent();" class="btn_board_write"><strong>첨부파일</strong></a>
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
								<a href="javascript:void(0);" onclick="goCommunityDataModifyAtcDataDeleteMoveEvent(<?php echo $intFL_NO;?>)">[X]</a>
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
								<a href="javascript:void(0);" onclick="goCommunityDataModifyAtcDeleteActEvent(<?php echo $key;?>)">[X]</a>
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
							<a href="javascript:void(0);" onclick="goCommunityDataModifyAtcWriteActEvent();" id="menu_auth_w" class="btn_board_write"><strong>업로드</strong></a>
							<a href="javascript:void(0);" onclick="goCommunityDataModifyAtcFormToggleEvent();" id="menu_auth_w" class="btn_board_cancel"><strong>닫기</strong></a>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>
<div class="button">
	<a class="btn_big" href="javascript:void(0);" onclick="goCommunityDataModifyActEvent();" id="menu_auth_w" style=""><strong>수정</strong></a>
	<a class="btn_big" href="javascript:void(0);" onclick="goCommunityDataModifyCancelMoveEvent();" ><strong>취소</strong></a>
</div>