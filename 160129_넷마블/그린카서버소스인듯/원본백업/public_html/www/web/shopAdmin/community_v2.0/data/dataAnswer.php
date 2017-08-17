<?php
	## 스크립트 설정 
	$aryScriptEx[]				= "/common/js/jquery.form.js";
	if($S_COMMUNITY_EDTOR == "eumEditor2"):
	$aryScriptEx[]				= "/common/eumEditor2/js/eumEditor2.js";
	else:
	$aryScriptEx[]				= "/common/eumEditor/highgardenEditor.js";
	endif;
	$aryScriptEx[]				= "./common/js/community_v2.0/data/dataAnswer.js";

?>
<div class="contentTop">
	<h2><?php echo $strB_NAME;?></h2>
	<div class="clr"></div>
</div>
<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>
<div class="tableForm">
	<table>
		<tr>
			<th>작성언어</th>
			<td><?php echo $strUB_LNG_NAME;?></td>
		</tr>
		<?php if(in_array("카테고리", $aryColumn)):?>
		<tr>
			<th>카테고리</th>
			<td><?php echo $strUB_BC_NO_NAME;?></td>
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
			<td><?php echo $strUB_MAIL;?></td>
		</tr>
		<? include "dataView.userfield.inc.php"; ?>
		<tr>
			<th>[번호] 제목</th>
			<td>[<?php echo $intUB_NO;?>] <?php echo $strUB_TITLE;?></td>
		</tr>
		<?php if(in_array("점수",$aryColumn)):?>
		<tr>
			<th>평점</th>
			<td><img src="/himg/board/icon/icon_star_<?php echo $intUB_P_GRADE;?>.png"></td>
		</tr>
		<?php endif;?>
		<tr>
			<th>내용</th>
			<td>
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
				<div class="viewContentArea"><?php echo $strUB_TEXT;?></div>
			</td>
		</tr>
		<tr>
			<th>IP</th>
			<td><?php echo $strUB_IP;?></td>
		</tr>
		<?php if($aryBoardFile['listImage']):?>
		<tr>
			<th>리스트이미지</th>
			<td colspan="3" style="text-align:left">
				<?php foreach($aryBoardFile['listImage'] as $key => $row):
							
						## 기본 설정
						$strFL_DIR = $row['FL_DIR'];
						$strFL_NAME = $row['FL_NAME'];

						## 이미지 설정
						$strImageFile = "{$strFL_DIR}/{$strFL_NAME}";
				?>
				<p><img src="<?php echo $strImageFile;?>"></p>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endif;?>
		<?php if($aryBoardFile['file']):?>
		<tr>
			<th>첨부파일</th>
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
				<p><a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinFileDownEvent('<?php echo $strAppID;?>',<?php echo $intFL_NO;?>)"><?php echo $strRealName;?> <span>(<?php echo $strFL_SIZE;?>)</span></a></p>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>

<!-- 답변 //-->
<div class="tableFormWrap">
	<form name="answerForm" id="tx_editor_form" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="community_v2.0">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="b_code" value="<?php echo $strBCode;?>">
	<input type="hidden" name="ub_p_code" value="<?php echo $strPCode;?>">
	<input type="hidden" name="ub_lng" value="<?php echo $strUB_LNG;?>">
	<input type="hidden" name="ub_no" value="<?php echo $intUB_NO;?>">
	<input type="hidden" name="editorDir" value="<?php echo $strEditorDir;?>">
	<table class="tableForm">
		<tr>
			<th class="name">작성자<span>*</span></th>
			<td><input type="text" name="ub_name" value="<?php echo $strMemberName;?>" maxlength="10" class="_w300" check="empty" alt="작성자"></td>
		</tr>
		<tr>
			<th class="name">이메일</th>
			<td><input type="text" name="ub_mail" value="<?php echo $strMemberEmail;?>" maxlength="25" class="_w300"></td>
		</tr>
		<tr>
			<th class="name">제목<span>*</span></th>
			<td><input type="text" name="ub_title" style="width:98%;" maxlength="100" check="empty" alt="제목" value="Re] <?php echo $strUB_TITLE;?>">
			</td>
		</tr>
		<tr>
			<th class="name">내용<span>*</span></th>
			<td>
				<?php if($S_COMMUNITY_EDTOR == "eumEditor2"):?>
				<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
				<textarea name="ub_text" id="ub_text"  style="display:none" check="empty" alt="내용"></textarea>
				<?php else:?>
				<textarea name="ub_text" id="ub_text" title="<?php echo $strBI_DATAWRITE_FORM;?>" style="width:98%;height:300px;" check="empty" alt="내용"></textarea>
				<?php endif;?>
			</td>
		</tr>
		<?php if($isFile):?>
		<tr>
			<th class="name">첨부파일<span>*</span></th>
			<td><a href="javascript:void(0);" onclick="goCommunityDataAnswerAtcFormToggleEvent();" class="btn_blue_sml"><span>첨부파일</span></a>
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
								<a href="javascript:void(0);" onclick="goCommunityDataAnswerAtcDeleteActEvent(<?php echo $key;?>)">[X]</a>
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
							<a href="javascript:void(0);" onclick="goCommunityDataAnswerAtcWriteActEvent();" class="btn_blue_sml"><span>업로드</span></a>
							<a href="javascript:void(0);" onclick="goCommunityDataAnswerAtcFormToggleEvent();" class="btn_blue_sml"><span>닫기</span></a>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php endif;?>
	</table>
	</form>
</div>
<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="goCommunityAnswerActEvent();" id="menu_auth_w"><strong class="ico_write">답변등록</strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityAnswerViewMoveEvent();" ><strong class="ico_cancel">취소</strong></a>
</div>
<!-- 답변 //-->