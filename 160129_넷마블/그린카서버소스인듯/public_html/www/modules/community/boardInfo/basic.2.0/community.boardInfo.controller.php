<?php
    /**
     * /home/shop_eng/www/modules/community/board/basic.2.0/community.boardInfo.controller.php
     * @author eumshop(thav@naver.com)
     * community boardInfo controller class (basic.2.0)
     * **/
	
	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.module.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.controller.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.controller.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";

    class CommunityBoardInfoController extends CommunityController {

		function __construct(&$db, &$field) {
			$this->module			= new CommunityBoardInfoModule($db, $field);
			$this->name				="BoardInfoMgr";
			$this->db				= &$db;
			$this->field			= &$field;
		}

		function getMessage() {
			echo "community boardInfo controller class (basic.2.0)";
		}

		/**
		 * getDeleteCode()
		 * 관련 코드 내용 삭제
		 * **/
		function getDeleteCode() {

			## STEP 1.
			## 카테고리 코드 내용 삭제
			$param['ba_b_code']	= $this->field['ba_b_code'];
			$this->module->getBoardInfoMgrUseDeleteCode($param);
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1.
			## 설정
			// 댓글(코멘트) 권한은 글쓰기 따라감.
//			$this->field['bi_comment_use']				=	$this->field['bi_datawrite_use'];			// 커뮤니티 코멘트 사용(일반=B,소셜=S,사용안함=N)
//			$this->field['bi_comment_member_auth']		=	$this->field['bi_datawrite_member_auth'];	// 커뮤니티 코멘트 사용 권한(일반회원, 관리자회원, 공급사회원)
			
			// 삭제 권한은 글쓰기 따라감.
			$this->field['bi_datadelete_use']			=	$this->field['bi_datawrite_use'];			// 커뮤니티 삭제 사용(일반=B,소셜=S,사용안함=N)
			$this->field['bi_datadelete_member_auth']	=	$this->field['bi_datawrite_member_auth'];	// 커뮤니티 삭제 사용 권한(일반회원, 관리자회원, 공급사회원)

			// 수정 권한은 글쓰기 따라감.
			$this->field['bi_datamodify_use']			=	$this->field['bi_datawrite_use'];			// 커뮤니티 수정 사용(일반=B,소셜=S,사용안함=N)
			$this->field['bi_datamodify_member_auth']	=	$this->field['bi_datawrite_member_auth'];	// 커뮤니티 수정 사용 권한(일반회원, 관리자회원, 공급사회원)

			// 공지글 무조건 사용
			$this->field['bi_datawrite_notice_use']		=	"Y";

			// 위젯 추천 설정
			if(!$this->field['bi_widget_icon_use']):
			$this->field['bi_widget_icon_use'] = "N";
			endif;

			if(!$this->field['bi_dataview_nextprve_use']):
			$this->field['bi_dataview_nextprve_use'] = "N";
			endif;

			## mode 설정
			$strMode		= $this->field['mode'];
			if($strMode == "act") { $strMode = $this->field['act']; }

			## STEP 2.
			##  설정 정보 DB에 등록
			$aryBoardSet			= $this->getBoardInfoKeyDefine();
			foreach($aryBoardSet as $act => $set):
				foreach($set as $key => $comment):
					$field = $this->field[strtolower($key)];
					if(is_array($field)):
						foreach($field as $fieldKey => $fieldVal):
							$this->field['ba_b_code']	= $this->field['b_code'];
							$this->field['ba_mode']		= $strMode;
							$this->field['ba_key']		= "{$key}_{$fieldKey}" ;
							$this->field['ba_val']		= $fieldVal;
							$this->field['ba_comment']	= $comment;
							parent::getWriteModify();
						endforeach;
					else:
						$this->field['ba_b_code']	= $this->field['b_code'];
						$this->field['ba_mode']		= $strMode;
						$this->field['ba_key']		= $key;
						$this->field['ba_val']		= $field;
						$this->field['ba_comment']	= $comment;
						parent::getWriteModify();
					endif;
				endforeach;
				$this->getBoardInfoFileWrite($act);			// 파일 생성	
			endforeach;
		}
		
		/**
		 * getWriteModifyPoint()
		 * 커뮤니티 포인트/쿠폰 옵션 설정 등록&수정
		 * 2013.05.10 이벤트 정보 페이블 변경
		 * **/
		function getWriteModifyPoint() {
			
			## STEP 1.
			## 선언
			$giftController = new CommunityGiftController($this->db, $this->field);
			$aryList		= array("bi_point_w","bi_coupon_w","bi_point_c","bi_coupon_c");
			$aryType		= array("bi_point_w" => "point" ,"bi_coupon_w" => "coupon" ,"bi_point_c" => "point"   ,"bi_coupon_c" => "coupon");
			$aryArea		= array("bi_point_w" => "data"  ,"bi_coupon_w" => "data"   ,"bi_point_c" => "comment" ,"bi_coupon_c" => "comment");

			## STEP 2.
			## 커뮤니티 포인트/쿠폰 옵션 삭제
			$deleteList			= $this->field['point_coupon_delete_list'];
			if($deleteList):
				$aryDeleteList  =	explode(",", $deleteList);
				foreach($aryDeleteList as $gm_no):
					$param['gm_no'] = $gm_no;
					$giftController->getDeleteEx($param);
				endforeach;
			endif;		

			## STEP 3.
			## 글쓰기 - 포인트 
			foreach($aryList as $list):
				if($this->field["{$list}_use"] != "Y"):
					// 사용 안함.
				else:

					if(in_array($this->field["{$list}_give"], array("A", "M"))):
						/** 자동포인트지급 or 수동포인트지급 **/

						$param['gm_no']			= $this->field["{$list}_no"];
						$param['gm_b_code']		= $this->field["b_code"];
						$param['gm_ub_no']		= -1;
						$param['gm_type']		= $aryType[$list];
						$param['gm_area']		= $aryArea[$list];
						$param['gm_use']		= $this->field["{$list}_use"];
						$param['gm_give_type']	= $this->field["{$list}_give"];
						$param['gm_max']		= $this->field["{$list}_count"];
						$param['gm_title']		= $this->field["{$list}_title"];
						$param['gm_data']		= $this->field["{$list}_data"];

						if($param['gm_no']):
							// 업데이트
							$giftController->getModifyEx($param);
						else:
							// 신규등록
							$giftController->getWriteEx($param);
						endif;

					elseif(in_array($this->field["{$list}_give"], array("T"))):
						/** 멀티차등포인트지급 **/

						$sizeCnt = sizeof($this->field["{$list}_multi_count"]);
						for($i=0;$i<$sizeCnt;$i++):
							$param['gm_no']			= $this->field["{$list}_multi_no"][$i];
							$param['gm_b_code']		= $this->field["b_code"];
							$param['gm_ub_no']		= -1;
							$param['gm_type']		= $aryType[$list];
							$param['gm_area']		= $aryArea[$list];
							$param['gm_use']		= $this->field["{$list}_use"];
							$param['gm_give_type']	= $this->field["{$list}_give"];
							$param['gm_max']		= $this->field["{$list}_multi_count"][$i];
							$param['gm_title']		= $this->field["{$list}_multi_title"][$i];
							$param['gm_data']		= $this->field["{$list}_multi_point"][$i];
							if($param['gm_no']):
								// 업데이트
								$giftController->getModifyEx($param);
							else:
								// 신규등록
								$giftController->getWriteEx($param);
							endif;

						endfor;

					endif;

				endif;

			endforeach;

			## 커뮤니티 포인트/쿠폰 옵션 설정 정보
			$eventInfoController = new CommunityEventInfoController($this->db, $this->field);
			$eventInfoController->getWriteModify();


			## 커뮤니티 설정 정보
			$this->getWriteModify();
		}

		/**
		 * getWriteModify()
		 * 데이터 등록&수정
		 * **/
		function getWriteModify() {

			## STEP 1.
			## 설정
			// 댓글(코멘트) 권한은 글쓰기 따라감.
//			$this->field['bi_comment_use']				=	$this->field['bi_datawrite_use'];			// 커뮤니티 코멘트 사용(일반=B,소셜=S,사용안함=N)
//			$this->field['bi_comment_member_auth']		=	$this->field['bi_datawrite_member_auth'];	// 커뮤니티 코멘트 사용 권한(일반회원, 관리자회원, 공급사회원)
			

			// 삭제 권한은 글쓰기 따라감.
			$this->field['bi_datadelete_use']			=	$this->field['bi_datawrite_use'];			// 커뮤니티 삭제 사용(일반=B,소셜=S,사용안함=N)
			$this->field['bi_datadelete_member_auth']	=	$this->field['bi_datawrite_member_auth'];	// 커뮤니티 삭제 사용 권한(일반회원, 관리자회원, 공급사회원)

			// 수정 권한은 글쓰기 따라감.
			$this->field['bi_datamodify_use']			=	$this->field['bi_datawrite_use'];			// 커뮤니티 수정 사용(일반=B,소셜=S,사용안함=N)
			$this->field['bi_datamodify_member_auth']	=	$this->field['bi_datawrite_member_auth'];	// 커뮤니티 수정 사용 권한(일반회원, 관리자회원, 공급사회원)

			// 공지글 무조건 사용
			$this->field['bi_datawrite_notice_use']		=	"Y";

			if(!$this->field['bi_column_default']) { $this->field['bi_column_default'] = 1; }

			## 목록항목 설정
			for($i=0;$i<5;$i++):
				if($this->field['bi_widget_datalist_field_use'][$i] == "Y") { continue; }
				$this->field['bi_widget_datalist_field_use'][$i] = "N";
			endfor;

			$intCnt=0;
			foreach($this->field['S_MEMBER_GROUP'] as $key => $group):
				if(!$this->field['bi_datalist_member_auth'][$intCnt]) { $this->field['bi_datalist_member_auth'][$intCnt] = "N"; }
				if(!$this->field['bi_dataview_member_auth'][$intCnt]) { $this->field['bi_dataview_member_auth'][$intCnt] = "N"; }
				if(!$this->field['bi_datawrite_member_auth'][$intCnt]) { $this->field['bi_datawrite_member_auth'][$intCnt] = "N"; }
				if(!$this->field['bi_dataanswer_member_auth'][$intCnt]) { $this->field['bi_dataanswer_member_auth'][$intCnt] = "N"; }
				if(!$this->field['bi_comment_member_auth'][$intCnt]) { $this->field['bi_comment_member_auth'][$intCnt] = "N"; }
				$intCnt++;
			endforeach;

			## STEP 2.
			## 데이터 기록
			$aryBoardInfo		= $this->getBoardInfoKeyDefine($this->field['act']);
			
			## mode 설정
			$strMode		= $this->field['mode'];
			if($strMode == "act") { $strMode = $this->field['act']; }

			if(is_array($aryBoardInfo)):
				foreach($aryBoardInfo as $key => $comment):
					$field = $this->field[strtolower($key)];
					if(is_array($field)):
						foreach($field as $fieldKey => $fieldVal):
							$this->field['ba_b_code']	= $this->field['b_code'];
							$this->field['ba_mode']		= $strMode;
							$this->field['ba_key']		= "{$key}_{$fieldKey}" ;
							$this->field['ba_val']		= $fieldVal;
							$this->field['ba_comment']	= $comment;
							parent::getWriteModify();
						endforeach;
					else:
						$this->field['ba_b_code']	= $this->field['b_code'];
						$this->field['ba_mode']		= $strMode;
						$this->field['ba_key']		= $key ;
						$this->field['ba_val']		= $field;
						$this->field['ba_comment']	= $comment;
						parent::getWriteModify();
					endif;
				endforeach;
			endif;

			## STEP 3.
			## 데이터 만들기
			$this->getBoardInfoFileWrite($this->field['act']);	


		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {	
		}


		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getDropTable() {
//		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
		}

		/**
		 * getSaveScriptFile()
		 * 커뮤니티 스크립트 저장
		 * **/	
		function getSaveScriptFile() {

			## STEP 1.
			## 커뮤니티 생성시, 기본 스크립트 생성
			if($this->field['act'] == "boardWrite"):
				$this->field['bi_datascript_data'] = "{{__커뮤니티본문__}}";
			endif;

			## STEP 2.
			## 수행파일 만들기
			## include 사용 형태 <%include "/html/top_5.inc.php"%>
			$bi_datascript_data					= $this->field['bi_datascript_data'];
			if ($this->field['bi_datascript_widget_data']) {
				$bi_datascript_data				= $this->field['bi_datascript_widget_data'];
			}

			## 변수 변경 2013-07-25 kim hee sung 변수 변경 모듈 추가
			preg_match_all("/<%=.*%>/", $bi_datascript_data, $preg_data);
			foreach($preg_data[0] as $data):
				$dataTemp = $data;
				$dataTemp = str_replace("<%=", "", $dataTemp);
				$dataTemp = str_replace("%>", "", $dataTemp);
				$dataTemp = "<?=\$USER_REQUEST['{$dataTemp}']?>";
				$bi_datascript_data	= str_replace($data, $dataTemp, $bi_datascript_data);
			endforeach;

			preg_match_all("/<%.*%>/", $bi_datascript_data, $preg_data);
			foreach($preg_data[0] as $data):
				$dataTemp = $data;
				$dataTemp = str_replace("<%", "", $dataTemp);
				$dataTemp = str_replace("%>", "", $dataTemp);
						
				/* include 치환 */
				if(preg_match("/^include[ |\"]/", $dataTemp)):
					$dataTemp			= str_replace("include", "", $dataTemp);
					$dataTemp			= str_replace("\"", "", $dataTemp);
					$dataTemp			= str_replace(" ", "", $dataTemp);
					if(is_file("{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}{$dataTemp}")):
						$dataTemp		= "<? include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}{$dataTemp}\"; ?>";
					else:
						$dataTemp		= "<!--ERROR NO FILE-->";
					endif;
					$bi_datascript_data	= str_replace($data, $dataTemp, $bi_datascript_data);
				endif;
			endforeach;

			## STEP 3.
			## 커뮤니티 스크립트 파일명 정의
			$lng = strtolower($_POST['lang']);
			if ($this->field['bi_datascript_data']) {
				$bi_datascript_href		= "/layout/html/community/{$lng}/board.{$this->field['b_code']}.script.php";
				$bi_datascript_href_tag	= "/layout/html/community/{$lng}/board.{$this->field['b_code']}.script.tag.php";
				$bi_datascript_data_tag	= $this->field['bi_datascript_data'];

				$this->field['bi_datascript_href']	= $bi_datascript_href;
			}
			
			## 커뮤니티 위젯 파일명 정의
			if ($this->field['bi_datascript_widget_data']) {
				$bi_datascript_href		= "/layout/html/community/{$lng}/widget.{$this->field['b_code']}.script.php";
				$bi_datascript_href_tag	= "/layout/html/community/{$lng}/widget.{$this->field['b_code']}.script.tag.php";
				$bi_datascript_data_tag	= $this->field['bi_datascript_widget_data'];

				$this->field['bi_datascript_widget_href']	= $bi_datascript_href;

			}
			

			## STEP 4.
			## 커뮤니티 스크립트 예약어 정의			
			$aryTag['{{__커뮤니티본문__}}']		= "<? include \$includeFile; ?>";
			$aryTag['{{__위젯본문__}}']			= "<? include \$includeFile; ?>";
			$aryTag['{{__MY페이지_메뉴__}}']	= "<? include MALL_WEB_PATH . \"navi/sub_navi_A0001_mypage.inc.php\"; ?>";
			$aryTag['{{__사용자_커뮤니티메뉴__}}']		= "<? include \"\$S_DOCUMENT_ROOT\$S_SHOP_HOME/html/userCommunityMenu.inc.php\"; ?>";
			$aryTag['{{__사용자_커뮤니티본문__}}']		= "<? include SHOP_HOME . \"/html/community/\" . strtolower(\$_REQUEST['b_code']) . \"/{\$_REQUEST['mode']}.layout.php\"; ?>";
	
			## 커뮤니티 스크립트 예약어 정의(배너 부분)		
			$bannerConfFolder		= SHOP_HOME . "/layout/banner/" . strtolower($this->field['lang']);
			if(is_dir($bannerConfFolder)):
				$dir			= dir($bannerConfFolder);
				while($file = $dir->read()):
					if($file == "." || $file == "..") { continue; }
					$tagName		= str_replace(".html.php", "" , $file);
					$aryTag["{{__{$tagName}__}}"] = "<? include sprintf ( \"%s%s/layout/banner/%s/%s\", \$S_DOCUMENT_ROOT, \$S_SHOP_HOME, \$S_SITE_LNG_PATH, \"$file\" ); ?>";
				endwhile;
			endif;

			## STEP 4-1.
			## 커뮤니티 윗젝 스크립트 예약어 정의	
			preg_match_all("/{{__.*_위젯__}}/", $bi_datascript_data, $preg_data);
			foreach($preg_data[0] as $data):
				$dataTemp		= $data;
				$dataTemp		= str_replace("{{__", "", $dataTemp);
				$dataTemp		= str_replace("_위젯__}}", "", $dataTemp);
				$aryTag[$data]	= "<? \$b_code=\"{$dataTemp}\"; include \"{\$S_DOCUMENT_ROOT}www/web/community/widget.index.php\"; ?>";
			endforeach;

			## 커뮤니티 스크립트 신규 예약어 정의
			$this->changeLayoutData($bi_datascript_data, $bi_datascript_data);
			$this->changeLayoutDataEx4($bi_datascript_data);
			$this->changeLayoutDataEx5($bi_datascript_data);


			## STEP 5.
			## 파일 만들기(태그파일)
			$file				= new FileHandler();
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}{$bi_datascript_href_tag}";
			$file->fileWrite($fileName, $bi_datascript_data_tag);

			## STEP 6.
			## 파일 만들기(수행파일)
			foreach($aryTag as $key => $tag):
				$bi_datascript_data = str_replace($key, $tag, $bi_datascript_data);
			endforeach;
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}{$bi_datascript_href}";
			$file->fileWrite($fileName, $bi_datascript_data);
		}

		/**
		 * getUserfieldSet()
		 * 커뮤니티 추가필드(사용자정의필드) 데이터 정리
		 * **/	
		function getUserfieldSet() {
			 
			 ## 기본설정
			 $userfield_field_use		= "";
			$intCnt						= sizeof($this->field['bi_userfield_name']);

			for($i=0;$i<$intCnt;$i++):
				$use			= $this->field['userfield_field_use'][$i];
				$essential		= $this->field['bi_userfield_essential'][$i];
				$onlyadmin		= $this->field['bi_userfield_onlyadmin'][$i];
				$userfield_field_use						   .= ($use) ? $use : "N";
				$this->field['bi_userfield_essential'][$i]		= ($essential) ? $essential : "N";
				$this->field['bi_userfield_onlyadmin'][$i]		= ($onlyadmin) ? $onlyadmin : "N";
			endfor;
			$this->field['bi_userfield_field_use'] = $userfield_field_use;
//			print_r($this->field);
		}

		function getUserfieldModify() {
			// 2013.11.21
			// kim hee sung
			// 추가 필드 설정
			
			## 모듈 설정
			require_once MALL_HOME . "/module2/BoardInfoMgr.module.php";
			require_once MALL_HOME . "/classes/file/file.handler.class.php";
			$boardInfoMgr			= new BoardInfoMgrModule($this->db);
			$file					= new FileHandler();
						
			## 기본설정
			$strAct					= $this->field['act'];
			$strBCode				= $this->field['b_code'];
			$strDocumentRoot		= $this->field['S_DOCUMENT_ROOT'];
			$strShopHome			= $this->field['S_SHOP_HOME'];
			$aryBoardInfo			= $G_BOARD_INFO[$strAct];
			$confDir				= "{$strDocumentRoot}{$strShopHome}/conf/community";
			$confFile				= "{$confDir}/board.{$strBCode}.info.php";

			## 기존 정보 삭제
			$param					= "";
			$param['BA_B_CODE']		= $strBCode;
			$param['BA_MODE']		= $strAct;
			$boardInfoMgr->getBoardInfoMgrDeleteEx($param);
			



			## 신규 데이터 등록
			foreach($aryBoardInfo as $key => $comment):
				$keyLower			= strtolower($key);	
				$value				= $this->field[$keyLower];

				## 신규 정보 저장
				if($value):
					$param						= "";
					$param['BA_B_CODE']			= $strBCode;
					$param['BA_MODE']			= $strAct;
					$param['BA_KEY']			= $key;
					$param['BA_VAL']			= $value;
					$param['BA_COMMENT']		= $comment;
					$re							= $boardInfoMgr->getBoardInfoMgrInsertEx($param);

				endif;
			endforeach;

			## 추가옵션 리스트
			$param								= "";
			$param['BA_B_CODE']					= $strBCode;
			$param['BA_MODE']					= $strAct;
			$boardInfoMgrArray					= $boardInfoMgr->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);

			## 데이터 만들기
			$dataInfo							= "";
			foreach($boardInfoMgrArray as $key => $data):
				$keyLower						= strtolower($data['BA_KEY']);
				$field							= $data['BA_VAL'];
				$comment						= $data['BA_COMMENT'];

				$dataTemp						= "";
				$dataTemp						= "\$BOARD_INFO['{$strBCode}']['{$keyLower}']";
				$dataTemp						= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);

				$dataTemp						= "{$dataTemp} = \"{$field}\";";
				$dataTemp						= str_pad($dataTemp, 140, " ", STR_PAD_RIGHT);

				$dataTemp						= "## {$comment}\n{$dataTemp}"; 
				$dataInfo					   .= ($dataInfo) ? "\n" : "";
				$dataInfo					   .= $dataTemp;
			endforeach;

			## 파일 만들기
			$file->getMadeInfo($confFile, $dataInfo, "/*@ {$strAct} @*/");
		}

		function changeLayoutData( $data, &$outData )
		{
			global $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, $db, $S_ST_LNG;
			
			$designConfigFile			= sprintf( "%swww/config/design_conf.php", $S_DOCUMENT_ROOT );
			
			if ( !file_exists($designConfigFile)  ) :
				// 설정 파일이 없음.
				return;	
			endif;	

			include $shopConfigFile;
			include $designConfigFile;


			foreach ( $DESIGN_TAG as $tag => $str ) :
				$str			= sprintf( "<? %s ?>", $str );
				$data 			= str_replace($tag, $str , $data);
			endforeach;
			
			$outData 			= $data;

			return 1;

		}

		/** 작성일 : 2013.06.27
		  * 작성자 : kim hee sung
		  * 내  용 : 문자을 언어별로 출력
		  *
		  **/
		function changeLayoutDataEx4(&$bi_datascript_data)
		{
			## STEP 2.
			## 수행파일 만들기
			## include 사용 형태 <%include "/html/top_5.inc.php"%>
			$bi_datascript_data = str_replace("&lt;", "<", $bi_datascript_data);
			$bi_datascript_data = str_replace("&gt;", ">", $bi_datascript_data);
			preg_match_all("/<@.*@>/iU", $bi_datascript_data, $preg_data);

			foreach($preg_data[0] as $data):
				$dataTemp = $data;
				$dataTemp = str_replace("<@", "", $dataTemp);
				$dataTemp = str_replace("@>", "", $dataTemp);
				$dataTemp = "<?=GET_U_TRANS(\"{$dataTemp}\");?>";
				$bi_datascript_data	= str_replace($data, $dataTemp, $bi_datascript_data);
			endforeach;
		}

		function changeLayoutDataEx5(&$bi_datascript_data)
		{
			## STEP 1.
			## 변경할 파일 검색 파일 검색
			## include 사용 형태 <!--?ID=12345678901234567890&WIDTH=100&HEIGHT=200-->
			$bi_datascript_data = str_replace("&lt;", "<", $bi_datascript_data);
			$bi_datascript_data = str_replace("&gt;", ">", $bi_datascript_data);
			preg_match_all("/<!--\?.*-->/iU", $bi_datascript_data, $preg_data);

			## STEP 2.
			## 검색 파일 변경
			foreach($preg_data[0] as $data):

				## STEP 2-1.
				## 필요 없는 내용 삭제
				$dataTemp	= $data;
				$dataTemp	= str_replace("<!--?", "", $dataTemp);
				$dataTemp	= str_replace("-->", "", $dataTemp);
				
				## STEP 2-2.
				## 구분
				$dataTemp1	= "";
				$dataTemp2	= explode("&", $dataTemp); 
				foreach($dataTemp2 as $temp):
					list($key, $value) = explode("=", $temp);
					if($dataTemp1) { $dataTemp1 .= "\n"; }
					$dataTemp1 .= "  \$EUMSHOP_APP_INFO['{$key}'] = \"{$value}\";";
				endforeach;
				
				if($dataTemp1) { $dataTemp1 .= "\n  include \"{\$S_DOCUMENT_ROOT}www/web/app/index.php\";"; }
				$dataTemp1				= "<?\n{$dataTemp1}\n?>";
				$bi_datascript_data		= str_replace($data, $dataTemp1, $bi_datascript_data);
			endforeach;

		//	print_r($dataTemp1);
		//	exit;
		}

    }
?>