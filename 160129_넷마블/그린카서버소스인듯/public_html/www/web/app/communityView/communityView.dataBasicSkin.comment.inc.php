<?php

	## 기본설정
	$strAppBCode			= $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo				= $EUMSHOP_APP_INFO['ubNo'];
	$aryAppBoardInfo		= $EUMSHOP_APP_INFO['boardInfo'];
	$intAppMemberNo			= $_SESSION['member_no']; // 회원번호
	$strAppMemberGroup		= $_SESSION['member_group']; // 회원 그룹 번호

	## 체크
	if(!$strAppBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		getDebug($param);
		return;		
	endif;
	if(!$intAppUbNo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "ub_no가 없습니다.";
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

	## 커뮤니티 설정
	$strBI_COMMENT_USE = $aryAppBoardInfo['BI_COMMENT_USE']; 

	## 체크
	if($strBI_COMMENT_USE == "N") { return; } // 사용안함

?>
<div class="comtTabWrap">
	<a href="javascript:void(0)" class="list-close btnComtClose" appID="COMMUNITY_COMMENT_LIST" toggleText="<?php echo $LNG_TRANS_CHAR["MW00108"]; //댓글창 열기?>"><?php echo $LNG_TRANS_CHAR["MW00109"]; //댓글창 닫기?></a>
	<a href="javascript:void(0)" class="list-refresh btnRefresh" appID="COMMUNITY_COMMENT_LIST"><?php echo $LNG_TRANS_CHAR["MW00110"]; //새로고침?></a>
	<a href="javascript:void(0)" class="comment-write-link btnComtWrite" appID="COMMUNITY_COMMENT_LIST"><?php echo $LNG_TRANS_CHAR["MW00111"]; //댓글쓰기?></a>

	<div class="array">
		<?php echo $LNG_TRANS_CHAR["MW00107"]; //정렬?>
		<span class="list-pageline" appID="COMMUNITY_COMMENT_LIST"></span>
	</div>
	<div class="clr"></div>
</div>

<!-- 댓글 쓰기 -->
<div class="comtWriteWrap">
	<div class="comment-write-form" appID="COMMUNITY_COMMENT_LIST"></div>
</div>
<!-- 댓글 쓰기 -->

<?php	
$EUMSHOP_APP_INFO				= "";
$EUMSHOP_APP_INFO['name']		= "댓글리스트";
$EUMSHOP_APP_INFO['appID']		= "COMMUNITY_COMMENT_LIST";
$EUMSHOP_APP_INFO['mode']		= "communityCommentList";
$EUMSHOP_APP_INFO['bCode']		= $strAppBCode;
$EUMSHOP_APP_INFO['ubNo']		= $intAppUbNo;
$EUMSHOP_APP_INFO['pageLine']	= 10;
include "{$S_DOCUMENT_ROOT}www/web/app/index.php";		
?>

<!-- 페이지 -->
<div class="list-paginate" appID="<?php echo $strAppID;?>"></div>
<!-- 페이지 -->

<div class="comtTabWrap">
	<a href="javascript:void(0)" class="list-close btnComtClose" appID="COMMUNITY_COMMENT_LIST" toggleText="<?php echo $LNG_TRANS_CHAR["MW00108"]; //댓글창 열기?>"><?php echo $LNG_TRANS_CHAR["MW00109"]; //댓글창 닫기?></a>
	<a href="javascript:void(0)" class="list-refresh btnRefresh" appID="COMMUNITY_COMMENT_LIST"><?php echo $LNG_TRANS_CHAR["MW00110"]; //새로고침?></a>
	<a href="javascript:void(0)" class="comment-write-link btnComtWrite" appID="COMMUNITY_COMMENT_LIST"><?php echo $LNG_TRANS_CHAR["MW00111"]; //댓글쓰기?></a>

	<div class="array">
		<?php echo $LNG_TRANS_CHAR["MW00107"]; //정렬?>
		<span class="list-pageline" appID="COMMUNITY_COMMENT_LIST"></span>
	</div>
	<div class="clr"></div>
</div>