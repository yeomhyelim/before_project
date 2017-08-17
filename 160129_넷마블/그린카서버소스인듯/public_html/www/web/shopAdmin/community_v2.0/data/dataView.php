<style>
	.tableForm td ul li{display:inline-block;*display:inline;*zoom:1;vertical-align:middle;}
	.tableForm td ul li.prodImg img{
		width:82px;height:82px;
		border:1px solid #bdbdbd;
		-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;
		box-shadow:0px 2px 8px #E5E5E5;
	}
	.tableForm td ul li.prodInfo{margin-left:13px;}
	.tableForm td ul li.prodInfo .title{margin:15px 0 10px;font-size:16px;font-weight:bold;color:#000;}
	/* td ul li.prodInfo .title{margin:20px 0 6px;font-size:16px;font-weight:bold;color:#000;}*/
	.tableForm td ul li.prodInfo .info{margin-top:2px;}
	.tableForm td ul li.prodInfo .info span{display:inline-block;*display:inline;*zoom:1;width:60px;font-size:11px;color:#AAA;}
	.tableForm td ul li.prodInfo .info strong{color:#444;}
</style>
<?php
## 스크립트 설정
$aryScriptEx[]				= "/common/js/jquery.form.js";
$aryScriptEx[]				= "./common/js/community_v2.0/data/dataView.js";
?>
<div class="contentTop">
	<h2><?php echo $strB_NAME;?></h2>
	<div class="clr"></div>
</div>
<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>
<div class="tableFormWrap">
	<input type="hidden" name="ubNo" value="<?php echo $intUbNo;?>"/>
	<input type="hidden" name="b_code" value="<?php echo $strBCode;?>"/>
	<table class="tableForm">
		<tr>
			<th>등록번호</th>
			<td><?php echo $intUB_NO;?></td>
		</tr>
		<?php if($intUseLang>1):?>
		<tr>
			<th>작성언어</th>
			<td><?php echo $strUB_LNG_NAME;?></td>
		</tr>
		<?php endif;?>
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
		<?if($strP_CODE){?>
		<tr>
			<th>제품</th>
			<td>
				<ul>
					<li class="prodImg"><a href= "../<?=strtolower($S_ST_LNG)?>/?menuType=product&mode=view&act=list&prodCode=<?=$strP_CODE?>"><img src="<?php echo $strPM_REAL_NAME;?>"/></a></li>
					<li class="prodInfo">
						<p class="title"><?php echo $strP_NAME;?></p>
					</li>
				</ul>
			</td>
		</tr>
		<?}?>

		<? include "dataView.userfield.inc.php"; ?>
		<tr>
			<th>제목</th>
			<td><?php echo $strUB_TITLE;?><?=$strFuncNotice=='Y'? '&nbsp; - <b>'.$LNG_TRANS_CHAR["BW00196"].'</b>'  :''?></td>
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
			<?//echo print_r($aryBoardFile['image']);?>
				<?php if(@$aryBoardFile['image']):?>
				<div class="community-view-image">
					<?php foreach($aryBoardFile['image'] as $key => $row):
								
							## 기본 설정
							$strFL_DIR = $row['FL_DIR'];
							$strFL_NAME = $row['FL_NAME'];

							## 이미지 설정
							$strImageFile = "{$strFL_DIR}/{$strFL_NAME}";
							$aryFileName	= explode('.',$strFL_NAME);
							$intFileName = count($aryFileName) -1;
							$aryFileExt = array('pdf','pptx');

							if(in_array($aryFileName[$intFileName],$aryFileExt) ){

								$strFileCheck = '<a href="'.$strImageFile.'" class="btn_big">download</a>';
							}else{

								$strFileCheck = '<img src="'.$strImageFile.'">';
							}
					?>
					<?php echo $strFileCheck;?>
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
		<?php if(@$aryBoardFile['listImage']):?>
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
		<?php if(@$aryBoardFile['file']):?>
		<tr>
			<th>첨부파일</th>
			<td colspan="3" style="text-align:left">
				<?php foreach($aryBoardFile['file'] as $key => $row):
						
						## 기본 설정
						$intFL_NO = $row['FL_NO'];
						$intFL_SIZE = $row['FL_SIZE'];
						$strFL_NAME = $row['FL_NAME'];
						$strFL_DIR = $row['FL_DIR'];

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

						## 이미지 설정
							$strImageFile = "{$strFL_DIR}/{$strFL_NAME}";
							$aryFileName	= explode('.',$strFL_NAME);
							$intFileName = count($aryFileName) -1;

						$aryFileExt = array('jpg','jpeg','gif','png','bmp');

						if(!in_array($aryFileName[$intFileName],$aryFileExt) ){

							$strFileCheck = '<a href="'.$strImageFile.'">'.$strRealName.'</a>';
						}else{

							$strFileCheck = '<img src="'.$strImageFile.'">';
						}

				?>
				<p><?php echo $strFileCheck;?><!--<a href="javascript:void(0);" onclick="goCommunityViewDataBasicSkinFileDownEvent('<?php echo $strAppID;?>',<?php echo $intFL_NO;?>)"><?php echo $strRealName;?>--> <span>(<?php echo $strFL_SIZE;?>)</span></a></p>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>
<div class="buttonBoxWrap">
<?
//입점사공지사항일 때 입점사는 글쓰기기 금지.
if($strBCode=='S_NOTICE'){
	if($_SESSION['ADMIN_TYPE']=='A'){?>
		<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataViewAnswerMoveEvent();" id="menu_auth_w"><strong class="ico_reply">답변</strong></a>
		<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataViewModifyMoveEvent();" id="menu_auth_w"><strong class="ico_modify">수정</strong></a>
		<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataViewDeleteActEvent();" id="menu_auth_w"><strong class="ico_del">삭제</strong></a>
		<?
	}
}else{
	?>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataViewAnswerMoveEvent();" id="menu_auth_w"><strong class="ico_reply">답변</strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataViewModifyMoveEvent();" id="menu_auth_w"><strong class="ico_modify">수정</strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="goCommunityDataViewDeleteActEvent();" id="menu_auth_w"><strong class="ico_del">삭제</strong></a>
<?}?>
	<a class="btn_new_blue" href="javascript:void(0);" onclick="goCommunityDataViewListMoveEvent();" ><strong class="ico_list">목록</strong></a>
</div>