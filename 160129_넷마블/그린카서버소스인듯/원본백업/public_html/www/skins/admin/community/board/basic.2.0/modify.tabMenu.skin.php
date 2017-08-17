<?php
	## 기본설정
	$strMemberType = $_REQUEST['member_type'];
	$strB_CODE = $_REQUEST['b_code']; // 게시판 코드
	$isBtnUseUse = true; // 기능설정 버튼 설정
	$isBtnViewUse = true; // 게시판 보기 버튼 설정

	## 입점사 로그인일때 설정
	## 2014.04.28 kim hee sung 입점사업체문의사항(S_REQ) 게시판은 등록수정삭제 기능이 되도록 변경함
	if($strMemberType == "S"):
		$isBtnUseUse				= "";
		$isBtnViewUse				= "";
	endif;

	## selected 설정
	$arySelected[$strMode] = "class='selected'";

	## 시작언어 설정
	$strStartLangLower = strtolower($S_ST_LNG);

?>
<!--
	<?php if($isBtnUseUse):?>
	<a href="./?menuType=community&mode=dataList&b_code=<?php echo $strB_CODE;?>"<?php echo $arySelected['dataList'];?>>내용</a>
	<a href="./?menuType=community&mode=boardModifyBasic&b_code=<?php echo $strB_CODE;?>"<?php echo $arySelected['boardModifyBasic'];?>>기본설정</a>	
	<a href="./?menuType=community&mode=boardModifyCategory&b_code=<?php echo $strB_CODE;?>"<?php echo $arySelected['boardModifyCategory'];?>>카테고리설정</a>	
-->	
	<!-- a href="./?menuType=community&mode=boardModifyPoint&b_code=<?php echo $strB_CODE;?>"<?php echo $arySelected['boardModifyPoint'];?>>포인트/쿠폰 설정</a //-->
<!--
	<a href="./?menuType=community&mode=boardModifyUserfield&b_code=<?php echo $strB_CODE;?>"<?php echo $arySelected['boardModifyUserfield'];?>>추가필드</a>	
	<a href="./?menuType=community&mode=boardModifyScript&b_code=<?php echo $strB_CODE;?>&lang=<?php echo $S_ST_LNG;?>"<?php echo $arySelected['boardModifyScript'];?>>HTML편집</a>
-->	
	<!-- a href="./?menuType=community&mode=boardModifyScriptWidget&b_code=<?php echo $strB_CODE;?>"<?php echo $arySelected['boardModifyScriptWidget'];?>>Widget편집</a //-->
	<?php endif;?>		
	<?php if($isBtnViewUse):?>
<!--	<a href="<?php echo "http://{$S_HTTP_HOST}/{$strStartLangLower}/?menuType=community&b_code={$_REQUEST['b_code']}"?>" target="_blank">사용자 게시판</a> -->
	<?php endif;?>	