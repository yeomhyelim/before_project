<?
/*@ boardModifyBasic @*/
## 커뮤니티 관리자 메인화면 표시 여부(사용=Y, 사용안함=N)
$BOARD_INFO['S_REQ']['BI_ADMIN_MAIN_SHOW'] = 'N';

## 커뮤니티 관리자 메인화면 순위(정렬)
$BOARD_INFO['S_REQ']['BI_ADMIN_MAIN_SORT'] = '';

## 커뮤니티 첨부파일 키1(file, image, movie..)
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_KEY'][0] = 'file';

## 커뮤니티 첨부파일 키2(file, image, movie..)
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_KEY'][1] = 'file';

## 커뮤니티 첨부파일 키3(file, image, movie..)
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_KEY'][2] = 'file';

## 커뮤니티 첨부파일 키4(file, image, movie..)
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_KEY'][3] = 'file';

## 커뮤니티 첨부파일 키5(file, image, movie..)
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_KEY'][4] = 'file';

## 커뮤니티 첨부파일 이름1
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_NAME'][0] = '';

## 커뮤니티 첨부파일 이름2
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_NAME'][1] = '';

## 커뮤니티 첨부파일 이름3
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_NAME'][2] = '';

## 커뮤니티 첨부파일 이름4
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_NAME'][3] = '';

## 커뮤니티 첨부파일 이름5
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_NAME'][4] = '';

## 커뮤니티 첨부파일 사용(사용=1/2/3/4..., 사용안함=0)
$BOARD_INFO['S_REQ']['BI_ATTACHEDFILE_USE'] = '0';

## 세로줄 수
$BOARD_INFO['S_REQ']['BI_COLUMN_DEFAULT'] = '5';

## 커뮤니티 코멘트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['S_REQ']['BI_COMMENT_USE'] = 'N';

## 
$BOARD_INFO['S_REQ']['BI_DATAANSWER_MEMBER_AUTH'][0] = '001';

## 커뮤니티 답변 사용(사용=Y, 모든회원/비회원=A, 회원전용=M, 사용안함=N)
$BOARD_INFO['S_REQ']['BI_DATAANSWER_USE'] = 'M';

## 
$BOARD_INFO['S_REQ']['BI_DATADELETE_AFTER'] = 'hide';

## 커뮤니티 리스트 목록 설정(번호)
$BOARD_INFO['S_REQ']['BI_DATALIST_FIELD_USE'][0] = 'Y';

## 커뮤니티 리스트 목록 설정(작성자)
$BOARD_INFO['S_REQ']['BI_DATALIST_FIELD_USE'][1] = 'Y';

## 커뮤니티 리스트 목록 설정(등록일)
$BOARD_INFO['S_REQ']['BI_DATALIST_FIELD_USE'][2] = 'Y';

## 커뮤니티 리스트 목록 설정(조회수)
$BOARD_INFO['S_REQ']['BI_DATALIST_FIELD_USE'][3] = 'Y';

## 목록권한 회원 그룹 리스트
$BOARD_INFO['S_REQ']['BI_DATALIST_MEMBER_AUTH'][2] = '005';

## 리스트 정렬 설정(등록날짜오름차순, 등록날짜내림차순...)
$BOARD_INFO['S_REQ']['BI_DATALIST_ORDERBY'] = '';

## 커뮤니티 리스트 타이틀 자리수
$BOARD_INFO['S_REQ']['BI_DATALIST_TITLE_LEN'] = '50';

## 커뮤니티 리스트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['S_REQ']['BI_DATALIST_USE'] = 'A';

## 커뮤니티 리스트 작성자 부분 숨김(갯수)
$BOARD_INFO['S_REQ']['BI_DATALIST_WRITER_HIDDEN'] = '';

## 
$BOARD_INFO['S_REQ']['BI_DATAVIEW_MEMBER_AUTH'][2] = '005';

## 커뮤니티 보기 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['S_REQ']['BI_DATAVIEW_USE'] = 'A';

## 글쓰기 완료 후, 이동경로(목록화면, 글쓰기화면, 상세보기화면)
$BOARD_INFO['S_REQ']['BI_DATAWRITE_END_MOVE'] = 'dataList';

## 글쓰기 폼(텍스트폼=textWrite, 에디터폼=editWrite)
$BOARD_INFO['S_REQ']['BI_DATAWRITE_FORM'] = 'higheditor_full';

## 비밀글 사용(사용자선택=C.무조건=E,사용안함=N or '')
$BOARD_INFO['S_REQ']['BI_DATAWRITE_LOCK_USE'] = 'C';

## 
$BOARD_INFO['S_REQ']['BI_DATAWRITE_MEMBER_AUTH'][0] = '001';

## 
$BOARD_INFO['S_REQ']['BI_DATAWRITE_MEMBER_AUTH'][2] = '005';

## 커뮤니티 쓰기/수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['S_REQ']['BI_DATAWRITE_USE'] = 'M';

## 리스트 수
$BOARD_INFO['S_REQ']['BI_LIST_DEFAULT'] = '10';

## 커뮤니티 시작 페이지(list,view,write)
$BOARD_INFO['S_REQ']['BI_START_MODE'] = 'dataList';

## 커뮤니티 그룹 번호
$BOARD_INFO['S_REQ']['B_BG_NO'] = '3';

## 
$BOARD_INFO['S_REQ']['B_CSS'] = 'basicCss1';

## 게시판 종류(종류_스킨)
$BOARD_INFO['S_REQ']['B_KIND_SKIN'] = 'data_basic';

## 
$BOARD_INFO['S_REQ']['B_NAME'] = '입점사문의';
/*@ boardModifyBasic @*/
?>
