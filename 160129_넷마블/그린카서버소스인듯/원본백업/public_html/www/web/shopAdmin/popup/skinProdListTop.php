<?
	## 작성일 : 2013.08.16
	## 작성자 : kim hee sung
	## 내  용 : 카테고리 설정(다국어 지원)
	## 수  정 : 2013.08.16 , kim hee sung, 소스 정리

	## 카테고리 기본 설정
 	$cateWebImgPath			= "/upload/layout/product/top/";
	$cateWebTagPath			= "/layout/topHtml/";
	$policyLng				= strtolower($strStLng);

	## 디자인 클래스 호출
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	
	## 이미지 관련 함수 호출
	require_once "{$S_DOCUMENT_ROOT}www/classes/image/image.func.class.php";
	$imageFunc = new ImageFunc();

	## 카테고리 요청
	$categoryPath			= "../conf/category.{$policyLng}.inc.php";
	if(is_file($categoryPath)) { require_once $categoryPath; }

	$siteLng				= strtolower($S_SITE_LNG);
	if($siteLng != $policyLng):
		$categoryPath			= "../conf/category.{$siteLng}.inc.php";
		if(is_file($categoryPath)) { require_once $categoryPath; }
	endif;

	$strSubPageCode	= $_REQUEST["subPageCode"];
	$ds				= substr($strSubPageCode,0,2);
	$designSetMgr	= new DesignSetMgr();	
	$designSetMgr->setDS_TYPE("SKIN_{$ds}");
	$codeViewRow	= $designSetMgr->getCodeView($db);	
	$level			= $codeViewRow["{$ds}_TOP_CAT_OP"];
	if(!$level) { $level = 0; }
?>

	<? include "./include/header.inc.php"?>

	<script language="javascript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
	<script type="text/javascript">
	<!--
		//<![CDATA[
		var rootDir 		= "../../common/eumEditor/highgardenEditor";
		var uploadImg 		= "/editor/categoryTop";
		var uploadFile		= "../kr/index.php";
		var htmlYN			= "Y";
		//]]>
	//-->
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			var level = "<?=$level?>";
			goCategoryChangeLevel(level);

			$("#pl_top_cat_op").change(function() {
				var level = $("#pl_top_cat_op").val();
				goCategoryChangeLevel(level);
			});
		});
		
		function goSelfClose() { parent.goClose(); }
		function goClose() { $.smartPop.close(); }
		function goCategoryTopImageActEvent(code)		{ goCategoryTopImageAct(code);			}
		function goCategoryTopImageUseActEvent()		{ goCategoryTopImageUseAct();			}
		function goCategoryTopImageMoveEvent(code)		{ goCategoryTopImageMove(code);			}
		function goCategoryTopImageDeleteActEvent(code)	{ goCategoryTopImageDeleteAct(code);	}
		function goCategoryTopHtmlMoveEvent(code)		{ goCategoryTopHtmlMove(code);			}
		function goCategoryTopHtmlActEvent(code)		{ goCategoryTopHtmlAct(code);			}
		function goCategoryTopHtmlDeleteActEvent(code)	{ goCategoryTopHtmlDeleteAct(code);		}

		
		function goCategoryTopImageAct(code) {
			var mode								= "categoryTopImageModify";
			document.form.encoding					= "multipart/form-data";
			document.form.menuType.value			= "layout";
			document.form.categoryCode.value		= code;
			C_getAction(mode,"<?=$PHP_SELF?>");				
		}

		function goCategoryTopImageUseAct() {
			document.form.menuType.value		= "layout";
			var mode							= "categoryTopImageUse";
			C_getAction(mode,"<?=$PHP_SELF?>");				
		}

		function goCategoryTopImageDeleteAct(code) {
			document.form.menuType.value		= "layout";
			document.form.categoryCode.value	= code;
			var mode							= "categoryTopImageDelete";
			C_getAction(mode,"<?=$PHP_SELF?>");		
		}

		function goCategoryTopHtmlDeleteAct(code) {
			document.form.menuType.value		= "layout";
			document.form.categoryCode.value	= code;
			var mode							= "categoryTopHtmlDelete";
			C_getAction(mode,"<?=$PHP_SELF?>");				
		}

		function goCategoryChangeLevel(level) {
			$("#categoryList").find("tr[id^=category_]").each(function() {
				$(this).css({'display':'none'});
			});
			for(var i=1;i<=level;i++){
				$("#categoryList").find("tr[id^=category_"+i+"]").each(function() {
					$(this).css({'display':''});
				});
			}
		}

		function goCategoryTopImageMove(code) {			
			var inputFileTag	= "<input type='file' name='cateFile_"+code+"'/>";
			var inputBtnTag		= "<a class='btn_sml' href=\"javascript:goCategoryTopImageActEvent('"+code+"');\"><strong>저장</strong></a>";
			$("input[type=file]").remove();
			$("span[id=cateFile_"+code+"]").html(inputFileTag+inputBtnTag);
		}

		function goCategoryTopHtmlMove(code) {
			var inputFileTag	= "<textarea name='cateTag_"+code+"' id='cateTagTemp_"+code+"' title='higheditor_full' style='width:100%;height:100px'></textarea>";
			var inputBtnTag		= "<a class='btn_sml' href=\"javascript:goCategoryTopHtmlActEvent('"+code+"');\"><strong>저장</strong></a>";
			$("textarea[id^=cateTagTemp_]").remove();
			$("span[id=cateFile_"+code+"]").html(inputFileTag+inputBtnTag);
		}

		function goCategoryTopHtmlAct(code) {
			var mode								= "categoryTopHtmlModify";
			document.form.menuType.value			= "layout";
			document.form.categoryCode.value		= code;
			C_getAction(mode,"<?=$PHP_SELF?>");	
		}

	</script>
		
	<form name="form" id="form">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
	<input type="hidden" name="categoryCode" value="">
	<input type="hidden" name="policyLng" value="<?=$_REQUEST['policyLng']?>">

	<div class="popTop">
		<h2>상품리스트 Top 관리</h2>
		<a  href="javascript:goSelfClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div><!--popTop-->


	<div class="layerPopWrap">

		<br><br>

		&nbsp;&nbsp;&nbsp;&nbsp;적용 범위

		<select id="pl_top_cat_op" name="pl_top_cat_op">
			<!--option value="0" <?if($level==0) { echo " selected"; }?>>사용안함</option-->
			<option>선택하세요.</option>
			<option value="1" <?if($level==1) { echo " selected"; }?>>1차 카테고리</option>
			<option value="2" <?if($level==2) { echo " selected"; }?>>2차 카테고리</option>
			<option value="3" <?if($level==3) { echo " selected"; }?>>3차 카테고리</option>
			<option value="4" <?if($level==4) { echo " selected"; }?>>4차 카테고리</option>
		</select> 

		으로 <a class="btn_sml" href="javascript:goCategoryTopImageUseActEvent();"><strong>변경</strong></a>
		
		<a href="javascript:goFTPFileUploadMoveEvent()" class="btn_sml"><span>FTP 파일 업로드</span></a>


		<!-- 언어 선택 탭 -->
		<?include "./include/tab_language.inc.php";?>
		<!-- 언어 선택 탭-->

		<div class="tableList" style="margin-top:10px;">	

			<table id="categoryList">
				<colgroup>
					<col style="width:150px;"/>
					<col/>
					<col/>
				</colgroup>
				<tr>
					<th>카테고리명</th>
					<th>이미지</th>
					<th>설정</th>
				</tr>
				<? foreach($S_ARY_CATE_NAME as $key => $data): 
						$level	= strlen($key) / 3;
						$step	= str_pad("", $level-1, " ", STR_PAD_LEFT);	
						$step	= str_replace(" ", "&nbsp;", $step);				
						$img	= $S_ARY_CATE_IMG[$key]['TOP_IMG'];
						$tag	= $S_ARY_CATE_HTML[$key]['TOP_HTML'];

						/** 다국어 이미지 파일 설정 **/
						$imgPath = "{$cateWebImgPath}{$policyLng}/{$img}";
						$ext = $imageFunc->getFindImage("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$imgPath}");
						if($ext):
							$fileInfo	= $imageFunc->getPathInfo($imgPath);
							$imgPath	= "{$fileInfo['dirname']}/{$fileInfo['name']}.$ext";
						else:
							$imgPath	= "";	
						endif;

				?>
				<tr id="category_<?=$level?>_<?=$key?>">
					<td><?if($level>1):?><?=$step?>└ <?endif;?><?=$data['CATE_NM'];?></td>
					<td><?if($imgPath):?><img src="<?=$imgPath?>" style="width:100px;height:50px;"/>
						<a class="btn_sml" href="javascript:goCategoryTopImageDeleteActEvent('<?=$key?>');"><strong>삭제</strong></a>
						<?endif;?>
						<span id="cateFile_<?=$key?>"></span>
						<?if($tag):?>
						<textarea name="cateTag_<?=$key?>" id="cateTag_<?=$key?>" title="" style="width:100%;height:100px"><?include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$cateWebTagPath}{$policyLng}/tag_{$tag}";?></textarea>
						<a class='btn_sml' href="javascript:goCategoryTopHtmlActEvent('<?=$key?>');"><strong>수정</strong></a>
						<a class='btn_sml' href="javascript:goCategoryTopHtmlDeleteActEvent('<?=$key?>');"><strong>삭제</strong></a>
						<?endif;?>
					</td>
					<td>
						<?if(($S_SITE_LNG != $strStLng) && !$img):?>
						<a class="btn_sml" href="javascript:alert('기준 언어를 먼저 등록하세요.');"><strong>파일업로드</strong></a>
						<?else:?>
						<a class="btn_sml" href="javascript:goCategoryTopImageMoveEvent('<?=$key?>');"><strong>파일업로드</strong></a>
						<?endif;?>

						<?if(($S_SITE_LNG != $strStLng) && !$tag):?>
							<a class="btn_sml" href="javascript:alert('기준 언어를 먼저 등록하세요.');"><strong>HTML코딩</strong></a>
						<?else:?>
							<?if($tag):?>
							<a class="btn_sml" href="#"><strong>HTML코딩</strong></a>
							<?else:?>
							<a class="btn_sml" href="javascript:goCategoryTopHtmlMoveEvent('<?=$key?>');"><strong>HTML코딩</strong></a>
							<?endif;?>
						<?endif;?>
					</td>
				</tr>
				<? endforeach; ?>
				
			</table>
		</div>

	</div><!--layerPopWrap-->

	</form>


</body>
</html>
