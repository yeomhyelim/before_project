
	## 상품리스트 이미지 설정 옵션을 추가 하고 싶다면?
	## 관리자페이지 -> 디자인 관리 -> 세부페이지 설정 -> 상품 리스트 -> 상품리스트 디자인 -> 이미지 설정 부분 레이아웃
		-> /home/shop_eng/www/web/shopAdmin/popup/skinProdListDesignSet.php
		-> 생상 코드 추가시 박스 모양이 틀리다면, CSS 내용 추가 할것. 
			/home/shop_eng/www/web/shopAdmin/common/css/design.css  
		-> 옵션을 하나 추가 하고 싶다면,
		-> 1. skin 을 만든다.
		-> 2. conf 파일에 추가된 설정 변수를 추가한다.(파일로 떨어트리기 위해) 
		    상품리스트 옵션은 "PL_BEST_LIST1000_" 시작.
			/home/shop_eng/www/web/shopAdmin/layout/_conf.inc.php
			참고) 베스트 상품도 동일하게 변경 가능함.
		-> 3.act.php 파일 수정
			3-1. POST 부분 추가.
			3-2. "skinProdListImg" 부분에 추가된 변수명을 추가한다.
		-> 4. 완료

	## 상품상세보기 이미지 사이즈를 변경 하고 싶다면?
	## 관리자페이지 -> 디자인 관리 -> 세부페이지 설정 -> 상품 상세 보기 -> 이미지 버튼 크릭시 팝업 뛰움
		-> /home/shop_eng/www/web/shopAdmin/popup/skinProdViewImg.php
		
			


