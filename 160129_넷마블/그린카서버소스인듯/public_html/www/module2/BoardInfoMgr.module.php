<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 커뮤니티 추가옵션 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardInfoMgrModule extends Module2
{
	function getBoardInfoMgrSelectEx($op, $param)
	{
		$column['OP_LIST']		= "BA.*";
		$column['OP_SELECT']	= "*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_ARYTOTAL']	= "*";

		## query(1) 영역
		
		## limit1
		if($param['LIMIT']):
			$limit1			= "LIMIT {$param['LIMIT']}";
		endif;		
		
		## order_by1
		if($param['ORDER_BY']):
			$order_by1		= "ORDER BY {$param['ORDER_BY']}";
		else:
			## default
//			$order_by1		= "ORDER BY BA.BA_KEY ASC";
		endif;

		## where1
		$where1				= "WHERE BA.BA_B_CODE IS NOT NULL";

		if($param['BA_B_CODE']):
			$where1			= "{$where1} AND BA.BA_B_CODE = '{$param['BA_B_CODE']}'";
		endif;

		if($param['BA_MODE']):
			$where1			= "{$where1} AND BA.BA_MODE = '{$param['BA_MODE']}'";
		endif;

		if($param['BA_KEY']):
			$where1			= "{$where1} AND BA.BA_KEY = '{$param['BA_KEY']}'";
		endif;

		if($param['BA_LNG']):
			$where1			= "{$where1} AND BA.BA_LNG = '{$param['BA_LNG']}'";
		endif;

		## from1
		$from1				= "FROM BOARD_INFO_MGR AS BA";

		## select1
		$select1			= "SELECT {$column[$op]}";
		
		## query1
		$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
	//	echo $query1;

		return $this->getSelectQuery($query1, $op);
	}

	function getBoardInfoMgrInsertEx($param)
	{
		$paramData					= "";
		$paramData['BA_B_CODE']		= $this->db->getSQLString($param['BA_B_CODE']);
		$paramData['BA_MODE']		= $this->db->getSQLString($param['BA_MODE']);
		$paramData['BA_LNG']		= $this->db->getSQLString($param['BA_LNG']);
		$paramData['BA_KEY']		= $this->db->getSQLString($param['BA_KEY']);
		$paramData['BA_VAL']		= $this->db->getSQLString($param['BA_VAL']);
		$paramData['BA_COMMENT']	= $this->db->getSQLString($param['BA_COMMENT']);

		return $this->db->getInsertParam("BOARD_INFO_MGR", $paramData);
	}

	function getBoardInfoMgrUpdateEx($param)
	{
		$paramData					= "";
//		$paramData['BA_B_CODE']		= $this->db->getSQLString($param['BA_B_CODE']);
		$paramData['BA_MODE']		= $this->db->getSQLString($param['BA_MODE']);
		$paramData['BA_LNG']		= $this->db->getSQLString($param['BA_LNG']);
//		$paramData['BA_KEY']		= $this->db->getSQLString($param['BA_KEY']);
		$paramData['BA_VAL']		= $this->db->getSQLString($param['BA_VAL']);
		$paramData['BA_COMMENT']	= $this->db->getSQLString($param['BA_COMMENT']);

		if($param['BA_B_CODE'] && $param['BA_KEY']):
			$baBCode				= $this->db->getSQLString($param['BA_B_CODE']);
			$baKey					= $this->db->getSQLString($param['BA_KEY']);
			$where					= "BA_B_CODE = {$baBCode} AND BA_KEY = {$baKey}";
		endif;
		
		if(!$where)					{ return; }

		return $this->db->getUpdateParam("BOARD_INFO_MGR", $paramData, $where);	
	}

	function getBoardInfoMgrDeleteEx($param)
	{
		$where						= "";

		if($param['BA_B_CODE'] && $param['BA_MODE'] && $param['BA_LNG']):
			$baBCode				= $this->db->getSQLString($param['BA_B_CODE']);
			$baMode					= $this->db->getSQLString($param['BA_MODE']);
			$baLng					= $this->db->getSQLString($param['BA_LNG']);
			$where					= "BA_B_CODE = {$baBCode} AND BA_MODE = {$baMode} AND BA_LNG = {$baLng}";
		endif;
		
		if($param['BA_B_CODE'] && $param['BA_KEY'] && $param['BA_LNG']):
			$baBCode				= $this->db->getSQLString($param['BA_B_CODE']);
			$baKey					= $this->db->getSQLString($param['BA_KEY']);
			$baLng					= $this->db->getSQLString($param['BA_LNG']);
			$where					= "BA_B_CODE = {$baBCode} AND BA_KEY = {$baKey} AND BA_LNG = {$baLng}";
		endif;
		
		if(!$where)					{ return; }

		return $this->db->getDelete("BOARD_INFO_MGR", $where);
	}

	function getSelectQuery($query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $this->db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $this->db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $this->db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $this->db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $this->db->getArrayTotal($query);
		else :
			return -100;
		endif;
	}	
}

## 추가 필드 정보
$s										= 0;
$G_USERFIELD_INFO[$s]['comment']		= "연락처1";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_PHONE1";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "30";
$G_USERFIELD_INFO[$s]['kindList']		= "phone";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "연락처2";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_PHONE2";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "30";
$G_USERFIELD_INFO[$s]['kindList']		= "phone";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "연락처3";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_PHONE3";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "30";
$G_USERFIELD_INFO[$s]['kindList']		= "phone";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "우편번호";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_ZIP";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "10";
$G_USERFIELD_INFO[$s]['kindList']		= "zip";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "주소1";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_ADDR1";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "100";
$G_USERFIELD_INFO[$s]['kindList']		= "text";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "주소2";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_ADDR2";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "150";
$G_USERFIELD_INFO[$s]['kindList']		= "text";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "회사명";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_COMPANY";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "100";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드1";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP1";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "50";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드2";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP2";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "50";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드3";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP3";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "50";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드4";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP4";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "50";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드5";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP5";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "200";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드6";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP6";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "200";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드7";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP7";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "200";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드8";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP8";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "200";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드9";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP9";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "500";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드10";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP10";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "500";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드11";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP11";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "500";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드12";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP12";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "500";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드13";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP13";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "10";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드14";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP14";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "10";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드15";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP15";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "10";
$G_USERFIELD_INFO[$s]['kindList']		= "text;select";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드16";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP16";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "1";
$G_USERFIELD_INFO[$s]['kindList']		= "radio";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드17";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP17";
$G_USERFIELD_INFO[$s]['columnType']		= "varchar";
$G_USERFIELD_INFO[$s]['columnSize']		= "1";
$G_USERFIELD_INFO[$s]['kindList']		= "radio";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드18";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP18";
$G_USERFIELD_INFO[$s]['columnType']		= "text";
$G_USERFIELD_INFO[$s]['columnSize']		= "";
$G_USERFIELD_INFO[$s]['kindList']		= "textarea";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드19";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP19";
$G_USERFIELD_INFO[$s]['columnType']		= "text";
$G_USERFIELD_INFO[$s]['columnSize']		= "";
$G_USERFIELD_INFO[$s]['kindList']		= "textarea";
$s++;
$G_USERFIELD_INFO[$s]['comment']		= "임시필드20";
$G_USERFIELD_INFO[$s]['columnName']		= "AD_TEMP20";
$G_USERFIELD_INFO[$s]['columnType']		= "text";
$G_USERFIELD_INFO[$s]['columnSize']		= "";
$G_USERFIELD_INFO[$s]['kindList']		= "textarea";
$s++;

$G_BOARD_INFO['boardWrite']			= 	array(	"B_CODE"						=> "커뮤니티 코드",
												"B_NO"							=> "커뮤니티 번호",
												"B_NAME"						=> "커뮤니티 이름",
												"B_KIND"						=> "커뮤니티 종류",
												"B_SKIN"						=> "커뮤니티 스킨",
												"B_CSS"							=> "커뮤니티 CSS",	
												"B_BG_NO"						=> "커뮤니티 그룹 번호",
												"B_USE"							=> "커뮤니티 사용 유무",			);

## 커뮤니티 기본 옵션 설정
$G_BOARD_INFO['boardModifyBasic']	= 	array(	"BI_START_MODE"					=> "커뮤니티 시작 페이지(list,view,write)",
												"BI_ADMIN_NICKNAME"				=> "커뮤니티 관리자 명칭 ",
												"BI_COMMENT_USE"				=> "커뮤니티 코멘트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
											//	"BI_COMMENT_NONMEMBER_USE"		=> "비회원 사용",
											//	"BI_COMMENT_MEMBER_AUTH"		=> "커뮤니티 코멘트 사용 권한(일반회원, 관리자회원, 공급사회원)",				
												"BI_DATALIST_USE"				=> "커뮤니티 리스트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
											//	"BI_DATALIST_NONMEMBER_USE"		=> "비회원 사용",
											//	"BI_DATALIST_MEMBER_AUTH"		=> "커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)",
												"BI_COLUMN_DEFAULT"				=> "세로줄 수",
												"BI_LIST_DEFAULT"				=> "리스트 수",
												"BI_PAGE_DEFAULT"				=> "페이지 수",	
												"BI_DATALIST_ORDERBY"			=> "리스트 정렬 설정(등록날짜오름차순, 등록날짜내림차순...)",
												"BI_DATALIST_FIELD_USE_0"		=> "커뮤니티 리스트 목록 설정(번호)",
												"BI_DATALIST_FIELD_USE_1"		=> "커뮤니티 리스트 목록 설정(작성자)",
												"BI_DATALIST_FIELD_USE_2"		=> "커뮤니티 리스트 목록 설정(등록일)",
												"BI_DATALIST_FIELD_USE_3"		=> "커뮤니티 리스트 목록 설정(조회수)",
												"BI_DATALIST_FIELD_USE_4"		=> "커뮤니티 리스트 목록 설정(점수)",
												"BI_DATALIST_FIELD_USE_5"		=> "커뮤니티 리스트 목록 설정(카테고리)",
												"BI_DATALIST_WRITER_SHOW_0"		=> "커뮤니티 리스트 작성자 표시 방법(성명)",
												"BI_DATALIST_WRITER_SHOW_1"		=> "커뮤니티 리스트 작성자 표시 방법(아이디)",
												"BI_DATALIST_WRITER_SHOW_2"		=> "커뮤니티 리스트 작성자 표시 방법(닉네임)",
												"BI_DATALIST_WRITER_HIDDEN"		=> "커뮤니티 리스트 작성자 부분 숨김(갯수)",									"BI_DATAVIEW_USE"				=> "커뮤니티 보기 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
											//	"BI_DATAVIEW_NONMEMBER_USE"		=> "비회원 사용",
											//	"BI_DATAVIEW_MEMBER_AUTH"		=> "커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)",
												"BI_DATAVIEW_TWITTER_USE"		=> "트위터 사용",
												"BI_DATAVIEW_FACEBOOK_USE"		=> "페이스북 사용",
												"BI_DATAVIEW_M2DAY_USE"			=> "미투데이",			
												"BI_DATAWRITE_USE"				=> "커뮤니티 쓰기/수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
											//	"BI_DATAWRITE_NONMEMBER_USE"	=> "비회원 사용",
											//	"BI_DATAWRITE_MEMBER_AUTH"		=> "커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)",
												"BI_DATAWRITE_NOTICE_USE"		=> "공지글 사용(사용=Y, 사용안함=N)",
												"BI_DATAWRITE_LOCK_USE"			=> "비밀글 사용(사용자선택=C.무조건=E,사용안함=N or '')",
												"BI_DATAWRITE_FORM"				=> "글쓰기 폼(텍스트폼=textWrite, 에디터폼=editWrite)",
												"BI_DATAWRITE_ICON_USE"			=> "아이콘(사용=Y, 사용안함=N)",
												"BI_DATAWRITE_END_MOVE"			=> "글쓰기 완료 후, 이동경로(목록화면, 글쓰기화면, 상세보기화면)",		
												"BI_DATADELETE_USE"				=> "커뮤니티 삭제/기타 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
											//	"BI_DATADELETE_NONMEMBER_USE"	=> "비회원 사용"
											//	"BI_DATADELETE_MEMBER_AUTH"		=> "커뮤니티 삭제 사용 권한(일반회원, 관리자회원, 공급사회원)",			
												"BI_DATAMODIFY_USE"				=> "커뮤니티 수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
											//	"BI_DATAMODIFY_MEMBER_AUTH"		=> "커뮤니티 수정 사용 권한(일반회원, 관리자회원, 공급사회원)",			
												"BI_ATTACHEDFILE_USE"			=> "커뮤니티 첨부파일 사용(사용=1/2/3/4..., 사용안함=0)",
												"BI_ATTACHEDFILE_NAME_0"		=> "커뮤니티 첨부파일 이름1",
												"BI_ATTACHEDFILE_NAME_1"		=> "커뮤니티 첨부파일 이름2",
												"BI_ATTACHEDFILE_NAME_2"		=> "커뮤니티 첨부파일 이름3",
												"BI_ATTACHEDFILE_NAME_3"		=> "커뮤니티 첨부파일 이름4",
												"BI_ATTACHEDFILE_NAME_4"		=> "커뮤니티 첨부파일 이름5",
												"BI_ATTACHEDFILE_KEY_0"			=> "커뮤니티 첨부파일 키1(file, image, movie..)",
												"BI_ATTACHEDFILE_KEY_1"			=> "커뮤니티 첨부파일 키2(file, image, movie..)",
												"BI_ATTACHEDFILE_KEY_2"			=> "커뮤니티 첨부파일 키3(file, image, movie..)",
												"BI_ATTACHEDFILE_KEY_3"			=> "커뮤니티 첨부파일 키4(file, image, movie..)",
												"BI_ATTACHEDFILE_KEY_4"			=> "커뮤니티 첨부파일 키5(file, image, movie..)",			
//												"BI_USERFIELD_USE"				=> "커뮤니티 추가필드 사용(사용=Y 사용안함=N)",
												"BI_USERFIELD_FIELD_USE"		=> "커뮤니티 추가필드 필드 사용(사용=Y 사용안함=N)",
												"BI_USERFIELD_NAME"				=> "커뮤니티 추가필드 이름",
												"BI_USERFIELD_SORT"				=> "커뮤니티 추가필드 정렬",							
												"BI_DATAANSWER_USE"				=> "커뮤니티 답변 사용(사용=Y, 모든회원/비회원=A, 회원전용=M, 사용안함=N)",
											//	"BI_DATAANSWER_MEMBER_AUTH"		=> "커뮤니티 답변 사용 권한(일반회원, 관리자회원, 공급사회원)",
												"BI_DATALIST_TITLE_LEN"			=> "커뮤니티 리스트 타이틀 자리수",
												"BI_DATAVIEW_NEXTPRVE_USE"		=> "커뮤니티 보기에서 다음/이전 리스트 사용(사용=Y, 사용안함=N)",
												"BI_ADMIN_MAIN_SHOW"			=> "커뮤니티 관리자 메인화면 표시 여부(사용=Y, 사용안함=N)",
												"BI_ADMIN_MAIN_SORT"			=> "커뮤니티 관리자 메인화면 순위(정렬)"										);

## 커뮤니티 카테고리 옵션 설정
$G_BOARD_INFO['boardModifyCategory']		= array(	"BI_CATEGORY_USE"				=> "카테고리 사용(사용(모든사용자)=Y,사용(관리자만)=A,사용안함=N)",
														"BI_CATEGORY_SKIN"				=> "카테고리 노출(콤보박스=combobox,텍스트=text,이미지=image)",	
														"BI_CATEGORY_LIST_USE"			=> "카테고리 표시(리스트 화면 상단에 카테고리 사용=Y)",							);

## 커뮤니티 추가필드 옵션 설정
$G_BOARD_INFO['boardModifyUserfield']		= array(	"BI_USERFIELD_USE"				=> "커뮤니티 추가필드 사용 유무(사용=Y, 사용안함=N)",		);

foreach($G_USERFIELD_INFO as $key => $data):
	$columnName																			= $data['columnName'];
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_KIND"]						= "커뮤니티 추가필드 종류";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_KIND_DATA"]					= "커뮤니티 추가필드 종류 데이터";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_KIND_DEFAULT"]				= "커뮤니티 추가필드 종류 디폴트";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_ONLYADMIN"]					= "커뮤니티 추가필드 관리자 전용";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_ESSENTIAL"]					= "커뮤니티 추가필드 필수 옵션";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_NAME"]						= "커뮤니티 추가필드 이름";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_SORT"]						= "커뮤니티 추가필드 정렬";
	$G_BOARD_INFO['boardModifyUserfield']["BI_{$columnName}_USE"]						= "커뮤니티 추가필드 사용유무";
endforeach;

