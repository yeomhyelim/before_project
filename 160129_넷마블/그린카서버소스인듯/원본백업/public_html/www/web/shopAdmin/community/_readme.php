<?
	## 데이터 베이스 오류 발생시 체크 사항.
	## 1. BOARD_MGR_NEW 테이블 생성이 되어 있는지 체크.
	## -> http://sgc.eumshop.co.kr/shopAdmin/?menuType=community&mode=boardTable 이동하여 테이블 생성
	## 2. BOARD_MGR_GROUP_NEW 테이블 생성이 되어 있는지 체크.
	## -> http://sgc.eumshop.co.kr/shopAdmin/?menuType=community&mode=groupTable 이동하여 테이블 생성
	## 3. BOARD_INFO_MGR 테이블 생성이 되어 있는지 체크
	## -> http://sgc.eumshop.co.kr/shopAdmin/?menuType=community&mode=boardInfoTable 이동하여 테이블 생성
	## 3. 커뮤니티 환경설정 폴더 체크 (707 권한)
	## -> /home/shop_eng/sgc/conf/community
	## -> /home/shop_eng/sgc/conf/community/category
	## 4. 업로드 폴더 체크 (권한 707)
	## -> /home/shop_eng/sgc/upload/community/group			= 그룹
	## -> /home/shop_eng/sgc/upload/community/data			= 데이터
	## -> /home/shop_eng/sgc/upload/community/temp			= 업로드 임시 폴더
	## -> /home/shop_eng/sgc/layout/html/community			= 스크립트 폴더
	## -> /home/shop_eng/ivenet/upload/community/category	= 카테고리 폴더

	## 오류 모음
	## 1. 사용자 페이지에서 커뮤니티 페이지가 보이지 않을 때.
	## -> HTML편집/커뮤니티 부분에서 {{__커뮤니티영역__}} 추가.
	## 2. 커뮤니티 게시판 글쓰기 오류가 날 때
	## -> UB_URL 컬럼 추가 되었는지 체크(data - basic 스킨)
	## -> ALTER TABLE `BOARD_UB_EVENT` ADD COLUMN `UB_URL` VARCHAR(200) COMMENT '웹주소' AFTER `UB_MAIL`;

	## 버튼 권한 설정
	## 이벤트 : e1 : 이벤트 참여자
	##			e2 : 포인트 발급 / 취소

	## 일반 게시판 : e1 : 답변 권한
	##				 e2 : 복사 권한

?>