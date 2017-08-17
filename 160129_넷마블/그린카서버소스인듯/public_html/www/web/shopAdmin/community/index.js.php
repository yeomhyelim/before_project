<?
	## STEP 1.
	## 공통 JS 파일 모음
	$aryCommonJsFile = array (	"../common/js/jquery-1.7.2.min.js", "../common/js/jquery.form.js", "../common/js/common.js", "../skins/javascript/common.js", "/shopAdmin/common/js/common.js", "/common/js/commonReady.js" );

	## STEP 2.
	## 요청한 모듈별, 액션별 JS 파일 실행
	switch($_REQUEST['mode']) :
		case "boardModifyComment":
		case "boardModifyBasic":
		case "boardModifyList":
		case "boardModifyView":
		case "boardModifyWrite":
		case "boardModifyDelete":
		case "boardModifyAttachedfile":
		case "boardModifyUserfield":
		case "boardModifyScriptWidget":
			// 커뮤니티 설정
			$aryJavascriptFile = array ( "./skins/admin/community/board/basic.1.0/javascript/boardModify.js"			);
		break;
		case "boardModifyScript":
			$aryJavascriptFile = array ( "./skins/admin/community/board/basic.1.0/javascript/boardModify.js","../common/eumEditor/highgardenEditor.js"			);		
		break;
		case "boardModifyCategory":
			// 커뮤니티 카테고리 설정
			$aryJavascriptFile = array ( "./skins/admin/community/board/basic.1.0/javascript/boardModify.js",
										 "./skins/admin/community/category/basic.1.0/javascript/category.js",			);
		break;
		case "boardModifyPoint":
			// 커뮤니티 포인트/쿠폰 설정
			$aryJavascriptFile = array ( "./skins/admin/community/board/basic.1.0/javascript/boardModify.js",
										 "./skins/admin/community/board/basic.1.0/javascript/point.js",	
										 "../common/js/jquery.smartPop.js"												);
		break;
		case "groupWrite":
		case "groupModify":
			// 커뮤니티 그룹 설정
			$aryJavascriptFile = array ( "./skins/admin/community/group/basic.1.0/javascript/group.js"				);
		break;
		case "boardIconList":
			// 커뮤니티 아이콘 리스트
		case "boardNonList":
			// 커뮤니티 리스트(정지된 게시판)
		case "boardList":
			// 커뮤니티 리스트
		case "boardWrite":
			// 커뮤니티 쓰기
			$aryJavascriptFile = array ( "./skins/admin/community/board/basic.1.0/javascript/board.js",
										 "../skins/admin/community/common/javascript/common.js",						);
		break;
		case "boardTable":
			// 커뮤니티 테이블/프로시저 생성
			$aryJavascriptFile = array ( "./skins/admin/community/board/basic.1.0/javascript/boardTable.js"				);
		break;
		case "dataTable":
			// 커뮤니티 글 테이블/프로시저 생성
			$aryJavascriptFile = array ( "./skins/admin/community/data/basic.1.0/javascript/dataTable.js"				);
		break;
		case "groupTable":
			// 커뮤니티 그룹 테이블/프로시저 생성
			$aryJavascriptFile = array ( "./skins/admin/community/group/basic.1.0/javascript/groupTable.js"				);
		break;
		case "boardInfoTable":
			// 커뮤니티 정보 테이블/프로시저 생성
			$aryJavascriptFile = array ( "./skins/admin/community/boardInfo/basic.1.0/javascript/boardInfoTable.js"		);
		break;
		case "dataView":
			// 커뮤니티 뷰
			$aryJavascriptFile[] = "../skins/admin/community/data/basic.1.0/javascript/data.js";
			$aryJavascriptFile[] = "../skins/admin/community/common/javascript/common.js";
			$aryJavascriptFile[] = "../common/eumEditor/highgardenEditor.js";
			if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 쿠폰/이벤트 
				$aryJavascriptFile[] = "../skins/admin/community/eventInfo/javascript/include.js";
			endif;
		break;
		case "dataList":
			// 커뮤니티 리스트
			$aryJavascriptFile[] = "../skins/admin/community/data/basic.1.0/javascript/data.js";
			$aryJavascriptFile[] = "../skins/admin/community/common/javascript/common.js";
			$aryJavascriptFile[] = "../common/eumEditor/highgardenEditor.js";
			$aryJavascriptFile[] = "../common/js/commonReady.js";
			$aryJavascriptFile[] = "../common/js/cal.js";
			if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용
			$aryJavascriptFile[] = "../skins/user/community/category/javascript/include.js";
			endif;
			if($_REQUEST['BOARD_INFO']['bi_point_use']=="Y"): // 쿠폰/이벤트 
			$aryJavascriptFile[] = "../skins/admin/community/eventInfo/javascript/include.js";
			endif;
		 break;
		case "dataAnswer":
		case "boardMain":
			// 커뮤니티 메인
			$aryJavascriptFile = array (	"../skins/admin/community/data/basic.1.0/javascript/data.js",
											"../skins/admin/community/common/javascript/common.js",
											"../common/eumEditor/highgardenEditor.js"									);
		break;
		case "dataModify":
		case "dataWrite":
			// 커뮤니티 보기
			$aryJavascriptFile = array (	"../skins/admin/community/data/basic.1.0/javascript/data.js",
											"../common/eumEditor/highgardenEditor.js",
											"../common/js/jquery.smartPop.js",
											"./skins/admin/community/board/basic.1.0/javascript/point.js",				);
		break;
		case "attachedfileWrite":
			$aryJavascriptFile = array ( "../skins/admin/community/attachedfile/basic.1.0/javascript/attachedfile.js",
										 "../skins/admin/community/data/basic.1.0/javascript/data.js"						);
		break;
		case "commentList":
			// 커뮤니티 뷰
			$aryJavascriptFile[] = "../skins/admin/community/data/basic.1.0/javascript/data.js";
			$aryJavascriptFile[] = "../skins/admin/community/common/javascript/common.js";
		break;
	endswitch;
?>

<? foreach($aryCommonJsFile as $file): ?>
<script language="javascript" type="text/javascript" src="<?=$file?>"></script>
<? endforeach; ?>

<? foreach($aryJavascriptFile as $file): ?>
<script language="javascript" type="text/javascript" src="<?=$file?>"></script>
<? endforeach; ?>

<script type="text/javascript">
<!--
	//<![CDATA[
	var rootDir 		= "../../common/eumEditor/highgardenEditor";
	var uploadImg 		= "/editor/board";
	var uploadFile		= "../kr/index.php";
	var htmlYN			= "Y";
	//]]>

	var G_PHP_SELF		= "./";
	var G_PHP_PARAM		= "<?=$_SERVER['QUERY_STRING']?>";

	var strSiteJsLng		= "<?=$strAdmSiteLng?>";
	var strAdminSiteLng		= "<?=$strAdmSiteLng?>";
	var intAdminLevel		= "<?=$a_admin_level?>"; //최상위관리자 구분
	var strAdminType		= "<?=$a_admin_type?>"; //최상위관리자 구분

	var strMenuAuthBtn_L	= "";	//목록
	var strMenuAuthBtn_W	= "";	//등록
	var strMenuAuthBtn_M	= "";	//수정
	var strMenuAuthBtn_D	= "";	//삭제
	var strMenuAuthBtn_E	= "";	//엑셀
	var strMenuAuthBtn_C	= "";	//정산
	var strMenuAuthBtn_S	= "";	//SMS
	var strMenuAuthBtn_P	= "";	//포인트
	var strMenuAuthBtn_U	= "";	//업로드
	var strMenuAuthBtn_E1	= "";	//기타기능1
	var strMenuAuthBtn_E2	= "";	//기타기능2
	var strMenuAuthBtn_E3	= "";	//기타기능3
	var strMenuAuthBtn_E4	= "";	//기타기능4
	var strMenuAuthBtn_E5	= "";	//기타기능5


	$(document).ready(function() {
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
	});
//-->
</script>
