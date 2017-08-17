<?
/*@ boardModifyBasic @*/
## 커뮤니티 관리자 메인화면 표시 여부(사용=Y, 사용안함=N)
$BOARD_INFO['USER_REPORT']['BI_ADMIN_MAIN_SHOW'] = 'Y';

## 커뮤니티 관리자 메인화면 순위(정렬)
$BOARD_INFO['USER_REPORT']['BI_ADMIN_MAIN_SORT'] = '';

## 커뮤니티 첨부파일 키1(file, image, movie..)
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_KEY'][0] = 'file';

## 커뮤니티 첨부파일 키2(file, image, movie..)
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_KEY'][1] = 'file';

## 커뮤니티 첨부파일 키3(file, image, movie..)
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_KEY'][2] = 'file';

## 커뮤니티 첨부파일 키4(file, image, movie..)
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_KEY'][3] = 'file';

## 커뮤니티 첨부파일 키5(file, image, movie..)
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_KEY'][4] = 'file';

## 커뮤니티 첨부파일 이름1
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_NAME'][0] = '';

## 커뮤니티 첨부파일 이름2
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_NAME'][1] = '';

## 커뮤니티 첨부파일 이름3
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_NAME'][2] = '';

## 커뮤니티 첨부파일 이름4
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_NAME'][3] = '';

## 커뮤니티 첨부파일 이름5
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_NAME'][4] = '';

## 커뮤니티 첨부파일 사용(사용=1/2/3/4..., 사용안함=0)
$BOARD_INFO['USER_REPORT']['BI_ATTACHEDFILE_USE'] = '0';

## 세로줄 수
$BOARD_INFO['USER_REPORT']['BI_COLUMN_DEFAULT'] = '1';

## 커뮤니티 코멘트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['USER_REPORT']['BI_COMMENT_USE'] = 'N';

## 커뮤니티 답변 사용(사용=Y, 모든회원/비회원=A, 회원전용=M, 사용안함=N)
$BOARD_INFO['USER_REPORT']['BI_DATAANSWER_USE'] = 'N';

## 
$BOARD_INFO['USER_REPORT']['BI_DATADELETE_AFTER'] = 'hide';

## 커뮤니티 리스트 목록 설정(번호)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_FIELD_USE'][0] = 'Y';

## 커뮤니티 리스트 목록 설정(작성자)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_FIELD_USE'][1] = 'Y';

## 커뮤니티 리스트 목록 설정(등록일)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_FIELD_USE'][2] = 'Y';

## 커뮤니티 리스트 목록 설정(조회수)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_FIELD_USE'][3] = 'Y';

## 커뮤니티 리스트 목록 설정(카테고리)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_FIELD_USE'][5] = 'Y';

## 목록권한 회원 그룹 리스트
$BOARD_INFO['USER_REPORT']['BI_DATALIST_MEMBER_AUTH'][0] = '001';

## 리스트 정렬 설정(등록날짜오름차순, 등록날짜내림차순...)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_ORDERBY'] = '';

## 커뮤니티 리스트 타이틀 자리수
$BOARD_INFO['USER_REPORT']['BI_DATALIST_TITLE_LEN'] = '';

## 커뮤니티 리스트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_USE'] = 'M';

## 커뮤니티 리스트 작성자 부분 숨김(갯수)
$BOARD_INFO['USER_REPORT']['BI_DATALIST_WRITER_HIDDEN'] = '';

## 
$BOARD_INFO['USER_REPORT']['BI_DATAVIEW_MEMBER_AUTH'][0] = '001';

## 커뮤니티 보기 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['USER_REPORT']['BI_DATAVIEW_USE'] = 'M';

## 글쓰기 완료 후, 이동경로(목록화면, 글쓰기화면, 상세보기화면)
$BOARD_INFO['USER_REPORT']['BI_DATAWRITE_END_MOVE'] = 'dataList';

## 글쓰기 폼(텍스트폼=textWrite, 에디터폼=editWrite)
$BOARD_INFO['USER_REPORT']['BI_DATAWRITE_FORM'] = 'higheditor_full';

## 비밀글 사용(사용자선택=C.무조건=E,사용안함=N or '')
$BOARD_INFO['USER_REPORT']['BI_DATAWRITE_LOCK_USE'] = 'C';

## 
$BOARD_INFO['USER_REPORT']['BI_DATAWRITE_MEMBER_AUTH'][0] = '001';

## 커뮤니티 쓰기/수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['USER_REPORT']['BI_DATAWRITE_USE'] = 'M';

## 리스트 수
$BOARD_INFO['USER_REPORT']['BI_LIST_DEFAULT'] = '10';

## 받는사람 연락처 리스트(최대5개)
$BOARD_INFO['USER_REPORT']['BI_SMS_HP_LIST'] = '';

## SMS 문자 내용
$BOARD_INFO['USER_REPORT']['BI_SMS_TEXT'] = '';

## SMS 사용 유무
$BOARD_INFO['USER_REPORT']['BI_SMS_USE'] = 'N';

## 커뮤니티 시작 페이지(list,view,write)
$BOARD_INFO['USER_REPORT']['BI_START_MODE'] = 'dataList';

## 커뮤니티 그룹 번호
$BOARD_INFO['USER_REPORT']['B_BG_NO'] = '1';

## 
$BOARD_INFO['USER_REPORT']['B_CSS'] = 'basicCss1';

## 게시판 종류(종류_스킨)
$BOARD_INFO['USER_REPORT']['B_KIND_SKIN'] = 'data_basic';

## 
$BOARD_INFO['USER_REPORT']['B_NAME'] = '상담관리';
/*@ boardModifyBasic @*/
/*@ boardModifyCategory @*/
## 카테고리 노출 방식
$BOARD_INFO['USER_REPORT']['BI_CATEGORY_SKIN'] = 'combobox';

## 카테고리 사용유무
$BOARD_INFO['USER_REPORT']['BI_CATEGORY_USE'] = 'A';
/*@ boardModifyCategory @*/
/*@ boardModifyUserfield @*/
## 주소1 필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_ADDR1_KIND'] = 'address';

## 주소1 필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_ADDR1_NAME'] = '';

## 주소1 필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_ADDR1_SORT'] = '100000';

## 주소1 필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_ADDR1_USE'] = 'N';

## 회사명 필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_COMPANY_KIND'] = 'text';

## 회사명 필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_COMPANY_KIND_DATA'] = '';

## 회사명 필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_COMPANY_KIND_DEFAULT'] = '';

## 회사명 필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_COMPANY_NAME'] = '';

## 회사명 필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_COMPANY_SORT'] = '100000';

## 회사명 필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_COMPANY_USE'] = 'N';

## 연락처 필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE1_KIND'] = 'phone';

## 연락처 필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE1_NAME'] = '';

## 연락처 필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE1_SORT'] = '100000';

## 연락처 필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE1_USE'] = 'N';

## 연락처 필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE2_KIND'] = 'phone';

## 연락처 필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE2_NAME'] = '';

## 연락처 필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE2_SORT'] = '100000';

## 연락처 필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE2_USE'] = 'N';

## 연락처 필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE3_KIND'] = 'phone';

## 연락처 필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE3_NAME'] = '';

## 연락처 필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE3_SORT'] = '100000';

## 연락처 필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_PHONE3_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP10_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP10_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP10_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP10_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP10_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP10_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP11_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP11_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP11_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP11_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP11_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP11_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP12_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP12_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP12_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP12_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP12_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP12_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP13_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP13_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP13_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP13_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP13_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP13_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP14_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP14_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP14_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP14_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP14_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP14_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP15_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP15_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP15_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP15_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP15_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP15_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP16_KIND'] = 'select';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP16_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP16_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP16_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP16_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP16_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP17_KIND'] = 'select';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP17_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP17_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP17_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP17_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP17_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP18_KIND'] = 'textarea';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP18_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP18_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP18_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP19_KIND'] = 'textarea';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP19_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP19_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP19_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_KIND'] = 'select';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_KIND_DATA'] = '상담접수중;상담진행중;상담완료;보류';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_KIND_DEFAULT'] = '상담접수중';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_NAME'] = '상담상태';

## 임시필드 관리자 전용
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_ONLYADMIN'] = 'Y';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP1_USE'] = 'Y';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP20_KIND'] = 'textarea';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP20_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP20_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP20_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP2_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP2_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP2_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP2_NAME'] = '주문번호(O_NO)';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP2_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP2_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP3_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP3_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP3_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP3_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP3_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP3_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP4_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP4_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP4_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP4_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP4_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP4_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP5_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP5_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP5_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP5_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP5_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP5_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP6_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP6_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP6_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP6_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP6_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP6_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP7_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP7_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP7_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP7_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP7_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP7_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP8_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP8_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP8_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP8_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP8_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP8_USE'] = 'N';

## 임시필드 종류
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP9_KIND'] = 'text';

## 임시필드 데이터
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP9_KIND_DATA'] = '';

## 임시필드 기본값
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP9_KIND_DEFAULT'] = '';

## 임시필드 이름
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP9_NAME'] = '';

## 임시필드 정렬
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP9_SORT'] = '100000';

## 임시필드 사용유무
$BOARD_INFO['USER_REPORT']['BI_AD_TEMP9_USE'] = 'N';

## 추가필드 사용 유무
$BOARD_INFO['USER_REPORT']['BI_USERFIELD_USE'] = 'Y';
/*@ boardModifyUserfield @*/
?>
