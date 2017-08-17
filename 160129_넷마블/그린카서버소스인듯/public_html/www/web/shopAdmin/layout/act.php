<?
	/*##################################### Parameter 셋팅 #####################################*/

	// 레이아웃 
	$strDM_CODE					= $_POST["dm_code"]				? $_POST["dm_code"]					: $_REQUEST["dm_code"];


	/* 첫화면 설정 */
	$strDL_BG_TYPE				= $_POST["dl_bg_type"]				? $_POST["dl_bg_type"]				: $_REQUEST["dl_bg_type"];
	$strDL_BG_COLOR				= $_POST["dl_bg_color"]				? $_POST["dl_bg_color"]				: $_REQUEST["dl_bg_color"];
	$strDL_BG_IMAGE				= $_POST["dl_bg_image_old"]			? $_POST["dl_bg_image_old"]			: $_REQUEST["dl_bg_image_old"];
	$strDL_BG_IMG_DIR_H			= $_POST["dl_bg_img_dir_h"]			? $_POST["dl_bg_img_dir_h"]			: $_REQUEST["dl_bg_img_dir_h"];
	$strDL_BG_IMG_DIR_V			= $_POST["dl_bg_img_dir_v"]			? $_POST["dl_bg_img_dir_v"]			: $_REQUEST["dl_bg_img_dir_v"];
	$strDL_BG_REPEAT			= $_POST["dl_bg_repeat"]			? $_POST["dl_bg_repeat"]			: $_REQUEST["dl_bg_repeat"];
	$strDL_BG_ALIGN				= $_POST["dl_bg_align"]				? $_POST["dl_bg_align"]				: $_REQUEST["dl_bg_align"];
	$strDL_FIRST_PAGE			= $_POST["dl_first_page"]			? $_POST["dl_first_page"]			: $_REQUEST["dl_first_page"];
	$strDL_FIRST_USE			= $_POST["dl_first_use"]			? $_POST["dl_first_use"]			: $_REQUEST["dl_first_use"];
	$strDL_GB_IMAGE_DEL			= $_POST["dl_bg_image_del"]			? $_POST["dl_bg_image_del"]			: $_REQUEST["dl_bg_image_del"];			// 배경이미지 삭제 유무

	$strWebLogoType				= $_POST["web_log_type"]			? $_POST["web_log_type"]			: $_REQUEST["web_log_type"];

	/* 첫화면 설정 */
	/* 페이지 디자인 설정 */
	$strDE_EDIT_TEXT			= $_POST["de_edit_text"]			? $_POST["de_edit_text"]			: $_REQUEST["de_edit_text"];
	
	/* 페이지 디자인 설정 */

	/* 상품리스트 이미지 관련 관리 */
	$strProdListImgViewW		= $_POST["imgViewW"]				? $_POST["imgViewW"]				: $_REQUEST["imgViewW"];
	$strProdListImgViewH		= $_POST["imgViewH"]				? $_POST["imgViewH"]				: $_REQUEST["imgViewH"];
	
	$strProdCateCode			= $_POST["prodCateCode"]			? $_POST["prodCateCode"]			: $_REQUEST["prodCateCode"];
	
	
	$strProdListTopHtml			= $_POST["pl_top_html"]				? $_POST["pl_top_html"]				: $_REQUEST["pl_top_html"];
	
	$strPROD_NAME_COLOR			= $_POST["prod_name_color"]			? $_POST["prod_name_color"]			: $_REQUEST["prod_name_color"];
	$strPROD_INTRO_COLOR		= $_POST["prod_intro_color"]		? $_POST["prod_intro_color"]		: $_REQUEST["prod_intro_color"];
	$strPROD_POINT_COLOR		= $_POST["prod_point_color"]		? $_POST["prod_point_color"]		: $_REQUEST["prod_point_color"];
	$strPROD_PRICE_COLOR		= $_POST["prod_price_color"]		? $_POST["prod_price_color"]		: $_REQUEST["prod_price_color"];
	$strPROD_SALE_COLOR			= $_POST["prod_sale_color"]			? $_POST["prod_sale_color"]			: $_REQUEST["prod_sale_color"];
	$strPROD_TEXT_ALIGN			= $_POST["prod_text_align"]			? $_POST["prod_text_align"]			: $_REQUEST["prod_text_align"];
	$strPROD_PRINT_TYPE			= $_POST["prod_print_type"]			? $_POST["prod_print_type"]			: $_REQUEST["prod_print_type"];
	$strPROD_OVER_IMAGE_USE		= $_POST["prod_over_image_use"]		? $_POST["prod_over_image_use"]		: $_REQUEST["prod_over_image_use"];

	$strPROD_NAME_COLOR_CODE		= $_POST["prod_name_color_code"]			? $_POST["prod_name_color_code"]			: $_REQUEST["prod_name_color_code"];
	$strPROD_INTRO_COLOR_CODE		= $_POST["prod_intro_color_code"]			? $_POST["prod_intro_color_code"]			: $_REQUEST["prod_intro_color_code"];
	$strPROD_POINT_COLOR_CODE		= $_POST["prod_point_color_code"]			? $_POST["prod_point_color_code"]			: $_REQUEST["prod_point_color_code"];
	$strPROD_PRICE_COLOR_CODE		= $_POST["prod_price_color_code"]			? $_POST["prod_price_color_code"]			: $_REQUEST["prod_price_color_code"];
	$strPROD_SALE_COLOR_CODE		= $_POST["prod_sale_color_code"]			? $_POST["prod_sale_color_code"]			: $_REQUEST["prod_sale_color_code"];
	$strPROD_PRINT_TYPE_ICON_FILE	= $_POST["prod_print_type_icon_file"]		? $_POST["prod_print_type_icon_file"]		: $_REQUEST["prod_print_type_icon_file"];

	/* 베스트 상품 구분 코드 */
	$intIC_CODE			= $_POST["ic_code"]			? $_POST["ic_code"]			: $_REQUEST["ic_code"];
	$strIC_TYPE			= $_POST["ic_type"]			? $_POST["ic_type"]			: $_REQUEST["ic_type"];




	/* 상품 상세보기 */
	$strProdViewAfterYN		= $_POST["afterYN"]			? $_POST["afterYN"]			: $_REQUEST["afterYN"];
	$strProdViewQnaYN		= $_POST["qnaYN"]			? $_POST["qnaYN"]			: $_REQUEST["qnaYN"];
	$strProdViewRelatedYN	= $_POST["relatedYN"]		? $_POST["relatedYN"]	: $_REQUEST["relatedYN"];

	/* 상품 상세보기 */


	/* 메뉴 관련 */
	$strMenuTopHtml				= $_POST["top_html"]				? $_POST["top_html"]				: $_REQUEST["top_html"];

	/* 메뉴 관련 */
	
	/* 메인 상품 리스트(진열관리)*/
	$strProdListOrder		= $_POST["prodListOrder"]		? $_POST["prodListOrder"]		: $_REQUEST["prodListOrder"];

	/* 메인 상품 리스트(진열관리)*/
	$strDS_CODE			= $_POST["ds_code"]				? $_POST["ds_code"]				: $_REQUEST["ds_code"];
	$strDS_IMG2			= $_POST["ds_img2"]				? $_POST["ds_img2"]				: $_REQUEST["ds_img2"];

	/* 이미지 및 버튼관리에 필요한 코드 */
	$strBtnCode			= $_POST["btnCode"]		? $_POST["btnCode"]		: $_REQUEST["btnCode"];	

	/* 퀙메뉴 */
	$strQuickMenuKind			= $_POST["quickMenuKind"]			? $_POST["quickMenuKind"]			: $_REQUEST["quickMenuKind"];	
	$strQuickMenuUse			= $_POST["quickMenuUse"]			? $_POST["quickMenuUse"]			: $_REQUEST["quickMenuUse"];	
	$strQuickMenuAct			= $_POST["quickMenuAct"]			? $_POST["quickMenuAct"]			: $_REQUEST["quickMenuAct"];	
	$strQuickMenuSpe			= $_POST["quickMenuSpe"]			? $_POST["quickMenuSpe"]			: $_REQUEST["quickMenuSpe"];	
	$strQuickMenuTop			= $_POST["quickMenuTop"]			? $_POST["quickMenuTop"]			: $_REQUEST["quickMenuTop"];	
	$strQuickMenuLef			= $_POST["quickMenuLef"]			? $_POST["quickMenuLef"]			: $_REQUEST["quickMenuLef"];
	
	$strQuickMenuProdListCnt	= $_POST["quickMenuProdListCnt"]	? $_POST["quickMenuProdListCnt"]	: $_REQUEST["quickMenuProdListCnt"];
	$strQuickMenuProdImgSize	= $_POST["quickMenuProdImgSize"]	? $_POST["quickMenuProdImgSize"]	: $_REQUEST["quickMenuProdImgSize"];
	$strQuickMenuEffect			= $_POST["quickMenuEffect"]			? $_POST["quickMenuEffect"]			: $_REQUEST["quickMenuEffect"];
	$strQuickMenuAlign			= $_POST["quickMenuAlign"]			? $_POST["quickMenuAlign"]			: $_REQUEST["quickMenuAlign"];

	/* 슬라이딩 배너 */	
	$intSB_IMAGES_CNT	= $_POST["sb_images_cnt"]		? $_POST["sb_images_cnt"]		: $_REQUEST["sb_images_cnt"];

//	$intSB_NO			= $_POST["sb_no"]				? $_POST["sb_no"]				: $_REQUEST["sb_no"];
	$strSB_COMMENT		= $_POST["sb_comment"]			? $_POST["sb_comment"]			: $_REQUEST["sb_comment"];
	$strIM_CODE			= $_POST["im_code"]				? $_POST["im_code"]				: $_REQUEST["im_code"];
	$intSB_W_SIZE		= $_POST["sb_w_size"]			? $_POST["sb_w_size"]			: $_REQUEST["sb_w_size"];
	$intSB_H_SIZE		= $_POST["sb_h_size"]			? $_POST["sb_h_size"]			: $_REQUEST["sb_h_size"];
	$strSB_LINK_TYPE	= $_POST["sb_link_type"]		? $_POST["sb_link_type"]		: $_REQUEST["sb_link_type"];
 //	$intSI_NO			= $_POST["si_no"]				? $_POST["si_no"]				: $_REQUEST["si_no"];
	$arySI_NO_BAK		= $_POST["si_no_bak"]			? $_POST["si_no_bak"]			: $_REQUEST["si_no_bak"];
//	$strSI_IMG			= $_POST["si_img"]				? $_POST["si_img"]				: $_REQUEST["si_img"];
	$strSI_LINK			= $_POST["si_link"]				? $_POST["si_link"]				: $_REQUEST["si_link"];
	$strSI_TEXT			= $_POST["si_text"]				? $_POST["si_text"]				: $_REQUEST["si_text"];
	$intSB_W_SIZE		= 0;
	$intSB_H_SIZE		= 0;

	/* 메인 타이틀 베너 (슬라이딩 배너 재정의) */
	$strZL_MAIN_TITLE_BANNER_USE			= $_POST["zl_main_title_banner_use"]				? $_POST["zl_main_title_banner_use"]				: $_REQUEST["zl_main_title_banner_use"];
	$strZL_MAIN_TITLE_BANNER_KIND			= $_POST["zl_main_title_banner_kind"]				? $_POST["zl_main_title_banner_kind"]				: $_REQUEST["zl_main_title_banner_kind"];
	$strZL_MAIN_TITLE_BANNER_SIZE_W			= $_POST["zl_main_title_banner_size_w"]				? $_POST["zl_main_title_banner_size_w"]				: $_REQUEST["zl_main_title_banner_size_w"];
	$strZL_MAIN_TITLE_BANNER_SIZE_H			= $_POST["zl_main_title_banner_size_h"]				? $_POST["zl_main_title_banner_size_h"]				: $_REQUEST["zl_main_title_banner_size_h"];


	/**************************** 정리 (2013-01-06) ****************************/
	
	// 페이지 구분
	$strCode					= substr($strSubPageCode, 0, 2);

	// 구분
	$intBE_NO					= $_POST["be_no"]					? $_POST["be_no"]				: $_REQUEST["be_no"];	// 베스트 구분(1,2,3,4,5)

	// 메인 움직이는 이미지(배너)
//	$strZL_SLIDER_USE			= $_POST["zl_slider_use"]			? $_POST["zl_slider_use"]				: $_REQUEST["zl_slider_use"];
	$strZL_SLIDER_MOTION_USE	= $_POST["zl_slider_motion_use"]	? $_POST["zl_slider_motion_use"]		: $_REQUEST["zl_slider_motion_use"];
	$strZL_SLIDER_MOTION_EFFECT	= $_POST["zl_slider_motion_effect"]	? $_POST["zl_slider_motion_effect"]		: $_REQUEST["zl_slider_motion_effect"];
	$strZL_SLIDER_MOTION_TYPE	= $_POST["zl_slider_motion_type"]	? $_POST["zl_slider_motion_type"]		: $_REQUEST["zl_slider_motion_type"];
	$strZL_SLIDER_IMAGE_SIZE_W	= $_POST["zl_slider_image_size_w"]	? $_POST["zl_slider_image_size_w"]		: $_REQUEST["zl_slider_image_size_w"];
	$strZL_SLIDER_IMAGE_SIZE_H	= $_POST["zl_slider_image_size_h"]	? $_POST["zl_slider_image_size_h"]		: $_REQUEST["zl_slider_image_size_h"];
	
	// 사용자 정의 베스트 상품 (메인 , 상품) (1 - 5 )
	$ds1	= $strCode . "_BEST_LIST" . $intBE_NO;
	$ds2	= strtolower($ds1);
	$strBEST_LIST_USE				= $_POST["{$ds2}_use"]				? $_POST["{$ds2}_use"]				: $_REQUEST["{$ds2}_use"];
	$strBEST_LIST_NAME				= $_POST["{$ds2}_name"]				? $_POST["{$ds2}_name"]				: $_REQUEST["{$ds2}_name"];
	$strBEST_LIST_SIZE_W			= $_POST["{$ds2}_size_w"]			? $_POST["{$ds2}_size_w"]			: $_REQUEST["{$ds2}_size_w"];
	$strBEST_LIST_SIZE_H			= $_POST["{$ds2}_size_h"]			? $_POST["{$ds2}_size_h"]			: $_REQUEST["{$ds2}_size_h"];
	$strBEST_LIST_VIEW_W			= $_POST["{$ds2}_view_w"]			? $_POST["{$ds2}_view_w"]			: $_REQUEST["{$ds2}_view_w"];
	$strBEST_LIST_VIEW_H			= $_POST["{$ds2}_view_h"]			? $_POST["{$ds2}_view_h"]			: $_REQUEST["{$ds2}_view_h"];
	$strBEST_LIST_SHOW_1			= $_POST["{$ds2}_show_1"]			? $_POST["{$ds2}_show_1"]			: $_REQUEST["{$ds2}_show_1"];
	$strBEST_LIST_SHOW_2			= $_POST["{$ds2}_show_2"]			? $_POST["{$ds2}_show_2"]			: $_REQUEST["{$ds2}_show_2"];
	$strBEST_LIST_SHOW_3			= $_POST["{$ds2}_show_3"]			? $_POST["{$ds2}_show_3"]			: $_REQUEST["{$ds2}_show_3"];
	$strBEST_LIST_SHOW_4			= $_POST["{$ds2}_show_4"]			? $_POST["{$ds2}_show_4"]			: $_REQUEST["{$ds2}_show_4"];
	$strBEST_LIST_SHOW_5			= $_POST["{$ds2}_show_5"]			? $_POST["{$ds2}_show_5"]			: $_REQUEST["{$ds2}_show_5"];
	$strBEST_LIST_SHOW_6			= $_POST["{$ds2}_show_6"]			? $_POST["{$ds2}_show_6"]			: $_REQUEST["{$ds2}_show_6"];
	$strBEST_LIST_SHOW_7			= $_POST["{$ds2}_show_7"]			? $_POST["{$ds2}_show_7"]			: $_REQUEST["{$ds2}_show_7"];
	$strBEST_LIST_SHOW_8			= $_POST["{$ds2}_show_8"]			? $_POST["{$ds2}_show_8"]			: $_REQUEST["{$ds2}_show_8"];
	$strBEST_LIST_COLOR_1			= $_POST["{$ds2}_color_1"]			? $_POST["{$ds2}_color_1"]			: $_REQUEST["{$ds2}_color_1"];
	$strBEST_LIST_COLOR_2			= $_POST["{$ds2}_color_2"]			? $_POST["{$ds2}_color_2"]			: $_REQUEST["{$ds2}_color_2"];
	$strBEST_LIST_COLOR_3			= $_POST["{$ds2}_color_3"]			? $_POST["{$ds2}_color_3"]			: $_REQUEST["{$ds2}_color_3"];
	$strBEST_LIST_COLOR_4			= $_POST["{$ds2}_color_4"]			? $_POST["{$ds2}_color_4"]			: $_REQUEST["{$ds2}_color_4"];
	$strBEST_LIST_COLOR_5			= $_POST["{$ds2}_color_5"]			? $_POST["{$ds2}_color_5"]			: $_REQUEST["{$ds2}_color_5"];
	$strBEST_LIST_COLOR_6			= $_POST["{$ds2}_color_6"]			? $_POST["{$ds2}_color_6"]			: $_REQUEST["{$ds2}_color_6"];
	$strBEST_LIST_COLOR_7			= $_POST["{$ds2}_color_7"]			? $_POST["{$ds2}_color_7"]			: $_REQUEST["{$ds2}_color_7"];
	$strBEST_LIST_COLOR_8			= $_POST["{$ds2}_color_8"]			? $_POST["{$ds2}_color_8"]			: $_REQUEST["{$ds2}_color_8"];
	$strBEST_LIST_WORD_ALIGN		= $_POST["{$ds2}_word_align"]		? $_POST["{$ds2}_word_align"]		: $_REQUEST["{$ds2}_word_align"];
	$strBEST_LIST_MONEY_TYPE		= $_POST["{$ds2}_money_type"]		? $_POST["{$ds2}_money_type"]		: $_REQUEST["{$ds2}_money_type"];
	$strBEST_LIST_MONEY_ICON		= $_POST["{$ds2}_money_icon"]		? $_POST["{$ds2}_money_icon"]		: $_REQUEST["{$ds2}_money_icon"];
	$strBEST_LIST_TURN_USE			= $_POST["{$ds2}_turn_use"]			? $_POST["{$ds2}_turn_use"]			: $_REQUEST["{$ds2}_turn_use"];
	$strBEST_LIST_TITLE_SHOW_USE	= $_POST["{$ds2}_title_show_use"]	? $_POST["{$ds2}_title_show_use"]	: $_REQUEST["{$ds2}_title_show_use"];
	$strBEST_LIST_TITLE_MAXSIZE		= $_POST["{$ds2}_title_maxsize"]	? $_POST["{$ds2}_title_maxsize"]	: $_REQUEST["{$ds2}_title_maxsize"];

	// 샵메인 -  레이어 팝업 사용유무
	$strZL_LAYERPOP_LOGIN_USE		= $_POST["zl_layerpop_login_use"]	? $_POST["zl_layerpop_login_use"]	: $_REQUEST["zl_layerpop_login_use"];
	$strZL_LAYERPOP_JOIN_USE		= $_POST["zl_layerpop_join_use"]	? $_POST["zl_layerpop_join_use"]	: $_REQUEST["zl_layerpop_join_use"];

	// 샵메인 -  베스트 사용유무
	$strZL_SLIDER_USE			= $_POST["zl_slider_use"]			? $_POST["zl_slider_use"]		: $_REQUEST["zl_slider_use"];
	$strZL_BEST_LIST1_USE		= $_POST["zl_best_list1_use"]		? $_POST["zl_best_list1_use"]	: $_REQUEST["zl_best_list1_use"];
	$strZL_BEST_LIST2_USE		= $_POST["zl_best_list2_use"]		? $_POST["zl_best_list2_use"]	: $_REQUEST["zl_best_list2_use"];
	$strZL_BEST_LIST3_USE		= $_POST["zl_best_list3_use"]		? $_POST["zl_best_list3_use"]	: $_REQUEST["zl_best_list3_use"];
	$strZL_BEST_LIST4_USE		= $_POST["zl_best_list4_use"]		? $_POST["zl_best_list4_use"]	: $_REQUEST["zl_best_list4_use"];
	$strZL_BEST_LIST5_USE		= $_POST["zl_best_list5_use"]		? $_POST["zl_best_list5_use"]	: $_REQUEST["zl_best_list5_use"];
	
	// 샵메인 -  베스트 이름 정의
	$strZL_BEST_LIST1_NAME		= $_POST["zl_best_list1_name"]		? $_POST["zl_best_list1_name"]	: $_REQUEST["zl_best_list1_name"];
	$strZL_BEST_LIST2_NAME		= $_POST["zl_best_list2_name"]		? $_POST["zl_best_list2_name"]	: $_REQUEST["zl_best_list2_name"];
	$strZL_BEST_LIST3_NAME		= $_POST["zl_best_list3_name"]		? $_POST["zl_best_list3_name"]	: $_REQUEST["zl_best_list3_name"];
	$strZL_BEST_LIST4_NAME		= $_POST["zl_best_list4_name"]		? $_POST["zl_best_list4_name"]	: $_REQUEST["zl_best_list4_name"];
	$strZL_BEST_LIST5_NAME		= $_POST["zl_best_list5_name"]		? $_POST["zl_best_list5_name"]	: $_REQUEST["zl_best_list5_name"];

	
	/*-- 상품 리스트 , 상품 검색 --*/
	$strPL_NAVI_USE_OP			= $_POST["pl_navi_use_op"]			? $_POST["pl_navi_use_op"]			: $_REQUEST["pl_navi_use_op"];	
	$strPL_TOP_USE_OP_Y			= $_POST["pl_top_use_op_y"]			? $_POST["pl_top_use_op_y"]			: $_REQUEST["pl_top_use_op_y"];		//
	$strPL_TOP_USE_OP			= $_POST["pl_top_use_op"]			? $_POST["pl_top_use_op"]			: $_REQUEST["pl_top_use_op"];		// 탑이미지 사용유무(미사용:N, 모든 상품페이지에 한개의 이미지만 적용 : A, 카테고리별 이미지 업로드 적용 : B)
	$strPL_TOP_CAT_OP			= $_POST["pl_top_cat_op"]			? $_POST["pl_top_cat_op"]			: $_REQUEST["pl_top_cat_op"];		// 탑이미지 카테고리 사용 범위
//	$strPL_TOP_CAT_OP			= 1;

//  2013.12.10 kim hee sung 탑이미지 사용 버튼 통합
//	$strPL_TOP_USE_OP			= ($strPL_TOP_USE_OP_Y != "Y")		? $strPL_TOP_USE_OP_Y				: $strPL_TOP_USE_OP;
	$strPL_TOP_USE_OP			= "";
	if($strPL_TOP_USE_OP_Y =="Y") { $strPL_TOP_USE_OP = "B"; }


	// 상품리스트 -  베스트 사용유무
	$strPL_BEST_LIST1_USE		= $_POST["pl_best_list1_use"]		? $_POST["pl_best_list1_use"]	: $_REQUEST["pl_best_list1_use"];
	$strPL_BEST_LIST2_USE		= $_POST["pl_best_list2_use"]		? $_POST["pl_best_list2_use"]	: $_REQUEST["pl_best_list2_use"];
	$strPL_BEST_LIST3_USE		= $_POST["pl_best_list3_use"]		? $_POST["pl_best_list3_use"]	: $_REQUEST["pl_best_list3_use"];
	$strPL_BEST_LIST4_USE		= $_POST["pl_best_list4_use"]		? $_POST["pl_best_list4_use"]	: $_REQUEST["pl_best_list4_use"];
	$strPL_BEST_LIST5_USE		= $_POST["pl_best_list5_use"]		? $_POST["pl_best_list5_use"]	: $_REQUEST["pl_best_list5_use"];	

	// 상품리스트 -  베스트 이름 정의
	$strPL_BEST_LIST1_NAME		= $_POST["pl_best_list1_name"]		? $_POST["pl_best_list1_name"]	: $_REQUEST["pl_best_list1_name"];
	$strPL_BEST_LIST2_NAME		= $_POST["pl_best_list2_name"]		? $_POST["pl_best_list2_name"]	: $_REQUEST["pl_best_list2_name"];
	$strPL_BEST_LIST3_NAME		= $_POST["pl_best_list3_name"]		? $_POST["pl_best_list3_name"]	: $_REQUEST["pl_best_list3_name"];
	$strPL_BEST_LIST4_NAME		= $_POST["pl_best_list4_name"]		? $_POST["pl_best_list4_name"]	: $_REQUEST["pl_best_list4_name"];
	$strPL_BEST_LIST5_NAME		= $_POST["pl_best_list5_name"]		? $_POST["pl_best_list5_name"]	: $_REQUEST["pl_best_list5_name"];

	// 상품 - 브랜드 세부화면
	$strPH_BEST_LIST1_NAME		= $_POST["ph_best_list1_name"]		? $_POST["ph_best_list1_name"]	: $_REQUEST["ph_best_list1_name"];
	$strPH_BEST_LIST2_NAME		= $_POST["ph_best_list2_name"]		? $_POST["ph_best_list2_name"]	: $_REQUEST["ph_best_list2_name"];
	$strPH_BEST_LIST3_NAME		= $_POST["ph_best_list3_name"]		? $_POST["ph_best_list3_name"]	: $_REQUEST["ph_best_list3_name"];
	$strPH_BEST_LIST4_NAME		= $_POST["ph_best_list4_name"]		? $_POST["ph_best_list4_name"]	: $_REQUEST["ph_best_list4_name"];
	$strPH_BEST_LIST5_NAME		= $_POST["ph_best_list5_name"]		? $_POST["ph_best_list5_name"]	: $_REQUEST["ph_best_list5_name"];

	// 상품리스트 서브 카테고리 관련 관리
	$strPL_SUB_CATE_USE			= $_POST["pl_sub_cate_use"]			? $_POST["pl_sub_cate_use"]			: $_REQUEST["pl_sub_cate_use"];
	$strPL_SUB_CATE_VIEW		= $_POST["pl_sub_cate_view"]		? $_POST["pl_sub_cate_view"]		: $_REQUEST["pl_sub_cate_view"];
	$strPL_SUB_CATE_DESIGN		= $_POST["pl_sub_cate_design"]		? $_POST["pl_sub_cate_design"]		: $_REQUEST["pl_sub_cate_design"];

	$strPL_SUB_CATE_L1_MODE		= $_POST["pl_sub_cate_l1_mode"]		? $_POST["pl_sub_cate_l1_mode"]		: $_REQUEST["pl_sub_cate_l1_mode"];
	$strPL_SUB_CATE_L2_MODE		= $_POST["pl_sub_cate_l2_mode"]		? $_POST["pl_sub_cate_l2_mode"]		: $_REQUEST["pl_sub_cate_l2_mode"];
	$strPL_SUB_CATE_L3_MODE		= $_POST["pl_sub_cate_l3_mode"]		? $_POST["pl_sub_cate_l3_mode"]		: $_REQUEST["pl_sub_cate_l3_mode"];
	$strPL_SUB_CATE_L4_MODE		= $_POST["pl_sub_cate_l4_mode"]		? $_POST["pl_sub_cate_l4_mode"]		: $_REQUEST["pl_sub_cate_l4_mode"];
	$strPL_SUB_CATE_USE			= ($strPL_SUB_CATE_USE)				? $strPL_SUB_CATE_USE				: "N"; 

	/*-- 상품 뷰 --*/

	// 설정
	$strPV_IMAGE_SHOW_TYPE_C	= $_POST["pv_image_show_type_c"]	? $_POST["pv_image_show_type_c"]	: $_REQUEST["pv_image_show_type_c"];
	$strPV_IMAGE_SHOW_TYPE		= $_POST["pv_image_show_type"]		? $_POST["pv_image_show_type"]		: $_REQUEST["pv_image_show_type"];
	$strPV_IMAGE_ZOOM_USE		= $_POST["pv_image_zoom_use"]		? $_POST["pv_image_zoom_use"]		: $_REQUEST["pv_image_zoom_use"];
	$strPV_BBS_REVIEW_USE		= $_POST["pv_bbs_review_use"]		? $_POST["pv_bbs_review_use"]		: $_REQUEST["pv_bbs_review_use"];
	$strPV_BBS_QNA_USE			= $_POST["pv_bbs_qna_use"]			? $_POST["pv_bbs_qna_use"]			: $_REQUEST["pv_bbs_qna_use"];
	$strPV_BEST_LIST1_USE_Y		= $_POST["pv_best_list1_use_y"]		? $_POST["pv_best_list1_use_y"]		: $_REQUEST["pv_best_list1_use_y"];
	$strPV_BEST_LIST1_USE		= $_POST["pv_best_list1_use"]		? $_POST["pv_best_list1_use"]		: $_REQUEST["pv_best_list1_use"];
	$strPV_IMAGE_SHOW_TYPE		= ($strPV_IMAGE_SHOW_TYPE_C == "C")	? $strPV_IMAGE_SHOW_TYPE_C			: $strPV_IMAGE_SHOW_TYPE;
	$strPV_IMAGE_ZOOM_USE		= ($strPV_IMAGE_SHOW_TYPE == "A")	? "Y"								: $strPV_IMAGE_ZOOM_USE;
	$strPV_BEST_LIST1_USE		= ($strPV_BEST_LIST1_USE_Y)			? $strPV_BEST_LIST1_USE				: "N";

	$strProdListImgSizeW		= $_POST["imgSizeW"]				? $_POST["imgSizeW"]				: $_REQUEST["imgSizeW"];
	$strProdListImgSizeH		= $_POST["imgSizeH"]				? $_POST["imgSizeH"]				: $_REQUEST["imgSizeH"];
	$strProdListPopImgSizeW		= $_POST["popImgSizeW"]				? $_POST["popImgSizeW"]				: $_REQUEST["popImgSizeW"];
	$strProdListPopImgSizeH		= $_POST["popImgSizeH"]				? $_POST["popImgSizeH"]				: $_REQUEST["popImgSizeH"];
//	$strPV_IMG_SIZE_W			= $_POST["pv_img_size_w"]			? $_POST["pv_img_size_w"]			: $_REQUEST["pv_img_size_w"];
//	$strPV_IMG_SIZE_H			= $_POST["pv_img_size_h"]			? $_POST["pv_img_size_h"]			: $_REQUEST["pv_img_size_h"];
	$strPV_IMG_VIEW_W			= $_POST["pv_img_view_w"]			? $_POST["pv_img_view_w"]			: $_REQUEST["pv_img_view_w"];
	$strPV_IMG_VIEW_H			= $_POST["pv_img_view_h"]			? $_POST["pv_img_view_h"]			: $_REQUEST["pv_img_view_h"];

	/* SNS */
	$strPV_SNS_USE				= $_POST["pv_sns_use"]				? $_POST["pv_sns_use"]				: $_REQUEST["pv_sns_use"];
	$strPV_SNS_FACEBOOK			= $_POST["pv_sns_facebook"]			? $_POST["pv_sns_facebook"]			: $_REQUEST["pv_sns_facebook"];
	$strPV_SNS_TWITTER			= $_POST["pv_sns_twitter"]			? $_POST["pv_sns_twitter"]			: $_REQUEST["pv_sns_twitter"];
	$strPV_SNS_M2DAY			= $_POST["pv_sns_m2day"]			? $_POST["pv_sns_m2day"]			: $_REQUEST["pv_sns_m2day"];


	// 다중이미지
	$strPV_IMG_MULTY_SIZE_W		= $_POST["pv_img_multy_size_w"]		? $_POST["pv_img_multy_size_w"]		: $_REQUEST["pv_img_multy_size_w"];
	$strPV_IMG_MULTY_SIZE_H		= $_POST["pv_img_multy_size_h"]		? $_POST["pv_img_multy_size_h"]		: $_REQUEST["pv_img_multy_size_h"];
	$strPV_IMG_MULTY_VIEW_W		= $_POST["pv_img_multy_view_w"]		? $_POST["pv_img_multy_view_w"]		: $_REQUEST["pv_img_multy_view_w"];
	$strPV_IMG_MULTY_VIEW_H		= $_POST["pv_img_multy_view_h"]		? $_POST["pv_img_multy_view_h"]		: $_REQUEST["pv_img_multy_view_h"];
	$strPV_IMG_MULTY_CHANGE		= $_POST["pv_img_multy_change"]		? $_POST["pv_img_multy_change"]		: $_REQUEST["pv_img_multy_change"];

	// 확대줌
	$strPV_IMG_ZOOM_SIZE_W		= $_POST["pv_img_zoom_size_w"]		? $_POST["pv_img_zoom_size_w"]		: $_REQUEST["pv_img_zoom_size_w"];
	$strPV_IMG_ZOOM_SIZE_H		= $_POST["pv_img_zoom_size_h"]		? $_POST["pv_img_zoom_size_h"]		: $_REQUEST["pv_img_zoom_size_h"];
	$strPV_IMG_ZOOM_VIEW_W		= $_POST["pv_img_zoom_view_w"]		? $_POST["pv_img_zoom_view_w"]		: $_REQUEST["pv_img_zoom_view_w"];
	$strPV_IMG_ZOOM_VIEW_H		= $_POST["pv_img_zoom_view_h"]		? $_POST["pv_img_zoom_view_h"]		: $_REQUEST["pv_img_zoom_view_h"];
	$strPV_IMG_ZOOM_POSITION	= $_POST["pv_img_zoom_position"]	? $_POST["pv_img_zoom_position"]	: $_REQUEST["pv_img_zoom_position"];

	/**************************** 정리 (2013-01-06) ****************************/

	$strIM_CODE			= strTrim($strIM_CODE,30);
	$strSB_COMMENT			= strTrim($strSB_COMMENT,500);
	$strSB_LINK_TYPE	= strTrim($strSB_LINK_TYPE,1);
	$strSI_IMG			= strTrim($strSI_IMG,50);
	$strSI_LINK			= strTrim($strSI_LINK,100);
	$strSI_TEXT			= strTrim($strSI_TEXT,200);

	$designSetMgr->setSB_NO($intSB_NO);
	$designSetMgr->setSB_COMMENT($strSB_COMMENT);
	$designSetMgr->setIM_CODE($strIM_CODE);
	$designSetMgr->setSB_W_SIZE($intSB_W_SIZE);
	$designSetMgr->setSB_H_SIZE($intSB_H_SIZE);
	$designSetMgr->setSB_LINK_TYPE($strSB_LINK_TYPE);
	$designSetMgr->setSI_NO($intSI_NO);
	$designSetMgr->setSB_NO($intSB_NO);
//	$designSetMgr->setSI_IMG($strSI_IMG);
//	$designSetMgr->setSI_LINK($strSI_LINK);
//	$designSetMgr->setSI_TEXT($strSI_TEXT);

	/*
	$strSB_GROUP			= $_POST["sb_group"]			? $_POST["sb_group"]				: $_REQUEST["sb_group"];
	$intSB_DESIGN_CODE		= $_POST["sb_design_code"]		? $_POST["sb_design_code"]			: $_REQUEST["sb_design_code"];
	$strSB_BANNER_NAME		= $_POST["sb_banner_name"]		? $_POST["sb_banner_name"]			: $_REQUEST["sb_banner_name"];
	$intSB_IMAGES_CNT		= $_POST["sb_images_cnt"]		? $_POST["sb_images_cnt"]			: $_REQUEST["sb_images_cnt"];
	$intSB_IMAGE_W			= $_POST["sb_image_w"]			? $_POST["sb_image_w"]				: $_REQUEST["sb_image_w"];
	$intSB_IMAGE_H			= $_POST["sb_image_h"]			? $_POST["sb_image_h"]				: $_REQUEST["sb_image_h"];
	$strSB_IMAGE_FILE_1 	= $_POST["sb_image_file_1"]		? $_POST["sb_image_file_1"]			: $_REQUEST["sb_image_file_1"];
	$strSB_IMAGE_FILE_2 	= $_POST["sb_image_file_2"]		? $_POST["sb_image_file_2"]			: $_REQUEST["sb_image_file_2"];
	$strSB_IMAGE_FILE_3 	= $_POST["sb_image_file_3"]		? $_POST["sb_image_file_3"]			: $_REQUEST["sb_image_file_3"];
	$strSB_IMAGE_FILE_4 	= $_POST["sb_image_file_4"]		? $_POST["sb_image_file_4"]			: $_REQUEST["sb_image_file_4"];
	$strSB_IMAGE_FILE_5		= $_POST["sb_image_file_5"]		? $_POST["sb_image_file_5"]			: $_REQUEST["sb_image_file_5"];
	$strSB_IMAGE_FILE_6 	= $_POST["sb_image_file_6"]		? $_POST["sb_image_file_6"]			: $_REQUEST["sb_image_file_6"];
	$strSB_IMAGE_FILE_7 	= $_POST["sb_image_file_7"]		? $_POST["sb_image_file_7"]			: $_REQUEST["sb_image_file_7"];
	$strSB_IMAGE_FILE_8		= $_POST["sb_image_file_8"]		? $_POST["sb_image_file_8"]			: $_REQUEST["sb_image_file_8"];
	$strSB_IMAGE_FILE_9 	= $_POST["sb_image_file_9"]		? $_POST["sb_image_file_9"]			: $_REQUEST["sb_image_file_9"];	
	$strSB_IMAGE_FILE_10	= $_POST["sb_image_file_10"]		? $_POST["sb_image_file_10"]			: $_REQUEST["sb_image_file_10"];

	$strSB_IMAGE_FILE_BAK[1] 		= $_POST["sb_image_file_1_bak"]		? $_POST["sb_image_file_1_bak"]			: $_REQUEST["sb_image_file_1_bak"];
	$strSB_IMAGE_FILE_BAK[2] 		= $_POST["sb_image_file_2_bak"]		? $_POST["sb_image_file_2_bak"]			: $_REQUEST["sb_image_file_2_bak"];
	$strSB_IMAGE_FILE_BAK[3] 		= $_POST["sb_image_file_3_bak"]		? $_POST["sb_image_file_3_bak"]			: $_REQUEST["sb_image_file_3_bak"];
	$strSB_IMAGE_FILE_BAK[4] 		= $_POST["sb_image_file_4_bak"]		? $_POST["sb_image_file_4_bak"]			: $_REQUEST["sb_image_file_4_bak"];
	$strSB_IMAGE_FILE_BAK[5]		= $_POST["sb_image_file_5_bak"]		? $_POST["sb_image_file_5_bak"]			: $_REQUEST["sb_image_file_5_bak"];
	$strSB_IMAGE_FILE_BAK[6] 		= $_POST["sb_image_file_6_bak"]		? $_POST["sb_image_file_6_bak"]			: $_REQUEST["sb_image_file_6_bak"];
	$strSB_IMAGE_FILE_BAK[7] 		= $_POST["sb_image_file_7_bak"]		? $_POST["sb_image_file_7_bak"]			: $_REQUEST["sb_image_file_7_bak"];
	$strSB_IMAGE_FILE_BAK[8]		= $_POST["sb_image_file_8_bak"]		? $_POST["sb_image_file_8_bak"]			: $_REQUEST["sb_image_file_8_bak"];
	$strSB_IMAGE_FILE_BAK[9] 		= $_POST["sb_image_file_9_bak"]		? $_POST["sb_image_file_9_bak"]			: $_REQUEST["sb_image_file_9_bak"];
	$strSB_IMAGE_FILE_BAK[10]		= $_POST["sb_image_file_10_bak"]		? $_POST["sb_image_file_10_bak"]			: $_REQUEST["sb_image_file_10_bak"];	
	
	$strSB_IMAGE_LINK_1 = $_POST["sb_image_link_1"]			? $_POST["sb_image_link_1"]		: $_REQUEST["sb_image_link_1"];
	$strSB_IMAGE_LINK_2 = $_POST["sb_image_link_2"]			? $_POST["sb_image_link_2"]		: $_REQUEST["sb_image_link_2"];
	$strSB_IMAGE_LINK_3 = $_POST["sb_image_link_3"]			? $_POST["sb_image_link_3"]		: $_REQUEST["sb_image_link_3"];
	$strSB_IMAGE_LINK_4 = $_POST["sb_image_link_4"]			? $_POST["sb_image_link_4"]		: $_REQUEST["sb_image_link_4"];
	$strSB_IMAGE_LINK_5 = $_POST["sb_image_link_5"]			? $_POST["sb_image_link_5"]		: $_REQUEST["sb_image_link_5"];
	$strSB_IMAGE_LINK_6 = $_POST["sb_image_link_6"]			? $_POST["sb_image_link_6"]		: $_REQUEST["sb_image_link_6"];
	$strSB_IMAGE_LINK_7 = $_POST["sb_image_link_7"]			? $_POST["sb_image_link_7"]		: $_REQUEST["sb_image_link_7"];
	$strSB_IMAGE_LINK_8 = $_POST["sb_image_link_8"]			? $_POST["sb_image_link_8"]		: $_REQUEST["sb_image_link_8"];
	$strSB_IMAGE_LINK_9 = $_POST["sb_image_link_9"]			? $_POST["sb_image_link_9"]		: $_REQUEST["sb_image_link_9"];
	$strSB_IMAGE_LINK_10 = $_POST["sb_image_link_10"]		? $_POST["sb_image_link_10"]	: $_REQUEST["sb_image_link_10"];
	$strSB_IMAGES_TITLE_1 = $_POST["sb_images_title_1"]		? $_POST["sb_images_title_1"]	: $_REQUEST["sb_images_title_1"];
	$strSB_IMAGES_TITLE_2 = $_POST["sb_images_title_2"]		? $_POST["sb_images_title_2"]	: $_REQUEST["sb_images_title_2"];
	$strSB_IMAGES_TITLE_3 = $_POST["sb_images_title_3"]		? $_POST["sb_images_title_3"]	: $_REQUEST["sb_images_title_3"];
	$strSB_IMAGES_TITLE_4 = $_POST["sb_images_title_4"]		? $_POST["sb_images_title_4"]	: $_REQUEST["sb_images_title_4"];
	$strSB_IMAGES_TITLE_5 = $_POST["sb_images_title_5"]		? $_POST["sb_images_title_5"]	: $_REQUEST["sb_images_title_5"];
	$strSB_IMAGES_TITLE_6 = $_POST["sb_images_title_6"]		? $_POST["sb_images_title_6"]	: $_REQUEST["sb_images_title_6"];
	$strSB_IMAGES_TITLE_7 = $_POST["sb_images_title_7"]		? $_POST["sb_images_title_7"]	: $_REQUEST["sb_images_title_7"];
	$strSB_IMAGES_TITLE_8 = $_POST["sb_images_title_8"]		? $_POST["sb_images_title_8"]	: $_REQUEST["sb_images_title_8"];
	$strSB_IMAGES_TITLE_9 = $_POST["sb_images_title_9"]		? $_POST["sb_images_title_9"]	: $_REQUEST["sb_images_title_9"];
	$strSB_IMAGES_TITLE_10 = $_POST["sb_images_title_10"]	? $_POST["sb_images_title_10"]	: $_REQUEST["sb_images_title_10"];
	$strSB_IMAGES_TXT_1 = $_POST["sb_images_txt_1"]			? $_POST["sb_images_txt_1"]		: $_REQUEST["sb_images_txt_1"];
	$strSB_IMAGES_TXT_2 = $_POST["sb_images_txt_2"]			? $_POST["sb_images_txt_2"]		: $_REQUEST["sb_images_txt_2"];
	$strSB_IMAGES_TXT_3 = $_POST["sb_images_txt_3"]			? $_POST["sb_images_txt_3"]		: $_REQUEST["sb_images_txt_3"];
	$strSB_IMAGES_TXT_4 = $_POST["sb_images_txt_4"]			? $_POST["sb_images_txt_4"]		: $_REQUEST["sb_images_txt_4"];
	$strSB_IMAGES_TXT_5 = $_POST["sb_images_txt_5"]			? $_POST["sb_images_txt_5"]		: $_REQUEST["sb_images_txt_5"];
	$strSB_IMAGES_TXT_6 = $_POST["sb_images_txt_6"]			? $_POST["sb_images_txt_6"]		: $_REQUEST["sb_images_txt_6"];
	$strSB_IMAGES_TXT_7 = $_POST["sb_images_txt_7"]			? $_POST["sb_images_txt_7"]		: $_REQUEST["sb_images_txt_7"];
	$strSB_IMAGES_TXT_8 = $_POST["sb_images_txt_8"]			? $_POST["sb_images_txt_8"]		: $_REQUEST["sb_images_txt_8"];
	$strSB_IMAGES_TXT_9 = $_POST["sb_images_txt_9"]			? $_POST["sb_images_txt_9"]		: $_REQUEST["sb_images_txt_9"];
	$strSB_IMAGES_TXT_10 = $_POST["sb_images_txt_10"]		? $_POST["sb_images_txt_10"]	: $_REQUEST["sb_images_txt_10"];
	$strSB_LINK_TARGET	= $_POST["sb_link_target"]			? $_POST["sb_link_target"]		: $_REQUEST["sb_link_target"];
	$intSB_REG_NO		= $_POST["sb_reg_no"]				? $_POST["sb_reg_no"]			: $_REQUEST["sb_reg_no"];
	$intSB_MOD_NO		= $_POST["sb_mod_no"]				? $_POST["sb_mod_no"]			: $_REQUEST["sb_mod_no"];



	$strSB_GROUP		= strTrim($strSB_GROUP,10);
	$strSB_BANNER_NAME	= strTrim($strSB_BANNER_NAME,50);
	$strSB_IMAGE_FILE_1 = strTrim($strSB_IMAGE_FILE_1,50);
	$strSB_IMAGE_FILE_2 = strTrim($strSB_IMAGE_FILE_2,50);
	$strSB_IMAGE_FILE_3 = strTrim($strSB_IMAGE_FILE_3,50);
	$strSB_IMAGE_FILE_4 = strTrim($strSB_IMAGE_FILE_4,50);
	$strSB_IMAGE_FILE_5 = strTrim($strSB_IMAGE_FILE_5,50);
	$strSB_IMAGE_FILE_6 = strTrim($strSB_IMAGE_FILE_6,50);
	$strSB_IMAGE_FILE_7 = strTrim($strSB_IMAGE_FILE_7,50);
	$strSB_IMAGE_FILE_8 = strTrim($strSB_IMAGE_FILE_8,50);
	$strSB_IMAGE_FILE_9 = strTrim($strSB_IMAGE_FILE_9,50);
	$strSB_IMAGE_FILE_10 = strTrim($strSB_IMAGE_FILE_10,50);
	$strSB_IMAGE_LINK_1 = strTrim($strSB_IMAGE_LINK_1,100);
	$strSB_IMAGE_LINK_2 = strTrim($strSB_IMAGE_LINK_2,100);
	$strSB_IMAGE_LINK_3 = strTrim($strSB_IMAGE_LINK_3,100);
	$strSB_IMAGE_LINK_4 = strTrim($strSB_IMAGE_LINK_4,100);
	$strSB_IMAGE_LINK_5 = strTrim($strSB_IMAGE_LINK_5,100);
	$strSB_IMAGE_LINK_6 = strTrim($strSB_IMAGE_LINK_6,100);
	$strSB_IMAGE_LINK_7 = strTrim($strSB_IMAGE_LINK_7,100);
	$strSB_IMAGE_LINK_8 = strTrim($strSB_IMAGE_LINK_8,100);
	$strSB_IMAGE_LINK_9 = strTrim($strSB_IMAGE_LINK_9,100);
	$strSB_IMAGE_LINK_10 = strTrim($strSB_IMAGE_LINK_10,100);
	$strSB_IMAGES_TITLE_1 = strTrim($strSB_IMAGES_TITLE_1,100);
	$strSB_IMAGES_TITLE_2 = strTrim($strSB_IMAGES_TITLE_2,100);
	$strSB_IMAGES_TITLE_3 = strTrim($strSB_IMAGES_TITLE_3,100);
	$strSB_IMAGES_TITLE_4 = strTrim($strSB_IMAGES_TITLE_4,100);
	$strSB_IMAGES_TITLE_5 = strTrim($strSB_IMAGES_TITLE_5,100);
	$strSB_IMAGES_TITLE_6 = strTrim($strSB_IMAGES_TITLE_6,100);
	$strSB_IMAGES_TITLE_7 = strTrim($strSB_IMAGES_TITLE_7,100);
	$strSB_IMAGES_TITLE_8 = strTrim($strSB_IMAGES_TITLE_8,100);
	$strSB_IMAGES_TITLE_9 = strTrim($strSB_IMAGES_TITLE_9,100);
	$strSB_IMAGES_TITLE_10 = strTrim($strSB_IMAGES_TITLE_10,100);
	$strSB_IMAGES_TXT_1 = strTrim($strSB_IMAGES_TXT_1,100);
	$strSB_IMAGES_TXT_2 = strTrim($strSB_IMAGES_TXT_2,100);
	$strSB_IMAGES_TXT_3 = strTrim($strSB_IMAGES_TXT_3,100);
	$strSB_IMAGES_TXT_4 = strTrim($strSB_IMAGES_TXT_4,100);
	$strSB_IMAGES_TXT_5 = strTrim($strSB_IMAGES_TXT_5,100);
	$strSB_IMAGES_TXT_6 = strTrim($strSB_IMAGES_TXT_6,100);
	$strSB_IMAGES_TXT_7 = strTrim($strSB_IMAGES_TXT_7,100);
	$strSB_IMAGES_TXT_8 = strTrim($strSB_IMAGES_TXT_8,100);
	$strSB_IMAGES_TXT_9 = strTrim($strSB_IMAGES_TXT_9,100);
	$strSB_IMAGES_TXT_10 = strTrim($strSB_IMAGES_TXT_10,100);
	$strSB_LINK_TARGET = strTrim($strSB_LINK_TARGET,1);

	$designMgr->setSB_NO($intSB_NO);
	$designMgr->setSB_GROUP($strSB_GROUP);
	$designMgr->setSB_DESIGN_CODE($intSB_DESIGN_CODE);
	$designMgr->setSB_BANNER_NAME($strSB_BANNER_NAME);
	$designMgr->setSB_IMAGES_CNT($intSB_IMAGES_CNT);
	$designMgr->setSB_IMAGE_W($intSB_IMAGE_W);
	$designMgr->setSB_IMAGE_H($intSB_IMAGE_H);
	$designMgr->setSB_IMAGE_FILE_1($strSB_IMAGE_FILE_1);
	$designMgr->setSB_IMAGE_FILE_2($strSB_IMAGE_FILE_2);
	$designMgr->setSB_IMAGE_FILE_3($strSB_IMAGE_FILE_3);
	$designMgr->setSB_IMAGE_FILE_4($strSB_IMAGE_FILE_4);
	$designMgr->setSB_IMAGE_FILE_5($strSB_IMAGE_FILE_5);
	$designMgr->setSB_IMAGE_FILE_6($strSB_IMAGE_FILE_6);
	$designMgr->setSB_IMAGE_FILE_7($strSB_IMAGE_FILE_7);
	$designMgr->setSB_IMAGE_FILE_8($strSB_IMAGE_FILE_8);
	$designMgr->setSB_IMAGE_FILE_9($strSB_IMAGE_FILE_9);
	$designMgr->setSB_IMAGE_FILE_10($strSB_IMAGE_FILE_10);
	$designMgr->setSB_IMAGE_LINK_1($strSB_IMAGE_LINK_1);
	$designMgr->setSB_IMAGE_LINK_2($strSB_IMAGE_LINK_2);
	$designMgr->setSB_IMAGE_LINK_3($strSB_IMAGE_LINK_3);
	$designMgr->setSB_IMAGE_LINK_4($strSB_IMAGE_LINK_4);
	$designMgr->setSB_IMAGE_LINK_5($strSB_IMAGE_LINK_5);
	$designMgr->setSB_IMAGE_LINK_6($strSB_IMAGE_LINK_6);
	$designMgr->setSB_IMAGE_LINK_7($strSB_IMAGE_LINK_7);
	$designMgr->setSB_IMAGE_LINK_8($strSB_IMAGE_LINK_8);
	$designMgr->setSB_IMAGE_LINK_9($strSB_IMAGE_LINK_9);
	$designMgr->setSB_IMAGE_LINK_10($strSB_IMAGE_LINK_10);
	$designMgr->setSB_IMAGES_TITLE_1($strSB_IMAGES_TITLE_1);
	$designMgr->setSB_IMAGES_TITLE_2($strSB_IMAGES_TITLE_2);
	$designMgr->setSB_IMAGES_TITLE_3($strSB_IMAGES_TITLE_3);
	$designMgr->setSB_IMAGES_TITLE_4($strSB_IMAGES_TITLE_4);
	$designMgr->setSB_IMAGES_TITLE_5($strSB_IMAGES_TITLE_5);
	$designMgr->setSB_IMAGES_TITLE_6($strSB_IMAGES_TITLE_6);
	$designMgr->setSB_IMAGES_TITLE_7($strSB_IMAGES_TITLE_7);
	$designMgr->setSB_IMAGES_TITLE_8($strSB_IMAGES_TITLE_8);
	$designMgr->setSB_IMAGES_TITLE_9($strSB_IMAGES_TITLE_9);
	$designMgr->setSB_IMAGES_TITLE_10($strSB_IMAGES_TITLE_10);
	$designMgr->setSB_IMAGES_TXT_1($strSB_IMAGES_TXT_1);
	$designMgr->setSB_IMAGES_TXT_2($strSB_IMAGES_TXT_2);
	$designMgr->setSB_IMAGES_TXT_3($strSB_IMAGES_TXT_3);
	$designMgr->setSB_IMAGES_TXT_4($strSB_IMAGES_TXT_4);
	$designMgr->setSB_IMAGES_TXT_5($strSB_IMAGES_TXT_5);
	$designMgr->setSB_IMAGES_TXT_6($strSB_IMAGES_TXT_6);
	$designMgr->setSB_IMAGES_TXT_7($strSB_IMAGES_TXT_7);
	$designMgr->setSB_IMAGES_TXT_8($strSB_IMAGES_TXT_8);
	$designMgr->setSB_IMAGES_TXT_9($strSB_IMAGES_TXT_9);
	$designMgr->setSB_IMAGES_TXT_10($strSB_IMAGES_TXT_10);
	$designMgr->setSB_LINK_TARGET($strSB_LINK_TARGET);
	$designMgr->setSB_REG_NO($a_admin_no);
	$designMgr->setSB_MOD_NO($a_admin_no);
	*/

	/* 추가 컨텐츠 */
//	$intCP_GROUP		= $_POST["cp_group"]		? $_POST["cp_group"]		: $_REQUEST["cp_group"]; /** 2013.04.24 index.php 으로 이동 **/
	$strCP_PAGE_NAME	= $_POST["cp_page_name"]	? $_POST["cp_page_name"]	: $_REQUEST["cp_page_name"];
	$strCP_PAGE_URL		= $_POST["cp_page_url"]		? $_POST["cp_page_url"]		: $_REQUEST["cp_page_url"];
	$strCP_PAGE_TEXT	= $_POST["cp_page_text"]	? $_POST["cp_page_text"]	: $_REQUEST["cp_page_text"];
	$strCP_PAGE_VIEW	= $_POST["cp_page_view"]	? $_POST["cp_page_view"]	: $_REQUEST["cp_page_view"];
	$intCP_REG_DT		= $_POST["cp_reg_dt"]		? $_POST["cp_reg_dt"]		: $_REQUEST["cp_reg_dt"];
	$intCP_REG_NO		= $_POST["cp_reg_no"]		? $_POST["cp_reg_no"]		: $_REQUEST["cp_reg_no"];
	$intCP_MOD_DT		= $_POST["cp_mod_dt"]		? $_POST["cp_mod_dt"]		: $_REQUEST["cp_mod_dt"];
	$intCP_MOD_NO		= $_POST["cp_mod_no"]		? $_POST["cp_mod_no"]		: $_REQUEST["cp_mod_no"];

	$strCP_PAGE_NAME = strTrim($strCP_PAGE_NAME,50);
	$strCP_PAGE_URL = strTrim($strCP_PAGE_URL,100);
	$strCP_PAGE_TEXT = strTrim($strCP_PAGE_TEXT,65535);
	$strCP_PAGE_VIEW = strTrim($strCP_PAGE_VIEW,1);

	$contentMgr->setCP_NO($intCP_NO);
	$contentMgr->setCP_GROUP($intCP_GROUP);
	$contentMgr->setCP_PAGE_NAME($strCP_PAGE_NAME);
	$contentMgr->setCP_PAGE_URL($strCP_PAGE_URL);
	$contentMgr->setCP_PAGE_TEXT($strCP_PAGE_TEXT);
	$contentMgr->setCP_PAGE_VIEW($strCP_PAGE_VIEW);
	$contentMgr->setCP_REG_NO($a_admin_no);
	$contentMgr->setCP_MOD_NO($a_admin_no);

	$intDS_REG_NO = $a_admin_no;
	$intDS_MOD_NO = $a_admin_no;

	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage = "";
	$strGroupImgPath = "upload/icon/memberGroup";

	switch ($strAct) {
		case "ftpFileDelete":
			// FTP 파일 삭제
			require_once MALL_HOME . "/classes/file/file.handler.class.php";
			$file				= new FileHandler();
			$uploadServerPath	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/images/";
			$deleteFile			= $_POST['deleteFile'];
			$fileName			= $uploadServerPath . $deleteFile;
			if(is_file($fileName)):
				unlink($fileName);
			endif;

			$result['mode'] = "1";
			$result['data']	= $deleteFile;
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "ftpFileUpload":
			// FTP 파일 업로드

			require_once MALL_HOME . "/classes/file/file.handler.class.php";
			$file				= new FileHandler();
			$uploadServerPath	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/images/";
			$uploadWebPath		= "/upload/images/";
			foreach($_FILES['file']['name'] as $key => $val):
				if(!$val) { continue; }
				$aryTemp				= array(		"F_NAME"		=> "file",
														"F_FILTER"		=> "gif;jpg;png;swf;flv",
														"F_SPATH"		=> $uploadServerPath,
														"F_WPATH"		=> $uploadWebPath,
														"F_SFNAME"		=> $val,
														"F_SECTION"		=> "",
														"F_NUM"			=> $key,
														"F_KEY"			=> "",			);
				$re						= $file->getFileUpload($aryTemp);
				$aryList[]				= $val;
			endforeach;

			$result['mode'] = "1";
			$result['data']	= $aryList;
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "categoryTopHtmlDelete":
			// 카테고리 HTML 삭제

			## STEP 1.
			## 파일 클래스 함수 호출
			$ds				= substr($strSubPageCode,0,2);
			$ds2			= strtolower($ds);
			$categoryCode	= $_POST['categoryCode'];
			$inputName		= "cateTag_{$categoryCode}";
			$lowerLng		= strtolower($strStLng);
			if(!$lowerLng) { $lowerLng = $S_SITE_LNG_PATH; }

			## STEP 2.
			## 파일 클래스 함수 호출
			$classFile = MALL_HOME . "/classes/file/file.handler.class.php";
			if(!is_file($classFile)) { echo "file class 파일이 없습니다."; exit; }
			require_once $classFile;
			$file = new FileHandler();			

			## STEP 3.
			## 파일 생성
			$categoryCode		= str_pad($categoryCode,12, "0", STR_PAD_RIGHT);
			$categoryHtmlFile	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/topHtml/{$lowerLng}/category_{$categoryCode}.html.php";
//			$file->fileDelete($categoryHtmlFile);
			unlink($categoryHtmlFile);

			## STEP 3.
			## 기준언어 파일을 삭제하면 다국어 모든 파일 삭제
			if($strStLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
				$aryLng = explode("/", $S_USE_LNG);
				foreach($aryLng as $lng):
					$lng			= strtolower($lng);
					if($lowerLng == $lng) { continue; }
					$categoryHtmlFile	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/topHtml/{$lng}/category_{$categoryCode}.html.php";
//					$file->fileDelete($categoryHtmlFile);
					unlink($categoryHtmlFile);
				endforeach;
			endif;

			## STEP 4.
			## 데이터 저장
			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
				$fileName			= "";
				$aryParam			= array( "{$ds2}_top_use_cate_{$categoryCode}_HTML"		=> $fileName );
				$designSetMgr->setDS_TYPE("SKIN_{$ds}");
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			endif;

			## STEP 5.
			## 카테고리 정보 파일 설정
//			$strStLng = $_POST['policyLng'];
			include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";

			## STEP 6.
			## 이동
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTop&lang={$strStLng}&subPageCode=$strSubPageCode";
		break;
		case "categoryTopHtmlModify":
			// 카테고리 HTML 수정
			## 2013.04.26 다국어 버전으로 변경, 

			## STEP 1.
			## 파일 클래스 함수 호출
			$ds				= substr($strSubPageCode,0,2);
			$ds2			= strtolower($ds);
			$categoryCode	= $_POST['categoryCode'];
			$inputName		= "cateTag_{$categoryCode}";
				$lowerLng	= strtolower($strStLng);
			if(!$lowerLng) { $lowerLng = $S_SITE_LNG_PATH; }

			## STEP 2.
			## 파일 클래스 함수 호출
			$classFile = MALL_HOME . "/classes/file/file.handler.class.php";
			if(!is_file($classFile)) { echo $LNG_TRANS_CHAR["CS00023"]; exit; } //"file class 파일이 없습니다."
			require_once $classFile;
			$file = new FileHandler();		
			
			## 파일 필터링
			include_once MALL_HOME . "/web/shopAdmin/layout/_function.lib.inc.php";
			$strHtml = $_POST[$inputName];
			$strHtmlTag = $_POST[$inputName];
			changeLayoutDataEx6($strHtml);
			changeLayoutData($strHtml, $strHtml);
			changeLayoutDataEx($strHtml);
			changeLayoutDataEx2($strHtml);
			changeLayoutDataEx3($strHtml);
			changeLayoutDataEx4($strHtml);
//			changeLayoutDataEx5($strHtml);

			## STEP 3.
			## 파일 생성
			$categoryCode			= str_pad($categoryCode,12, "0", STR_PAD_RIGHT);
			$categoryHtmlFile		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/topHtml/{$lowerLng}/category_{$categoryCode}.html.php";
			$categoryHtmlFileTag	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/topHtml/{$lowerLng}/tag_category_{$categoryCode}.html.php";
			$file->fileWrite($categoryHtmlFile, $strHtml);
			$file->fileWrite($categoryHtmlFileTag, $strHtmlTag);

			## STEP 4.
			## 데이터 저장
			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
//				$fileName			= "/layout/topHtml/category_{$categoryCode}.html.php";
				$fileName			= "category_{$categoryCode}.html.php";
				$aryParam			= array( "{$ds2}_top_use_cate_{$categoryCode}_HTML"		=> $fileName );
				$designSetMgr->setDS_TYPE("SKIN_{$ds}");
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			endif;

			## STEP 5.
			## 카테고리 정보 파일 설정
//			$strStLng = $_POST['policyLng'];
			include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";

			## STEP 6.
			## 이동
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTop&lang={$strStLng}&subPageCode=$strSubPageCode";
		break;
		case "categoryTopImageDelete":
			// 카테고리 이미지 삭제
			## 2013.04.26 다국어 버전으로 변경, 
			## 조건1. 기준언어 파일을 삭제할때는 모든 언어의 파일이 삭제됩니다.

			## STEP 1.
			## 설정
			$ds				= substr($strSubPageCode,0,2);
			$ds2			= strtolower($ds);
			$categoryCode	= $_POST['categoryCode'];
			$categoryCode	= str_pad($categoryCode,12, "0", STR_PAD_RIGHT);
				$lowerLng	= strtolower($strStLng);
			if(!$lowerLng) { $lowerLng = $S_SITE_LNG_PATH; }
			
			## STEP 2.
			## 삭제
			$designSetMgr->setDS_TYPE("SKIN_{$ds}");
			$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_{$categoryCode}_IMG");
			$fileName		= $designSetMgr->getCodeVal($db);

			/** 2013.04.26 다국어 파일 삭제 추가 **/
			$saveDir		= "/layout/product/top/{$lowerLng}";
			unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$_POST['categoryCode']}.jpg");
			unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$_POST['categoryCode']}.gif");
			unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$_POST['categoryCode']}.png");
//			require_once "{$S_DOCUMENT_ROOT}www/classes/image/image.func.class.php";
//			$imageFunc		= new ImageFunc();
//			$saveDir		= "/upload/layout/product/top/{$policyLng}";
//			$imgPath		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$saveDir}/{$fileName}";
//			$ext			= $imageFunc->getFindImage($imgPath);
//			if($ext):
//				$fileInfo	= $imageFunc->getPathInfo($imgPath);
//				$imgPath	= "{$fileInfo['dirname']}/{$fileInfo['name']}.$ext";
//				$fh->fileDelete($imgPath);
//			endif;

			## STEP 3.
			## 기준언어 파일을 삭제하면 다국어 모든 파일 삭제
			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
				$aryLng = explode("/", $S_USE_LNG);
				foreach($aryLng as $lng):
					$lng			= strtolower($lng);
					if($lowerLng == $lng) { continue; }
					$saveDir		= "/layout/product/top/{$lng}";
					unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$_POST['categoryCode']}.jpg");
					unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$_POST['categoryCode']}.gif");
					unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$_POST['categoryCode']}.png");
//					$saveDir		= "/upload/layout/product/top/{$lng}";
//					$imgPath		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$saveDir}/{$fileName}";
//					$ext			= $imageFunc->getFindImage($imgPath);
//					if($ext):
//						$fileInfo	= $imageFunc->getPathInfo($imgPath);
//						$imgPath	= "{$fileInfo['dirname']}/{$fileInfo['name']}.$ext";
//						$fh->fileDelete($imgPath);
//					endif;
				endforeach;
			endif;

			## STEP 4.
			## 데이터 업데이트
			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
				$aryParam		= array( "{$ds2}_top_use_cate_{$categoryCode}_IMG"		=> "" );
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			endif;

			## STEP 5.
			## 파일 업데이트
//			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
//				$strStLng = $lowerLng;
				include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";
//			endif;

			## STEP 5.
			## 이동
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTop&lang={$strStLng}&subPageCode=$strSubPageCode";
			break;
		case "categoryTopImageModify":
			// 카테고리 이미지 업로드
			## 2013.04.26 다국어 버전으로 변경, 

			## STEP 1.
			## 설정
			$ds				= substr($strSubPageCode, 0, 2);	// 대문자
			$ds2			= strtolower($ds);					// 소문자
			$categoryCode	= $_POST['categoryCode'];
			$inputName		= "cateFile_{$categoryCode}";
			$lowerLng		= strtolower($strStLng);
			if(!$lowerLng) { $lowerLng = $S_SITE_LNG_PATH; }

			## STEP 2.
			## 기존에 등록된 파일 삭제
			$saveDir		= "/layout/product/top/{$lowerLng}";
			unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$categoryCode}.jpg");
			unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$categoryCode}.gif");
			unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload$saveDir/{$categoryCode}.png");

			## STEP 2.
			## 파일 업로드
			if(!HS_makeDir($saveDir)):
				echo $LNG_TRANS_CHAR["CS00012"]; //"파일 업로드 할 수 없습니다. 폴더 생성 하세요.";
				exit;
			endif;
			$re				= imageFileUpLoad($inputName, $saveDir, $fileName, $categoryCode);
			if($re != 1 && !$fileName) :
				// 업로드 실패
				echo $LNG_TRANS_CHAR["CS00025"]; //"파일 업로드 실패했습니다.";
				exit;
			endif;

			## STEP 3.
			## 데이터 업데이트
			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 DB 업데이트
				$categoryCode	= str_pad($categoryCode,12, "0", STR_PAD_RIGHT);	
//				$fileName		= "/upload{$saveDir}/$fileName"; /* 2013.04.26 다국어 버전으로 변경하면서, 언어별 폴더 설정으로 폴더 저장 안함.(파일명만 저장)
				$aryParam		= array( "{$ds2}_top_use_cate_{$categoryCode}_IMG"		=> $fileName );
				$designSetMgr->setDS_TYPE("SKIN_{$ds}");
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			endif;

			## STEP 4.
			## 상품 카테고리 파일 생성
//			if($lowerLng == $S_SITE_LNG_PATH): // 기준언어만 파일 업데이트
//				$strStLng = $_POST['policyLng'];
				include MALL_HOME."/web/shopAdmin/layout/categoryMakeFile.php";
//			endif;

			## STEP 5.
			## 이동
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTop&lang={$strStLng}&subPageCode=$strSubPageCode";
		break;
		case "categoryTopImageUse":
			// 세부페이지 설정 - 상품리스트 - 카테고리 사용 범위 설정
			$ds				= substr($strSubPageCode,0,2);
			$ds2			= strtolower($ds);

			$aryParam = array(
				"{$ds2}_top_cat_op"		=>$strPL_TOP_CAT_OP
			);
			
			$designSetMgr->setDS_TYPE("SKIN_{$ds}");
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			/*---------------------------*/

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTop&subPageCode=$strSubPageCode";
			
//			$result[0]['MSG'] = $strMsg;
//			$result[0]['RET'] = "Y";
//			$db->disConnect();
//			echo json_encode($result);	
//			exit;
		break;
		case "cssFileEdit":
			// CSS 파일 설정

			## STEP 1.
			## 파일 클래스 함수 호출
			$classFile = MALL_HOME . "/classes/file/file.handler.class.php";
			if(!is_file($classFile)) { echo $LNG_TRANS_CHAR["CS00023"]; exit; } //"file class 파일이 없습니다."
			require_once $classFile;
			$file = new FileHandler();

			## STEP 2.
			## 파일 생성
			$cssFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/css/{$S_SHOP_HOME}_style.css";
			$file->fileWrite($cssFile, $_POST['css_edit']);

			## STEP 3.
			## 이동
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=layout&mode=cssFileEdit";
		break;
		case "jsFileEdit":
			// JS 파일 설정
			## STEP 1.
			## 파일 클래스 함수 호출
			$classFile = MALL_HOME . "/classes/file/file.handler.class.php";
			if(!is_file($classFile)) { echo $LNG_TRANS_CHAR["CS00023"]; exit; } //"file class 파일이 없습니다."
			require_once $classFile;
			$file = new FileHandler();

			## STEP 2.
			## 파일 생성
			$cssFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/js/{$S_SHOP_HOME}_script.js";
			$file->fileWrite($cssFile, $_POST['js_edit']);

			## STEP 3.
			## 이동
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=layout&mode=jsFileEdit";
		break;
		case "skinMemberLoginModify":
			// 회원로그인
			$designSetMgr->setDS_TYPE("SKIN");
			$aryParam = array(
				 "MF"					=>$strDS_CODE
				,"MI"					=>$strDS_CODE
				,"MT"					=>$strDS_CODE
				,"ME"					=>$strDS_CODE
				,"ML"					=>$strDS_CODE
				,"OB"					=>$strDS_CODE
				,"OC"					=>$strDS_CODE
				,"ON"					=>$strDS_CODE
				,"OW"					=>$strDS_CODE
				,"OP"					=>$strDS_CODE
				,"OO"					=>$strDS_CODE
				,"OM"					=>$strDS_CODE
				,"OR"					=>$strDS_CODE
			);	
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

		case "skinPordViewDesign":
			// 상품정보 디자인 변경
			$ds					= substr($strSubPageCode,0,2);
			$designSetMgr->setDS_TYPE("SKIN_".$ds);
			$aryParam = array(
				$ds."_IMAGE_DESIGN"	=>	$strDS_CODE
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
//			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode=$strSubPageCode";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinBestCodeModify":
//			echo $strIM_CODE . "<br>";
//			echo $strSubPageCode . "<br>";
//			echo $intBE_NO . "<br>";

// 2014.08.29 kim hee sung 변경할 필요 없는 코드임.
//			$designSetMgr->setDS_TYPE("SKIN");
//			$aryParam = array(
//				 "PH"	=>	$strDS_CODE
//			);
//			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			$ds					= substr($strSubPageCode,0,2);
			$designSetMgr->setDS_TYPE("SKIN_".$ds);
			$aryParam = array(
				$ds."_BEST_LIST".$intBE_NO."_DESIGN"	=>	$strDS_CODE
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
//			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode=$strSubPageCode";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "designSkinModify":
			/* 상품리스트 이미지 관련 관리 */
			$designSetMgr->setDS_TYPE("SKIN");
			$aryParam = array(
				 substr($strDS_CODE,0,2)	=>	$strDS_CODE
			);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

//			$strScript		= sprintf("parent.goSkinSampleHtmlReturn('%s','%s');", $strDS_CODE, $strDS_IMG2);
//			$strScript		= $strScript . "parent.goClose();";
//			$strScript		= sprintf("<script language='javascript'>%s</script>", $strScript);
//			echo	$strScript;
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode=$strSubPageCode";

			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinBestName":
			// 진열장 이름 정의(메인, 상품)
			// SELECT * FROM DESIGN_SET WHERE DS_TYPE = 'SKIN_ZL'
			//	ZL_BEST_LIST1_NAME
			//	ZL_BEST_LIST2_NAME
			//	ZL_BEST_LIST3_NAME
			//	ZL_BEST_LIST4_NAME
			//	ZL_BEST_LIST5_NAME
	
			$ds					= substr($strSubPageCode,0,2);
			
			if($ds == "ZL") :
				$aryParam = array(
					 $ds."_best_list1_name"	=>$strZL_BEST_LIST1_NAME
					,$ds."_best_list2_name"	=>$strZL_BEST_LIST2_NAME
					,$ds."_best_list3_name"	=>$strZL_BEST_LIST3_NAME
					,$ds."_best_list4_name"	=>$strZL_BEST_LIST4_NAME
					,$ds."_best_list5_name"	=>$strZL_BEST_LIST5_NAME
				);
			elseif($ds=="PL") :
				$aryParam = array(
					 $ds."_best_list1_name"	=>$strPL_BEST_LIST1_NAME
					,$ds."_best_list2_name"	=>$strPL_BEST_LIST2_NAME
					,$ds."_best_list3_name"	=>$strPL_BEST_LIST3_NAME
					,$ds."_best_list4_name"	=>$strPL_BEST_LIST4_NAME
					,$ds."_best_list5_name"	=>$strPL_BEST_LIST5_NAME
				);
			elseif($ds=="PH") :
				$aryParam = array(
					 $ds."_best_list1_name"	=>$strPH_BEST_LIST1_NAME
					,$ds."_best_list2_name"	=>$strPH_BEST_LIST2_NAME
					,$ds."_best_list3_name"	=>$strPH_BEST_LIST3_NAME
					,$ds."_best_list4_name"	=>$strPH_BEST_LIST4_NAME
					,$ds."_best_list5_name"	=>$strPH_BEST_LIST5_NAME
				);
			endif;

			$designSetMgr->setDS_TYPE("SKIN_".$ds);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode$strSubPageCode";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinMainInfoSave":
			// 샵메인
			
			$strZL_LAYERPOP_LOGIN_USE	= ($strZL_LAYERPOP_LOGIN_USE) ? $strZL_LAYERPOP_LOGIN_USE : "N";
			$strZL_LAYERPOP_JOIN_USE	= ($strZL_LAYERPOP_JOIN_USE)  ? $strZL_LAYERPOP_JOIN_USE  : "N";
			$strZL_SLIDER_USE			= ($strZL_SLIDER_USE)	  ? $strZL_SLIDER_USE	  : "N";
			$strZL_BEST_LIST1_USE		= ($strZL_BEST_LIST1_USE) ? $strZL_BEST_LIST1_USE : "N";
			$strZL_BEST_LIST2_USE		= ($strZL_BEST_LIST2_USE) ? $strZL_BEST_LIST2_USE : "N";
			$strZL_BEST_LIST3_USE		= ($strZL_BEST_LIST3_USE) ? $strZL_BEST_LIST3_USE : "N";
			$strZL_BEST_LIST4_USE		= ($strZL_BEST_LIST4_USE) ? $strZL_BEST_LIST4_USE : "N";
			$strZL_BEST_LIST5_USE		= ($strZL_BEST_LIST5_USE) ? $strZL_BEST_LIST5_USE : "N";
			
			$ds							= substr($strSubPageCode,0,2);

			if($ds == "ZL") :
				$aryParam = array(
					 $ds."_layerpop_login_use"  =>$strZL_LAYERPOP_LOGIN_USE
					,$ds."_layerpop_join_use"   =>$strZL_LAYERPOP_JOIN_USE
					,$ds."_slider_use"			=>$strZL_SLIDER_USE
					,$ds."_best_list1_use"		=>$strZL_BEST_LIST1_USE
					,$ds."_best_list2_use"		=>$strZL_BEST_LIST2_USE
					,$ds."_best_list3_use"		=>$strZL_BEST_LIST3_USE
					,$ds."_best_list4_use"		=>$strZL_BEST_LIST4_USE
					,$ds."_best_list5_use"		=>$strZL_BEST_LIST5_USE
				);
			elseif($ds="PL") :
				$aryParam = array(
					 $ds."_slider_use"		=>$strPL_SLIDER_USE
					,$ds."_best_list1_use"	=>$strPL_BEST_LIST1_USE
					,$ds."_best_list2_use"	=>$strPL_BEST_LIST2_USE
					,$ds."_best_list3_use"	=>$strPL_BEST_LIST3_USE
					,$ds."_best_list4_use"	=>$strPL_BEST_LIST4_USE
					,$ds."_best_list5_use"	=>$strPL_BEST_LIST5_USE
				);	
			endif;

			
			$designSetMgr->setDS_TYPE("SKIN_".$ds);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			/*---------------------------*/

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode$strSubPageCode";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skin_pj_InfoSave":
			// 상품 - 브랜드 메인화면
		case "skin_ph_InfoSave":
			// 상품 - 브랜드 세부화면
		case "skin_ps_InfoSave":
			// 상품검색결과
		case "skin_pl_InfoSave":
			// 상품리스트 저장 및 파일 생성

			$ds							= substr($strSubPageCode,0,2);
			$ds2						= strtolower($ds);

			$aryParam = array(
				 $ds2."_navi_use_op"		=>$strPL_NAVI_USE_OP
				,$ds2."_top_use_op"			=>$strPL_TOP_USE_OP
//				,$ds2."_top_cat_op"			=>$strPL_TOP_CAT_OP
				,$ds2."_sub_cate_use"		=>$strPL_SUB_CATE_USE
				,$ds2."_best_list1_use"		=>$strPL_BEST_LIST1_USE
				,$ds2."_best_list2_use"		=>$strPL_BEST_LIST2_USE
				,$ds2."_best_list3_use"		=>$strPL_BEST_LIST3_USE
				,$ds2."_best_list4_use"		=>$strPL_BEST_LIST4_USE
				,$ds2."_best_list5_use"		=>$strPL_BEST_LIST5_USE
			);
			


			$designSetMgr->setDS_TYPE("SKIN_".$ds);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			/*---------------------------*/


			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode=$strSubPageCode";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;

		break;

		case "skin_pv_InfoSave":

			$ds							= substr($strSubPageCode,0,2);
			$ds2						= strtolower($ds);

			$aryParam = array(
				 $ds2."_image_show_type"	=>$strPV_IMAGE_SHOW_TYPE
				,$ds2."_image_zoom_use"		=>$strPV_IMAGE_ZOOM_USE
				,$ds2."_bbs_review_use"		=>$strPV_BBS_REVIEW_USE
				,$ds2."_bbs_qna_use"		=>$strPV_BBS_QNA_USE
				,$ds2."_best_list1_use"		=>$strPV_BEST_LIST1_USE
				,$ds2."_sns_use"			=>$strPV_SNS_USE
				,$ds2."_sns_facebook"		=>$strPV_SNS_FACEBOOK
				,$ds2."_sns_twitter"		=>$strPV_SNS_TWITTER
				,$ds2."_sns_m2day"			=>$strPV_SNS_M2DAY
			);

			$designSetMgr->setDS_TYPE("SKIN_".$ds);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			/*---------------------------*/

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode$strSubPageCode";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
//		case "skin_pj_InfoSave":
//			// 상품리스트 저장 및 파일 생성
//	
//
//			$strMsg	= "설정이 변경되었습니다.";
//			$strUrl	= "./?menuType=popup&mode=skinProdDisplay&subPageCode$strSubPageCode";
//			
//			$result[0]['MSG'] = $strMsg;
//			$result[0]['RET'] = "Y";
//			$db->disConnect();
//			echo json_encode($result);	
//			exit;
//
//		break;
		case "introSave":
			$designSetMgr->setDS_TYPE("INTRO");
			$designSetMgr->setDS_CODE("DL_BG_IMAGE");
			$strPrevBgImg = $designSetMgr->getCodeVal($db);
			$strDL_BG_IMAGE = $strPrevBgImg;

			$designSetMgr->setDS_CODE("WEB_LOGO_IMG");
			$strPrevWebLogImg = $designSetMgr->getCodeVal($db);
			$strWebLogoImg = $strPrevWebLogImg;

			$designSetMgr->setDS_CODE("MOB_LOGO_IMG");
			$strPrevMobLogImg = $designSetMgr->getCodeVal($db);
			$strMobLogoImg = $strPrevMobLogImg;
			
			if ($_FILES["dl_bg_image"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["dl_bg_image"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename		= $_FILES["dl_bg_image"][name];
				$tmpname		= $_FILES["dl_bg_image"][tmp_name];
				$filesize		= $_FILES["dl_bg_image"][size];
				$filetype		= $_FILES["dl_bg_image"][type];

				$number			= date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strDL_BG_IMAGE = "/upload/layout/".$fres[file_real_name];
					if ($strPrevBgImg){
						$fh->fileDelete("..".$strPrevBgImg);
					}
				}
			}else {
				if($strDL_GB_IMAGE_DEL) :
					// 배경 이미지 삭제
					$fh->fileDelete(".." . $strDL_GB_IMAGE_DEL);
					$strDL_BG_IMAGE = "";
				endif;
			}
						

			if ($_FILES["web_log_img"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["web_log_img"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename		= $_FILES["web_log_img"][name];
				$tmpname		= $_FILES["web_log_img"][tmp_name];
				$filesize		= $_FILES["web_log_img"][size];
				$filetype		= $_FILES["web_log_img"][type];

				$number			= date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strWebLogoImg = "/upload/layout/".$fres[file_real_name];
					if ($strPrevWebLogImg){
						$fh->fileDelete("..".$strPrevWebLogImg);
					}
				}
			} 

			if ($_FILES["mob_log_img"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["mob_log_img"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
					exit;
				}

				$filename		= $_FILES["mob_log_img"][name];
				$tmpname		= $_FILES["mob_log_img"][tmp_name];
				$filesize		= $_FILES["mob_log_img"][size];
				$filetype		= $_FILES["mob_log_img"][type];

				$number			= date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strMobLogoImg = "/upload/layout/".$fres[file_real_name];
					if ($strPrevMobLogoImg){
						$fh->fileDelete("..".$strPrevMobLogoImg);
					}
				}
			} 

			if ( $strDL_BG_COLOR ) :
				$strBackground = sprintf ( "%s#%s" ,$strBackground ,$strDL_BG_COLOR );
			endif;

			if ( $strDL_BG_IMAGE ) :
				$strBackground = sprintf ( "%s url(%s)" , $strBackground, $strDL_BG_IMAGE );
				
				if ( $strDL_BG_IMG_DIR_H ) :
					$strBackground = sprintf ( "%s %s" , $strBackground, $strDL_BG_IMG_DIR_H );
				endif;
				
				if ( $strDL_BG_IMG_DIR_V ) :
					$strBackground = sprintf ( "%s %s" , $strBackground, $strDL_BG_IMG_DIR_V );
				endif;
				
				if ( $strDL_BG_REPEAT == "" ) :
					$strBackground = sprintf ( "%s %s" , $strBackground, "repeat" );
				elseif ( $strDL_BG_REPEAT == "x" ) :
					$strBackground = sprintf ( "%s %s" , $strBackground, "repeat-x" );
				elseif ( $strDL_BG_REPEAT == "y" ) :
					$strBackground = sprintf ( "%s %s" , $strBackground, "repeat-y" );
				elseif ( $strDL_BG_REPEAT == "no" ) :
					$strBackground = sprintf ( "%s %s" , $strBackground, "no-repeat" );
				endif;
			endif;

			if ( $strBackground ) :
				$strBackground = sprintf("body {background:%s}", $strBackground);
			else :
				$strBackground = "";
			endif;

			/* 파일 생성 */
			$intAryCnt = 0;

			// body {background:#f2f2f2 url(/upload/layout/20121217184651.gif) left top repeat-x}
//			$aryData[$intAryCnt]['key']		= "\$D_LAYOUT_BG_CSS";
//			$aryData[$intAryCnt]['data'] 	= sprintf("\"%s\"", $strBackground);
//			$intAryCnt++;

//			$fileName				= "layout.inc.php";
//			shopConfigFileUpdate ( $aryData, $fileName );
			/* 파일 생성 */
			
			$aryParam = array(
				 "dl_bg_type"		=>$strDL_BG_TYPE
				,"dl_bg_color"		=>$strDL_BG_COLOR
				,"dl_bg_image"		=>$strDL_BG_IMAGE
				,"dl_bg_img_dir_h"	=>$strDL_BG_IMG_DIR_H
				,"dl_bg_img_dir_v"	=>$strDL_BG_IMG_DIR_V
				,"dl_bg_repeat"		=>$strDL_BG_REPEAT
				,"dl_bg_align"		=>$strDL_BG_ALIGN
				,"dl_first_page"	=>$strDL_FIRST_PAGE
				,"dl_first_use"		=>$strDL_FIRST_USE
				,"web_logo_type"	=>$strWebLogoType
				,"web_logo_img"		=>$strWebLogoImg
				,"mob_logo_img"		=>$strMobLogoImg
				,"dl_background"	=>$strBackground
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			include MALL_HOME."/web/shopAdmin/layout/shopSkinMakeFile.php";
		
			$strUrl = "./?menuType=$strMenuType&mode=introSave";
		break;

		case "layoutSaveModify":
			$designSetMgr->setDS_TYPE("LAYOUT");

			$aryParam = array(
				 "dm_code"			=>$strDM_CODE
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			include MALL_HOME."/web/shopAdmin/layout/shopSkinMakeFile.php";

			/* layout/html/ 파일 모두 변경 */		
			$strDir			= sprintf("%s%s/layout/html", $S_DOCUMENT_ROOT, $S_SHOP_HOME);
			$strBackupDir	= sprintf("%s/%s", $strDir, date("YmdHis"));
			$strOrgDir		= sprintf("%swww/web/shopAdmin/layout/pageDesignCode/%s", $S_DOCUMENT_ROOT, $strDM_CODE);
			if(mkdir($strBackupDir, 0707) == 1) :
				/* 원본 파일 백업 */
				@chmod( $strBackupDir , 0707 );
				if(is_dir($strDir)) :
					$dir			= dir( $strDir );
					while( $file = $dir->read() ) :
						if ( $file == "." || $file == ".." ) {		continue;		}
						if ( is_file($strDir . "/" . $file) ) :
							rename( $strDir . "/" . $file, $strBackupDir . "/" . $file);
							@chmod( $strBackupDir . "/" . $file , 0707 );
//							echo $file . "<br>";
						endif;
					endwhile;
				endif;
				/* 원본 파일 백업 */
				
				/* 신규 파일 생성 */
				if(is_dir($strOrgDir)) :
					$dir			= dir( $strOrgDir );
					while( $file = $dir->read() ) :
						if ( $file == "." || $file == ".." ) {		continue;		}
						if ( is_file($strOrgDir . "/" . $file) ) :
							$strDE_EDIT_TEXT	= file_get_contents($strOrgDir . "/" . $file);
							$htmlFileTag		= sprintf("%s/tag_%s", $strDir, $file );
							$htmlFile			= sprintf("%s/%s", $strDir, $file );
							updateHtmlFile($htmlFileTag, $strDE_EDIT_TEXT);
							changeLayoutDataEx6( $strDE_EDIT_TEXT );			
							changeLayoutData( $strDE_EDIT_TEXT, $strLayoutData);
							changeLayoutDataEx( $strLayoutData );
							changeLayoutDataEx2( $strLayoutData );
							changeLayoutDataEx3( $strLayoutData );
							changeLayoutDataEx4( $strLayoutData );
							updateHtmlFile($htmlFile, $strLayoutData);
						endif;
					endwhile;
				endif;
				/* 신규 파일 생성 */
			endif;
			/* layout/html/ 파일 모두 변경 */

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"레이아웃 설정이 변경되었습니다.";
			$strUrl		= "./?menuType=$strMenuType&mode=layoutSave";
		break;
		case "skinMainListTopImg":
			/* 메인 타이틀 베너 */

			$designSetMgr->setDS_TYPE("SKIN_".substr($strSubPageCode,0,2));
			
			$strZL_SLIDER_MOTION_USE	= ($strZL_SLIDER_MOTION_USE)	? $strZL_SLIDER_MOTION_USE		: "N";
			$strZL_SLIDER_USE			= ($strZL_SLIDER_USE)			? $strZL_SLIDER_USE				: "N";
			$aryParam = array(
				 "zl_main_title_banner_use"			=>$strZL_MAIN_TITLE_BANNER_USE
				,"zl_main_title_banner_kind"		=>$strZL_MAIN_TITLE_BANNER_KIND
				,"zl_main_title_banner_size_w"		=>$strZL_MAIN_TITLE_BANNER_SIZE_W
				,"zl_main_title_banner_size_h"		=>$strZL_MAIN_TITLE_BANNER_SIZE_H

//				,"zl_slider_use"				=>$strZL_SLIDER_USE
				,"zl_slider_motion_effect"		=>$strZL_SLIDER_MOTION_EFFECT
				,"zl_slider_motion_use"			=>$strZL_SLIDER_MOTION_USE
				,"zl_slider_motion_type"		=>$strZL_SLIDER_MOTION_TYPE
				,"zl_slider_image_size_w"		=>$strZL_SLIDER_IMAGE_SIZE_W
				,"zl_slider_image_size_h"		=>$strZL_SLIDER_IMAGE_SIZE_H
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinMainListTopImg";
			
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinProdListTitleImageDelete":
			/* 타이틀 이미지 삭제 */

			$designSetMgr->setDS_TYPE("SKIN_".substr($strSubPageCode,0,2));
			$designSetMgr->setDS_CODE($ds1."_TITLE_FILE_NAME");
			$fileName		= $designSetMgr->getCodeVal($db);
			if($fileName) :
				$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $fileName); 	
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);

				$aryParam = array( $ds1."_TITLE_FILE_NAME"	=>  "" );
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);

				$strMsg	= "타이틀 이미지가 삭제되었습니다.";
				$strRet	= "Y";
			else :
				$strMsg	= "등록된 파일이 없습니다.";
				$strRet	= "N";
			endif;

			$strUrl	= "./?menuType=popup&mode=skinProdListDesignSet&ds_code=$strDS_CODE&be_no=$intBE_NO&ic_code=$intIC_CODE&ic_type=$strIC_TYPE&subPageCode=$strSubPageCode";
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = $strRet;
			$db->disConnect();
			echo json_encode($result);	
			exit;		
		break;
		case "skinProdBrandMainDesignSet":
			/* 브랜드 메인화면 설정 */

			$designSetMgr->setDS_TYPE("SKIN_".substr($strSubPageCode,0,2));

			$ds			= substr($strSubPageCode,0,2);
			if($intIC_CODE && $strIC_TYPE) :
				$ds		= sprintf("%s_%s%d", $ds, $strIC_TYPE, $intIC_CODE);
			endif;


			$aryParam = array(
				"{$ds1}_BEST_LIST1_DESIGN"	=> "{$ds1}0001"
				,$ds1."_SIZE_W"				=> $strBEST_LIST_SIZE_W
				,$ds1."_SIZE_H"				=> $strBEST_LIST_SIZE_H
				,$ds1."_VIEW_W"				=> $strBEST_LIST_VIEW_W
				,$ds1."_VIEW_H"				=> $strBEST_LIST_VIEW_H
				,$ds1."_SHOW_1"				=> $strBEST_LIST_SHOW_1
				,$ds1."_SHOW_2"				=> $strBEST_LIST_SHOW_2
				,$ds1."_SHOW_3"				=> $strBEST_LIST_SHOW_3
				,$ds1."_SHOW_4"				=> $strBEST_LIST_SHOW_4
				,$ds1."_SHOW_5"				=> $strBEST_LIST_SHOW_5
				,$ds1."_SHOW_6"				=> $strBEST_LIST_SHOW_6
				,$ds1."_SHOW_7"				=> $strBEST_LIST_SHOW_7
				,$ds1."_SHOW_8"				=> $strBEST_LIST_SHOW_8
				,$ds1."_COLOR_1"			=> $strBEST_LIST_COLOR_1
				,$ds1."_COLOR_2"			=> $strBEST_LIST_COLOR_2
				,$ds1."_COLOR_3"			=> $strBEST_LIST_COLOR_3
				,$ds1."_COLOR_4"			=> $strBEST_LIST_COLOR_4
				,$ds1."_COLOR_5"			=> $strBEST_LIST_COLOR_5
				,$ds1."_COLOR_6"			=> $strBEST_LIST_COLOR_6
				,$ds1."_COLOR_7"			=> $strBEST_LIST_COLOR_7
				,$ds1."_COLOR_8"			=> $strBEST_LIST_COLOR_8
				,$ds1."_WORD_ALIGN"			=> $strBEST_LIST_WORD_ALIGN
				,$ds1."_MONEY_TYPE"			=> $strBEST_LIST_MONEY_TYPE
				,$ds1."_MONEY_ICON"			=> $strBEST_LIST_MONEY_ICON
				,$ds1."_TURN_USE"			=> $strBEST_LIST_TURN_USE
				,$ds1."_TITLE_SHOW_USE"		=> $strBEST_LIST_TITLE_SHOW_USE
				,$ds1."_TITLE_MAXSIZE"		=> $strBEST_LIST_TITLE_MAXSIZE
			);


			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdBrandMainDesignSet&ds_code=$strDS_CODE&be_no=$intBE_NO&ic_code=$intIC_CODE&ic_type=$strIC_TYPE&subPageCode=$strSubPageCode";
//			$result[0]['MSG'] = $strMsg;
//			$result[0]['RET'] = "Y";
//			$db->disConnect();
//			echo json_encode($result);	
//			exit;
		break;
		case "skinProdListImg":
			/* 상품리스트 이미지 관련 관리 */

			/* 파일 업로드 */
			$saveDir		= "/layout/product/bestTitle";
			$strFileName	= $ds2;
			if(HS_makeDir($saveDir)):
				$re = imageFileUpLoad("{$ds2}_title_file_name", $saveDir, $strBEST_LIST_TITLE_FILE_NAME, $strFileName);
			endif;
			/* 파일 업로드 */

			/* 업로드 파일 DB 업데이트 */
			if($re == 1 && $strBEST_LIST_TITLE_FILE_NAME) :
				
				// 기존 파일 삭제
				$designSetMgr->setDS_TYPE("SKIN_".substr($strSubPageCode,0,2));
				$designSetMgr->setDS_CODE($ds1."_TITLE_FILE_NAME");
				$fileName		= $designSetMgr->getCodeVal($db);
				$fh->fileDelete($S_DOCUMENT_ROOT . $S_SHOP_HOME . $fileName); 

				$strBEST_LIST_TITLE_FILE_NAME = "/upload" . $saveDir. "/" . $strBEST_LIST_TITLE_FILE_NAME;
				$aryParam = array( $ds1."_TITLE_FILE_NAME"	=>  $strBEST_LIST_TITLE_FILE_NAME );
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			endif;
			/* 업로드 파일 DB 업데이트 */

			/*-----------------------------*/

			$designSetMgr->setDS_TYPE("SKIN_".substr($strSubPageCode,0,2));

			$ds			= substr($strSubPageCode,0,2);
			if($intIC_CODE && $strIC_TYPE) :
				$ds		= sprintf("%s_%s%d", $ds, $strIC_TYPE, $intIC_CODE);
			endif;
			
			$aryParam = array(
				 $ds1."_SIZE_W"				=> $strBEST_LIST_SIZE_W
				,$ds1."_SIZE_H"				=> $strBEST_LIST_SIZE_H
				,$ds1."_VIEW_W"				=> $strBEST_LIST_VIEW_W
				,$ds1."_VIEW_H"				=> $strBEST_LIST_VIEW_H
				,$ds1."_SHOW_1"				=> $strBEST_LIST_SHOW_1
				,$ds1."_SHOW_2"				=> $strBEST_LIST_SHOW_2
				,$ds1."_SHOW_3"				=> $strBEST_LIST_SHOW_3
				,$ds1."_SHOW_4"				=> $strBEST_LIST_SHOW_4
				,$ds1."_SHOW_5"				=> $strBEST_LIST_SHOW_5
				,$ds1."_SHOW_6"				=> $strBEST_LIST_SHOW_6
				,$ds1."_SHOW_7"				=> $strBEST_LIST_SHOW_7
				,$ds1."_SHOW_8"				=> $strBEST_LIST_SHOW_8
				,$ds1."_COLOR_1"			=> $strBEST_LIST_COLOR_1
				,$ds1."_COLOR_2"			=> $strBEST_LIST_COLOR_2
				,$ds1."_COLOR_3"			=> $strBEST_LIST_COLOR_3
				,$ds1."_COLOR_4"			=> $strBEST_LIST_COLOR_4
				,$ds1."_COLOR_5"			=> $strBEST_LIST_COLOR_5
				,$ds1."_COLOR_6"			=> $strBEST_LIST_COLOR_6
				,$ds1."_COLOR_7"			=> $strBEST_LIST_COLOR_7
				,$ds1."_COLOR_8"			=> $strBEST_LIST_COLOR_8
				,$ds1."_WORD_ALIGN"			=> $strBEST_LIST_WORD_ALIGN
				,$ds1."_MONEY_TYPE"			=> $strBEST_LIST_MONEY_TYPE
				,$ds1."_MONEY_ICON"			=> $strBEST_LIST_MONEY_ICON
				,$ds1."_TURN_USE"			=> $strBEST_LIST_TURN_USE
				,$ds1."_TITLE_SHOW_USE"		=> $strBEST_LIST_TITLE_SHOW_USE
				,$ds1."_TITLE_MAXSIZE"		=> $strBEST_LIST_TITLE_MAXSIZE
			);
			
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListDesignSet&ds_code=$strDS_CODE&be_no=$intBE_NO&ic_code=$intIC_CODE&ic_type=$strIC_TYPE&subPageCode=$strSubPageCode";
//			$result[0]['MSG'] = $strMsg;
//			$result[0]['RET'] = "Y";
//			$db->disConnect();
//			echo json_encode($result);	
//			exit;
		break;

		case "skinProdViewImg":
			/* 상품리스트 이미지 관련 관리 */
			$designSetMgr->setDS_TYPE("SKIN_PV");
			
			$aryParam = array(
				 "PV_IMG_SIZE_W"		=>$strProdListImgSizeW
				,"PV_IMG_SIZE_H"		=>$strProdListImgSizeH
				,"PV_POP_IMG_SIZE_W"	=>$strProdListPopImgSizeW
				,"PV_POP_IMG_SIZE_H"	=>$strProdListPopImgSizeH
			);



			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdViewImg&subPageCode=$strSubPageCode";
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinProdViewImgMulty":
			/* 상품리스트 다중이미지 */
			$designSetMgr->setDS_TYPE("SKIN_PV");
			
			$aryParam = array(
				 "PV_IMG_MULTY_SIZE_W"	=>$strPV_IMG_MULTY_SIZE_W
				,"PV_IMG_MULTY_SIZE_H"	=>$strPV_IMG_MULTY_SIZE_H
				,"PV_IMG_MULTY_VIEW_W"	=>$strPV_IMG_MULTY_VIEW_W
				,"PV_IMG_MULTY_VIEW_H"	=>$strPV_IMG_MULTY_VIEW_H
				,"PV_IMG_MULTY_CHANGE"	=>$strPV_IMG_MULTY_CHANGE
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdViewImgMulty&subPageCode=$strSubPageCode";
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinProdViewImgZoom":
			/* 상품리스트 확대줌 */
			$designSetMgr->setDS_TYPE("SKIN_PV");
			
			$aryParam = array(
				 "PV_IMG_ZOOM_SIZE_W"	=>$strPV_IMG_ZOOM_SIZE_W
				,"PV_IMG_ZOOM_SIZE_H"	=>$strPV_IMG_ZOOM_SIZE_H
				,"PV_IMG_ZOOM_VIEW_W"	=>$strPV_IMG_ZOOM_VIEW_W
				,"PV_IMG_ZOOM_VIEW_H"	=>$strPV_IMG_ZOOM_VIEW_H
				,"PV_IMG_ZOOM_POSITION"	=>$strPV_IMG_ZOOM_POSITION
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdViewImgZoom&subPageCode=$strSubPageCode";
			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;
		case "skinProdViewReview":
			/* 상품상세보기 사용후기,상품QNA 관련 관리 */
			$designSetMgr->setDS_TYPE("SKIN_PV");
			
			$aryParam = array(
				 "PV_AFTER_YN"		=>$strProdViewAfterYN
				,"PV_QNA_YN"		=>$strProdViewQnaYN
				,"PV_RELATED_YN"	=>$strProdViewRelatedYN
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdViewReview&subPageCode=$strSubPageCode";

		break;

		case "skinProdListSubCate":
			/* 상품리스트 이미지 관련 관리 */
			$ds							= substr($strSubPageCode,0,2);
			$ds2						= strtolower($ds);

			$designSetMgr->setDS_TYPE("SKIN_{$ds}");
			
			$aryParam = array(
				 "{$ds}_SUB_CATE_USE"		=>$strPL_SUB_CATE_USE
				,"{$ds}_SUB_CATE_VIEW"		=>$strPL_SUB_CATE_VIEW
				,"{$ds}_SUB_CATE_DESIGN"	=>$strPL_SUB_CATE_DESIGN
				,"{$ds}_SUB_CATE_L1_MODE"	=>$strPL_SUB_CATE_L1_MODE
				,"{$ds}_SUB_CATE_L2_MODE"	=>$strPL_SUB_CATE_L2_MODE
				,"{$ds}_SUB_CATE_L3_MODE"	=>$strPL_SUB_CATE_L3_MODE
				,"{$ds}_SUB_CATE_L4_MODE"	=>$strPL_SUB_CATE_L4_MODE
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListSubCate&subPageCode=$strSubPageCode";

		break;
		case "skinProdListTop":
			/* 상품리스트 Top 관리 */
			$designSetMgr->setDS_TYPE("SKIN_PL");
			
			$aryParam = array(
				 "PL_TOP_USE_OP"	=>$strPL_TOP_USE_OP
				,"PL_TOP_CAT_OP"	=>$strPL_TOP_CAT_OP
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTop&subPageCode=$strSubPageCode";
		break;

		case "skinMenuGrpTop":
			/* 페이지(회원, 주문..) 그룹별 Top 관리 설정*/
			
			$strKey = substr($strSubPageCode,0,1);

			$designSetMgr->setDS_TYPE("SKIN_" .$strKey);
			
			$aryParam = array(
				 "{$strKey}_TOP_USE_OP"	=>$strPL_TOP_USE_OP
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinMenuTop&subPageCode=$strSubPageCode&dm_code=$strDM_CODE";
		break;

		case "skinProdListTopImgHtml":

			$ds							= substr($strSubPageCode,0,2);
			$ds2						= strtolower($ds);
			
			/* 파일 저장 */
			$fileName = $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/topHtml/{$ds}_TOP_USE_CATE_HTML.php";
			$fh->doStringSave($fileName, $strProdListTopHtml);
			/* 파일 저장 */

			/* Top Img 등록 */
			$designSetMgr->setDS_TYPE("SKIN_{$ds}");
			$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_IMG");
			if ($strProdCateCode) {
				$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_".$strProdCateCode."_IMG");
			}
			$strPrevProdListTopImg = $designSetMgr->getCodeVal($db);
			
			$strProdListTopImg = $strPrevProdListTopImg;
			if ($_FILES["pl_top_img"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["pl_top_img"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename		= $_FILES["pl_top_img"][name];
				$tmpname		= $_FILES["pl_top_img"][tmp_name];
				$filesize		= $_FILES["pl_top_img"][size];
				$filetype		= $_FILES["pl_top_img"][type];

				if ($strProdCateCode) $number = $strProdCateCode;
				else $number = date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/product/top",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strProdListTopImg = "/upload/layout/product/top/".$fres[file_real_name];
					if ($strPrevProdListTopImg){
						$fh->fileDelete("..".$strPrevProdListTopImg);
					}
				}
			} 
			
			$aryParam = array(
				 $designSetMgr->getDS_CODE() => $strProdListTopImg
			);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);


			/* 모두 적용일때 자동 저장(카테고리가 없을때) */
			if (!$strProdCateCode && ($strProdListTopImg || $strProdListTopHtml)) {
				$aryParam = array(
					 "{$ds}_TOP_USE_OP"				=> $strPL_TOP_USE_OP,
					 "{$ds}_TOP_USE_CATE_HTML"		=> $fileName	
				);
				$designSetMgr->getCodeInsertUpdate($db,$aryParam);
			}
			/* 모두 적용일때 자동 저장 */

			/* Top Html 등록 */
			$designSetMgr->setDHS_TYPE("SKIN_{$ds}");
			$designSetMgr->setDHS_CODE("{$ds}_TOP_USE_CATE_HTML");
			if ($strProdCateCode) {
				$designSetMgr->setDHS_CODE("{$ds}_TOP_USE_CATE_".$strProdCateCode."_HTML");
			}

			if ($strProdListTopHtml) {
				$aryParam = array(
					 $designSetMgr->getDHS_CODE() => $strProdListTopHtml
				);
				$designSetMgr->getCodeHtmlInsertUpdate($db,$aryParam);
			} else {
				$designSetMgr->getCodeHtmlDelete($db);
			}
			


			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTopHtml&subPageCode=$strSubPageCode&cateCode=$strProdCateCode";

//			$result[0]['MSG'] = $strMsg;
//			$result[0]['RET'] = "Y";
//			$db->disConnect();
//			echo json_encode($result);	
//			exit;
		break;

		case "skinProdListTopImgDel":
			$ds							= substr($strSubPageCode,0,2);
			$ds2						= strtolower($ds);

			$designSetMgr->setDS_TYPE("SKIN_{$ds}");
			$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_IMG");
			if ($strProdCateCode) {
				$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_".$strProdCateCode."_IMG");
			}
			$strPrevProdListTopImg = $designSetMgr->getCodeVal($db);
			if ($strPrevProdListTopImg){
				$fh->fileDelete("..".$strPrevProdListTopImg);

			$aryParam = array(
				 "{$ds2}_top_use_cate_img"	=> ""
			);
			
			$designSetMgr->setDS_TYPE("SKIN_{$ds}");
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

//				$designSetMgr->getCodeDelete($db);
			}

			$strMsg	= "이미지가 삭제되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinProdListTopHtml&subPageCode=$strSubPageCode&cateCode=$strProdCateCode";
		break;
		
		case "skinMenuTopImgHtml":
			
			$strSubPageType = SUBSTR($strSubPageCode,0,2);

			$designSetMgr->setDS_TYPE("SKIN_".$strSubPageType);
			$row = $designSetMgr->getCodeView($db);

			$designSetMgr->setDHS_TYPE("SKIN_".$strSubPageType);
			$htmlRow = $designSetMgr->getCodeHtmlView($db);

			/* Top Img 등록 */
			$arySkinGrpName		= array("P" => "product", "M" => "member", "O" => "order", "C" =>"customer","E" => "etc");

			$strPrevMenuTopImg = $row[$strSubPageType."_TOP_IMG"];
			$strMenuTopImg = $strPrevMenuTopImg;
			if ($_FILES["top_img"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["top_img"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]);
					exit;
				}

				$filename		= $_FILES["top_img"][name];
				$tmpname		= $_FILES["top_img"][tmp_name];
				$filesize		= $_FILES["top_img"][size];
				$filetype		= $_FILES["top_img"][type];

				$number = date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/".$arySkinGrpName[SUBSTR($strSubPageType,0,1)]."/top",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strMenuTopImg = "/upload/layout/".$arySkinGrpName[SUBSTR($strSubPageType,0,1)]."/top/".$fres[file_real_name];
					if ($strPrevMenuTopImg){
						$fh->fileDelete("..".$strPrevMenuTopImg);
					}
				}
			} 
			
			$aryParam = array(
				 $strSubPageType."_TOP_IMG" => $strMenuTopImg
			);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);


			/* Top Html 등록 */
			$designSetMgr->setDHS_CODE($strSubPageType."_TOP_HTML");
			if ($strMenuTopHtml) {
				$aryParam = array(
					 $strSubPageType."_TOP_HTML" => $strMenuTopHtml
				);
				$designSetMgr->getCodeHtmlInsertUpdate($db,$aryParam);
			} else {
				$designSetMgr->getCodeHtmlDelete($db);
			}
			


			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinMenuTopHtml&reload=Y&dm_code=$strDM_CODE&subPageCode=$strSubPageCode";

		break;

		case "skinMenuTopImgDel":
			
			$strSubPageType = SUBSTR($strSubPageCode,0,2);

			$designSetMgr->setDS_TYPE("SKIN_".$strSubPageType);
			$designSetMgr->setDS_CODE($strSubPageType."_TOP_IMG");
			$strPrevMenuTopImg = $designSetMgr->getCodeVal($db);
			if ($strPrevMenuTopImg){
				$fh->fileDelete("..".$strPrevMenuTopImg);

				$designSetMgr->getCodeDelete($db);
			}

			$strMsg	= "이미지가 삭제되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinMenuTopHtml&reload=Y&dm_code=$strDM_CODE&subPageCode=$strSubPageCode";
		break;



		case "designSkinBtnModify":
			/* 상품리스트 버튼 이미지 관련 관리 */
			if ($strBtnCode){
				$designSetMgr->setDS_TYPE("SKIN_".SUBSTR($strSubPageCode,0,2));
				
				if ($strBtnCode == "T"){
					
					$aryParam = array(
						"ZL_TOP_MENU"	=>$strDS_CODE
					);
				}
				
				$strUrl	= "./?menuType=popup&mode=designSkinBtnList&subPageCode=$subPageCode&btnCode=$strBtnCode";
			} else {
				$designSetMgr->setDS_TYPE("SKIN");
			
				$aryParam = array(
				 substr($strDS_CODE,0,1) . "_BTN"	=>$strDS_CODE
				);
				$strUrl	= "./?menuType=popup&mode=designSkinBtnList&subPageCode=$subPageCode=$strDS_CODE";
			}

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

//			$strScript		= sprintf("parent.goSkinSampleHtml('%s');", $strDS_CODE);
//			$strScript		= $strScript . "parent.goClose();";
//			$strScript		= sprintf("<script language='javascript'>%s</script>", $strScript);
//			echo	$strScript;
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			
		break;
		case "skinQuickMenuListHtml":
			// 퀙메뉴

			$designSetMgr->setDS_TYPE("SKIN_EQ");
			$aryParam = array(
				 "EQ_QUICK_MENU_USE_".$strQuickMenuKind	=> $strQuickMenuUse		// 사용유무
				,"EQ_QUICK_MENU_ACT_".$strQuickMenuKind	=> $strQuickMenuAct		// 액션
				,"EQ_QUICK_MENU_SPE_".$strQuickMenuKind	=> $strQuickMenuSpe		// 스피드
				,"EQ_QUICK_MENU_TOP_".$strQuickMenuKind	=> $strQuickMenuTop		// 탑위치
				,"EQ_QUICK_MENU_LEF_".$strQuickMenuKind	=> $strQuickMenuLef		// 우측 위치

				,"EQ_QUICK_MENU_LIST_CNT_".$strQuickMenuKind	=> $strQuickMenuProdListCnt		// 이미지 개수
				,"EQ_QUICK_MENU_PIMG_SIZ_".$strQuickMenuKind	=> $strQuickMenuProdImgSize		// 이미지 사이즈
				,"EQ_QUICK_MENU_EFFECT_".$strQuickMenuKind		=> $strQuickMenuEffect			// 효과
				,"EQ_QUICK_MENU_ALIGN_".$strQuickMenuKind		=> $strQuickMenuAlign			// 정렬
			);

			$designSetMgr->getCodeInsertUpdate($db,$aryParam);	
			
			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinQuickMenuListHtml&subPageCode=$strSubPageCode&quickMenuKind=$strQuickMenuKind";
		break;
		case "skinMainProdListHtml":
			
			$strCode				= substr($strSubPageCode, 0, 2);
			$aryCodeForderName		= array( "ZL" => "main", "PL" => "product" );
			
			$designSetMgr->setDS_TYPE("SKIN_{$strCode}");
			$row = $designSetMgr->getCodeView($db);

			/* Title Img 등록 */
			$strPrevTitImg = $row["{$strCode}_PRODLIST_TIT_".$strProdListOrder];
			$strTitImg = $strPrevTitImg;
			if ($_FILES["tit_img"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["tit_img"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]);
					exit;
				}

				$filename		= $_FILES["tit_img"][name];
				$tmpname		= $_FILES["tit_img"][tmp_name];
				$filesize		= $_FILES["tit_img"][size];
				$filetype		= $_FILES["tit_img"][type];

				$number = date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/{$aryCodeForderName[$strCode]}/tit",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strTitImg = "/upload/layout/{$aryCodeForderName[$strCode]}/tit/".$fres[file_real_name];
					if ($strPrevTitImg){
						$fh->fileDelete("..".$strPrevTitImg);
					}
				}
			} 

			$aryParam = array(
				 "{$strCode}_PRODLIST_IMG_SIZE_W_".$strProdListOrder	=>$strProdListImgSizeW
				,"{$strCode}_PRODLIST_IMG_SIZE_H_".$strProdListOrder	=>$strProdListImgSizeH
				,"{$strCode}_PRODLIST_IMG_VIEW_W_".$strProdListOrder	=>$strProdListImgViewW
				,"{$strCode}_PRODLIST_IMG_VIEW_H_".$strProdListOrder	=>$strProdListImgViewH
				,"{$strCode}_PRODLIST_TIT_".$strProdListOrder			=>$strTitImg
			);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinMainProdListHtml&subPageCode=$strSubPageCode&prodListOrder=$strProdListOrder";

			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;
		break;

		case "skinMainProdListTitImgDel":
		
			$strCode				= substr($strSubPageCode, 0, 2);

			$designSetMgr->setDS_TYPE("SKIN_{$strCode}");
			$designSetMgr->setDS_CODE("{$strCode}_PRODLIST_TIT_".$strProdListOrder);
			$strPrevTitImg = $designSetMgr->getCodeVal($db);
			if ($strPrevTitImg){
				$fh->fileDelete("..".$strPrevTitImg);

				$designSetMgr->getCodeDelete($db);
			}

			$strMsg	= "이미지가 삭제되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinMainProdListHtml&subPageCode=$strSubPageCode&prodListOrder=$strProdListOrder";
		break;

		case "skinSubProdListHtml":
			
			$designSetMgr->setDS_TYPE("SKIN_SL");
			$row = $designSetMgr->getCodeView($db);

			/* Title Img 등록 */
			$strPrevTitImg = $row["SL_PRODLIST_TIT_".$strProdListOrder];
			$strTitImg = $strPrevTitImg;
			if ($_FILES["tit_img"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["tit_img"][name], "Y")){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]);
					exit;
				}

				$filename		= $_FILES["tit_img"][name];
				$tmpname		= $_FILES["tit_img"][tmp_name];
				$filesize		= $_FILES["tit_img"][size];
				$filetype		= $_FILES["tit_img"][type];

				$number = date("YmdHis");
				$fres			= $fh->doUpload("$number","../upload/layout/product/tit",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$strTitImg = "/upload/layout/product/tit/".$fres[file_real_name];
					if ($strPrevTitImg){
						$fh->fileDelete("..".$strPrevTitImg);
					}
				}
			} 

			$aryParam = array(
				 "SL_PRODLIST_IMG_SIZE_W_".$strProdListOrder	=>$strProdListImgSizeW
				,"SL_PRODLIST_IMG_SIZE_H_".$strProdListOrder	=>$strProdListImgSizeH
				,"SL_PRODLIST_IMG_VIEW_W_".$strProdListOrder	=>$strProdListImgViewW
				,"SL_PRODLIST_IMG_VIEW_H_".$strProdListOrder	=>$strProdListImgViewH
				,"SL_PRODLIST_TIT_".$strProdListOrder			=>$strTitImg
			);
			$designSetMgr->getCodeInsertUpdate($db,$aryParam);

			$strMsg	= $LNG_TRANS_CHAR["CS00024"]; //"설정이 변경되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinSubProdListHtml&subPageCode=$strSubPageCode&prodListOrder=$strProdListOrder";

			$result[0]['MSG'] = $strMsg;
			$result[0]['RET'] = "Y";
			$db->disConnect();
			echo json_encode($result);	
			exit;

		break;

		case "skinSubProdListTitImgDel":
			
			$designSetMgr->setDS_TYPE("SKIN_SL");
			$designSetMgr->setDS_CODE("SL_PRODLIST_TIT_".$strProdListOrder);
			$strPrevTitImg = $designSetMgr->getCodeVal($db);
			if ($strPrevTitImg){
				$fh->fileDelete("..".$strPrevTitImg);

				$designSetMgr->getCodeDelete($db);
			}

			$strMsg	= "이미지가 삭제되었습니다.";
			$strUrl	= "./?menuType=popup&mode=skinSubProdListHtml&subPageCode=$strSubPageCode&prodListOrder=$strProdListOrder";
		break;


		// 슬라이딩 배너
		case "sliderBannerWrite":	
			
			/* 파일 업로드 */
			$dir			= "slider";
			for ( $i = 0; $i < $intSB_IMAGES_CNT; $i++ ) :
				$strSB_IMAGE_FILE		= "";
				$intResult				= imageFileUpLoadArray("si_img", $dir, $i, $strSB_IMAGE_FILE);	
				if ( $intResult ) :
					// 업데이트 파일이 있을 때.
					if ( $intResult <= 0 ) :
						// 파일 복사 실패 했을 때.
						break;
					endif;
					// 파일 복사 성공 했을 때.
				else :
					// 업데이트 파일이 없을 때.
				endif;
				$arySB_IMAGE_FILE[] = $strSB_IMAGE_FILE;
			endfor;		
			/* 파일 업로드 */

			/* 데이터 베이스에 기록 */
//			$designSetMgr->setSB_REG_NO($g_member_no);
			$designSetMgr->setSB_REG_NO(0);
			$intSB_NO		= $designSetMgr->getDesignSliderBannerInsert($db);
			$intAryCnt		= 0; 
			$intCnt			= 0;
			/* 파일 정보 생성 */
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_NO']";
			$aryData[$intAryCnt]['data'] 	= $intSB_NO;
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['IM_CODE']";
			$aryData[$intAryCnt]['data'] 	= "\"$strIM_CODE\"";
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_W_SIZE']";
			$aryData[$intAryCnt]['data'] 	= $intSB_W_SIZE;
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_H_SIZE']";
			$aryData[$intAryCnt]['data'] 	= $intSB_H_SIZE;
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_LINK_TYPE']";
			$aryData[$intAryCnt]['data'] 	= "\"$strSB_LINK_TYPE\"";
			$intAryCnt++;
			/* 파일 정보 생성 */
//			$designSetMgr->setSI_REG_NO($g_member_no);
			$designSetMgr->setSI_REG_NO(0);
			$designSetMgr->setSB_NO($intSB_NO);	
			foreach($arySB_IMAGE_FILE as $fileName) :
				if($fileName) :
					$designSetMgr->setSI_IMG($fileName);
					$designSetMgr->setSI_LINK($strSI_LINK[$intCnt]);
					$designSetMgr->setSI_TEXT($strSI_TEXT[$intCnt]);
					$designSetMgr->getDesignSliderBannerImgInsert($db);
					/* 파일 정보 생성 */
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_IMG'][]";
					$aryData[$intAryCnt]['data'] 	= "\"$fileName\"";
					$intAryCnt++;
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_LINK'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$strSI_LINK[$intCnt]}\"";
					$intAryCnt++;
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_TEXT'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$strSI_TEXT[$intCnt]}\"";
					$intAryCnt++;
					/* 파일 정보 생성 */
				endif;
				$intCnt++;
			endforeach;
			/* 데이터 베이스에 기록 */	

			/* 파일 정보 생성 */
//			$fileName				= sprintf("sliderBanner/sliderBanner_%s_%d.conf.inc.php", $strIM_CODE, $intSB_NO);
			$fileName				= sprintf("sliderBanner/sliderBanner_%s.conf.inc.php", $strIM_CODE);
			shopConfigFileUpdate ( $aryData, $fileName );
			/* 파일 정보 생성 */

			$strMsg		= "움직이는 배너가 등록되었습니다..";
			$strUrl		= "./?menuType=".$strMenuType."&mode=sliderBannerList&".$strLinkPage;
		break;

		case "sliderBannerModify":
			// 디자인관리 / 레이아웃 / 움직이는 배너
			
			/* 파일 업로드 */
			$dir			= "slider";
			for ( $i = 0; $i < $intSB_IMAGES_CNT; $i++ ) :
				$strSB_IMAGE_FILE		= "";
				$intResult				= imageFileUpLoadArray("si_img", $dir, $i, $strSB_IMAGE_FILE);	
				if ( $intResult ) :
					// 업데이트 파일이 있을 때.
					if ( $intResult <= 0 ) :
						// 파일 복사 실패 했을 때.
						break;
					endif;
					// 파일 복사 성공 했을 때.
				else :
					// 업데이트 파일이 없을 때.
				endif;
				$arySB_IMAGE_FILE[] = $strSB_IMAGE_FILE;
			endfor;		
			/* 파일 업로드 */

			/* 움직이는 배너 데이터 업데이트 */
			$designSetMgr->setSB_MOD_NO(0);
			$bannerRowBak	= $designSetMgr->getDesignSliderBannerView($db);
			$designSetMgr->getDesignSliderBannerUpdate($db);

			$intAryCnt		= 0;
			/* 파일 정보 생성 */
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_NO']";
			$aryData[$intAryCnt]['data'] 	= $intSB_NO;
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['IM_CODE']";
			$aryData[$intAryCnt]['data'] 	= "\"$strIM_CODE\"";
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_W_SIZE']";
			$aryData[$intAryCnt]['data'] 	= $intSB_W_SIZE;
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_H_SIZE']";
			$aryData[$intAryCnt]['data'] 	= $intSB_H_SIZE;
			$intAryCnt++;
			$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SB_LINK_TYPE']";
			$aryData[$intAryCnt]['data'] 	= "\"$strSB_LINK_TYPE\"";
			$intAryCnt++;
			/* 파일 정보 생성 */
			/* 움직이는 배너 데이터 업데이트 */

			/* 이미지 데이터 업데이트 */
			$bannerImgResult		= $designSetMgr->getDesignSliderBannerImgList($db);
			while($row = mysql_fetch_array($bannerImgResult)) : 
				if(in_array($row['SI_NO'], $arySI_NO_BAK)) :
					// DB 정보가 업데이트 후에도 존재 하는 경우.
					$index = array_search($row['SI_NO'], $arySI_NO_BAK);
					$designSetMgr->setSI_NO($row['SI_NO']);
					$designSetMgr->setSI_IMG($row['SI_IMG']);
					$designSetMgr->setSI_LINK($strSI_LINK[$index]);
					$designSetMgr->setSI_TEXT($strSI_TEXT[$index]);
					if($arySB_IMAGE_FILE[$index]):
						// 신규 이미지 파일이 있는 경우.
						/* 파일 삭제*/
						$strDelPath = sprintf( "%s/%s/%s" , WEB_UPLOAD_PATH, $dir, $row['SI_IMG'] );
						unlink($strDelPath);		
						/* 파일 삭제*/
						$designSetMgr->setSI_IMG($arySB_IMAGE_FILE[$index]);
					endif;
					/* 움직이는 배너 이미지 DB 업데이트 */
					$designSetMgr->getDesignSliderBannerImgUpdate($db);
					/* 움직이는 배너 이미지 DB 업데이트 */
					/* 배열 요소 삭제 */
					$arySI_NO_BAK[$index]		= "";
					$arySB_IMAGE_FILE[$index]	= "";
					/* 배열 요소 삭제 */
					/* 파일 정보 생성 */
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_IMG'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$designSetMgr->getSI_IMG()}\"";
					$intAryCnt++;
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_LINK'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$designSetMgr->getSI_LINK()}\"";
					$intAryCnt++;
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_TEXT'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$designSetMgr->getSI_TEXT()}\"";
					$intAryCnt++;
					/* 파일 정보 생성 */
				else :
					// DB 정보가 업데이트 후에 삭제된 경우.
					/* 파일 삭제 및 DB 삭제*/
					$strDelPath = sprintf( "%s/%s/%s" , WEB_UPLOAD_PATH, $dir, $row['SI_IMG'] );
					unlink($strDelPath);

					$param				= "";
					$param['SI_NO']		= $row['SI_NO'];
					$designSetMgr->getDesignSliderBannerImgDeleteEx($db, $param);

// 2013.09.12 kim hee sung 실행시, 모든 데이터가 삭제되는 문제가 있음.
//					$designSetMgr->setSI_NO($row['SI_NO']);
//					$designSetMgr->getDesignSliderBannerImgDelete($db);
					/* 파일 삭제 및 DB 삭제*/
				endif;
			endwhile;
			/* 이미지 데이터 업데이트 */
			/* 신규 움직이는 배너 이미지 데이터 Insert */
			$intCnt			= 0;
			$designSetMgr->setSI_REG_NO(0);
			foreach($arySB_IMAGE_FILE as $fileName) :
				if($fileName) :
					$designSetMgr->setSI_IMG($fileName);
					$designSetMgr->setSI_LINK($strSI_LINK[$intCnt]);
					$designSetMgr->setSI_TEXT($strSI_TEXT[$intCnt]);
					$designSetMgr->getDesignSliderBannerImgInsert($db);
					/* 파일 정보 생성 */
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_IMG'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$designSetMgr->getSI_IMG()}\"";
					$intAryCnt++;
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_LINK'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$designSetMgr->getSI_LINK()}\"";
					$intAryCnt++;
					$aryData[$intAryCnt]['key']		= "\$S_SLIDER_INFO['SI_TEXT'][]";
					$aryData[$intAryCnt]['data'] 	= "\"{$designSetMgr->getSI_TEXT()}\"";
					$intAryCnt++;
					/* 파일 정보 생성 */
				endif;	
				$intCnt++;
			endforeach;
			/* 신규 움직이는 배너 이미지 데이터 Insert */
			
			/* 파일 정보 삭제 */
//			$deleteFileName			= sprintf("sliderBanner/sliderBanner_%s_%d.conf.inc.php", $bannerRowBak['IM_CODE'], $intSB_NO);
			$deleteFileName			= sprintf("sliderBanner/sliderBanner_%s.conf.inc.php", $bannerRowBak['IM_CODE']);
			$deleteFileName 		= sprintf( "%s%s/conf/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $deleteFileName );
			unlink($deleteFileName);
			/* 파일 정보 삭제 */
			/* 파일 정보 생성 */
//			$fileName				= sprintf("sliderBanner/sliderBanner_%s_%d.conf.inc.php", $strIM_CODE, $intSB_NO);
			$fileName				= sprintf("sliderBanner/sliderBanner_%s.conf.inc.php", $strIM_CODE);
			shopConfigFileUpdate ( $aryData, $fileName );
			/* 파일 정보 생성 */

			$strMsg = "슬라이딩 배너를 수정 하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=sliderBannerList&page=".$intPage.$strLinkPage;
		break;

		case "sliderBannerDelete":
			
			/* 움직이는 배너 파일 삭제 */
			$dir					= "slider";
			$bannerImgResult		= $designSetMgr->getDesignSliderBannerImgList($db);
			while($row = mysql_fetch_array($bannerImgResult)) : 
				/* 파일 삭제*/
				$strDelPath = sprintf( "%s/%s/%s" , WEB_UPLOAD_PATH, $dir, $row['SI_IMG'] );
				unlink($strDelPath);		
				/* 파일 삭제*/
			endwhile;
			/* 움직이는 배너 파일 삭제 */
			/* 움직이는 배너 Conf 파일 삭제 */
			$bannerRow				= $designSetMgr->getDesignSliderBannerView($db);
			$fileName				= sprintf("sliderBanner/sliderBanner_%s_%d.conf.inc.php", $bannerRow['IM_CODE'], $intSB_NO);
			$deleteFileName 		= sprintf( "%s%s/conf/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $fileName );
			unlink($deleteFileName);
			/* 움직이는 배너 Conf 파일 삭제 */

			/* DB 삭제 */
			$designSetMgr->getDesignSliderBannerImgDelete($db);
			$designSetMgr->getDesignSliderBannerDelete($db);
			/* DB 삭제 */
			
			$strMsg="슬라이딩 배너를 삭제 하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=sliderBannerList&page=".$intPage.$strLinkPage;
		break;

		case "sliderBannerMake":	//슬라이더 설정파일 만들기			
			makeSliderBannerFile();
			$strMsg = "슬라이드 배너를 만들었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=sliderBannerList&".$strLinkPage;
		break;

		case "maindesignModify":
			// 페이지 디자인 설정 변경
			//- M		-> main
			//- S		-> sub
			//- P		-> productList
			//- O		-> order
			//- E		-> member
			//- B		-> community
			//- R		-> brand
			//- V		-> productView
			//- C		-> myCommunity
			//- H		-> shop

			$aryPageDesignName1	= array("M" => "main", "S" => "sub", "P" => "productList", "O" => "order", "E" => "member", "B" => "community", "R" => "brand", "V" => "productView", "Y" => "mypage", "C" => "myCommunity", "H" => "shop");
			$aryPageDesignName2	= array("H" => "html", "T" => "top", "D" => "body", "B" => "bottom", "L" => "left", "R" => "right");

			if($strSubPageDesign) { $strSubPageName = "_{$strSubPageDesign}"; }

			// 변환된 소스코드 저장 경로
			$htmlFile				= sprintf( "%s%s/layout/html/%s_%s%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, 
												$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );
			// TAG 코드 저장 경로
			$htmlFileTag			= sprintf( "%s%s/layout/html/tag_%s_%s%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, 
												$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );

			## 2013.05.29
			## 메인 하단 영역 다국어 파일로 변경
			if($strPageDesign == "MB"):
				// 변환된 소스코드 저장 경로
				$htmlFile				= sprintf( "%s%s/layout/html/%s/%s_%s%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($strStLng), 
													$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );

				// TAG 코드 저장 경로
				$htmlFileTag			= sprintf( "%s%s/layout/html/%s/tag_%s_%s%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($strStLng),  
													$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );
			endif;


			updateHtmlFile($htmlFileTag, $strDE_EDIT_TEXT);			
			changeLayoutDataEx6( $strDE_EDIT_TEXT );
			changeLayoutData( $strDE_EDIT_TEXT, $strLayoutData);
			changeLayoutDataEx( $strLayoutData );
			changeLayoutDataEx2( $strLayoutData );
			changeLayoutDataEx3( $strLayoutData );
			changeLayoutDataEx4( $strLayoutData );
			changeLayoutDataEx5( $strLayoutData );
			updateHtmlFile($htmlFile, $strLayoutData);
		
//			$strMsg="설정 되었습니다.";		
			$strUrl = "./?menuType=layout&mode=pageDesignSave&pageDesign=$strPageDesign&subPageDesign={$strSubPageDesign}&lang={$strStLng}";
		break;

		// 컨텐츠 추가페이지 
		case "contentWrite":

			## STEP 1.
			## 데이터 등록
			if(!$strStLng) { $strStLng = $S_SITE_LNG; }
			$contentMgr->setCP_LNG($strStLng);
			$contentMgr->getContentInsert($db);

			## STEP 2.
			## CP_GROUP 컬럼 업데이트
			$intCP_NO		= $db->getLastInsertID();
			$intCP_GROUP	= $intCP_NO;
			$contentMgr->setCP_NO($intCP_NO);
			$contentMgr->setCP_GROUP($intCP_GROUP);
			$contentMgr->getContentGroupUpdate($db);

			## STEP 3.
			## 사용중인 모든언어에 적용.
			if($S_USE_LNG):
				$aryUseLng = explode("/", $S_USE_LNG);
				foreach($aryUseLng as $lng):
					if(strtolower($lng) == strtolower($strStLng)) { continue; }
					$contentMgr->setCP_LNG($lng);
					$contentMgr->getContentInsert($db);					
				endforeach;
			endif;

			## STEP 4.
			## 사용중인 모든언어로 스크립트 파일 생성
			foreach($aryUseLng as $lng):
				$strPageDir			= sprintf("%s%s/layout/contents/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($lng));
				$strPageFileName	= sprintf("contents_%s.html.php", pushHeadZero($intCP_GROUP, 5));
				if(is_dir($strPageDir)) :
//					changeLayoutDataEx3( $strCP_PAGE_TEXT );
					changeLayoutDataEx6( $strCP_PAGE_TEXT );
					changeLayoutData( $strCP_PAGE_TEXT, $strCP_PAGE_TEXT);
					changeLayoutDataEx( $strCP_PAGE_TEXT );
					changeLayoutDataEx2( $strCP_PAGE_TEXT );
					changeLayoutDataEx3( $strCP_PAGE_TEXT );
					changeLayoutDataEx4( $strCP_PAGE_TEXT );
					changeLayoutDataEx5( $strCP_PAGE_TEXT );
					updateHtmlFile($strPageDir . "/" . $strPageFileName , $strCP_PAGE_TEXT);
				endif;
			endforeach;

			/* 페이지 생성 */	
// 2013.04.24 다국어 버전으로 변경
//			$strPageDir			= sprintf("%s%s/layout/contents", $S_DOCUMENT_ROOT, $S_SHOP_HOME);
//			$strPageFileName	= sprintf("contents_%s.html.php", pushHeadZero($intCP_NO, 5));
//			if(is_dir($strPageDir)) :
//				updateHtmlFile($strPageDir . "/" . $strPageFileName , $strCP_PAGE_TEXT);
//			endif;
			/* 페이지 생성 */

			$strMsg="추가 페이지를 등록하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=contentList&".$strLinkPage;
		break;

		case "contentModify":		

			if(!$strStLng) { $strStLng = $S_SITE_LNG; }

			$contentMgr->setCP_GROUP($intCP_GROUP);
			$contentMgr->setCP_LNG($strStLng);
			$row = $contentMgr->getContentView($db);
			if($row):
				$intCP_NO = $row['CP_NO'];
				$contentMgr->setCP_NO($intCP_NO);
				$contentMgr->getContentUpdate($db);
			else:
				$contentMgr->getContentInsert($db);
			endif;

			$strMsg="페이지가 수정 되었습니다.";		

			/* 페이지 생성 */
			$strPageDir			= sprintf("%s%s/layout/contents/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($strStLng));
			$strPageFileName	= sprintf("contents_%s.html.php", pushHeadZero($intCP_GROUP, 5));
			if(is_dir($strPageDir)) :
//				changeLayoutDataEx3( $strCP_PAGE_TEXT );
			
				changeLayoutDataEx6( $strCP_PAGE_TEXT );
				changeLayoutData( $strCP_PAGE_TEXT, $strCP_PAGE_TEXT);
				changeLayoutDataEx( $strCP_PAGE_TEXT );
				changeLayoutDataEx2( $strCP_PAGE_TEXT );
				changeLayoutDataEx3( $strCP_PAGE_TEXT );
				changeLayoutDataEx4( $strCP_PAGE_TEXT );
				changeLayoutDataEx5( $strCP_PAGE_TEXT );

				updateHtmlFile($strPageDir . "/" . $strPageFileName , $strCP_PAGE_TEXT);
			endif;
			/* 페이지 생성 */


			$strUrl = "./?menuType={$strMenuType}&mode=contentModify&lang={$strStLng}&cp_group={$intCP_GROUP}&page={$intPage}{$strLinkPage}";
		break;
		
		case "contentDelete":

			## STEP 1.
			## 데이터 삭제(모든 언어)
			$contentMgr->getContentDelete($db);			

			## STEP 2.
			## 파일 삭제
			if($S_USE_LNG):
				$aryUseLng = explode("/", $S_USE_LNG);
				foreach($aryUseLng as $lng):
					$strPageDir			= sprintf("%s%s/layout/contents/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($lng));
					$strPageFileName	= sprintf("contents_%s.html.php", pushHeadZero($intCP_GROUP, 5));
					if(is_file($strPageDir . "/" . $strPageFileName)) :
						unlink($strPageDir . "/" . $strPageFileName);
					endif;			
				endforeach;
			endif;

			$strMsg="페이지가 삭제 되었습니다.";

			/* 페이지 생성 */
// 2013.04.24 다국어 버전으로 변경
//			$strPageDir			= sprintf("%s%s/layout/contents", $S_DOCUMENT_ROOT, $S_SHOP_HOME);
//			$strPageFileName	= sprintf("contents_%s.html.php", pushHeadZero($intCP_NO, 5));
//			if(is_dir($strPageDir)) :
//				unlink($strPageDir . "/" . $strPageFileName);
//			endif;
			/* 페이지 생성 */

			$strUrl = "./?menuType=".$strMenuType."&mode=contentList&page=".$intPage.$strLinkPage;
		break;


	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>