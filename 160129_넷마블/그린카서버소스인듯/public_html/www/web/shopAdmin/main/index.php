<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";

	$memberMgr = new MemberMgr();
	$orderMgr = new OrderMgr();
	$siteMgr = new SiteMgr();
	$productMgr = new ProductMgr();
	require_once MALL_PROD_FUNC;

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$strBoardCode	= $_POST["bCode"]			? $_POST["bCode"]			: $_REQUEST["bCode"];

	$intB_NO		= $_POST["bNo"]				? $_POST["bNo"]				: $_REQUEST["bNo"];

	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/

?>

<? include "./include/header.inc.php"?>
<?
	/* 회원그룹 */
	//$aryMemberGroup = $memberMgr->getGroupList($db);

	switch($strMode){
		case "memberList":
			
			/* 메인 화면 권한 확인 */
			if ($a_admin_level > 0){
				$arrayMainRow = getTopLowMenuArray($a_admin_no, "012", $strCode2);
			
				if (!is_array($arrayMainRow)){
					goErrMsg("메뉴권한이 없는 관리자입니다.");
					exit;
				}
			}

			if ($a_admin_type == "S"){
				$orderMgr->setP_SHOP_NO($a_admin_shop_no);
			}

			/* 통계 관련 */
			$aryMainStaticsList  = $orderMgr->getOrderMainStatics($db);
			//echo $db->query;
			$aryMainStaticsList2 = $orderMgr->getOrderMainStatics2($db);
			$aryMainStaticsGraph = $orderMgr->getOrderMainStatics3($db);
			
			$strX .= "'01월','02월','03월','04월','05월','06월','07월','08월','09월','10월','11월','12월'";
			if (is_array($aryMainStaticsGraph)){
				
				for($i=1;$i<=12;$i++){
					$strColNm = $i;
					if ($i < 10 ) $strColNm = "0".$i;
					$strY1 .= STR_REPLACE(",","",getFormatPrice($aryMainStaticsGraph[0][$strColNm."_PRICE1"],2,$S_ST_CUR)).",";
					$strY2 .= STR_REPLACE(",","",getFormatPrice($aryMainStaticsGraph[0][$strColNm."_PRICE3"],2,$S_ST_CUR)).",";
					$strY3 .= STR_REPLACE(",","",getFormatPrice($aryMainStaticsGraph[0][$strColNm."_PRICE2"],2,$S_ST_CUR)).",";
				}

				$strY1 = SUBSTR($strY1,0,STRLEN($strY1)-1);
				$strY2 = SUBSTR($strY2,0,STRLEN($strY2)-1);
				$strY3 = SUBSTR($strY3,0,STRLEN($strY3)-1);
			} else {
				$strY = "0,0,0,0,0,0,0,0,0,0,0,0";
			}

			/* 통계 관련 */

			// 2013.08.30 kim hee sung 애협 사이트 임시로 정보 숨김 처리
//			if($a_admin_type == "A" || $S_SHOP_HOME == "demo2"):

				/* eumshop에서 가져온 shop 정보 가져오기 */
//				$xml = simplexml_load_file( "http://www.eumshop.com/api/xml/shop.info.xml.php?shopId=" . $S_SHOP_HOME );
//				$getName = $xml->getName();
//				if ( $getName == "shopInfo" ) :
//	//				$shopInfo['version']				= $xml->xpath("version");						// 버전 정보
//					$shopInfo['startDateTime']			= $xml->xpath("startDateTime");			// 살치일
//					$shopInfo['endDateTime']			= $xml->xpath("endDateTime");				// 종료일
//					$shopInfo['totalUseDate']			= $xml->xpath("totalUseDate");				// 남은기간
//	//				$shopInfo['smsPoint']				= $xml->xpath("smsPoint");					// sms 사용 개수
//				endif;
				/* eumshop에서 가져온 shop 정보 가져오기 */

				/*사이트 정보 가져오기*/
				$siteResult						= $siteMgr->getSiteInfo($db);
				$shopInfo['smsPoint'][0]		= $siteResult['S_SMS_MONEY'];
				/*사이트 정보 가져오기*/
				
//				/* 업로드 폴더 사용 크기 */
//				$floadUploadSize				= GetFolderSize ( WEB_UPLOAD_PATH );
//				$shopInfo['useSize'][0]			= round ( $floadUploadSize / 1024 / 1024 , 1 );
//				/* 업로드 폴더 사용 크기 */
//
//				/* 등록된 상품 개수 */
//				$productResult					= $productMgr->getProdTotal($db);
//				$shopInfo['productCnt'][0]		= $productResult;
//				/* 등록된 상품 개수 */
				
				$aryFunc['REAL_CONFIRM']		= "OFF";			// 실명인증
				$aryFunc['SECURE_SERVER']		= "OFF";			// 보안서버
				$aryFunc['QUANTITY_MAIL']		= "OFF";			// 대량메일
				$aryFunc['CYWORLD_SCRAP']		= "OFF";			// 싸이월드스크랩

				/* 전자결제 On/Off */
				$aryFunc['ELECT_BANKING']	= "OFF";			// 전자결제
				if ( $siteResult['S_PG_SITE_CODE'] && $siteResult['S_PG_SITE_KEY'] ) :
					$aryFunc['ELECT_BANKING']	= "ON";
				endif;
				/* 전자결제 On/Off */

				/* 에스크로 On/Off */
				$aryFunc['ESCROW']				= "OFF";			// 에스크로
				if ( $siteResult['S_PG_ESCROW'] == "O" || $siteResult['S_PG_ESCROW'] == "Y" ) :
					$aryFunc['ESCROW']				= "ON";		
				endif;
				/* 에스크로 On/Off */

				/* 이읍샵 문자 On/Off*/
				$aryFunc['EUMSHOM_SMS']	= "OFF";			// 이음문자
				if ( $siteResult['S_SMS_USE'] == "Y" ) :
					$aryFunc['EUMSHOM_SMS']				= "ON";		
				endif;
				/* 이읍샵 문자 On/Off*/

				/* 1:1문의 */
	// 2013.05.10 구버전
	//			$boardMgr->setB_CODE("REQ");
	//			$boardMgr->setB_LEVEL(-1);
	//			$aryBoardSet1		= $boardMgr->getBoardData($db);
	//			$intB_NO1			= $aryBoardSet1[0]['B_NO'];
	//			$boardMgr->setTable($intB_NO1);
	//			$intTotal1			= $boardMgr->getDataTotal($db);
	//			$boardMgr->setLimitFirst(0);
	//			$boardMgr->setPageLine(6);
	//			$result1			= $boardMgr->getDataList($db);

				/* 상품 문의 */
	//			$boardMgr->setB_CODE("QA");
	//			$aryBoardSet2		= $boardMgr->getBoardData($db);
	//			$intB_NO2			= $aryBoardSet2[0]['B_NO'];
	//			$boardMgr->setTable($intB_NO2);
	//			$intTotal2			= $boardMgr->getDataTotal($db);
	//			$boardMgr->setLimitFirst(0);
	//			$boardMgr->setPageLine(6);
	//			$result2			= $boardMgr->getDataList($db);

				/** 2013.05.10 신규 게시판 **/
				require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
				$dataView	= new CommunityDataView($db,  $_REQUEST);
				


				## 2014.08.27 kim hee sung
				## 입점사 로그인은 입점사 관련 글만 출력합니다.
				$param		= "";
				if($a_admin_type == "S"):
					$param['product_mgr_use']	= "Y";
					$param['p_shop_no']			= $a_admin_shop_no;
				endif;
				$param['b_code']			= "PROD_QNA";
				$param['ub_func_notice']	= "N";
				$param['page_line']			= 5;
				$param['answer_no']			= true;
				$param['orderby']			= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
				$result1					= $dataView->getListEx("OP_LIST", $param);
//				echo $db->query;


				## 2014.08.27 kim hee sung
				## 입점사 로그인은 입점사 관련 글만 출력합니다.
				$param		= "";
				if($a_admin_type == "S"):
					$param['product_mgr_use']	= "Y";
					$param['p_shop_no']			= $a_admin_shop_no;
				endif;
				$param['b_code']			= "MY_QNA";
				$param['ub_func_notice']	= "N";
				$param['page_line']			= 5;
				$param['answer_no']			= true;
				$param['orderby']			= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
				$result2					= $dataView->getListEx("OP_LIST", $param);
			
		

//			endif;

		break;

	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}

	function GetFolderSize ( $d = "." ) {
		$h = @opendir ( $d );
		if ( $h == 0 ) return 0;
		while ( $f = readdir ( $h ) ) :
			if ( $f != ".." ) :
				$sf += filesize ( $nd = $d . "/" . $f );
				if ( $f != "." && is_dir ( $nd ) ) :
					$sf += GetFolderSize ( $nd );
				endif;
			endif;
		endwhile;
		closedir ( $h );
		return $sf;
	}


	/* 게시판 아이콘 정의 */
	$aryQnaIcon		= array(	"ICON_END" => "icon_qna_end.gif",		// 답변완료	- 관리자가 답변 완료로 변경한 상태
								"ICON_ING" => "icon_qna_ing.gif",		// 답변준비 - 등록일자에서 하루가 지난 상태
								"ICON_XNO" => "icon_qna_no.gif",		// 미처리	- 등록일자에서 2일이 지난 상태
								"ICON_REG" => "icon_qna_reg.gif"		// 접수완료	- 문의를 등록한 상태
							);
								
						
?>
<link class="include" rel="stylesheet" type="text/css" href="./common/statics/jquery.jqplot.min.css" />
<link rel="stylesheet" type="text/css" href="./common/statics/examples.min.css" />
<link type="text/css" rel="stylesheet" href="./common/statics/syntaxhighlighter/styles/shCoreDefault.min.css" />
<link type="text/css" rel="stylesheet" href="./common/statics/syntaxhighlighter/styles/shThemejqPlot.min.css" />
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
	
	 // 20150702 차트?
	 /*
		$.jqplot.config.enablePlugins = true;
        var s1 = [<?=$strY1?>];
		var s2 = [<?=$strY2?>];
		var s3 = [<?=$strY3?>];
        var ticks = [<?=$strX?>];
        
        plot1 = $.jqplot('chart1', [s1,s2,s3], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            //animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: false},
				
            },
			series:[
				{label:'매출액'},
				{label:'구매완료액'},
				{label:'취소/환불/반품액'}
			],
			legend: {
				show: true
			},
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
				yaxis:{
					
					tickOptions:{
						 formatString:"%'d"
					}
				}
            },
            highlighter: { show: false }
        });
    */
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                //$('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );	
		
	});

//-->
</script>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea" style="background:#f4f4f4;">
	<table style="width:100%;">
		<tr>
			<td class="leftWrap">
				<!-- ******************** leftArea ********************** -->
					<!-- 기본정보 -->
					<div class="serviceInfo">
						<ul>
							<li><span><?=$LNG_TRANS_CHAR["EW00116"] //버전?></span>: <strong  class="txtColorBlue">1.30.12.0605</strong></li>
							<li><span>PHP버젼</span>: <strong  class="txtColorBlue"><?php echo PHP_VERSION;?></strong></li>
							<!--
							<li><span><?=$LNG_TRANS_CHAR["EW00117"] //설치일?></span>: <?=$shopInfo['startDateTime'][0]?></li>
							<li><span><?=$LNG_TRANS_CHAR["EW00118"] //종료일?></span>: <?=$shopInfo['endDateTime'][0]?></li>
							<li><span><?=$LNG_TRANS_CHAR["EW00119"] //남은기간?></span>: <strong  class="txtColorBlue"><?=$shopInfo['totalUseDate'][0]?></strong>일 <a href="javascript:alert('관리자에게 문의해주세요.')"/><?=$LNG_TRANS_CHAR["EW00120"] //기간연장?></a></li>
							<li><span><?=$LNG_TRANS_CHAR["EW00121"]//등록상품?></span>: <strong  class="txtColorBlue"><?=$shopInfo['productCnt'][0]?></strong><?=$LNG_TRANS_CHAR["CW00045"]//개?></li>
							<li><span><?=$LNG_TRANS_CHAR["EW00122"]//SMS?></span>: <strong  class="txtColorBlue"><?=$shopInfo['smsPoint'][0]?> </strong><?=$LNG_TRANS_CHAR["MW00167"]//건?></li>
							<li><span><?=$LNG_TRANS_CHAR["EW00123"]//용량?></span>: <strong  class="txtColorBlue"><?=$shopInfo['useSize'][0]?>M <?=$LNG_TRANS_CHAR["EW00131"]//사용중?></strong>(1G)</li>
							-->
						</ul>
					</div><!-- serviceInfo -->
					<!-- 기본정보 -->

					<!-- 서비스 설정정보 -->
					<div class="serviceSetup">
						<table>
														
						</table>
					</div>
					<!-- 서비스 설정정보 -->
				<!-- ******************** leftArea ********************** -->
			</td>
			<td class="contentWrap">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
				<div class="bodyWrap" style="border:1px solid #333;min-width:1000px;">
					<div>
						<!-- (1) 전체현황 -->
						<?include MALL_WEB_PATH."shopAdmin/main/summury_manage.inc.php";?>
						<!-- (1) 전체현황 -->

						<!-- 메모기능 -->
							<?
							/*
							?>
							<div class="memoWrap left">
								<img src="./himg/common/memo_tit.png">
								<img src="./himg/common/icon_clip.png" class="clipIcon">
								<div class="memoListWrap">
										<ul>
											<!-- (1) -->
											<li class="memoTit"><span></span></li>	
											<li>
												<span class="writer left">Admin</span>
												<!-- span class="memoBtn right">
													<a href="#">삭제</a> |
													<a href="#">수정</a>
												</span -->
												<div class="clear"></div>
											</li>	
											<!-- (1) -->
											<!--li class="writeBox" style="padding-bottom:0px;"><textarea name="" style="width:100%;height:45px;line-height:22px;background:none;border:none;"></textarea></li>
											<li class="btnWrap"><img src="./himg/common/btn_memo_write.png"></li -->
										</ul>
								</div><!-- memoListWrap -->
								<img src="./himg/common/memo_shadow.png" class="shadowIcon">
							</div><!-- memoWrap -->
							<?
							*/
							?>
						<!-- 메모기능 -->
						<div class="clear"></div>
					</div>

					<div class="mt10">
					<!-- (2) 1:1문의 -->
						<div class="mainBasicBox left" style="width:600px;">
							<div class="mainBoardWrap left">
								<div class="mainPageTitWrap" style="border-right:none;"><strong><?=$LNG_TRANS_CHAR["MW00178"]//상품 문의?></strong></div>
								<div class="mainListWrap" style="border-right:none;">
									<table>
										<colgroup>
											<col style="width:42px"/>
											<col/>
											<col style="width:35px"/>
										</colgroup>
										<? while ( $row = mysql_fetch_array ( $result1 ) ) :  ?>
										<tr>
											<td><?=$row['UB_M_ID']?></td>
											<td><a href="./?menuType=community&mode=dataView&b_code=PROD_QNA&ubNo=<?=$row['UB_NO']?>&ub_no=<?=$row['UB_NO']?>"><?=strHanCutUtf($row['UB_TITLE'],20)?></a></td>
											<td><?=date("m.d", strtotime($row['UB_REG_DT']))?></td>
										</tr>
										<? endwhile; ?>
									</table>
								</div><!-- mainListWrap -->
							</div><!-- mainBoardLeftWrap -->
							<div class="mainBoardWrap right">
								<div class="mainPageTitWrap"><strong><?=$LNG_TRANS_CHAR["MW00177"]//1:1게시판?></strong></div>
								<div class="mainListWrap">
									<table>
										<colgroup>
											<col style="width:42px"/>
											<col/>
											<col style="width:35px"/>
										</colgroup>
										<?	while ( $row = mysql_fetch_array ( $result2 ) ) : ?>
										<tr>
											<td><?=$row['UB_M_ID']?></td>
											<td><a href="./?menuType=community&mode=dataView&b_code=MY_QNA&ubNo=<?=$row['UB_NO']?>&ub_no=<?=$row['UB_NO']?>"><?=strHanCutUtf($row['UB_TITLE'],20)?></a></td>
											<td><?=date("m.d", strtotime($row['UB_REG_DT']))?></td>
										</tr>
										<?	endwhile; ?>
									</table>
								</div><!-- mainListWrap -->
							</div><!-- mainBoardLeftWrap -->
							<div class="clear"></div>
						</div>
					<!-- (2) 상품문의 -->
					<?/*?>
					<div class="mainBoardWrap left" style="width:247px;margin-left:10px;">
						<div class="mainPageTitWrap"><!-- <strong><?=$LNG_TRANS_CHAR["MW00246"]//패치/업그레이드?></strong>  --></div>
						<div class="mainListWrap">
							<!-- <iframe src="http://www.eumshop.com/api/iframe/shopRightScreen.iFrame.php/?shopId=<?=$S_SHOP_HOME?>" width="240" height="105" scrolling="no" frameborder=0 marginwidth=0 marginheight=0></iframe>  -->
						</div><!-- mainListWrap -->
					</div><!-- mainBoardLeftWrap -->
					<?*/?>
				<!-- 메모기능 -->
					<div class="clear"></div>
				</div>
	
				<!--
				<div class="mt10">
					<!-- 년매출 비교 
					<div class="left" style="width:600px;background:#FFF;">
						<div class="mainPageTitWrap"><strong><?=date("Y")?><?=$LNG_TRANS_CHAR["MW00247"] //년 매출현황?></strong></div>
						<div class="plot" style="width:600px;height:320px;margin-bottom:30px;" id="chart1">
						</div>
					</div><!-- yearGraphWrap -->
					<!-- 년매출 비교 
					<?/*?>
					<div class="left" style="width:230px;min-height:330px;padding:7px;margin-left:10px;border:1px solid #cccccc;background:#FFF;">
						<!-- img src="./himg/common/logo_eumshop.gif"/ 
					</div>
					<?*/?>
					<div class="clear"></div>
				</div>
				-->

				</div><!-- bodyWrap -->
				<!-- ******************** contentsArea ********************** -->
			</td>
			
		</tr>
	</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>
	<script class="include" type="text/javascript" src="./common/statics/jquery.jqplot.min.js"></script>
	<script type="text/javascript" src="./common/statics/syntaxhighlighter/scripts/shCore.min.js"></script>
	<script type="text/javascript" src="./common/statics/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
	<script type="text/javascript" src="./common/statics/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
	<!-- Additional plugins go here -->

	<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.barRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.pieRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	<script class="include" type="text/javascript" src="./common/statics/plugins/jqplot.pointLabels.min.js"></script>

	<script type="text/javascript" src="./common/statics/plugins/jqplot.logAxisRenderer.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.dateAxisRenderer.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.barRenderer.min.js"></script>


	<script type="text/javascript" src="./common/statics/plugins/jqplot.highlighter.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.cursor.min.js"></script>
	<script type="text/javascript" src="./common/statics/plugins/jqplot.pointLabels.min.js"></script>

</html>
				
