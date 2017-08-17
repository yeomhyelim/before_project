<?

/**
 * function getUserAuth
 * 쓰기권한/목록권한/보기권한 을 체크하여 현재 사용자 브라우저의 상태를 체크하여 Y OR N 를 리턴
 * @param string auth 		: 사용 권한 값
 * @param string group 	: 회원 그룹 레벨
 * 사용 권한이 있으면 "Y", 없으면 "N" 리턴
 */ 
function getUserAuth ( $auth, $group )
{
	global $g_member_no, $memberMgr, $db;

	if ( $auth == "1" || $auth == "Y" ) :
		// 모든회원/비회원 사용 가능한 경우
		return "Y";
	elseif ( $g_member_no ) :
		if ( $group ) :
			$memberMgr->setG_CODE($aryBoardSet[0][B_LIST_GROUP]);
			$intListLevel = $memberMgr->getGroupView($db);
			if ( $intListLevel >= $g_member_no ) :
				// 회원 그룹 사용시, 관련 그룹에 해당하는 경우
				return "Y";
			endif;
		else :
			// 회원 전체 사용 가능한 경우
			return "Y";
		endif;
	endif;
	return "N";
}

function getCategory() {
	global $aryBoardSet, $commCodeRow;
	if ( $aryBoardSet[0][B_CAT_TYPE] == "T" ) :	 // 카테고리 타입이 텍스트 인 경우
		echo sprintf("<a href=\"javascript:goMoveUrlCate('list','%s')\">%s</a> ", "", "전체" );
		while( $commRow = mysql_fetch_array( $commCodeRow ) ) : 
			echo sprintf("<a href=\"javascript:goMoveUrlCate('list','%s')\">%s</a> ", $commRow[CC_NO], $commRow[CC_NAME] );
		endwhile;
	elseif ( $aryBoardSet[0][B_CAT_TYPE] == "I" ) :  // 카테고리 타입이 이미지 인 경우
		while( $commRow = mysql_fetch_array( $commCodeRow ) ) : 
			echo sprintf("<a href=\"javascript:goMoveUrlCate('list','%s')\"><img src=\"%s\"/></a> ", $commRow[CC_NO], $commRow[CC_IMG1] );
		endwhile;	
	endif;
	$colspan = 4;
}

?>

