- 2013-03-29
- style 0003, 0004 번 만듬.. 시간이 없는 관계로 추후 설명 예정




---------------------------------------------------------

- 파일명 :
	categoryStyle.0001.php
- conf 정보(/home/shop_eng/preforyou/conf/site_skin_main.conf.inc.php)
	$S_MAIN_SUB_CATE_USE1			= "Y"; // 사용유무
	$S_MAIN_CATE_L1_MODE1			= "T"; // 카테고리 레벨1 사용 유무(사용안함:N,텍스트:T)
	$S_MAIN_CATE_L2_MODE1			= "T"; // 카테고리 레벨2 사용 유무(사용안함:N,텍스트:T)
	$S_MAIN_CATE_L3_MODE1			= "T"; // 카테고리 레벨3 사용 유무(사용안함:N,텍스트:T)
	$S_MAIN_CATE_L4_MODE1			= "T"; // 카테고리 레벨4 사용 유무(사용안함:N,텍스트:T)

- 설명
	사용중인 레벨의 모든 카테고리를 호출한다.
	하위 레벨은 무시하고 무조건 conf 설정에 따라 카테고리 호출
	단, 레벨1 사용 안하는 경우, 레벨1 값(default=001) 에 의한 레벨2~레벨4까지 호출한다.

- 예제
		A
			AA
			AB
		B
			BA
			BB

		일때, L1 = T, L2 = N, L3 = N, L4 = N		=> A, B 값이 나온다.
		또한, L1 = N, L2 = T, L3 = N, L4 = N		=> AA, AB, BA, BB 가 나온다.			-> 룰 변경.
		또한, L1 = T, L2 = T, L3 = N, L4 = N		=> A, AA, AB, B, BA, BB 가 나온다.


	추가내용, L1 = N, L2 = T, L3 = N, L4 = N		=> 레벨1 정의가 안된   경우, AA, AB 가 나온다.
													=> 레벨1 값이 B 정의된 경우, BA, BB 가 나온다.


- 예제2
		A
			AA
				AAA
					AAAA
					AAAB
					AAAC
				AAB
				AAC
			AB
				ABA
				ABB
				ABC
		B
			BA
				BAA
				BAB
				BAC
			BB
				BBA
				BBB

		일때, L1 = N, L2 = N, L3 = Y, L4 = N		=> 경우의 수는 없음.


-------------------------------------------

- 파일명 :
	categoryStyle.0002.php
- conf 정보(/home/shop_eng/preforyou/conf/site_skin_main.conf.inc.php)
	$S_MAIN_SUB_CATE_USE2			= "Y"; // 사용유무
	$S_MAIN_CATE_L1_MODE2			= "T"; // 카테고리 레벨1 사용 유무(사용안함:N,텍스트:T)
	$S_MAIN_CATE_L2_MODE2			= "T"; // 카테고리 레벨2 사용 유무(사용안함:N,텍스트:T)
	$S_MAIN_CATE_L3_MODE2			= "T"; // 카테고리 레벨3 사용 유무(사용안함:N,텍스트:T)
	$S_MAIN_CATE_L4_MODE2			= "T"; // 카테고리 레벨4 사용 유무(사용안함:N,텍스트:T)

- 설명
	(상품페이지)의 카테고리 레벨 이동에 따라 해당하는 카테고리 호출.

- 참고
	관리자페이지 디자인 설정에서 카테고리 관련 설정 변경할 수 있음.

- 예제
		A(001)
			AA(001)
			AB(002)
		B(002)
			BA(001)
			BB(002)
		
		현재 페이지가 lcate=001&mcate=&scate=&fcate= 

		일때, L1 = T, L2 = N, L3 = N, L4 = N		=> A 가  나온다.
		일때, L1 = T, L2 = T, L3 = N, L4 = N		=> A, AA, AB 가  나온다.
		일때, L1 = N, L2 = T, L3 = N, L4 = N		=> AA, AB 가  나온다.		




