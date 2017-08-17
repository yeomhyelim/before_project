<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/layout_v2.0/skin/skin.skinList.js";

	## 스크립트 데이터 설정
	$aryScriptData['SKIN_CODE_SELECT'] = $strSkinCodeSelect;
?>
<!-- 제목 //-->
<div class="contentTop">
	<h2>스킨 설정</h2>
</div>
<!-- 제목 //-->

<br>

<!-- 스킨 리스트 //-->
<div class="selectedSkinWrap"></div>
<!-- 버튼 //-->
<div class="btnNewWrap">
	<div class="leftBtnWrap">
		<div class="noWrap"> 2</div> <a href="javascript:goLayoutSkinListSkinModifyActEvent()" id="menu_auth_w"  class="btn_big_new"><strong>스킨설정 하기</strong></a>	
	</div>
	
	<div class="rightBtnWrap">
		<select name="skinBak" class="backSkinList">
		<option value="">이전 스킨리스트</option>
		<?php foreach($aryLayoutBakList as $strSkinBak):
				
				## 기본설정
				list($strSkinBakDate, $strSkinBakCode) = explode("@", $strSkinBak, 2);
				$strFilderName = date("Y년m월d일 H시i분s초", strtotime($strSkinBakDate));
		?>
		<option value="<?php echo $strSkinBak;?>"><?php echo $strFilderName;?> <?php echo $strSkinBakCode;?> 스킨으로 디자인 변경</option>
		<?php endforeach;?>
		</select>
		<a href="javascript:goLayoutSkinListSkinRestoreActEvent()" id="menu_auth_w" style="display:none"   class="btn_big_new2"><strong>이전스킨으로 되돌리기</strong></a>	
	</div>
	<div class="clr"></div>
</div>
<!-- 버튼 //-->
<div class="titSkinWrap">
	<div class="left">
		<div class="noWrap"> 1</div>
		<div class="txtInfoLeft">
			스킨을 변경하기 위해 먼저 원하시는 디자인을 선택하세요.<br>
			선택된 스킨의 라디오 버튼을 체크하신 후 [2]번 "스킨설정하기" 버튼을 클릭해 주세요.
		</div>
		<div class="clr"></div>
	</div>
	<div class="right">
		<div class="sortWrap">
			<a href="#" class="sort_Up">등록순</a>
			<a href="#" class="sort_Down">인기순</a>
		</div>
	</div>
	<div class="clr"></div>
</div>
<div class="skinListWrap"></div>
<div class="clr"></div>
<div class="paginate mt20"></div>
<!-- 스킨 리스트 //-->