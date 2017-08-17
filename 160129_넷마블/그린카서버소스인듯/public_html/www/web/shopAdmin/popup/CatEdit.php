<?
	require_once MALL_CONF_LIB."BoardMgr.php";

	$intB_NO	= $_POST["bNo"]				? $_POST["bNo"]				: $_REQUEST["bNo"];
	$intCC_NO	= $_POST["cc_no"]			? $_POST["cc_no"]			: $_REQUEST["cc_no"];
	$strM_ID	= $g_member_id;
	$strM_NAME	= $g_member_name;

	if (!$intB_NO){
		$db->disConnect();
		goClose("카테고리 관리를 사용하실 수 없습니다. 로그인을 하신 후 이용하세요.");
		exit;
	}

	switch ($strAct) {
		case "edit":
			$boardMgr = new BoardMgr();
			$boardMgr->setB_NO($intB_NO);
			$boardRow = $boardMgr->getBoardView($db);		// ex query ) SELECT * FROM BOARD_MGR WHERE B_CODE = 'REVIEW'
			
			$arrCommCode = getCommGrpNo($boardRow[B_CODE]);
			$boardMgr->setCG_NO($arrCommCode[$boardRow[B_CODE]]);
			$commCodeRow = $boardMgr->getCommCodeList($db);
			
			$txtPageTag		= "카테고리 등록";
			$btnPageTag		= "<a class='btn_blue_big' href='javascript:goCatEditEvent(\"write\",\"catEditWrite\",\"\");'><strong>카테고리 등록</strong></a>";
			$btncloseTag	= "<a class='btn_big' href='javascript:self.close();'><strong>닫기</strong></a>";
//			echo $db->query;
		break;
		case "modify":
			$boardMgr = new BoardMgr();
			$boardMgr->setB_NO($intB_NO);
			$boardRow = $boardMgr->getBoardView($db);		// ex query ) SELECT * FROM BOARD_MGR WHERE B_CODE = 'REVIEW'
			
			$arrCommCode = getCommGrpNo($boardRow[B_CODE]);
			$boardMgr->setCG_NO($arrCommCode[$boardRow[B_CODE]]);
			$commCodeRow = $boardMgr->getCommCodeList($db);

			$boardMgr->setCG_NO("");
			$boardMgr->setCC_NO("$intCC_NO");
			$arrModify = $boardMgr->getCommCodeList($db);
			$modifyRow = mysql_fetch_array($arrModify);
			
			$txtPageTag		= "카테고리 수정";
			$btnPageTag		= "<a class='btn_blue_big' href='javascript:goCatEditEvent(\"modify\",\"catEditModify\",\"$intCC_NO\");'><strong>카테고리 수정</strong></a>";
			$btncloseTag	= "<a class='btn_big' href='javascript:goCatEditEvent(\"goCancel\",\"catEditCancelGo\",\"\",\"\");'><strong>취소</strong></a>";
			$imgViewTag1	= $modifyRow[CC_IMG1] != "" ? "<img src='$modifyRow[CC_IMG1]'/>" : ""; 
			$imgViewTag2	= $modifyRow[CC_IMG2] != "" ? "<img src='$modifyRow[CC_IMG2]'/>" : ""; 
		break;
	}

	 $strCC_USE = ($modifyRow[CC_USE] == "Y" || $modifyRow[CC_USE] == "N") ? $modifyRow[CC_USE] : "Y";

?>

<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});


	function goCatEditEvent(s, val, parm1)
	{	
		var doc					= document.form;
		
		switch (s)
		{
		case "write":
			if(!C_chkInput("cc_name",true,"카테고리 이름",true)) return;
		break;
		case "goModify":
			doc.cc_no.value = parm1;
		case "modify":
			doc.cc_no.value = parm1;
		break;
		case "delete":
			var x = confirm("선택한  카테고리를 삭제 하시겠습니까?");
			if (x == false) { return; }
			doc.cc_no.value = parm1;
		case "goCancel":
		break;		
		}

		doc.menuType.value		= "board";
		doc.mode.value				= "act";
		doc.act.value					= val;
		doc.action						= "<?=$PHP_SELF?>";
		doc.method					= "post";

		doc.submit();
	}

	/* image file check */
	function fileUpload(f) {
		var strPopImg = f.value;
		if (!C_isNull(strPopImg))
		{
			if(!strPopImg.toLowerCase().match(/(.jpg|.jpeg|.gif|.png)/)) { 
				alert("이미지 파일만 등록하실 수 있습니다.");
				strPopImg.value = "";
				return;
			}
		}
     }

//-->
</script>


<div id="contentArea">

	<table style="width:100%;">
	<tr>
	<td class="contentWrap">
		<div class="layoutWrap">
		<div id="contentArea">
			<div class="contentTop">
				<h2>카테고리 관리</h2>
			</div>
			<div class="tableForm" style="margin-top:10px;">

				<h1>- <?=$txtPageTag?></h1>
				<!-- insert data table //-->
				<form name='form' method='post' enctype="multipart/form-data">
				<input type="hidden" name="menuType" id="menuType" value="" />
				<input type="hidden" name="mode" id="mode" value="" />
				<input type="hidden" name="act" id="act" value="" />
				<input type="hidden" name="cc_no" id="cc_no" value="" />
				<input type="hidden" name="cc_code" id="cc_code" value="<?=$boardRow[B_NO]?>" />
				<input type="hidden" name="bCode" id="bCode" value="<?=$boardRow[B_CODE]?>" />
				<input type="hidden" name="bNo", id="bNo" value="<?=$intB_NO?>" />
				<input type="hidden" name="tempImgDir1" id="tempImgDir1" value="<?=$modifyRow[CC_IMG1]?>" />
				<input type="hidden" name="tempImgDir2" id="tempImgDir2" value="<?=$modifyRow[CC_IMG2]?>" />
				<table>
				</tr>
					<th> 게시판 이름(코드) </th>
					<td><?=$boardRow[B_TITLE]?>(<?=$boardRow[B_CODE]?>)</td>
				</tr>
				<tr>
					<th> 카테고리 이름 </th>
					<td><input type="text" name="cc_name" id="cc_name" value="<?=$modifyRow[CC_NAME]?>" /></td>
				</tr>
				<tr>
					<th> 카테고리 정렬 </th>
					<td><input type="text" name="cc_sort" id="cc_sort" value="<?=$modifyRow[CC_SORT]?>" /></td>
				</tr>
				<tr>
					<th> 이미지1 </th>
					<td><input type="file" <?=$nBox?> id="file1" name="file1" style="height:20px;" onchange="fileUpload(this)" value="12345"/> <?=$imgViewTag1?></td>
				</tr>
				<tr>
					<th> 이미지2 </th>
					<td><input type="file" <?=$nBox?> id="file2" name="file2" style="height:20px;" onchange="fileUpload(this)" value="7890"/> <?=$imgViewTag2?></td>
				</tr>
				<tr>
					<th> 사용</th>
					<td>
						<input type="radio" id="cc_use" name="cc_use" value="Y" <?= $strCC_USE == "Y" ? "checked" : ""; ?>>사용
						<input type="radio" id="cc_use" name="cc_use" value="N" <?= $strCC_USE == "N" ? "checked" : ""; ?>>사용안함
					</td>
				<tr>
				</table>
				
				<div class="buttonWrap">
					<?=$btnPageTag ?>
					<?=$btncloseTag ?>
				</div>
				<form>
				<!-- inset data table //-->
				<h1>- 카테고리 리스트</h1>			
				
				<table>
				<colgroup>
					<col style="width:40px"/>
					<col/>
					<col style="width:100px;"/>
					<col style="width:100px;"/>
					<col style="width:150px;"/>
				</colgroup>
				<tr>
					<td>번호</td>
					<td>카테고리 이름</td>
					<td>정렬</td>
					<td>사용여부</td>
					<td>관리</td>
				</tr>

				<?
					$i = 1;
					while($row = mysql_fetch_array($commCodeRow))
					{
				?>
				
				<tr>
					<td><?=$i++?></td>
					<td><?=$row[CC_NAME]?></td>
					<td><?=$row[CC_SORT]?></td>
					<td><?=$row[CC_USE]?></td>
					<td>
						<a class="btn_big" href="javascript:goCatEditEvent('goModify','catEditModifyGo','<?=$row[CC_NO]?>');"><strong>수정</strong>
						<a class="btn_big" href="javascript:goCatEditEvent('delete','catEditDelete','<?=$row[CC_NO]?>');"><strong>삭제</strong>
					</td>
				</tr>
				
				<?
					}
				?>
				
				</table>
			</div>

		</div>
		</div>
	</td>
	</tr>
	</table>
</div>

</body>
</html>