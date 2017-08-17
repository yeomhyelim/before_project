<?
#/*====================================================================*/# 
#|화일명	: Scraping.php																												|#
#|작성자	: 김희성(THAV@NAVER.COM)																						|#
#|작성일	: 2012.08.30																												|#
#|작성내용	: 스누피를 이용한 웹사이트 스크랩핑																			|#
#|버전 		: 0.0.0.1																													|#
#/*====================================================================*/# 

class Scraping extends Snoopy
{
 	public  $scrStruct					= null;				// conf 파일 데이터 저장
	private $url							= null;				// url
	private $hs							= null;				// log
	private $sessionID					= null;

	public $intSizeOfPage			= 0;					// 전체 페이지 수 
	public $intSizeOfLink			= 0;					// 전체 상품 수



	private $strSitePath				= null;				// web site list
	private $dataFetch				= null;
	private $dataFetchLinks			= null;
	private $dataFetchText			= null;
	private $productMgr				= null;				// 상품관리 데이터베이스
	private $db							= null;
	private $userTemp				= null;				// 템프 저장(배열)

	

	/* 생성자 */
	public function Scraping(&$hs)		
	{			
		$this->hs = $hs;		
		$this->sessionID		= session_id();
		$this->scrStruct			= new ScrapingStruct($this->hs);
	}

	public function setSessionID(&$sId)						{		$this->sessionID = $sId;										}
	public function setUrl($url)									{		$this->url = $url;												}
	public function getSizeOf_Page()							{		return $this->intSizeOfPage;								}
	public function getSizeOf_Link()							{		return $this->intSizeOfLink;									}


	##############################################################
	# 백그라운드 수행 함수
	# return
	##############################################################
	public function backgroundRun($url)
	{
		$this->trace(MALL_HOME);
		$PID = shell_exec("/usr/bin/php -f" . MALL_HOME . "/scraping/ScrapingRun.class.php " . $url . " " . session_id() . "> /dev/null & echo $!");
		return $PID;
	}
	##############################################################
	# HTML 내용 가져오기
	# return
	##############################################################
	public function getDataHtml()	
	{
		$path				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "html" );
		$readFile			= file($path);

		foreach($readFile as $f)
			$responseText .= $f;

		return $responseText;
	}
	##############################################################
	# 스크립핑 가능한 사이트인지 폴더 체크 합니다.
	# return
	#				0 : 사이트 없음, 
	#				1 : 사이트 있음. 
	##############################################################
	public function siteCheckFile($nameDF) 
	{
		$this->trace("siteCheckFile start", TRACE_LEVEL_NORM);	
		$sitePath			= MALL_HOME."/scraping/site";					// scraping config list
		$pagePath			= MALL_HOME."/scraping/page";				// scraping html file 
		if ( is_file( $sitePath . "/" . $nameDF )  || is_dir( $pagePath . "/" . $nameDF )  ) {			
			$this->trace("getSiteCheckUrl end", TRACE_LEVEL_NORM);				
			return  1;					
		}
		$this->trace("siteCheckFile end", TRACE_LEVEL_NORM);	
		return 0;
	}
	##############################################################
	# 스크립핑 가능한 사이트인지 체크 합니다.
	# return
	#				0 : 사이트 없음, 
	#				1 : 사이트 있음. 
	##############################################################
	public function siteCheckUrl($url)
	{
		$this->trace("getSiteCheckUrl start", TRACE_LEVEL_NORM);		
		$sitePath			= MALL_HOME."/scraping/site";
		$urlInfo				= parse_url ($url, PHP_URL_HOST);
		$urlInfo				= explode("." , $urlInfo);	
		
		if ( is_file( $sitePath . "/" . $urlInfo[0] )  || is_file( $sitePath . "/" . $urlInfo[1] )  ) {			
			$this->trace("getSiteCheckUr2012-09-04l end", TRACE_LEVEL_NORM);				
			return  1;					
		}

		$this->trace("getSiteCheckUrl end", TRACE_LEVEL_NORM);
		return 0;
	}
	##############################################################
	# 스크랩핑에 필요한 정보 로드
	# return
	##############################################################
	public function scrapingInfoLoad($url)
	{
		$this->trace("scrapingInfoLoad start", TRACE_LEVEL_NORM);		
		$dirPath			= MALL_HOME."/scraping/site";
		$urlInfo				= parse_url ($url, PHP_URL_HOST);
		$urlInfo				= explode("." , $urlInfo);
		if ( !is_array($urlInfo) ) {
			$this->trace("scrapingInfoLoad end (not good URL : $url )", TRACE_LEVEL_FAIL);
			return -1;
		}
		if ( is_file( $dirPath . "/" . $urlInfo[0] ) )					{				$fileName = 	$dirPath . "/" . $urlInfo[0];				}
		else if ( is_file( $dirPath . "/" . $urlInfo[1] ) )			{				$fileName = 	$dirPath . "/" . $urlInfo[1];				}

		$this->scrStruct->setUrl( $url );
		$this->scrStruct->setInfoFileName( $fileName );
		$this->scrStruct->initialization();

		$this->getHtmlPage( $url );
		$key								= "sizeOf_Page";
		$this->intSizeOfPage		= $this->getDataCut($key);
		/*---------------------------------------------------------------------------------------------------------------------------------*/

		$aryData						= &$this->scrStruct->SCRAPING_DATA[$key][DATA];	
		$key								= "sizeOf_Link";
		foreach( $aryData[sizeOf_Page] as $data ) {
			$this->trace(  $this->scrStruct->SCRAPING_DATA[$key][DATA][sizeOf_Page] );
			$this->getHtmlPage( $data );
			$this->intSizeOfLink		= $this->intSizeOfLink + $this->getDataCut($key);
		}		
		/*---------------------------------------------------------------------------------------------------------------------------------*/
	
		$this->trace("scrapingInfoLoad end", TRACE_LEVEL_NORM);
		return 0;
	}
	##############################################################
	# 스크립핑 시작, 정보 수집 (From File
	# return
	##############################################################
	public function scrapingFileLoad($nameDF)
	{
		$this->trace("scrapingFileLoad start", TRACE_LEVEL_NORM);	
		$sitePath			= MALL_HOME."/scraping/site";					// scraping config list
		$pagePath			= MALL_HOME."/scraping/page";				// scraping html file 
		$this->trace(is_dir( $pagePath . "/" . $nameDF ));
		$this->trace(is_file( $sitePath . "/" . $nameDF ));

	if ( !is_file( $sitePath . "/" . $nameDF ) )	 {	
		$this->trace("can't find this file : " . $sitePath . "/" . $nameDF, TRACE_LEVEL_NORM);	
		$this->trace("scrapingFileLoad end", TRACE_LEVEL_NORM);	
		return 1;
	} 
	$this->scrStruct->setUrl( $pagePath . "/" . $nameDF );
	$this->scrStruct->setInfoFileName( $sitePath . "/" . $nameDF );
	$this->scrStruct->initialization();		

	/*---------------------------------------------------------------------------------------------------------------------------------*/
	$pCode							= 0;
	$dir								= dir( $pagePath . "/" . $nameDF );
	while( $file = $dir->read() ) {
		if ( $file == "." || $file == ".." ) {		continue;		}

		$filePoint = fopen( $pagePath . "/" . $nameDF . "/" . $file , "r" );
		if( !$filePoint ) {
			$this->trace("can not open this file : " . $pagePath . "/" . $nameDF . "/" . $file, TRACE_LEVEL_NORM);	
			$this->trace("scrapingFileLoad end", TRACE_LEVEL_NORM);	
			return 1;
		}
		$size						= filesize( $pagePath . "/" . $nameDF . "/" . $file );
		$this->results		= fread($filePoint, $size );
		fclose( $filePoint );

		$this->getFilePage();

		/* 데이터 가져오기 시작 */
		$productInfo[prodName]						= $this->getDataCut("prodName");											// 상품이름
		$productInfo[sallingPrice]						= $this->getDataCut("sallingPrice");											// 상품가격

		$productInfo[webText1]							= $this->getDataCut("webText1");												// 상품설명
		$productInfo[webText2]							= $this->getDataCut("webText2");												// 상품설명
		$productInfo[webText][0]						=	$productInfo[webText1][0]	 . $productInfo[webText2][0];			// 상품설명 함치기	

		$listImage												= $this->getDataCut("listImage");												// 리스트이미지
		$detailImage											= $this->getDataCut("detailImage");											// 상세이미지

		$productItem = null;
		for( $i=0; $i < 9; $i++ )
			$productItem[]								= $this->getDataCut("prodItem_" . $i);											// 상품 아이템

		$productOpt = null;
		for( $i=0; $i < 63; $i++) 
			$productOpt[]								= $this->getDataCut("prodOpt_" . $i);												// 옵션


		$this->makeToHtmlFile( $productInfo, $pCode );
		$this->makeToMgrTempSQL( $productInfo, $pCode, "productInfo", false );
		$this->makeToItemTempSQL( $productItem, $pCode, "productItem", false );
		$this->makeToOptTempSQL( $productOpt, $pCode, "productOpt", false );
		$this->makeToImgTempSQL( $listImage, $pCode, "listImage", false );
		$this->makeToImgTempSQL( $detailImage, $pCode, "detailImage", false );
	


		$pCode++;

	}






		$this->trace("scrapingFileLoad end", TRACE_LEVEL_NORM);	
	}
	##############################################################
	# 스크립핑 시작, 정보 수집
	# return
	##############################################################
	public function scrapingRunLoad($url)
	{
		$this->trace("scrapingRunLoad start", TRACE_LEVEL_NORM);	

		/* 리스트 이미지 스크립핑 */
		$pCode							= 0;
		$aryData						= &$this->scrStruct->SCRAPING_DATA[sizeOf_Page][DATA];			
		foreach( $aryData[sizeOf_Page] as $data ) {
			$this->getHtmlPage( $data );
			$listImage = $this->getDataCut("listImage");
			$this->makeToImgTempSQL( $listImage, $pCode, "listImage", true );	
		}
		/*---------------------------------------------------------------------------------------------------------------------------------*/

		$pCode							= 0;
		$aryData						= &$this->scrStruct->SCRAPING_DATA[sizeOf_Link][DATA];	
		foreach( $aryData[sizeOf_Link] as $data ) {
			$this->getHtmlPage( $data );

//			$productInfo[prodOpt_0]				= $this->getDataCut("prodOpt_0");

			$productInfo[prodName]				= $this->getDataCut("prodName");
			$productInfo[sallingPrice]				= $this->getDataCut("sallingPrice");
			$productInfo[supplyPrice]				= $this->getDataCut("supplyPrice");
			$productInfo[savedMoney]				= $this->getDataCut("savedMoney");
			$productInfo[maker]						= $this->getDataCut("maker");	
			$productInfo[placeOfOrigin]			= $this->getDataCut("placeOfOrigin");	
			$productInfo[productCode]				= $this->getDataCut("productCode");	
			$colorOption									= $this->getDataCut("colorOption");	
			$sizeOption									= $this->getDataCut("sizeOption");	
			$viewImage									= $this->getDataCut("viewImage");	
			$productIntro								= $this->getDataCut("productIntroduce");	

			$this->makeToImgTempSQL( $viewImage, $pCode, "viewImage", false );
			$this->makeToImgTempSQL( $productIntro, $pCode, "productIntroduce", false );
			$this->makeToOptTempSQL( $colorOption, $pCode, "colorOption", false );
			$this->makeToOptTempSQL( $sizeOption, $pCode, "sizeOption", false );
			$this->makeToMgrTempSQL( $productInfo, $pCode, "productInfo", false );
			$this->makeToHtmlFile( $productInfo, $pCode );


			$pCode++;
			break;
		}

		$this->trace("scrapingRunLoad end", TRACE_LEVEL_NORM);
		return 0;
	}

	##############################################################
	#  PRODUCT_IMG_TEMP SQL 파일 만들기 
	# return
	##############################################################
	public function makeToImgTempSQL( &$data, &$pCode, $key, $flag = true ) 
	{
		$this->trace("makeToImgTempSQL start", TRACE_LEVEL_NORM);
		$path				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, $key );
		if( $pCode == 0 )	{			unlink($path);																}
		$fp					= fopen( $path, "a+" );
		if( !$fp )					{			echo "Error! Can't make the file";			return;			}


		$query				= "INSERT INTO `PRODUCT_IMG_TEMP` (`P_CODE`, `PM_TYPE`, `PM_REAL_NAME`) VALUES ('▣▣%d▣▣', '%s', '%s')\r\n";
		$type				= $this->scrStruct->SCRAPING_DATA[$key][TYPE];
		for ( $i = 0; $i < sizeof($data)  ; $i++) {
			$pmType				= $data[PM_TYPE];		
			$pmRealName		= $data[$i];
			if ($pmRealName	== "") { continue; }
			if ( !$type ) {
				if( $pmType == "view" ) 
					$pmType = ( $i == 0 ) ? $pmType  : $pmType . (string)$i;	
			} else { $pmType = $type; }
			$queryData	= sprintf( $query, $pCode, $pmType, $pmRealName );
			fwrite($fp, $queryData);
			$this->trace("query = " . $queryData );
			if( $flag == true ) { $pCode++; }
		}
		fclose($fp);
		$this->trace("makeToImgTempSQL end", TRACE_LEVEL_NORM);
		return;
	}
	##############################################################
	#  PRODUCT_OPT_TEMP SQL 파일 만들기 
	# return
	##############################################################
	public function makeToOptTempSQL( &$data, &$pCode, $key, $flag = true ) 
	{
		$this->trace("makeToOptTempSQL start", TRACE_LEVEL_NORM);
		$path				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, $key );
		if( $pCode == 0 )	{			unlink($path);																}
		$fp					= fopen( $path, "a+" );
		if( !$fp )					{			echo "Error! Can't make the file";			return;			}

		$query				= "INSERT INTO `PRODUCT_OPT_TEMP` (`P_CODE`, `PT_NAME`, `PT_TYPE`) VALUES (▣▣%d▣▣, '%s', '%s')\r\n";
		foreach( $data as $value ) {
			$ptName		=	$value[0];
			$ptType		=	$value[PT_TYPE];
			$queryData	= sprintf( $query, $pCode, $ptName, $ptType );
			fwrite($fp, $queryData);
			$this->trace("query = " . $queryData );
			if( $flag == true ) { $pCode++; }
		}
		fclose($fp);
		$this->trace("makeToOptTempSQL end", TRACE_LEVEL_NORM);
		return;
	}
	##############################################################
	#  PRODUCT_ITEM_TEMP SQL 파일 만들기 
	# return
	##############################################################
	public function makeToItemTempSQL( &$data, &$pCode, $key, $flag = true ) 
	{
		$this->trace("makeToOptTempSQL start", TRACE_LEVEL_NORM);
		$path				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, $key );
		if( $pCode == 0 )	{			unlink($path);																}
		$fp					= fopen( $path, "a+" );
		if( !$fp )					{			echo "Error! Can't make the file";			return;			}

		$query				= "INSERT INTO `PRODUCT_ITEM_TEMP` (`P_CODE`, `PI_NAME`, `PI_TEXT`) VALUES (▣▣%d▣▣, '%s', '%s')\r\n";
		foreach($data as $value ) {
			$piName		= $value[PI_NAME];
			$piText			= $value[0];
			$queryData	= sprintf( $query, $pCode, $piName, $piText );
			fwrite($fp, $queryData);
			$this->trace("query = " . $queryData );
			if( $flag == true ) { $pCode++; }
		}
		fclose($fp);
		$this->trace("makeToOptTempSQL end", TRACE_LEVEL_NORM);
		return;
	}
	##############################################################
	#  PRODUCT_MGR_TEMP SQL 파일 만들기 
	# return
	##############################################################
	public function makeToMgrTempSQL( &$data, &$pCode, $key, $flag = true ) 
	{
		$this->trace("makeToMgrTempSQL start", TRACE_LEVEL_NORM);
		$path				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, $key );
		if( $pCode == 0 )	{			unlink($path);																}
		$fp					= fopen( $path, "a+" );
		if( !$fp )					{			echo "Error! Can't make the file";			return;			}

		$productCode			= $data[productCode][0];
		$prodName				= $data[prodName][0];
		$maker						= $data[maker][0];
		$placeOfOrigin			= $data[placeOfOrigin][0];
		$maker						= $data[maker][0];
//		$webText					= htmlspecialchars( $data[webText][0] );
		$webText					= addslashes($data[webText][0]);
		$supplyPrice				= sizeof( $data[supplyPrice][0] ) > 0		?		$data[supplyPrice][0]				: "0" ;
		$sallingPrice				= sizeof( $data[sallingPrice][0] ) > 0		?		$data[sallingPrice][0]				: "0" ;
		$savedMoney			= sizeof( $data[savedMoney][0] ) > 0		?		$data[savedMoney][0]			: "0" ;

//		$query				 = "INSERT INTO `PRODUCT_MGR_TEMP` ";
//		$query				.= "(`P_CODE`, `P_SITE_CODE`, `P_NAME`, `P_CATE`, `P_NUM`, `P_MAKER`, `P_ORIGIN`, `P_BRAND`, `P_SALE_PRICE`, `P_CONSUMER_PRICE`, `P_STOCK_PRICE`, `P_POINT`, `P_WEB_TEXT`, `P_USE`, `P_REG_DT`) VALUES ";
//		$query				.= "('▣▣%d▣▣', '%s', '%s', '▣▣P_CATE▣▣', '%s', '%s', '%s', '%s', %s, %s, %s, %s,'%s', '%s', NOW())\r\n";
//		$queryData		= sprintf( $query, $pCode, $productCode, $prodName, $productCode, $maker, $placeOfOrigin, $maker, $supplyPrice, $sallingPrice, $sallingPrice, $savedMoney, $webText, "N" );
		$query				 = "INSERT INTO `PRODUCT_MGR_TEMP` ";
		$query				.= "(`P_CODE`, `P_SITE_CODE`, `P_NAME`, `P_CATE`, `P_NUM`, `P_MAKER`, `P_ORIGIN`, `P_BRAND`, `P_SALE_PRICE`, `P_CONSUMER_PRICE`, `P_STOCK_PRICE`, `P_POINT`, `P_WEB_TEXT`, `P_USE`, `P_REG_DT`) VALUES ";
		$query				.= "('▣▣%d▣▣', '%s', '%s', '▣▣P_CATE▣▣', '%s', '%s', '%s', '%s', %s, %s, %s, %s,'%s', '%s', NOW())\r\n";
		$queryData		= sprintf( $query, $pCode, $productCode, $prodName, $productCode, $maker, $placeOfOrigin, $maker, $sallingPrice, 0, 0, 0, $webText, "N" );

		fwrite($fp, $queryData);
		$this->trace("query = " . $queryData );
		if( $flag == true ) { $pCode++; }
		fclose($fp);
		$this->trace("makeToMgrTempSQL end", TRACE_LEVEL_NORM);
		return;
	}
	##############################################################
	#  HTML 파일 만들기 
	# return
	##############################################################
	public function makeToHtmlFile( &$data, &$pCode )
	{
			$this->trace("makeToHtmlFile start", TRACE_LEVEL_NORM);
			$path				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "html" );
			
			if( $pCode == 0 )	{		
				unlink($path);	
				$responseText	= "<tr class=\"item1\"><th><input type=\"checkbox\" name=\"\"/></th><th>번호</th><th>상품명</th>";
				$responseText	.= "<th>판매가</th><th>가져온일자</th></tr>";
			}

			$fp					= fopen( $path, "a+" );
			if( !$fp )					{			echo "Error! Can't make the file";			return;			}

			$responseText .= "<tr id='TrNo_$i'>";
			$responseText .= "<td><input type='checkbox' name=''/> </td>";
			$responseText .= "<td>".($pCode+1)."</td>";
			$responseText .= "<td>".$data[prodName][0]."</td>";
//			$responseText .= "<td><input type='text' name='' $nBox  value='".$data[supplyPrice][0]."' style='width:80px;'/></td>";
			$responseText .= "<td><input type='text' name='' $nBox  value='".$data[sallingPrice][0]."' style='width:80px;'/></td>";
//			$responseText .= "<td><input type='text' name='' $nBox  value='".$data[sallingPrice][0]."' style='width:80px;'/></td>";
//			$responseText .= "<td><input type='text' name='' $nBox  value='".$data[savedMoney][0]."' style='width:80px;'/></td>";
			$responseText .= "<td>" . date("Y-m-d H:i:s") . "</td>";
			$responseText .= "</tr>";
			$responseText .= "\r\n";

			fwrite($fp, $responseText);
			fclose($fp);
			$this->trace("makeToHtmlFile end", TRACE_LEVEL_NORM);
			return;
	}
	##############################################################
	#  스크랩핑으로 생성된 파일 데이터베이스에 Insert
	# return
	##############################################################
	public function userSaveDB(&$db, &$productMgr, $strP_CATE) 
	{

			$this->trace("userSaveDB start", TRACE_LEVEL_NORM);
//			$path1				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "productInfo" );
//			$path2				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "viewImage" );
//			$path3				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "listImage" );
//			$path4				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "colorOption" );
//			$path5				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "sizeOption" );
//			$path6				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "productIntroduce" );

			$path1				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "productInfo" );
			$path2				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "listImage" );
			$path3				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "detailImage" );
			$path4				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "productItem" );
			$path5				= sprintf( MALL_HOME."/scraping/session/%s_%s.txt" , $this->sessionID, "productOpt" );

		
			$readFile1			= file($path1);
			$readFile2			= file($path2);
			$readFile3			= file($path3);
			$readFile4			= file($path4);
			$readFile5			= file($path5);
//			$readFile6			= file($path6);


			$i								= 0;
			foreach($readFile1 as $query) {
				$strPCode				= $productMgr->getProductTempCode($db);
				$aryPCode[$i]		= $strPCode;
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$oldPCate				= sprintf("▣▣%s▣▣", "P_CATE");
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				$query					= ereg_replace($oldPCate, $strP_CATE, $query);
				$this->trace($query);
				$productMgr->getProductTempQuery($db, $query);	
				$i++;
			}

			$i								= 0;
			foreach($readFile2 as $query) {
				$strPCode				= $aryPCode[$i];
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				$productMgr->getProductTempQuery($db, $query);
				$i++;
			}


			$i								= 0;
			foreach($readFile3 as $query) {
				$strPCode				= $aryPCode[$i];
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$nexPCode			= sprintf("▣▣%d▣▣", $i+1);
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				if( ereg( $nexPCode, $query ) ) {
					$i++;
					$strPCode			= $aryPCode[$i];
					$query				= ereg_replace($nexPCode, $strPCode, $query);
				}
				$productMgr->getProductTempQuery($db, $query);
			}


			$i								= 0;
			foreach($readFile4 as $query) {
				$strPCode				= $aryPCode[$i];
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$nexPCode			= sprintf("▣▣%d▣▣", $i+1);
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				if( ereg( $nexPCode, $query ) ) {
					$i++;
					$strPCode			= $aryPCode[$i];
					$query				= ereg_replace($nexPCode, $strPCode, $query);
				}
				$productMgr->getProductTempQuery($db, $query);
			}


			$i								= 0;
			foreach($readFile5 as $query) {
				$strPCode				= $aryPCode[$i];
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$nexPCode			= sprintf("▣▣%d▣▣", $i+1);
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				if( ereg( $nexPCode, $query ) ) {
					$i++;
					$strPCode			= $aryPCode[$i];
					$query				= ereg_replace($nexPCode, $strPCode, $query);
				}
				$productMgr->getProductTempQuery($db, $query);
			}

/*--
			$i								= 0;
			foreach($readFile5 as $query) {
				$strPCode				= $aryPCode[$i];
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$nexPCode			= sprintf("▣▣%d▣▣", $i+1);
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				if( ereg( $nexPCode, $query ) ) {
					$query				= ereg_replace($nexPCode, $strPCode, $query);
					$i++;
				}
				$productMgr->getProductTempQuery($db, $query);
			}

			$i								= 0;
			foreach($readFile6 as $query) {
				$strPCode				= $aryPCode[$i];
				$oldPCode				= sprintf("▣▣%d▣▣", $i);
				$nexPCode			= sprintf("▣▣%d▣▣", $i+1);
				$query					= ereg_replace($oldPCode, $strPCode, $query);
				if( ereg( $nexPCode, $query ) ) {
					$query				= ereg_replace($nexPCode, $strPCode, $query);
					$i++;
				}
				$productMgr->getProductTempQuery($db, $query);
			}

--*/

//			unlink($path1);	
//			unlink($path2);	
//			unlink($path3);	
//			unlink($path4);	
//			unlink($path5);	
//			unlink($path6);	
			$this->trace("userSaveDB end", TRACE_LEVEL_NORM);
			return;
	}


	##############################################################
	#  fetch() 함수를 사용하여 웹사이트 파일 호출 및 데이터 초기 정리
	# return
	##############################################################
	public function getHtmlPage($strUrl)
	{
		$this->trace("getHtmlPage start", TRACE_LEVEL_NORM);
		$this->fetch($strUrl);
		$this->getFilePage();
		$this->trace($this->results, TRACE_HTML_CODE);	
		$this->trace("getHtmlPage end", TRACE_LEVEL_NORM);
		return 0;
	}
	##############################################################
	#  순수 HTML 정보를 형식에 맞게 초기 정리
	# return
	##############################################################
	public function getFilePage() {
		$this->results = str_replace("euc-kr", 'UTF-8', $this->results);
		$this->results = str_replace("\n", '', $this->results);				
		$this->results = str_replace("\r", '', $this->results);
		$this->results = str_replace("\t", '', $this->results);
		$this->results = str_replace("	", '', $this->results);
		$this->results = iconv("euc-kr", "UTF-8", $this->results);

	}

	##############################################################
	##############################################################
	##############################################################
	#  형식에 맞게 데이터 스크립핑
	# return
	##############################################################
	##############################################################
	##############################################################
	public function getDataCut($key)
	{
		$this->trace("getDataCut start", TRACE_LEVEL_NORM);
		$aryLevel			=  $this->scrStruct->SCRAPING_DATA[$key][LEVEL];
		$aryData			= &$this->scrStruct->SCRAPING_DATA[$key][DATA];
		$arrayResults[0]	= $this->results;

		foreach($aryLevel as $level) {
			// 정규화 표현식을 이용한 내용 가져오기
			$aryTempData = null;
			if( ereg( "preg_match_all=", $level ) ) {
				$this->Trace( "[$level] " , TRACE_LEVEL_PREG_MATCH_ALL );
				$op						= substr($level, strlen("preg_match_all=")); 
				foreach($arrayResults as $tempResults) {
					preg_match_all ( $op, $tempResults, $out, PREG_PATTERN_ORDER );
					$temp = "";
					foreach ( $out as &$out_1 ) {
						foreach ( $out_1 as &$out_2 ) {
							$temp	 .= $out_2;
						}
					}
					$aryTempData[]			= $temp;
					$this->Trace( $temp , TRACE_LEVEL_PREG_MATCH_ALL	 );
				}
				$arrayResults				= $aryTempData;		
				continue;
			}
			/*---------------------------------------------------------------------------------------------------------------------------------*/

				// snoopy 함수, 텍스트 값만 반환
				if( ereg( "_striptext=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_STRIPTEXT );
					foreach($arrayResults as $tempResults) {
						$temp						= $this->_striptext($tempResults);
						$aryTempData[]			= $temp;
						$this->Trace( $temp , TRACE_LEVEL_STRIPTEXT	 );
					}
					$arrayResults				= $aryTempData;	
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/
		
				// 정규화 표현식을 이용하여 A를 B 로 변경 (여기서 구분자는 &nbsp; 로 한다.)
				if( ereg( "ereg_replace=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_EREG_REPLACE );
					$op = substr($level, strlen("ereg_replace="));
					$op = split("▣▣SPLIT▣▣", $op);
					foreach($arrayResults as $tempResults) {
						$temp						= ereg_replace($op[0], $op[1], $tempResults);
						$aryTempData[]			= $temp;
						$this->Trace( $temp , TRACE_LEVEL_EREG_REPLACE	 );
					}
					$arrayResults				= $aryTempData;	
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 정규화 표현식을 이용하여 문자열 짜르기 
				if( ereg( "split=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_SPLIT );
					$op = substr($level, strlen("split="));
					foreach( $arrayResults as $tempResults ) {
						$aryTempData[]		= split($op, $tempResults);
					}
					$arrayResults = null;
					foreach( $aryTempData as $aryTemp ) {
						foreach( $aryTemp as $temp) {
							if( mb_strlen( $temp, "UTF-8" ) > 0 ) {
								$arrayResults[] = $temp;
								$this->Trace( $temp , TRACE_LEVEL_SPLIT	 );
							}
						}
					}
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 오른쪽 왼쪽 원하는 문자 제거하기
				if( ereg( "RLtrimEx=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_R_L_TRIM_EX );
					$op				= substr( $level, strlen( "RLtrimEx=" ) );
					foreach( $arrayResults as $tempResults ) {	
						$temp			= $tempResults;
						$temp			= $this->ltrimEx( $temp , $op );		
						$temp			= $this->rtrimEx( $temp , $op );
						$temp			= trim( $temp );
						if( mb_strlen( $temp, "UTF-8" ) > 0 ) {
							$aryTempData[] = $temp;
							$this->Trace( $temp , TRACE_LEVEL_R_L_TRIM_EX	 );
						}
					}
					$arrayResults = $aryTempData;
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 배열 정보를 DATA 배열에 추가
				if( ereg( "saveDataInArray=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_SAVE_DATA_IN_ARRAY );	
					$op = substr( $level, strlen( "saveDataInArray=" ) );
					foreach( $arrayResults as $tempResults ) {
						$aryData[$op][] = $tempResults;
						$this->Trace( "(" . sizeof($aryData[$op]) . ")" . $tempResults , TRACE_LEVEL_SAVE_DATA_IN_ARRAY	 );
					}
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 배열 개수 반환
				if( ereg( "sizeof=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_SIZE_OF );	
					$op = substr( $level, strlen( "sizeof=" ) );
					$arrayResults = ($op != "-") ? sizeof($aryData[$op]) : sizeof($arrayResults);
					$this->Trace( $arrayResults  , TRACE_LEVEL_SIZE_OF	 );
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 변수만큼 값 더하기
				if( ereg( "plus=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_PLUS );	
					$op = substr($level, strlen("plus="));		
					$arrayResults = $arrayResults + $op;
					$this->Trace( $arrayResults . "(" . sizeof($arrayResults) . ")" , TRACE_LEVEL_PLUS	 );
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 지정된 배열 변수에 데이터 추가
				if( ereg( "addDataInArray=", $level ) ) {
					$this->Trace( "[$level] " , TRACE_LEVEL_ADD_DATA_IN_ARRAY );	
					$op = substr( $level, strlen( "addDataInArray=" ) );
					if( $op == "THIS_WEB_SITE" )
							$op = $this->scrStruct->getUrl();
					$arrayResults[] = $op;
					foreach( $arrayResults as $tempResults ) {	
						$this->Trace( $tempResults , TRACE_LEVEL_ADD_DATA_IN_ARRAY	 );
					}
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// 원하는 내용을 앞부분에 추가. 
				if(ereg("addStringFront=", $level)) {
					$this->Trace( "[$level] " , TRACE_LEVEL_ADD_STRING_FRONT );	
					$op = substr($level, strlen("addStringFront="));
					if( $op == "THIS_WEB_SITE" )
						$op = $this->scrStruct->getUrl();
					foreach( $arrayResults as $tempResults ) {	
						$temp					= $op . $tempResults;
						$aryTempData[]		= $temp;
						$this->Trace( $temp , TRACE_LEVEL_ADD_STRING_FRONT	 );
					}
					$arrayResults = $aryTempData;
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/
		
				// 값을 비교해서 있으면 A를 없으면 B 를 출력 
				if(ereg("ereg=", $level)) {
					$this->Trace( "[$level] " , TRACE_LEVEL_PI_NAME );						//
					$op = substr($level, strlen("ereg="));
					$op = split("▣▣SPLIT▣▣", $op);
					foreach( $arrayResults as $tempResults ) {	
						if( ereg($op[0], $tempResults) )
							$temp					= $op[1];
						else
							$temp					= $op[2];
						$aryTempData[]			= $temp;
						$this->Trace( $temp , TRACE_LEVEL_EREG_REPLACE	 );
					}
					$arrayResults				= $aryTempData;	
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/


				// PRODUCT_ITEM 테이블의 PI_NAME 정의 
				if(ereg("PT_TYPE=", $level)) {
					$this->Trace( "[$level] " , TRACE_LEVEL_PI_NAME );						//
					$op = substr($level, strlen("PT_TYPE="));
					$arrayResults[PT_TYPE] = $op;
					continue;
				}
				// PRODUCT_ITEM 테이블의 PI_NAME 정의 
				if(ereg("PI_NAME=", $level)) {
					$this->Trace( "[$level] " , TRACE_LEVEL_PI_NAME );						//
					$op = substr($level, strlen("PI_NAME="));
					$arrayResults[PI_NAME] = $op;
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/

				// PRODUCT_IMG 테이블의 PM_TYPE 정의 
				if(ereg("PM_TYPE=", $level)) {
					$this->Trace( "[$level] " , TRACE_LEVEL_PI_NAME );						//
					$op = substr($level, strlen("PM_TYPE="));
					$arrayResults[PM_TYPE] = $op;
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/



				// Javascript 형식으로 불려지는 데이터를 인자값( , 구분) 정의된 형식으로 치환 (현재 최대 3개 가능) 
				if(ereg("httpUrl_A=", $level)) {
					$this->Trace( "[$level] " , TRACE_LEVEL_HTTP_URL_A );					//
					foreach ( $arrayResults as $tempResults ) {
						$op							= substr($level, strlen("httpUrl_A="));
						$temp						= split( "," , $tempResults );
						$op							= ereg_replace(▣▣0▣▣, $temp[0], $op);
						$op							= ereg_replace(▣▣1▣▣, $temp[1], $op);
						$op							= ereg_replace(▣▣2▣▣, $temp[2], $op);
						$aryTempData[]			= $op;
						$this->Trace( $op , TRACE_LEVEL_HTTP_URL_A	 );
					}
					$arrayResults = $aryTempData;
					continue;
				}
				/*---------------------------------------------------------------------------------------------------------------------------------*/


		}

		$this->trace("getDataCut end", TRACE_LEVEL_NORM);
		return $arrayResults;
	}











#########################################################################################################

	public function getArySiteConf($path = null)
	{
		$this->trace("getArySiteConf start", TRACE_LEVEL_NORM);

		if($path != null) { $this->strSitePath = $path; }
		
		$re = $this->scrStruct->initConfig($this->strSitePath, $this->url);

		$this->trace("getArySiteConf end", TRACE_LEVEL_NORM);
		return $re;
	}



	/*  scrapingMake.php */
	public function getHtmlCode()
	{
		$this->getHtmlPage();

//		return "DFF";
		return $this->results;
	}

	public function getScrapingCode($code, $html)
	{
		$this->results		= $html;
		$code				= explode("\r\n", $code);	

		$this->scrStruct->initConfig($code, $html, "data");
		
//		return $this->getRun("TEST");

		return $code;

	}
	/*  scrapingMake.php */








	// 백그라운드에서 수행되는 함수
	public function runPlay()
	{
		$path = "/home/mallinmall/www/logs/" . $this->sId;

		if($this->getArySiteConf() <= 0)
		{
			$this->trace("This URL can't do Scraping");
			$this->trace("Run End");
			return;
		}

		$this->getHtmlPage();

		$intTotalPage		= $this->getSizeOf_Page();		// 페이지 수 가져오기

		$intTotalLink		= $this->getSizeOf_Link();		// 상품 리스트(링크) 가져오기

		$this->trace("page : $intTotalPage, link : $intTotalLink");

		$this->getArySiteConf( MALL_HOME . "/config/site.product.conf");

		$link = $this->scrStruct->aryFunc[LINK][prodName][0];

		unlink($path);

		$htmlTopCode  = "";
		$htmlTopCode .= "<table id=\"prodListTable\" >";
		$htmlTopCode .= "<colgroup>";
		$htmlTopCode .= "<col style=\"width:40px;\"/>";
		$htmlTopCode .= "<col style=\"width:60px;\"/>";
		$htmlTopCode .= "<col/>";
		$htmlTopCode .= "<col style=\"width:100px;\"/>";
		$htmlTopCode .= "<col style=\"width:100px;\"/>";
		$htmlTopCode .= "<col style=\"width:100px;\"/>";
		$htmlTopCode .= "<col style=\"width:80px;\"/>";				
		$htmlTopCode .= "<col style=\"width:150px;\"/>";
//		$htmlTopCode .= "<col style=\"width:150px;\"/>";
		$htmlTopCode .= "</colgroup>";
		$htmlTopCode .= "<tr class=\"item1\">";
		$htmlTopCode .= "<th><input type=\"checkbox\" name=\"\"/></th>";
		$htmlTopCode .= "<th>번호</th>";
		$htmlTopCode .= "<th>상품명</th>";
		$htmlTopCode .= "<th>소비자가</th>";
		$htmlTopCode .= "<th>판매가</th>";
		$htmlTopCode .= "<th>적용가</th>";
		$htmlTopCode .= "<th>포인트</th>";
		$htmlTopCode .= "<th>가져온일자</th>";
	//	$htmlTopCode .= "<th>관리</th>";
		$htmlTopCode .= "</tr>";

		$i = 0;
		$this->makeTheFile($htmlTopCode);

		foreach($this->userTemp['sizeOf_Link'] as $url)
		{
			$strFPrint = "";

			$this->url = $link . $url;	

			$this->getHtmlPage();

			$strId				= $this->scrStruct->strId;
			$prodName			= $this->getRun("prodName");
			$price1				= $this->getRun("price1");
			$price2				= $this->getRun("price2");
			$price3				= $this->getRun("price3");
			$company			= $this->getRun("company");
			$country			= $this->getRun("country");
			$prodCode			= $this->getRun("prodCode");
			$opt1				= $this->getRun("opt1");
			$opt2				= $this->getRun("opt2");
			$image1				= $this->getRun("image1");
			$image2				= $this->getRun("image2");
			$image3				= $this->getRun("image3");

			$opt1				= $this->aryToString($opt1);
			$opt2				= $this->aryToString($opt2);
			$image3				= $this->aryToString($image3);

//			if(!mb_strlen($opt1)) { $opt1 = " "; }
//			if(!mb_strlen($opt2)) { $opt2 = " "; }

			$responseText  = "";
			$responseText .= "<tr id='TrNo_$i'>";
			$responseText .= "<td><input type='checkbox' name=''/></td>";
			$responseText .= "<td>".($i+1)."</td>";
			$responseText .= "<td>$prodName</td>";
			$responseText .= "<td><input type='text' name='' $nBox  value='$price1' style='width:80px;'/></td>";
			$responseText .= "<td><input type='text' name='' $nBox  value='$price2' style='width:80px;'/></td>";
			$responseText .= "<td><input type='text' name='' $nBox  style='width:80px;'/></td>";
			$responseText .= "<td><input type='text' name='' $nBox  value='$price3' style='width:80px;'/></td>";
			$responseText .= "<td>" . date("Y-m-d H:i:s") . "</td>";
			$responseText .= "</tr>";
			
			$responseText .= "<input type='hidden' name='TrNo' id='TrNo' value='$i'/>";
			$responseText .= "<input type='hidden' name='prodName' id='prodName' value='$prodName'/>";
			$responseText .= "<input type='hidden' name='price1' id='price1' value='$price1'/>";
			$responseText .= "<input type='hidden' name='price2' id='price2' value='$price2'/>";
			$responseText .= "<input type='hidden' name='price3' id='price3' value='$price3'/>";
			$responseText .= "<input type='hidden' name='company' id='company' value='$company'/>";
			$responseText .= "<input type='hidden' name='country' id='country' value='$country'/>";
			$responseText .= "<input type='hidden' name='siteCode' id='siteCode' value='$prodCode'/>";
			$responseText .= "<input type='hidden' name='opt1' id='opt1' value='$opt1'/>";
			$responseText .= "<input type='hidden' name='opt2' id='opt2' value='$opt2'/>";
			$responseText .= "<input type='hidden' name='image1' id='image1' value='$image1'/>";
			$responseText .= "<input type='hidden' name='image2' id='image2' value='$image2'/>";
			$responseText .= "<input type='hidden' name='image3' id='image3' value='$image3'/>";
			$responseText .= "\n";

			$i++;

			$this->makeTheFile($responseText);	
		}

		$this->makeTheFile("</table>");
	}









	public function getRun($key)
	{
	//	$this->trace("getSizeOf_Page start", TRACE_LEVEL_DEFAULT);

//		for($i=0;$i<sizeof($this->scrStruct->aryFunc[KEY]);$i++)
//		{
			$i = 0;
//			$this->trace( "키정보 : " . $this->scrStruct->aryFunc[KEY][$i]);
//			$this->trace( "이름정보 : " . $this->scrStruct->aryFunc[NAME][$key][0]);
//			$this->trace( "링크정보 : " . $this->scrStruct->aryFunc[LINK][$key][0]);

			$tempResults = $this->results;

			$this->trace($this->url);

			foreach($this->scrStruct->aryFunc[LEVEL][$key] as $level) {

				// 정규화를 이용한 삭제
				if(ereg("DELT=", $level))
				{
					
					$op = substr($level, strlen("DELT=")); // $this->trace($op);

					$data = ($data == null) ? $this->results : $data;		

					preg_match_all($op, $tempResults, $out, PREG_PATTERN_ORDER);
					
					$temp = "";
					
					foreach ($out as &$out_1) {
						foreach ($out_1 as &$out_2) {
							$temp	 .= $out_2;
						}
					}

					
					$tempResults = $temp;
		//			$this->trace($temp);

					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// 텍스트만 남겨둠
				if(ereg("HDEL=", $level))
				{
					$tempResults = $this->_striptext($tempResults);

//					$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// A를 B로 변경함
				if(ereg("HCHE=", $level))
				{
					$op = substr($level, strlen("HCHE="));
					$op = split("&nbsp;", $op);

	//				$this->trace($op[0] . "--" . $op[1]);

					$tempResults = ereg_replace($op[0], $op[1], $tempResults);
//
		//			$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}


				// 오른쪽 왼쪽 원하는 것 삭제
				if(ereg("LERE=", $level))
				{
					$op = substr($level, strlen("LERE="));

					$tempResults = $this->ltrimEx($tempResults , $op);		
					$tempResults = $this->rtrimEx($tempResults , $op);
					$tempResults = trim($tempResults);

		//			$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}


				// 짜르기
				if(ereg("SPLI=", $level))
				{
					$op = substr($level, strlen("SPLI="));

					$tempResults = split($op, $tempResults);

			//		$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}


				// 배열을 TEMP 에 저장
				if(ereg("TEMS=", $level))
				{
					$i = 0;
					$op = substr($level, strlen("TEMS="));
					foreach($tempResults as $t)
					{
		//				$this->trace($t);
						if(strlen(trim($t)) <= 0) { continue; }
						$this->userTemp[$op][] = $t;
						$i++;
					}

				
			//		$this->trace("Temp : " . sizeof($this->userTemp[$op]));
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}


				// 배열을 카운트로 공백은 제거
				if(ereg("COUT=", $level))
				{
					$i = 0;
					foreach($tempResults as $t)
					{
		//				$this->trace($t);
						if(strlen(trim($t)) <= 0) { continue; }
						$i++;
					}

					$tempResults = $i;
				
			//		$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// 변수만큼 값 더하기
				if(ereg("PLUS=", $level))
				{
					$op = substr($level, strlen("PLUS="));

					$tempResults = $tempResults + $op;
					if($key == "image3") { $this->trace($tempResults); }
			//		$this->trace($tempResults);
					continue;
				}

				// 정규화 변환시 / 해야 하는 부분 체크
				if(ereg("NORM=", $level))
				{
					$op = substr($level, strlen("NORM="));
					$temp = $this->getQuotemeta($op);
		//			$this->trace($temp);
					continue;
				}

				// 텍스트만 가져오기
				if(ereg("ONTX=", $level))
				{
					$tempResults = $this->_striptext($tempResults);
		//			$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// 내용 제거1 - 정규화 언어 사용
				if(ereg("CBDE=", $level))
				{
					$op = substr($level, strlen("CBDE="));
					$op = split("&nbsp;", $op);
					$tempResults = ereg_replace($op[0], $op[1], $tempResults);
		//			$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// 내용 제거2 - 정규화 언어 사용
				if(ereg("PREG=", $level))
				{
					$op = substr($level, strlen("PREG="));
					$op = split("&nbsp;", $op);
					$tempResults = preg_replace($op[0], $op[1], $tempResults);
		//			$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// 배열 링크에 주소 붙이기
				if(ereg("ADDV=", $level))
				{
					$op = substr($level, strlen("ADDV="));
					$tempResults = $op . $tempResults;
		//			$this->trace($tempResults);
					if($key == "image3") { $this->trace($tempResults); }
					continue;
				}

				// 배열 링크에 주소 붙이기
				if(ereg("ADDR=", $level))
				{
					$op = substr($level, strlen("ADDR="));
					$temp = "";
					$tempResults;
					foreach($tempResults as $t)
					{
						if(strlen(trim($t)) <= 0) { continue; }
						$temp[] = $op . $t;
			//			$this->trace( $op . $t);
					}

					$tempResults = $temp;
					if($key == "image3") { $this->trace($tempResults); }
//					$this->treace(sizeof($tempResults));
					continue;
				}

		
			} // foreach

//		}  // for

		
		
	//	$this->trace("getSizeOf_Page end", TRACE_LEVEL_DEFAULT);

		if(!is_array($tempResults))
		{
			if(!mb_strlen($tempResults)) { $tempResults = " "; }
		} else {
			foreach($tempResults as $temp)
			{
				if(!mb_strlen($temp)) { $temp = " "; }
			}
		}

		return $tempResults;
	}



	public function confTestSee()
	{
		for($i=0;$i<sizeof($this->scrStruct->aryFunc[KEY]);$i++)
		{
//			$this->trace( "키정보 : " . $this->scrStruct->aryFunc[KEY][$i]);
//			$this->trace( "이름정보 : " . $this->scrStruct->aryFunc[NAME][$this->scrStruct->aryFunc[KEY][$i]][0]);
//			$this->trace( "링크정보 : " . $this->scrStruct->aryFunc[LINK][$this->scrStruct->aryFunc[KEY][$i]][0]);

			foreach($this->scrStruct->aryFunc[LEVEL][$this->scrStruct->aryFunc[KEY][$i]] as $level) {
//				$this->trace( "레벨정보 : " . substr($level, strlen("DELT=")));
			}
		}
	}

	function imageSave($oldPath, $newPath)
	{
		$path_parts		= pathinfo($oldPath);
		$ext			= $path_parts['extension'];
		$tempPath		= $newPath . date("YmdHis");

		for($i = 0; $i < 10; $i++) {
			$newPath = $tempPath ."_" . $i . "." . $ext;
			if(!file_exists($newPath)) {
				break;
			}
		}

		if($ext == "jpg") {
			$im_jpg			= imagecreatefromjpeg($oldPath); 
			$re = imagejpeg($im_jpg, $newPath);
		} else if($ext == "gif") {
			$im_gif			= imagecreatefromjpeg($oldPath); 
			$re = imagegif($im_gif, $newPath);
		} else if($ext == "png") {
			$im_png			= imagecreatefromgif($oldPath); 
			$re = imagepng($im_png, $newPath);
		}
		

		if($re == 1)
			return $newPath;

		return -1;
	}



	/* site.list.conf 내용 가져오기 */
	private function aryToString($aryData)
	{
		$strTemp = "";

		foreach($aryData as $data)
		{
			$strTemp .= $data . "{{:::}}";
		}

		$strTemp = $this->ltrimEx($strTemp , "{{:::}}");		
		$strTemp = $this->rtrimEx($strTemp , "{{:::}}");
		$strTemp = trim($strTemp);

		if(!mb_strlen($strTemp)) { $strTemp = " "; }


		return $strTemp;
	}




	public function stringToAry($key, $val)
	{
		if(is_array($val)) 
		{
		//	$this->trace($key, "--" . $val);
			$strFPrint = "{" . $key . ":";
			
			$strFPrint = "";

			for($i=0;$i<sizeof($val);$i++)
			{
				$strFPrint .= $val[$i] . "&nbsp;";
			}
			
			$strFPrint .= "}";

		} else {

			$strFPrint = "{" . $key . ":" . $val . "}";
		}

		return $strFPrint;
	}

	private function getQuotemeta($str)
	{
		$str		= str_replace("^", "\^", $str);
		$str		= str_replace(".", "\.", $str);
		$str		= str_replace("[", "\[", $str);
		$str		= str_replace("]", "\]", $str);
		$str		= str_replace("$", "\$", $str);
		$str		= str_replace("(", "\(", $str);
		$str		= str_replace(")", "\)", $str);
		$str		= str_replace("|", "\|", $str);
		$str		= str_replace("*", "\*", $str);
		$str		= str_replace("+", "\+", $str);
		$str		= str_replace("?", "\?", $str);
		$str		= str_replace("{", "\{", $str);
		$str		= str_replace("}", "\}", $str);
		$str		= str_replace("\"", "\\\"", $str);
		$str		= str_replace("/", "\/", $str);

//		$str		= str_replace("=", "\=", $str);
//		$str		= str_replace("'", "\'", $str);
//		$str		= str_replace("_", "\_", $str);

		return $str;
	}

	/*  시작 문자열이 $del 이면 삭제 */
	private function ltrimEx($str, $del)
	{
		$temp = substr($str, 0, strlen($del));

		if($temp == $del) 
			$str = substr($str, strlen($del));

		return $str;
	}

	/*  마지막 문자열이 $del 이면 삭제 */
	private function rtrimEx($str, $del)
	{
			$temp = substr($str, strlen($str) - strlen($del), strlen($del));

			if($temp == $del) 
				$str = substr($str, 0, strlen($str) - strlen($del));

			return$str;
	}

	
	/* 현재 클래스 로그 생성 */
	private function trace($txt, $level=1)
	{
		if($this->hs)
		{
			$this->hs->setFileName("Scraping.class.php");
			$this->hs->trace($txt, $level);
		}

		return;
	}




	public function makeTheFile($str)
	{
		

		$path = "/home/mallinmall/www/logs/" . $this->sId;

//		$this->trace("www.aaremmadkj.dpp");
		
		$fp = fopen($path, "a+");

		if(!$fp) 
		{
			echo "Error! Can't make the file";
			return;
		}

		fwrite($fp, $str);

		fclose($fp);

//		$this->trace("makeTheFile stop");
		return;
	}



	public function setProductMgr(&$productMgr)			{ $this->productMgr = $productMgr; }
	public function setDb(&$db)							{ $this->db = $db; }

}




?>