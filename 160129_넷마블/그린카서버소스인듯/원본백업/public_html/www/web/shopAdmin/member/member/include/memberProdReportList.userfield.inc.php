<?
	## 설정 파일 불러오기
	if($bCode && !$aryBoardInfo):
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$bCode}.info.php";
		$aryBoardInfo				= $BOARD_INFO[$bCode];
		if(!$aryBoardInfo):
			echo "설정 파일이 없습니다.";
			exit;
		endif;
	endif;

	## 설정 파일 설정
	$userfieldUse					= $aryBoardInfo['bi_userfield_use'];
	$userfieldFieldUse				= $aryBoardInfo['bi_userfield_field_use'];
	$userfieldName					= $aryBoardInfo['bi_userfield_name'];
	$userfieldSort					= $aryBoardInfo['bi_userfield_sort'];
	$userfieldEssential				= $aryBoardInfo['bi_userfield_essential'];
	$userfieldKind					= $aryBoardInfo['bi_userfield_kind'];
	$userfieldKindName				= $aryBoardInfo['bi_userfield_kind_name'];

	## 추가 필드 사용 유무
	if($userfieldUse == "Y"):
		print_r($aryBoardInfo);
	endif;