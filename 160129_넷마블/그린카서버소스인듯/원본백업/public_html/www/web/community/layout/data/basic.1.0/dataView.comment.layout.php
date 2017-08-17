<?php
	/**
	 * eumshop app - dataView - comment - layout
	 *
	 * 커뮤니티 댓글 리스트 및 글쓰기 수정 기능입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/community/layout/data/basic.1.0/dataView.comment.layout.php
	 * @manual		
	 * @history
	 *				2014.05.07 kim hee sung - 개발 완료
	 */

	## 스크립트 설정
	$aryScript[] = "/common/js/community/dataView.comment.layout.js";
	$aryScriptEx[] = "/common/js/community/dataView.comment.layout.js";

	## 기본 설정
	$strBCode = $_GET['b_code'];
	$strUbNo = $_GET['ub_no'];
	$isMemberLogin = $_REQUEST['member_login'];
	$strMemberGroup = $_REQUEST['member_group'];
	$strCommentUse = $_REQUEST['BOARD_INFO']['bi_comment_use'];
	$aryCommentAuth = $_REQUEST['BOARD_INFO']['bi_comment_member_auth'];

	## 글쓰기 사용권한 체크
//	if($strCommentUse == "M" && !in_array($strMemberGroup, $aryCommentAuth)) { $strCommentUse = ""; } 
	if($strCommentUse == "N") { $strCommentUse = ""; }

	## 체크
	if(!$strCommentUse) { return; }
	if($S_COMMUNITY_COMMENT_VERSION != "V2.0") { return; }

?>

<div class="comtTabWrap">
	<a href="javascript:void(0)" class="list-close btnComtClose" appID="COMMUNITY_COMMENT_LIST" toggleText="댓글창 열기">댓글창 닫기</a>
	<a href="javascript:void(0)" class="list-refresh btnRefresh" appID="COMMUNITY_COMMENT_LIST">새로고침</a>
	<a href="javascript:void(0)" class="comment-write-link btnComtWrite" appID="COMMUNITY_COMMENT_LIST">댓글쓰기</a>

	<div class="array">
		정렬
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
$EUMSHOP_APP_INFO['bCode']		= $strBCode;
$EUMSHOP_APP_INFO['ubNo']		= $strUbNo;
$EUMSHOP_APP_INFO['pageLine']	= 10;
include "{$S_DOCUMENT_ROOT}www/web/app/index.php";		
?>

<!-- 페이지 -->
<div class="list-paginate" appID="<?php echo $strAppID;?>"></div>
<!-- 페이지 -->

<div class="comtTabWrap">
	<a href="javascript:void(0)" class="list-close btnComtClose" appID="COMMUNITY_COMMENT_LIST" toggleText="댓글창 열기">댓글창 닫기</a>
	<a href="javascript:void(0)" class="list-refresh btnRefresh" appID="COMMUNITY_COMMENT_LIST">새로고침</a>
	<a href="javascript:void(0)" class="comment-write-link btnComtWrite" appID="COMMUNITY_COMMENT_LIST">댓글쓰기</a>

	<div class="array">
		정렬
		<span class="list-pageline" appID="COMMUNITY_COMMENT_LIST"></span>
	</div>
	<div class="clr"></div>
</div>