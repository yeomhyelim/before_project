<?

require_once "makeProdpageFile.inc.php";
require_once "makeDesignFirstFile.inc.php";
require_once "makeEditLayoutFile.inc.php";
require_once "makeSliderBannerFile.inc.php";


/*##################################### Parameter 셋팅 ##################################################*/	
	/* 디자인 레이아웃 설정(레이아웃설정, 첫화면 설정)*/
	$strDL_CODE					= $_POST["dl_code"]					? $_POST["dl_code"]					: $_REQUEST["dl_code"];
	$strDL_DESIGN_CODE			= $_POST["dl_design_code"]			? $_POST["dl_design_code"]				: $_REQUEST["dl_design_code"];
	$strDL_BG_TYPE				= $_POST["dl_bg_type"]				? $_POST["dl_bg_type"]					: $_REQUEST["dl_bg_type"];
	$strDL_BG_COLOR				= $_POST["dl_bg_color"]				? $_POST["dl_bg_color"]				: $_REQUEST["dl_bg_color"];
	$strDL_BG_IMAGE				= $_POST["dl_bg_image_old"]			? $_POST["dl_bg_image_old"]			: $_REQUEST["dl_bg_image_old"];
	$strDL_BG_IMG_DIR_H			= $_POST["dl_bg_img_dir_h"]			? $_POST["dl_bg_img_dir_h"]			: $_REQUEST["dl_bg_img_dir_h"];
	$strDL_BG_IMG_DIR_V			= $_POST["dl_bg_img_dir_v"]			? $_POST["dl_bg_img_dir_v"]			: $_REQUEST["dl_bg_img_dir_v"];
	$strDL_BG_REPEAT				= $_POST["dl_bg_repeat"]				? $_POST["dl_bg_repeat"]				: $_REQUEST["dl_bg_repeat"];
	$strDL_BG_ALIGN				= $_POST["dl_bg_align"]				? $_POST["dl_bg_align"]				: $_REQUEST["dl_bg_align"];
	$strDL_FIRST_PAGE				= $_POST["dl_first_page"]				? $_POST["dl_first_page"]				: $_REQUEST["dl_first_page"];
	$strDL_FIRST_USE				= $_POST["dl_first_use"]				? $_POST["dl_first_use"]				: $_REQUEST["dl_first_use"];
	$intDL_REG_DT					= $_POST["dl_reg_dt"]					? $_POST["dl_reg_dt"]					: $_REQUEST["dl_reg_dt"];
	$intDL_REG_NO					= $_POST["dl_reg_no"]					? $_POST["dl_reg_no"]					: $_REQUEST["dl_reg_no"];
	$intDL_MOD_DT				= $_POST["dl_mod_dt"]					? $_POST["dl_mod_dt"]					: $_REQUEST["dl_mod_dt"];
	$intDL_MOD_NO				= $_POST["dl_mod_no"]				? $_POST["dl_mod_no"]					: $_REQUEST["dl_mod_no"];

	/* 서브탑 이미지 관리 */
	$strTI_CATE_CODE				= $_POST["ti_cate_code"]				? $_POST["ti_cate_code"]				: $_REQUEST["ti_cate_code"];
	$strTI_TOP_IMAGE				= $_POST["ti_top_image_bak"]			? $_POST["ti_top_image_bak"]			: $_REQUEST["ti_top_image_bak"];
	$strTI_LEFT_IMAGE				= $_POST["ti_left_image_bak"]			? $_POST["ti_left_image_bak"]			: $_REQUEST["ti_left_image_bak"];
	$strTI_HTML_TOP				= $_POST["ti_html_top"]				? $_POST["ti_html_top"]				: $_REQUEST["ti_html_top"];
	$strTI_HTML_BOTTOM			= $_POST["ti_html_bottom"]			? $_POST["ti_html_bottom"]			: $_REQUEST["ti_html_bottom"];
	$intTI_REG_DT					= $_POST["ti_reg_dt"]					? $_POST["ti_reg_dt"]					: $_REQUEST["ti_reg_dt"];
	$intTI_REG_NO					= $_POST["ti_reg_no"]					? $_POST["ti_reg_no"]					: $_REQUEST["ti_reg_no"];
	$intTI_MOD_DT				= $_POST["ti_mod_dt"]					? $_POST["ti_mod_dt"]					: $_REQUEST["ti_mod_dt"];
	$intTI_MOD_NO				= $_POST["ti_mod_no"]					? $_POST["ti_mod_no"]					: $_REQUEST["ti_mod_no"];
	/* 서브탑 이미지 관리 */
	
	
	/* 디자인 직접 편집*/	
	$strDE_CODE			= $_POST["de_code"]				? $_POST["de_code"]				: $_REQUEST["de_code"];
	$strDE_EDIT_GROUP	= $_POST["de_edit_group"]		? $_POST["de_edit_group"]		: $_REQUEST["de_edit_group"];
	$strDE_EDIT_SECTION = $_POST["de_edit_section"]		? $_POST["de_edit_section"]		: $_REQUEST["de_edit_section"];
	$strDE_EDIT_TEXT	= $_POST["de_edit_text"]		? $_POST["de_edit_text"]		: $_REQUEST["de_edit_text"];
	$intDE_REG_DT		= $_POST["de_reg_dt"]			? $_POST["de_reg_dt"]			: $_REQUEST["de_reg_dt"];
	$intDE_REG_NO		= $_POST["de_reg_no"]			? $_POST["de_reg_no"]			: $_REQUEST["de_reg_no"];
	$intDE_MOD_DT		= $_POST["de_mod_dt"]			? $_POST["de_mod_dt"]			: $_REQUEST["de_mod_dt"];
	$intDE_MOD_NO		= $_POST["de_mod_no"]			? $_POST["de_mod_no"]			: $_REQUEST["de_mod_no"];


	/* 추가 컨텐츠 */
	$intCP_GROUP		= $_POST["cp_group"]		? $_POST["cp_group"]		: $_REQUEST["cp_group"];
	$strCP_PAGE_NAME	= $_POST["cp_page_name"]	? $_POST["cp_page_name"]	: $_REQUEST["cp_page_name"];
	$strCP_PAGE_URL		= $_POST["cp_page_url"]		? $_POST["cp_page_url"]		: $_REQUEST["cp_page_url"];
	$strCP_PAGE_TEXT	= $_POST["cp_page_text"]	? $_POST["cp_page_text"]	: $_REQUEST["cp_page_text"];
	$strCP_PAGE_VIEW	= $_POST["cp_page_view"]	? $_POST["cp_page_view"]	: $_REQUEST["cp_page_view"];
	$intCP_REG_DT		= $_POST["cp_reg_dt"]		? $_POST["cp_reg_dt"]		: $_REQUEST["cp_reg_dt"];
	$intCP_REG_NO		= $_POST["cp_reg_no"]		? $_POST["cp_reg_no"]		: $_REQUEST["cp_reg_no"];
	$intCP_MOD_DT		= $_POST["cp_mod_dt"]		? $_POST["cp_mod_dt"]		: $_REQUEST["cp_mod_dt"];
	$intCP_MOD_NO		= $_POST["cp_mod_no"]		? $_POST["cp_mod_no"]		: $_REQUEST["cp_mod_no"];


	/* 상품페이지 설정 */
	$strPV_CODE			= $_POST["pv_code"]			? $_POST["pv_code"]			: $_REQUEST["pv_code"];
//	$strPV_PAGE			= $_POST["pv_page"]			? $_POST["pv_page"]			: $_REQUEST["pv_page"];
	$strPV_MODUL_TYPE	= $_POST["pv_modul_type"]	? $_POST["pv_modul_type"]	: $_REQUEST["pv_modul_type"];
	$intPV_DESIGN_NO	= $_POST["pv_design_no"]	? $_POST["pv_design_no"]	: $_REQUEST["pv_design_no"];
	$strPV_MODUL_NAME	= $_POST["pv_modul_name"]	? $_POST["pv_modul_name"]	: $_REQUEST["pv_modul_name"];
	$strPV_IMAGE_FILE	= $_POST["pv_image_file"]	? $_POST["pv_image_file"]	: $_REQUEST["pv_image_file"];
	$intPV_IMAGE_SIZE_W = $_POST["pv_image_size_w"]	? $_POST["pv_image_size_w"]	: $_REQUEST["pv_image_size_w"];
	$intPV_IMAGE_SIZE_H = $_POST["pv_image_size_h"]	? $_POST["pv_image_size_h"]	: $_REQUEST["pv_image_size_h"];
	$intPV_IMAGE_CNT_W	= $_POST["pv_image_cnt_w"]	? $_POST["pv_image_cnt_w"]	: $_REQUEST["pv_image_cnt_w"];
	$intPV_IMAGE_CNT_H	= $_POST["pv_image_cnt_h"]	? $_POST["pv_image_cnt_h"]	: $_REQUEST["pv_image_cnt_h"];
	$strPV_MODUL_TEXT	= $_POST["pv_modul_text"]	? $_POST["pv_modul_text"]	: $_REQUEST["pv_modul_text"];
	$strPV_LIST_CATE	= $_POST["pv_list_cate"]	? $_POST["pv_list_cate"]	: $_REQUEST["pv_list_cate"];
	$intPV_VIEW_FUNCTION	= $_POST["pv_view_function"]	? $_POST["pv_view_function"]	: $_REQUEST["pv_view_function"];
	$strPV_USE			= $_POST["pv_use"]			? $_POST["pv_use"]			: $_REQUEST["pv_use"];
	$intPV_ORDER		= $_POST["pv_order"]		? $_POST["pv_order"]		: $_REQUEST["pv_order"];
	$intPV_REG_DT		= $_POST["pv_reg_dt"]		? $_POST["pv_reg_dt"]		: $_REQUEST["pv_reg_dt"];
	$intPV_REG_NO		= $_POST["pv_reg_no"]		? $_POST["pv_reg_no"]		: $_REQUEST["pv_reg_no"];
	$intPV_MOD_DT		= $_POST["pv_mod_dt"]		? $_POST["pv_mod_dt"]		: $_REQUEST["pv_mod_dt"];
	$intPV_MOD_NO		= $_POST["pv_mod_no"]		? $_POST["pv_mod_no"]		: $_REQUEST["pv_mod_no"];


	/* 슬라이딩 배너 */	
	$strSB_GROUP		= $_POST["sb_group"]			? $_POST["sb_group"]				: $_REQUEST["sb_group"];
	$intSB_DESIGN_CODE	= $_POST["sb_design_code"]		? $_POST["sb_design_code"]			: $_REQUEST["sb_design_code"];
	$strSB_BANNER_NAME	= $_POST["sb_banner_name"]		? $_POST["sb_banner_name"]			: $_REQUEST["sb_banner_name"];
	$intSB_IMAGES_CNT	= $_POST["sb_images_cnt"]		? $_POST["sb_images_cnt"]			: $_REQUEST["sb_images_cnt"];
	$intSB_IMAGE_W		= $_POST["sb_image_w"]			? $_POST["sb_image_w"]				: $_REQUEST["sb_image_w"];
	$intSB_IMAGE_H		= $_POST["sb_image_h"]			? $_POST["sb_image_h"]				: $_REQUEST["sb_image_h"];
	$strSB_IMAGE_FILE_1 	= $_POST["sb_image_file_1"]		? $_POST["sb_image_file_1"]			: $_REQUEST["sb_image_file_1"];
	$strSB_IMAGE_FILE_2 	= $_POST["sb_image_file_2"]		? $_POST["sb_image_file_2"]			: $_REQUEST["sb_image_file_2"];
	$strSB_IMAGE_FILE_3 	= $_POST["sb_image_file_3"]		? $_POST["sb_image_file_3"]			: $_REQUEST["sb_image_file_3"];
	$strSB_IMAGE_FILE_4 	= $_POST["sb_image_file_4"]		? $_POST["sb_image_file_4"]			: $_REQUEST["sb_image_file_4"];
	$strSB_IMAGE_FILE_5	 = $_POST["sb_image_file_5"]		? $_POST["sb_image_file_5"]			: $_REQUEST["sb_image_file_5"];
	$strSB_IMAGE_FILE_6 	= $_POST["sb_image_file_6"]		? $_POST["sb_image_file_6"]			: $_REQUEST["sb_image_file_6"];
	$strSB_IMAGE_FILE_7 	= $_POST["sb_image_file_7"]		? $_POST["sb_image_file_7"]			: $_REQUEST["sb_image_file_7"];
	$strSB_IMAGE_FILE_8	= $_POST["sb_image_file_8"]		? $_POST["sb_image_file_8"]			: $_REQUEST["sb_image_file_8"];
	$strSB_IMAGE_FILE_9 	= $_POST["sb_image_file_9"]		? $_POST["sb_image_file_9"]			: $_REQUEST["sb_image_file_9"];	
	$strSB_IMAGE_FILE_10 = $_POST["sb_image_file_10"]		? $_POST["sb_image_file_10"]			: $_REQUEST["sb_image_file_10"];

	$strSB_IMAGE_FILE_BAK[1] 		= $_POST["sb_image_file_1_bak"]		? $_POST["sb_image_file_1_bak"]			: $_REQUEST["sb_image_file_1_bak"];
	$strSB_IMAGE_FILE_BAK[2] 		= $_POST["sb_image_file_2_bak"]		? $_POST["sb_image_file_2_bak"]			: $_REQUEST["sb_image_file_2_bak"];
	$strSB_IMAGE_FILE_BAK[3] 		= $_POST["sb_image_file_3_bak"]		? $_POST["sb_image_file_3_bak"]			: $_REQUEST["sb_image_file_3_bak"];
	$strSB_IMAGE_FILE_BAK[4] 		= $_POST["sb_image_file_4_bak"]		? $_POST["sb_image_file_4_bak"]			: $_REQUEST["sb_image_file_4_bak"];
	$strSB_IMAGE_FILE_BAK[5]		= $_POST["sb_image_file_5_bak"]		? $_POST["sb_image_file_5_bak"]			: $_REQUEST["sb_image_file_5_bak"];
	$strSB_IMAGE_FILE_BAK[6] 		= $_POST["sb_image_file_6_bak"]		? $_POST["sb_image_file_6_bak"]			: $_REQUEST["sb_image_file_6_bak"];
	$strSB_IMAGE_FILE_BAK[7] 		= $_POST["sb_image_file_7_bak"]		? $_POST["sb_image_file_7_bak"]			: $_REQUEST["sb_image_file_7_bak"];
	$strSB_IMAGE_FILE_BAK[8]		= $_POST["sb_image_file_8_bak"]		? $_POST["sb_image_file_8_bak"]			: $_REQUEST["sb_image_file_8_bak"];
	$strSB_IMAGE_FILE_BAK[9] 		= $_POST["sb_image_file_9_bak"]		? $_POST["sb_image_file_9_bak"]			: $_REQUEST["sb_image_file_9_bak"];
	$strSB_IMAGE_FILE_BAK[10]	= $_POST["sb_image_file_10_bak"]		? $_POST["sb_image_file_10_bak"]			: $_REQUEST["sb_image_file_10_bak"];	
	
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
	$intSB_REG_DT		= $_POST["sb_reg_dt"]				? $_POST["sb_reg_dt"]			: $_REQUEST["sb_reg_dt"];
	$intSB_REG_NO		= $_POST["sb_reg_no"]				? $_POST["sb_reg_no"]			: $_REQUEST["sb_reg_no"];
	$intSB_MOD_DT		= $_POST["sb_mod_dt"]				? $_POST["sb_mod_dt"]			: $_REQUEST["sb_mod_dt"];
	$intSB_MOD_NO		= $_POST["sb_mod_no"]				? $_POST["sb_mod_no"]			: $_REQUEST["sb_mod_no"];




	/* 디자인 샘플관리 */	
	$strDM_DESIGN_PAGE		= $_POST["dm_design_page"]			? $_POST["dm_design_page"]			: $_REQUEST["dm_design_page"];
	$strDM_DESIGN_GROUP		= $_POST["dm_design_group"]			? $_POST["dm_design_group"]			: $_REQUEST["dm_design_group"];
	$strDM_DESIGN_TYPE		= $_POST["dm_design_type"]			? $_POST["dm_design_type"]			: $_REQUEST["dm_design_type"];
	$strDM_DESIGN_CODE		= $_POST["dm_design_code"]			? $_POST["dm_design_code"]			: $_REQUEST["dm_design_code"];
	$strDM_DESIGN_TITLE		= $_POST["dm_design_title"]			? $_POST["dm_design_title"]			: $_REQUEST["dm_design_title"];
	$strDM_DESIGN_TXT		= $_POST["dm_design_txt"]			? $_POST["dm_design_txt"]			: $_REQUEST["dm_design_txt"];
	$strDM_SAMPLE_LINK		= $_POST["dm_sample_link"]			? $_POST["dm_sample_link"]			: $_REQUEST["dm_sample_link"];
	$strDM_SAMPLE_IMAGE_1	= $_POST["dm_sample_image_1"]		? $_POST["dm_sample_image_1"]		: $_REQUEST["dm_sample_image_1"];
	$strDM_SAMPLE_IMAGE_2	= $_POST["dm_sample_image_2"]		? $_POST["dm_sample_image_2"]		: $_REQUEST["dm_sample_image_2"];
	$intDM_REG_DT			= $_POST["dm_reg_dt"]			? $_POST["dm_reg_dt"]			: $_REQUEST["dm_reg_dt"];
	$intDM_REG_NO			= $_POST["dm_reg_no"]			? $_POST["dm_reg_no"]			: $_REQUEST["dm_reg_no"];
	$intDM_MOD_DT			= $_POST["dm_mod_dt"]			? $_POST["dm_mod_dt"]			: $_REQUEST["dm_mod_dt"];
	$intDM_MOD_NO			= $_POST["dm_mod_no"]			? $_POST["dm_mod_no"]			: $_REQUEST["dm_mod_no"];


	/* 버튼이미지 관리 */
//	$strBI_GROUP			= $_POST["bi_group"]			? $_POST["bi_group"]				: $_REQUEST["bi_group"];
//	$strBI_IMAGE_CATE		= $_POST["bi_image_cate"]		? $_POST["bi_image_cate"]			: $_REQUEST["bi_image_cate"];
	$strBI_IMAGE_GUBUN		= $_POST["bi_image_gubun"]		? $_POST["bi_image_gubun"]			: $_REQUEST["bi_image_gubun"];
	$strBI_IMAGE_PAGE		= $_POST["bi_image_page"]		? $_POST["bi_image_page"]			: $_REQUEST["bi_image_page"];
	$strBI_IMAGE_DIR		= $_POST["bi_image_dir"]		? $_POST["bi_image_dir"]			: $_REQUEST["bi_image_dir"];
	$strBI_IMAGE_FILE_1		= $_POST["bi_image_file_1"]		? $_POST["bi_image_file_1"]			: $_REQUEST["bi_image_file_1"];
	$strBI_IMAGE_FILE_2		= $_POST["bi_image_file_2"]		? $_POST["bi_image_file_2"]			: $_REQUEST["bi_image_file_2"];
	$strBI_IMAGE_FILE_3		= $_POST["bi_image_file_3"]		? $_POST["bi_image_file_3"]			: $_REQUEST["bi_image_file_3"];
	$strBI_IMAGE_FILE_4		= $_POST["bi_image_file_4"]		? $_POST["bi_image_file_4"]			: $_REQUEST["bi_image_file_4"];
	$strBI_IMAGE_FILE_5		= $_POST["bi_image_file_5"]		? $_POST["bi_image_file_5"]			: $_REQUEST["bi_image_file_5"];
	$strBI_ATATCH_TYPE		= $_POST["bi_atatch_type"]		? $_POST["bi_atatch_type"]			: $_REQUEST["bi_atatch_type"];
	$intBI_IMAGE_W			= $_POST["bi_image_w"]			? $_POST["bi_image_w"]			: $_REQUEST["bi_image_w"];
	$intBI_IMAGE_H			= $_POST["bi_image_h"]			? $_POST["bi_image_h"]			: $_REQUEST["bi_image_h"];
	$intBI_REG_DT			= $_POST["bi_reg_dt"]			? $_POST["bi_reg_dt"]			: $_REQUEST["bi_reg_dt"];
	$intBI_REG_NO			= $_POST["bi_reg_no"]			? $_POST["bi_reg_no"]			: $_REQUEST["bi_reg_no"];
	$intBI_MOD_DT			= $_POST["bi_mod_dt"]			? $_POST["bi_mod_dt"]			: $_REQUEST["bi_mod_dt"];
	$intBI_MOD_NO			= $_POST["bi_mod_no"]			? $_POST["bi_mod_no"]			: $_REQUEST["bi_mod_no"];

/*##################################### Parameter 셋팅 ##################################################*/

	$strPV_USE			= ($strPV_USE == 'Y') ? $strPV_USE : 'N';
	$strPV_LIST_CATE	= ($strPV_LIST_CATE == 'Y') ? $strPV_LIST_CATE : 'N';

	/* (1) 디자인 레이아웃 설정(레이아웃설정, 첫화면 설정)*/
	$strDL_CODE = strTrim($strDL_CODE,10);
	$strDL_BG_TYPE = strTrim($strDL_BG_TYPE,2);
	$strDL_BG_COLOR = strTrim($strDL_BG_COLOR,20);
	$strDL_BG_IMAGE = strTrim($strDL_BG_IMAGE,50);
	$strDL_BG_IMG_DIR_H = strTrim($strDL_BG_IMG_DIR_H,30);
	$strDL_BG_IMG_DIR_V = strTrim($strDL_BG_IMG_DIR_V,30);
	$strDL_BG_REPEAT = strTrim($strDL_BG_REPEAT,2);
	$strDL_BG_ALIGN = strTrim($strDL_BG_ALIGN,10);
	$strDL_FIRST_PAGE = strTrim($strDL_FIRST_PAGE,1);
	$strDL_FIRST_USE = strTrim($strDL_FIRST_USE,1);

	/* 디자인 통합 작업 */
	$designMgr->setDL_NO($intDL_NO);
	$designMgr->setDL_CODE($strDL_CODE);
	$designMgr->setDL_DESIGN_CODE($strDL_DESIGN_CODE);
	$designMgr->setDL_BG_TYPE($strDL_BG_TYPE);
	$designMgr->setDL_BG_COLOR($strDL_BG_COLOR);
	$designMgr->setDL_BG_IMAGE($strDL_BG_IMAGE);
	$designMgr->setDL_BG_IMG_DIR_H($strDL_BG_IMG_DIR_H);
	$designMgr->setDL_BG_IMG_DIR_V($strDL_BG_IMG_DIR_V);
	$designMgr->setDL_BG_REPEAT($strDL_BG_REPEAT);
	$designMgr->setDL_BG_ALIGN($strDL_BG_ALIGN);
	$designMgr->setDL_FIRST_PAGE($strDL_FIRST_PAGE);
	$designMgr->setDL_FIRST_USE($strDL_FIRST_USE);
	$designMgr->setDL_REG_DT($intDL_REG_DT);
	$designMgr->setDL_REG_NO($intDL_REG_NO);
	$designMgr->setDL_MOD_DT($intDL_MOD_DT);
	$designMgr->setDL_MOD_NO($intDL_MOD_NO);
	
	// DESIGN_TOP_IMAGES
	$designMgr->setTI_NO($intTI_NO);
//	$designMgr->setTI_CATE_CODE($strTI_CATE_CODE);
	$designMgr->setTI_TOP_IMAGE($strTI_TOP_IMAGE);
	$designMgr->setTI_LEFT_IMAGE($strTI_LEFT_IMAGE);
	$designMgr->setTI_HTML_TOP($strTI_HTML_TOP);
	$designMgr->setTI_HTML_BOTTOM($strTI_HTML_BOTTOM);
	$designMgr->setTI_REG_DT($intTI_REG_DT);
	$designMgr->setTI_REG_NO($intTI_REG_NO);
	$designMgr->setTI_MOD_DT($intTI_MOD_DT);
	$designMgr->setTI_MOD_NO($intTI_MOD_NO);	
	/* 디자인 통합 작업 */




	$designlayoutMgr->setDL_NO($intDL_NO);
	$designlayoutMgr->setDL_CODE($strDL_CODE);
	$designlayoutMgr->setDL_DESIGN_CODE($strDL_DESIGN_CODE);
	$designlayoutMgr->setDL_BG_TYPE($strDL_BG_TYPE);
	$designlayoutMgr->setDL_BG_COLOR($strDL_BG_COLOR);
	$designlayoutMgr->setDL_BG_IMAGE($strDL_BG_IMAGE);
	$designlayoutMgr->setDL_BG_IMG_DIR_H($strDL_BG_IMG_DIR_H);
	$designlayoutMgr->setDL_BG_IMG_DIR_V($strDL_BG_IMG_DIR_V);
	$designlayoutMgr->setDL_BG_REPEAT($strDL_BG_REPEAT);
	$designlayoutMgr->setDL_BG_ALIGN($strDL_BG_ALIGN);
	$designlayoutMgr->setDL_FIRST_USE($strDL_FIRST_USE);
	$designlayoutMgr->setDL_REG_DT($intDL_REG_DT);
	$designlayoutMgr->setDL_REG_NO($intDL_REG_NO);
	$designlayoutMgr->setDL_MOD_DT($intDL_MOD_DT);
	$designlayoutMgr->setDL_MOD_NO($intDL_MOD_NO);


	
	/* 디자인 직접 편집 */
	$strDE_CODE = strTrim($strDE_CODE,10);
	$strDE_EDIT_GROUP = strTrim($strDE_EDIT_GROUP,20);
	$strDE_EDIT_SECTION = strTrim($strDE_EDIT_SECTION,20);
	$strDE_EDIT_TEXT = strTrim($strDE_EDIT_TEXT,65535);

	$maindesignMgr->setDE_NO($intDE_NO);
	$maindesignMgr->setDE_CODE($strDE_CODE);
	$maindesignMgr->setDE_EDIT_GROUP($strDE_EDIT_GROUP);
	$maindesignMgr->setDE_EDIT_SECTION($strDE_EDIT_SECTION);
	$maindesignMgr->setDE_EDIT_TEXT($strDE_EDIT_TEXT);
	$maindesignMgr->setDE_REG_DT($intDE_REG_DT);
	$maindesignMgr->setDE_REG_NO($intDE_REG_NO);
	$maindesignMgr->setDE_MOD_DT($intDE_MOD_DT);
	$maindesignMgr->setDE_MOD_NO($intDE_MOD_NO);


	
	/* 추가컨텐츠 */
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
	$contentMgr->setCP_REG_DT($intCP_REG_DT);
	$contentMgr->setCP_REG_NO($intCP_REG_NO);
	$contentMgr->setCP_MOD_DT($intCP_MOD_DT);
	$contentMgr->setCP_MOD_NO($intCP_MOD_NO);

	/* 상품페이지 설정 */
	$strPV_PAGE = strTrim($strPV_PAGE,10);
	$strPV_MODUL_TYPE = strTrim($strPV_MODUL_TYPE,20);
	$strPV_MODUL_NAME = strTrim($strPV_MODUL_NAME,50);
	$strPV_IMAGE_FILE = strTrim($strPV_IMAGE_FILE,30);
	$strPV_MODUL_TEXT = strTrim($strPV_MODUL_TEXT,65535);
	$strPV_LIST_CATE = strTrim($strPV_LIST_CATE,1);
	$strPV_LIST_USE = strTrim($strPV_USE,1);

	$prodpageMgr->setPV_NO($intPV_NO);
	$prodpageMgr->setPV_CODE($strPV_CODE);
	$prodpageMgr->setPV_PAGE($strPV_PAGE);
	$prodpageMgr->setPV_MODUL_TYPE($strPV_MODUL_TYPE);
	$prodpageMgr->setPV_DESIGN_NO($intPV_DESIGN_NO);
	$prodpageMgr->setPV_MODUL_NAME($strPV_MODUL_NAME);
	$prodpageMgr->setPV_IMAGE_FILE($strPV_IMAGE_FILE);
	$prodpageMgr->setPV_IMAGE_SIZE_W($intPV_IMAGE_SIZE_W);
	$prodpageMgr->setPV_IMAGE_SIZE_H($intPV_IMAGE_SIZE_H);
	$prodpageMgr->setPV_IMAGE_CNT_W($intPV_IMAGE_CNT_W);
	$prodpageMgr->setPV_IMAGE_CNT_H($intPV_IMAGE_CNT_H);
	$prodpageMgr->setPV_MODUL_TEXT($strPV_MODUL_TEXT);
	$prodpageMgr->setPV_LIST_CATE($strPV_LIST_CATE);
	$prodpageMgr->setPV_VIEW_FUNCTION($intPV_VIEW_FUNCTION);
	$prodpageMgr->setPV_USE($strPV_USE);
	$prodpageMgr->setPV_ORDER($intPV_ORDER);
	$prodpageMgr->setPV_REG_DT($intPV_REG_DT);
	$prodpageMgr->setPV_REG_NO($intPV_REG_NO);
	$prodpageMgr->setPV_MOD_DT($intPV_MOD_DT);
	$prodpageMgr->setPV_MOD_NO($intPV_MOD_NO);

	/* 슬라이딩 배너 */
	$strSB_GROUP = strTrim($strSB_GROUP,10);
	$strSB_BANNER_NAME = strTrim($strSB_BANNER_NAME,50);
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
	$designMgr->setSB_REG_DT($intSB_REG_DT);
	$designMgr->setSB_REG_NO($intSB_REG_NO);
	$designMgr->setSB_MOD_DT($intSB_MOD_DT);
	$designMgr->setSB_MOD_NO($intSB_MOD_NO);

	/* 서브탑 이미지 관리 */
	$strTI_CATE_CODE = strTrim($strTI_CATE_CODE,20);
	$strTI_TOP_IMAGE = strTrim($strTI_TOP_IMAGE,50);
	$strTI_LEFT_IMAGE = strTrim($strTI_LEFT_IMAGE,50);
//	$strTI_HTML_TOP = strTrim($strTI_HTML_TOP,65535);
//	$strTI_HTML_BOTTOM = strTrim($strTI_HTML_BOTTOM,65535);

	$subtopMgr->setTI_NO($intTI_NO);
	$subtopMgr->setTI_CATE_CODE($strTI_CATE_CODE);
	$subtopMgr->setTI_TOP_IMAGE($strTI_TOP_IMAGE);
	$subtopMgr->setTI_LEFT_IMAGE($strTI_LEFT_IMAGE);
	$subtopMgr->setTI_HTML_TOP($strTI_HTML_TOP);
	$subtopMgr->setTI_HTML_BOTTOM($strTI_HTML_BOTTOM);
	$subtopMgr->setTI_REG_DT($intTI_REG_DT);
	$subtopMgr->setTI_REG_NO($intTI_REG_NO);
	$subtopMgr->setTI_MOD_DT($intTI_MOD_DT);
	$subtopMgr->setTI_MOD_NO($intTI_MOD_NO);

	/* 디자인 샘플 관리 */
	$strDM_DESIGN_PAGE = strTrim($strDM_DESIGN_PAGE,20);
	$strDM_DESIGN_GROUP = strTrim($strDM_DESIGN_GROUP,20);
	$strDM_DESIGN_TYPE = strTrim($strDM_DESIGN_TYPE,2);
	$strDM_DESIGN_CODE = strTrim($strDM_DESIGN_CODE,10);
	$strDM_DESIGN_TITLE = strTrim($strDM_DESIGN_TITLE,50);
	$strDM_DESIGN_TXT = strTrim($strDM_DESIGN_TXT,65535);
	$strDM_SAMPLE_LINK = strTrim($strDM_SAMPLE_LINK,50);
	$strDM_SAMPLE_IMAGE_1 = strTrim($strDM_SAMPLE_IMAGE_1,50);
	$strDM_SAMPLE_IMAGE_2 = strTrim($strDM_SAMPLE_IMAGE_2,50);


	$designsampleMgr->setDM_NO($intDM_NO);
	$designsampleMgr->setDM_DESIGN_PAGE($strDM_DESIGN_PAGE);
	$designsampleMgr->setDM_DESIGN_GROUP($strDM_DESIGN_GROUP);
	$designsampleMgr->setDM_DESIGN_TYPE($strDM_DESIGN_TYPE);
	$designsampleMgr->setDM_DESIGN_CODE($strDM_DESIGN_CODE);
	$designsampleMgr->setDM_DESIGN_TITLE($strDM_DESIGN_TITLE);
	$designsampleMgr->setDM_DESIGN_TXT($strDM_DESIGN_TXT);
	$designsampleMgr->setDM_SAMPLE_LINK($strDM_SAMPLE_LINK);
	$designsampleMgr->setDM_SAMPLE_IMAGE_1($strDM_SAMPLE_IMAGE_1);
	$designsampleMgr->setDM_SAMPLE_IMAGE_2($strDM_SAMPLE_IMAGE_2);
	$designsampleMgr->setDM_REG_DT($intDM_REG_DT);
	$designsampleMgr->setDM_REG_NO($intDM_REG_NO);
	$designsampleMgr->setDM_MOD_DT($intDM_MOD_DT);
	$designsampleMgr->setDM_MOD_NO($intDM_MOD_NO);


	/* 버튼 이미지 관리 */
	$strBI_GROUP = strTrim($strBI_GROUP,10);
//	$strBI_IMAGE_CATE = strTrim($strBI_IMAGE_CATE,10);
	$strBI_IMAGE_GUBUN = strTrim($strBI_IMAGE_GUBUN,10);
	$strBI_IMAGE_PAGE = strTrim($strBI_IMAGE_PAGE,10);
	$strBI_IMAGE_DIR = strTrim($strBI_IMAGE_DIR,50);
	$strBI_IMAGE_FILE_1 = strTrim($strBI_IMAGE_FILE_1,50);
	$strBI_IMAGE_FILE_2 = strTrim($strBI_IMAGE_FILE_2,50);
	$strBI_IMAGE_FILE_3 = strTrim($strBI_IMAGE_FILE_3,50);
	$strBI_IMAGE_FILE_4 = strTrim($strBI_IMAGE_FILE_4,50);
	$strBI_IMAGE_FILE_5 = strTrim($strBI_IMAGE_FILE_5,50);
	$strBI_ATATCH_TYPE = strTrim($strBI_ATATCH_TYPE,1);

	$designMgr->setBI_NO($intBI_NO);
	$designMgr->setBI_GROUP($strBI_GROUP);
//	$designMgr->setBI_IMAGE_CATE($strBI_IMAGE_CATE);
	$designMgr->setBI_IMAGE_GUBUN($strBI_IMAGE_GUBUN);
	$designMgr->setBI_IMAGE_PAGE($strBI_IMAGE_PAGE);
	$designMgr->setBI_IMAGE_DIR($strBI_IMAGE_DIR);
	$designMgr->setBI_IMAGE_FILE_1($strBI_IMAGE_FILE_1);
	$designMgr->setBI_IMAGE_FILE_2($strBI_IMAGE_FILE_2);
	$designMgr->setBI_IMAGE_FILE_3($strBI_IMAGE_FILE_3);
	$designMgr->setBI_IMAGE_FILE_4($strBI_IMAGE_FILE_4);
	$designMgr->setBI_IMAGE_FILE_5($strBI_IMAGE_FILE_5);
	$designMgr->setBI_ATATCH_TYPE($strBI_ATATCH_TYPE);
	$designMgr->setBI_IMAGE_W($intBI_IMAGE_W);
	$designMgr->setBI_IMAGE_H($intBI_IMAGE_H);
	$designMgr->setBI_REG_DT($intBI_REG_DT);
	$designMgr->setBI_REG_NO($intBI_REG_NO);
	$designMgr->setBI_MOD_DT($intBI_MOD_DT);
	$designMgr->setBI_MOD_NO($intBI_MOD_NO);


	switch ($strAct) {	
		case "logoModify":
			// 디자인관리 / 레이아웃 / 이미지관리 => 설정 저장 버튼 클릭시
			
			imageFileUpLoad("bi_image_file_1_new", "subbtnimg", $strBI_IMAGE_FILE_1_NEW);
			imageFileUpLoad("bi_image_file_2_new", "subbtnimg", $strBI_IMAGE_FILE_2_NEW);
			
			/* conf / shop.inc.php 정보 생성 */
			$i 			= 0;
			$aryData 	= null;
			if($strBI_IMAGE_FILE_1_NEW) :
				$designMgr->setBI_IMAGE_FILE_1($strBI_IMAGE_FILE_1_NEW);
				$aryData[$i]['key']			= "\$D_WEB_LOGO_PATH";
				$aryData[$i]['data'] 		= sprintf( "\"./upload/subbtnimg/%s\"", $strBI_IMAGE_FILE_1_NEW  );
				$i++;
			endif;

			if ( $strBI_ATATCH_TYPE ) :
				$aryData[$i]['key']			= "\$D_WEB_LOGO_TYPE";
				$aryData[$i]['data'] 		= sprintf( "\"%s\"", $strBI_ATATCH_TYPE );
				$i++;
			endif;

			if($strBI_IMAGE_FILE_2_NEW) :
				$designMgr->setBI_IMAGE_FILE_2($strBI_IMAGE_FILE_2_NEW);
				$aryData[$i]['key']			= "\$D_MOB_LOGO_PATH";
				$aryData[$i]['data'] 		= sprintf( "\"./upload/subbtnimg/%s\"", $strBI_IMAGE_FILE_2_NEW  );
				$i++;
			endif;
			
			shopConfigFileUpdate ( $aryData );
			/* conf / shop.inc.php 정보 생성 */

			$designMgr->getDesignBtnImageUpdate($db);
			
			$strMsg="설정 되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=logoModify&bi_no=".$intBI_NO."&page=".$intPage.$strLinkPage;
		break;
		
		case "designlayoutModify":				
			// 디자인 관리 / 레이아웃 설정
			
			$htmlFile		= sprintf( "%s%s/layout/html/%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $strLayoutPage, $strEditPage );
			$htmlTrans		= sprintf( "%s%s/layout/html/trans_%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $strLayoutPage, $strEditPage );
			
			$layoutDir		= sprintf( "%swww/html/%s%s", $S_DOCUMENT_ROOT, $strDL_CODE, $strDL_DESIGN_CODE);

			changeLayoutFile($layoutDir);
			

			/* conf / shop.inc.php 정보 생성 */
			$aryData[0]['key'] = "\$D_LAYOUT";
			$aryData[0]['data'] = sprintf( "\"%s\"", $strDL_CODE );
			$aryData[1]['key'] = "\$D_SKIN";
			$aryData[1]['data'] = sprintf( "\"%s\"", $strDL_DESIGN_CODE );
				
			shopConfigFileUpdate ( $aryData );
			/* conf / shop.inc.php 정보 생성 */
			
			$designMgr->getDesignLayoutCodeUpdate($db);
			$strMsg="설정 되었습니다.";		
			$strUrl = "./?menuType=".$strMenuType."&mode=designlayoutModify&cp_no=".$intCP_NO."&page=".$intPage.$strLinkPage;
		break;
		case "designfirstModify":
			// 디자인관리 / 첫화면 설정

			if ($_FILES["dl_bg_image"][name]) 
			{
				if (!getAllowImgFileExt($_FILES["dl_bg_image"][name], "Y")){
					goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
					exit;
				}

				$filename		= $_FILES["dl_bg_image"][name];
				$tmpname		= $_FILES["dl_bg_image"][tmp_name];
				$filesize			= $_FILES["dl_bg_image"][size];
				$filetype		= $_FILES["dl_bg_image"][type];

				$number		= date("YmdHis");		//파일명 숫자로 변경			
				$fres				= $fh->doUpload("$number","../upload/layout",$filename,$tmpname,$filesize,$filetype);

				if($fres) {
					$designMgr->setDL_BG_IMAGE($fres[file_real_name]);
					$designMgr->getDesignLayoutUpdate($db);
					makeDesignFirstFile();

					if ($strDL_BG_IMAGE){
						$fh->fileDelete("../upload/layout/".$strDL_BG_IMAGE);
					}
					$strMsg="설정 되었습니다.";	
				}else {
					$strMsg="업데이트 실패.";	
				}
			}else{

//				makeDesignFirstFile();
//				$designfirstMgr->setDL_NO($intDL_NO);
//				$designfirstMgr->setDL_BG_IMAGE($row[DL_BG_IMAGE]);
				if( $strDL_BG_IMAGE ) {
					$designMgr->setDL_BG_IMAGE($strDL_BG_IMAGE);
				}
				$designMgr->getDesignLayoutUpdate($db);
				makeDesignFirstFile();
				$strMsg="설정 되었습니다.";	
			}
			
			/* conf / shop.inc.php 정보 변경 (관련 내용이 없다면 내용 생성) */
			// $S_DESIGN_BACKGROUND 		ex ) "#ffffff url(\"/home/shop/treenme/upload/layout/20120917102849.gif\") left top repeat";
			// $S_DESIGN_ALIGN 				ex )  "center";
			// $S_DESIGN_INTRO 				ex ) "M";
			// $S_DESIGN_AUTO 				ex ) "Y";
			
			$strBackground = "\"";
			if ( $strDL_BG_COLOR ) :
				$strBackground = sprintf ( "%s#%s" ,$strBackground ,$strDL_BG_COLOR );
			endif;

			if ( $strDL_BG_IMAGE ) :
				$strBackground = sprintf ( "%s url(\\\"%s%s/upload/layout/%s\\\")" , $strBackground, $S_DOCUMENT_ROOT, $S_SHOP_HOME, $strDL_BG_IMAGE );
			
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
			
			$strBackground .= "\"";
			$aryData[0]['key'] = "\$S_DESIGN_BACKGROUND";
			$aryData[0]['data'] = $strBackground;
			$aryData[1]['key'] = "\$S_DESIGN_ALIGN";
			$aryData[1]['data'] = sprintf( "\"%s\"", $strDL_BG_ALIGN );
			$aryData[2]['key'] = "\$S_DESIGN_INTRO";
			$aryData[2]['data'] = sprintf( "\"%s\"", $strDL_FIRST_PAGE );
			$aryData[3]['key'] = "\$S_DESIGN_AUTO";
			$aryData[3]['data'] = sprintf( "\"%s\"", $strDL_FIRST_USE );

			shopConfigFileUpdate ( $aryData );
			/* conf / shop.inc.php 정보 생성 */
					
			$strUrl = "./?menuType=".$strMenuType."&mode=designfirstModify&cp_no=".$intDL_NO."&page=".$intPage.$strLinkPage;
		break;

		// 디자인 직접편집
		case "maindesignModify":	
			
//			if ( $strLayoutView != "edit" ) :
//				goErrMsg("저장 권한이 없습니다.");
//				exit;	
//			endif;
			
			$htmlFile				= sprintf( "%s%s/layout/html/%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $strLayoutPage, $strEditPage );
			$htmlFileTag		= sprintf( "%s%s/layout/html/tag_%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $strLayoutPage, $strEditPage );
			
			updateHtmlFile($htmlFileTag, $strDE_EDIT_TEXT);			
			changeLayoutData( $strDE_EDIT_TEXT, $strLayoutData);
			updateHtmlFile($htmlFile, $strLayoutData);
		
//			$maindesignMgr->getMaindesignUpdate($db);
			$strMsg="설정 되었습니다.";		
			$strUrl = "./?menuType=$strMenuType&mode=maindesignModify&layoutPage=$strLayoutPage&editPage=$strEditPage&layoutView=$strLayoutView&de_no=1&page=$intPage.$strLinkPage";
		break;

		
		// 컨텐츠 추가페이지 
		case "contentWrite":
			$contentMgr->getContentInsert($db);
			$strMsg="추가 페이지를 등록하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=contentList&".$strLinkPage;
		break;

		case "contentModify":		
			$contentMgr->getContentUpdate($db);
			$strMsg="페이지가 수정 되었습니다.";		

			$strUrl = "./?menuType=".$strMenuType."&mode=contentModify&cp_no=".$intCP_NO."&page=".$intPage.$strLinkPage;
		break;
		
		case "contentDelete":
			$contentMgr->getContentDelete($db);			
			$strMsg="페이지가 삭제 되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=contentList&page=".$intPage.$strLinkPage;
		break;

		// 메인,목록,상세페이지 구성요서 정의
		case "prodpageWrite":	
			makeProductPageFile();
			$prodpageMgr->getProdpageInsert($db);
			$strMsg = "설정값을 등록하였습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodpageList&".$strLinkPage;
		break;

		case "prodpageModify":
			// 디자인관리 / 레이아웃 / 상품진열방식 / 관리 / 설정 저장 버튼 클릭시...
	


			/* conf / shop.inc.php 정보 생성 */
			if ( $strPV_PAGE == "main" || $strPV_PAGE == "subpage" ) :
				$aryData[0]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['W_SIZE']";
				$aryData[0]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_SIZE_W );
				$aryData[1]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['H_SIZE']";
				$aryData[1]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_SIZE_H );
				$aryData[2]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['W_LIST']";
				$aryData[2]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_CNT_W );
				$aryData[3]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['H_LIST']";
				$aryData[3]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_CNT_H );
				$aryData[4]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['D_TYPE']";
				$aryData[4]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_TYPE );
				$aryData[5]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['D_CODE']";
				$aryData[5]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_CODE );
			else :
				$aryData[0]['key'] = "\$D_PRODUCT_OP['" . $strPV_PAGE . "']['W_SIZE']";
				$aryData[0]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_SIZE_W );
				$aryData[1]['key'] = "\$D_PRODUCT_OP['" . $strPV_PAGE . "']['H_SIZE']";
				$aryData[1]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_SIZE_H );
				$aryData[2]['key'] = "\$D_PRODUCT_OP['" . $strPV_PAGE . "']['W_LIST']";
				$aryData[2]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_CNT_W );
				$aryData[3]['key'] = "\$D_PRODUCT_OP['" . $strPV_PAGE . "']['H_LIST']";
				$aryData[3]['data'] = sprintf( "\"%d\"", $intPV_IMAGE_CNT_H );		
				$aryData[4]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['D_TYPE']";
				$aryData[4]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_TYPE );
				$aryData[5]['key'] = "\$D_PRODUCT_OP['{{__" . $strPV_PAGE . "_" . $strPV_MODUL_TYPE . "__}}']['D_CODE']";
				$aryData[5]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_CODE );
			endif;
				
			shopConfigFileUpdate ( $aryData );
			/* conf / shop.inc.php 정보 생성 */


			$prodpageMgr->getProdpageUpdate($db);
			$strMsg = "설정값을 수정 되었습니다.";		
			$strUrl = "./?menuType=".$strMenuType."&mode=prodpageList&cp_no=".$intPV_NO."&page=".$intPage.$strLinkPage."&pv_page=".$strPV_PAGE;

		break;

		case "prodpageMake":	//설정파일 만들기			
			makeProductPageFile();
			$strMsg = "페이지 설정값을 적용하였습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodpageList&".$strLinkPage;
		break;
		
		// 슬라이딩 배너
		case "sliderbannerWrite":	

			/* 이미지 파일 채크 */
			for( $i=1; $i<=10; $i++ ) : 	
				$strFileNameKey 		= sprintf( "sb_image_file_%d", $i );
				if ($_FILES[$strFileNameKey][name] ) :
					if(!getAllowImgFileExt($_FILES[$strFileNameKey][name], "Y")) :
						goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
						exit;
					endif;
				endif;
			endfor;
			
			/* 이미지 다운로드 */
			for( $i=1; $i<=10; $i++ ) :
				$strFileNameKey 		= sprintf( "sb_image_file_%d", $i );
				if ($_FILES[$strFileNameKey][name]) :
					$filename 		= $_FILES[$strFileNameKey][name];
					$tmpname  	= $_FILES[$strFileNameKey][tmp_name];
					$filesize 		= $_FILES[$strFileNameKey][size];
					$filetype 		= $_FILES[$strFileNameKey][type];
					$number 		= date("YmdHis");
					$path			= "../upload/slider";
					$fres 			= $fh->doUpload("$number", $path, $filename, $tmpname, $filesize, $filetype);
					if($fres) :
						$sbImageFile[] 	= $fres[file_real_name];
					endif;
				endif;
			endfor;
			
			/* 데이터 베이스에 기록 */
			$i = 1;
			foreach( $sbImageFile as $file ) :
				$funcName = sprintf ( "setSB_IMAGE_FILE_%d", $i );
				call_user_func( array( $designMgr, $funcName ), $file);
				$i++;
			endforeach;
			
			// 이미지 개수 
			$designMgr->setSB_IMAGES_CNT( sizeof( $sbImageFile ) );

			// 데이터 베이스 Insert
			$designMgr->getSliderInsert($db);
			/* 데이터 베이스에 기록 */		
				
			/* conf / shop.inc.php 정보 생성 */
			$aryData[0]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['W_SIZE']";
			$aryData[0]['data'] = sprintf( "\"%s\"", $intSB_IMAGE_W );
			$aryData[1]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['H_SIZE']";
			$aryData[1]['data'] = sprintf( "\"%s\"", $intSB_IMAGE_H );
			$aryData[2]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['D_TYPE']";
			$aryData[2]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_TYPE );
			$aryData[3]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['D_CODE']";
			$aryData[3]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_CODE );
				
			shopConfigFileUpdate ( $aryData );
			/* conf / shop.inc.php 정보 생성 */
			
			$strUrl = "./?menuType=".$strMenuType."&mode=sliderbannerList&".$strLinkPage;
		break;

		case "sliderbannerModify":
			// 디자인관리 / 레이아웃 / 움직이는 배너
			
			
			/* 이미지 파일 채크 */
			for( $i=1; $i<=10; $i++ ) :
				$strFileNameKey 		= sprintf( "sb_image_file_%d", $i );
				if ($_FILES[$strFileNameKey][name] ) :
					if(!getAllowImgFileExt($_FILES[$strFileNameKey][name], "Y")) :
						goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
						exit;
					endif;
				endif;
			endfor;
						
			/* 이미지 업로드 */
			$sbImageFile = null;
			for( $i=1; $i<=10; $i++ ) :
				$sbImageFile			= null;
				$strFileNameKey 		= sprintf( "sb_image_file_%d", $i );
				if ( imageFileUpLoad( $strFileNameKey, "slider", $sbImageFile ) == 1 ) :
					// 데이터 베이스에 기록
					$funcName = sprintf ( "setSB_IMAGE_FILE_%d", $i );
					call_user_func( array( $designMgr, $funcName ), $sbImageFile );
					// 기존에 파일이 있다면, 삭제
					if ( $strSB_IMAGE_FILE_BAK[$i] ) :
						$strDelPath = WEB_UPLOAD_PATH . "/slider/" . $strSB_IMAGE_FILE_BAK[$i];
						unlink($strDelPath);
					endif;
				endif;
				
				// 신규 이미지 파일이 없으므로, 백업 이미지가 존재한다면, 그대로 가지고 있는다.
				if ( !$sbImageFile ) :
					// 데이터 베이스에 기록
					$funcName = sprintf ( "setSB_IMAGE_FILE_%d", $i );
					call_user_func( array( $designMgr, $funcName ), $strSB_IMAGE_FILE_BAK[$i] );
				endif;				
			endfor;	
			
			$designMgr->getSliderUpdate($db);

			/* conf / shop.inc.php 정보 생성 */
			$aryData[0]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['W_SIZE']";
			$aryData[0]['data'] = sprintf( "\"%s\"", $intSB_IMAGE_W );
			$aryData[1]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['H_SIZE']";
			$aryData[1]['data'] = sprintf( "\"%s\"", $intSB_IMAGE_H );
			$aryData[2]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['D_TYPE']";
			$aryData[2]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_TYPE );
			$aryData[3]['key'] = "\$D_PRODUCT_OP['{{__" . $strSB_BANNER_NAME . "__}}']['D_CODE']";
			$aryData[3]['data'] = sprintf( "\"%s\"", $strDM_DESIGN_CODE );
				
			shopConfigFileUpdate ( $aryData );
			/* conf / shop.inc.php 정보 생성 */

			
			$strMsg = "슬라이딩 배너를 수정 하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=sliderbannerList&cp_no=".$intSB_NO."&page=".$intPage.$strLinkPage;
		break;

		case "sliderbannerDelete":

			/* 파일 삭제 */
			$row = $designMgr->getSliderView($db);
			for ( $i=1; $i<=10; $i++ ) :
				$strImageFileName = sprintf( "SB_IMAGE_FILE_%d", $i );
				if ( $row[$strImageFileName] ) :
					$strDeletefile 	= sprintf( "%s/slider/%s", WEB_UPLOAD_PATH, $row[$strImageFileName] );
					$fh->fileDelete($strDeletefile);
				endif;
			endfor;
			/* 파일 삭제 */

			$designMgr->getSliderDelete($db);			
			$strMsg="슬라이딩 배너를 삭제 하였습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=sliderbannerList&page=".$intPage.$strLinkPage;
		break;

		case "sliderbannerMake":	//슬라이더 설정파일 만들기			
			makeSliderBannerFile();
			$strMsg = "슬라이드 배너를 만들었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=sliderbannerList&".$strLinkPage;
		break;


		case "subtopWrite":		
		// 디자인관리 / 레이아웃 / 서브탑이미지 / 글 등록

			// 카테고리
			$strP_CATE			= $strC_HCODE1;
			if ($strC_HCODE2) $strP_CATE .= $strC_HCODE2;
			else $strP_CATE .= "000";
				
			if ($strC_HCODE3) $strP_CATE .= $strC_HCODE3;
			else $strP_CATE .= "000";
				
			if ($strC_HCODE4) $strP_CATE .= $strC_HCODE4;
			else $strP_CATE .= "000";
				
			$designMgr->setTI_CATE_CODE($strP_CATE);
			// 카테고리
		
			if ($_FILES["ti_top_image"][name]) :
				if(!getAllowImgFileExt($_FILES["ti_top_image"][name], "Y")) :
					goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
					exit;
				endif;
				
				$filename 		= $_FILES["ti_top_image"][name];
				$tmpname  	= $_FILES["ti_top_image"][tmp_name];
				$filesize 		= $_FILES["ti_top_image"][size];
				$filetype 		= $_FILES["ti_top_image"][type];
				$number 		= date("YmdHis");
				$path			= "../upload/subtopimg";
				$extension 		= substr(strrchr($filename, "."), 1);																	// 확장자
				$file_real_name = $strC_HCODE1 . $strC_HCODE2 . $strC_HCODE3 . $strC_HCODE4;					 	// 파일명
				$file_real_name	= $file_real_name == "" ? "product" : $file_real_name;
				$fres 			= $fh->doUpload("$number", $path, $filename, $tmpname, $filesize, $filetype, $file_real_name . "." . $extension);
				if($fres) :
					$designMgr->setTI_TOP_IMAGE($fres[file_real_name]);
				endif;
			endif;
			
			if ($_FILES["ti_left_image"][name]) :
				if(!getAllowImgFileExt($_FILES["ti_left_image"][name], "Y")) :
					goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
					exit;
				endif;
				
				$filename 		= $_FILES["ti_left_image"][name];
				$tmpname  	= $_FILES["ti_left_image"][tmp_name];
				$filesize 		= $_FILES["ti_left_image"][size];
				$filetype 		= $_FILES["ti_left_image"][type];
				$number 		= date("YmdHis");
				$path			= "../upload/subtopimg";
				$extension 		= substr(strrchr($filename, "."), 1);														// 확장자
				$file_real_name = $strC_HCODE1 . $strC_HCODE2 . $strC_HCODE3 . $strC_HCODE4;					 	// 파일명
				$file_real_name	= $file_real_name == "" ? "product" : $file_real_name;
				$fres 			= $fh->doUpload("$number", $path, $filename, $tmpname, $filesize, $filetype, $file_real_name . "." . $extension);
				if($fres) :
					$designMgr->setTI_LEFT_IMAGE($fres[file_real_name]);
				endif;
			endif;

			$intTopImageTotal =  $designMgr->getDesignTopImagetotal($db);

			if ( $intTopImageTotal <= 0 ) :
				$designMgr->getDesignTopImageInsert($db);
				$strMsg = "서브탑 이미지가 등록되었습니다..";
			else :
				$designMgr->getDesignTopImageUpdate($db);
				$strMsg = "기존에 등록된 정보가 있습니다. 데이터를 업데이트 하였습니다.";
			endif;
						
			
			$strUrl = "./?menuType=".$strMenuType."&mode=subtopList&".$strLinkPage;
		break;

		case "subtopModify":

			if ($_FILES["ti_top_image"][name]) :
				if(!getAllowImgFileExt($_FILES["ti_top_image"][name], "Y")) :
					goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
					exit;
				endif;
				
				$filename 		= $_FILES["ti_top_image"][name];
				$tmpname  	= $_FILES["ti_top_image"][tmp_name];
				$filesize 		= $_FILES["ti_top_image"][size];
				$filetype 		= $_FILES["ti_top_image"][type];
				$number 		= date("YmdHis");
				$path			= "../upload/subtopimg";
				$fres 			= $fh->doUpload("$number", $path, $filename, $tmpname, $filesize, $filetype);
				if($fres) :
					$designMgr->setTI_TOP_IMAGE($fres[file_real_name]);
					if($strTI_TOP_IMAGE) :
						$strDelPath = WEB_UPLOAD_PATH . "/subtopimg/" . $strTI_TOP_IMAGE;
						unlink($strDelPath);
					endif;
				endif;
			endif;
			
			if ($_FILES["ti_left_image"][name]) :
				if(!getAllowImgFileExt($_FILES["ti_left_image"][name], "Y")) :
					goErrMsg("첨부하신 파일은 확장자가 금지된 파일입니다.");
					exit;
				endif;
				
				$filename 		= $_FILES["ti_left_image"][name];
				$tmpname  	= $_FILES["ti_left_image"][tmp_name];
				$filesize 		= $_FILES["ti_left_image"][size];
				$filetype 		= $_FILES["ti_left_image"][type];
				$number 		= date("YmdHis");
				$path			= "../upload/subtopimg";
				$fres 			= $fh->doUpload("$number", $path, $filename, $tmpname, $filesize, $filetype);
				if($fres) :
					$designMgr->setTI_LEFT_IMAGE($fres[file_real_name]);
					if($strTI_LEFT_IMAGE) :
						$strDelPath = WEB_UPLOAD_PATH . "/subtopimg/" . $strTI_LEFT_IMAGE;
						unlink($strDelPath);
					endif;				
				endif;
			endif;

			// 카테고리
			$strP_CATE			= $strC_HCODE1;
			if ($strC_HCODE2) $strP_CATE .= $strC_HCODE2;
			else $strP_CATE .= "000";
				
			if ($strC_HCODE3) $strP_CATE .= $strC_HCODE3;
			else $strP_CATE .= "000";
				
			if ($strC_HCODE4) $strP_CATE .= $strC_HCODE4;
			else $strP_CATE .= "000";
				
			$designMgr->setTI_CATE_CODE($strP_CATE);
			// 카테고리
			
			$designMgr->getDesignTopImageUpdate($db);	
			$strMsg = "설정값을 수정 되었습니다.";		
			$strUrl = "./?menuType=".$strMenuType."&mode=subtopModify&ti_no=".$intTI_NO;
		break;

		case "subtopMake":
		//설정파일 만들기			
			makeSubtopFile();
			$strMsg = "페이지 설정값을 적용하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=subtopeList&".$strLinkPage;
		break;
		case "subtopDelete":
		// 디자인관리 / 레이아웃 / 서브탑이미지 / 글 삭제
			$row 	= $designMgr->getDesignTopImageView($db);
			$del 	= $designMgr->getDesignTopImageDelete($db);

			if($del == 1):
				/* 업로드 파일 삭제*/
				$strTI_TOP_IMAGE 		= $row['TI_TOP_IMAGE'];
				$strTI_LEFT_IMAGE 		= $row['TI_LEFT_IMAGE'];
				
				if($strTI_TOP_IMAGE) :
					$strDelPath = WEB_UPLOAD_PATH . "/subtopimg/" . $strTI_TOP_IMAGE;
					unlink($strDelPath);
				endif;
				if($strTI_LEFT_IMAGE) :
					$strDelPath = WEB_UPLOAD_PATH . "/subtopimg/" . $strTI_LEFT_IMAGE;
					unlink($strDelPath);
				endif;
				$strMsg = "등록된 정보를 삭제 하였습니다..";
			else:
				$strMsg = "삭제 실패!! 담당자에게 문의주세요..";
			endif;	
			$strUrl = "./?menuType=".$strMenuType."&mode=subtopList&".$strLinkPage;
		break;

		// 디자인 샘플 만들기
		case "designsampleWrite":	
			$designsampleMgr->getDesignsampleInsert($db);
			$strMsg="추가 페이지를 등록하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=designsampleList&".$strLinkPage;
		break;
		
		case "imgStyle2Write":
			
			imageFileUpLoad("bi_image_file_1_new", "designbtnimg", $strBI_IMAGE_FILE_1_NEW);
			
			if($strBI_IMAGE_FILE_1_NEW) :
				$designMgr->setBI_IMAGE_FILE_1($strBI_IMAGE_FILE_1_NEW);
			endif;
			
			$designMgr->getDesignBtnImageInsert($db);

			$strMsg="등록 되었습니다.";		
			$strUrl = "./?menuType=".$strMenuType."&mode=imgstyle2&bi_image_cate=" . $strBI_IMAGE_CATE . "&bi_group=" . $strBI_GROUP . "&page=" . $intPage.$strLinkPage;
//			echo $strBI_GROUP;
		break;
		
		case "imgStyle2Update":
			imageFileUpLoad("bi_image_file_1_new", "designbtnimg", $strBI_IMAGE_FILE_1_NEW);
			if($strBI_IMAGE_FILE_1_NEW) :
				$designMgr->setBI_IMAGE_FILE_1($strBI_IMAGE_FILE_1_NEW);
				$strDelPath = WEB_UPLOAD_PATH . "/designbtnimg/" . $strBI_IMAGE_FILE_1;
				unlink($strDelPath);
			endif;

			$designMgr->getDesignBtnImageUpdate($db);

			$strMsg="수정 되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=imgStyle2Modify&bi_no=" . $intBI_NO . "&bi_image_cate=" . $strBI_IMAGE_CATE . "&bi_group=" . $strBI_GROUP . "&page=" . $intPage.$strLinkPage;
		break;
		
		case "imgStyle2Delete":
			// 디자인관리 / 이미지관리 / 커뮤니티 => 삭제 버튼 클릭시
			$row 	= $designMgr->getDesignBtnImagesView($db);
			$del 	= $designMgr->getDesignBtnImagesDelete($db);
			if($del == 1) :
				/* 업로드 파일 삭제*/
				$strBI_IMAGE_FILE_1 = $row['BI_IMAGE_FILE_1'];
				if($strBI_IMAGE_FILE_1) :
					$strDelPath = WEB_UPLOAD_PATH . "/designbtnimg/" . $strBI_IMAGE_FILE_1;
				endif;
				$strMsg = "등록된 정보를 삭제 하였습니다..";
			else:
				$strMsg = "삭제 실패!! 담당자에게 문의주세요..";
			endif;
			$strUrl = "./?menuType=".$strMenuType."&mode=imgstyle2&bi_image_cate=" . $strBI_IMAGE_CATE . "&bi_group=" . $strBI_GROUP . "&".$strLinkPage;
		break;
	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);

	

?>