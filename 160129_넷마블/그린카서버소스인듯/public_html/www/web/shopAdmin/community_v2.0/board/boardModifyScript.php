<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boardModifyScript.js";
?>
<div class="contentTop">
	<h2>커뮤니티 설정 (<?php echo $strB_NAME;?>)</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>

<br>

<!-- 언어 선택 탭 -->
<?php include MALL_HOME . "/web/shopAdmin/include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->

<br>
<form name="form" id="form">
<input type="hidden" name="menuType" id="menuType" value="community_v2.0">
<input type="hidden" name="mode" id="mode" value="json">
<input type="hidden" name="act" id="act" value="boardModifyScript">
<input type="hidden" name="b_code" id="b_code" value="<?php echo $strBCode;?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $strLang;?>">
<div class="tableForm">
	<h3>커뮤니티 스크립트 옵션</h3>
	<table>
		<tbody>
			<tr>
				<th>스크립트</th>
				<td>
					<textarea name="bi_datascript_data" id="bi_datascript_data" style="width:100%;height:500px" title=""><?php include "{$strScriptDir}/{$strScriptTagFile}";?></textarea>				
				</td>
			</tr>
		</tbody>
	</table>
</div>
</form>

<br>

<div class="button">
	<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyScriptModifyActEvent();" id="menu_auth_m" style=""><strong>설정 변경</strong></a>
	<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyScriptListMoveEvent();"><strong>목록</strong></a>
</div>
