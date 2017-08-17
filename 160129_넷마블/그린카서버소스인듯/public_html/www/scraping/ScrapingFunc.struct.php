<?

class ScrapingStruct
{
	private $classHS					= null;				// LOG Class
	private $strUrl						= null;				// URL
	private $strInfoFileName		= null;				// scraping file path and file name

	public $SCRAPING_ID			= null;
	public $SCRAPING_URL			= null;
	public $SCRAPING_DATA		= null;

	/* 생성자 */
	public function ScrapingStruct(&$hs)		
	{			
		$this->classHS = $hs;		
	}

	public function getUrl()										{			return $this->strUrl;												}
	public function setUrl($url)									{			$this->strUrl						= $url;							}
	public function setInfoFileName($fName)				{			$this->strInfoFileName		= $fName;						}


	##############################################################
	# 스크랩핑에 필요한 정보 저장
	# return
	##############################################################
	public function initialization( )
	{
		$this->trace("initialization start", TRACE_LEVEL_NORM);
		if(!$this->strUrl)	{
			$this->trace("initialization end ( URL : $this->strUrl )", TRACE_LEVEL_FAIL);
			return -1;
		}
		if(!$this->strInfoFileName)	{
			$this->trace("initialization end ( fileName : $this->strInfoFileName )", TRACE_LEVEL_FAIL);
			return -1;
		}

		$aryFile = file ( $this->strInfoFileName ); 
		$this->siteInfoLoad($aryFile);

		$this->trace("initialization end", TRACE_LEVEL_NORM);
		return 0;
	}
	##############################################################
	# aryBuf 에 저장된 내용을 형식에 맞게 저장
	# return
	##############################################################
	public function siteInfoLoad(&$aryBuf)
	{
		$this->trace("siteInfoLoad start", TRACE_LEVEL_NORM);
		$intState				= 0;																// 0 - 대기 , 1 - start 시작, 2 - 아이디 등록
		$strKey					= "";

		foreach($aryBuf as $buf) {
			/*  시작 단계 intState == 0 */
			$buf						= trim($buf);

			if(sizeof($buf) < 0)								{ continue; }								// 공백 문자 체크
			if($buf[0] == '/' && $buf[1] == '/')		{ continue; }								// 주석 체크

			$str	= $this->getValue("END", $buf);
			if($str == "-") { $intState = 0; break; }														// 종료

			$str	= $this->getValue("START", $buf);
			if($str == "-" && $intState == 0) { $intState = 10; continue; }						// 시작 시점 찾그
			if($intState < 10) { continue; }																	// 상태가 0인 경우 하단 스크립드 실행 안함.
			/*---------------------------------------------------------------------------------------------------------------------------------*/

			/*   ID 값 등록 단계 intState < 10*/
			$str	= $this->getValue("ID", $buf);														// 아이디 등록
			if($str)  {
					$this->SCRAPING_ID = $str; 
					$intState = 20; 
					continue;
			} // if
			if($intState < 20) { continue; }
			/*---------------------------------------------------------------------------------------------------------------------------------*/

			/*   SITE URL 주소 등록 단계 intState < 20 */
			$str	= $this->getValue("URL", $buf);												// URL 등록
			if($str)  {
					$this->SCRAPING_URL = $str; 
					$intState = 100; 
					continue;
			} // if
			if($intState < 100) { continue; }
			/*---------------------------------------------------------------------------------------------------------------------------------*/

			/*   KEY 등록 intState < 100 */
			$str	= $this->getValue("KEY", $buf);				
			if($str)  {	
				$strKey			= $str;
				$intState		= 200; 
				continue; 
			}			
			if($intState < 200 || $strKey == "" ) { continue; }
			/*---------------------------------------------------------------------------------------------------------------------------------*/

			/*   현재 KEY 값 종료 다음 KEY 값 받을 준비  */
			$str	= $this->getValue("NEXT", $buf);
			if($str) {  
				$strKey				= "";
				$intState			= 100; 
				continue; 
			}	
			/*---------------------------------------------------------------------------------------------------------------------------------*/
	
			/*    LINK 값 받기 */
			$str	= $this->getValue("LINK", $buf); 
			if($str) {  
				$this->SCRAPING_DATA[$strKey][LINK]		= $str;
				continue; 
			}	
			/*---------------------------------------------------------------------------------------------------------------------------------*/

			/*    NAME 값 받기 */
			$str	= $this->getValue("NAME", $buf);
			if($str) {  
				$this->SCRAPING_DATA[$strKey][NAME]		= $str;
				continue; 
			}	
			/*---------------------------------------------------------------------------------------------------------------------------------*/
		
			/*    TYPE 값 받기 */
			$str	= $this->getValue("TYPE", $buf);
			if($str) {  
				$this->SCRAPING_DATA[$strKey][TYPE]		= $str;
				continue; 
			}	
			/*---------------------------------------------------------------------------------------------------------------------------------*/
					
			/*    LEVEL 값 받기 */
			$str	= $this->getValue("LEVEL", $buf);
			if($str) {  
				$this->SCRAPING_DATA[$strKey][LEVEL][]		= $str;
				continue; 
			}	
			/*---------------------------------------------------------------------------------------------------------------------------------*/
		}

		$this->trace("siteInfoLoad end", TRACE_LEVEL_NORM);
		return 0;
	}

###########################################################################################################
















	function initConfig($file, $url, $flag="file")
	{
		$this->trace("initConfig start", 1);

		$intState				= 0;					// 0 - 대기 , 1 - start 시작
		$aryFile				= ($flag == "file") ? file($file) : $file;
		$strKey					= "";
		
		$this->strId			= "";
		$this->strUrl			= "";
		$this->strLink			= "";
		$this->aryFunc			= null;


		$this->trace("file sizeof : " . sizeof($aryFile), TRACE_LEVEL_DEFAULT);
		$this->trace("url         : " . $url, TRACE_LEVEL_DEFAULT);



		for($i=0; $i < sizeof($aryFile) ; $i++)
		{
			/*  시작 단계 level = 0 */
			if(sizeof($aryFile[$i]) < 0) { continue; }
		
			if($aryFile[$i][0] == '/' && $aryFile[$i][1] == '/') { continue; }		/* 주석 */

			$str	= $this->getValue("START", $aryFile[$i]);

			if($str == "-" && $state == 0) { $intState = 1; continue; }				// 시작

			if($intState < 1) { continue; }											// 시작전




			/*  종료 단계 및 ID 값 등록 단계 Level = 1*/
			$str	= $this->getValue("END", $aryFile[$i]);

			if($str == "-") { $state = 0; break; }									// 종료

			$str	= $this->getValue("ID", $aryFile[$i]);

			if($str) 
			{
				if(ereg($str, $url))
				{
					$this->strId = $str; 
					$intState = 2; 
					continue;
				}
			
			}
			if($intState < 2) { continue; }
		


			/* URL 정보 및 KEY 정보 등록 단계 Level 3*/

			$str	= $this->getValue("URL", $aryFile[$i]);

			if($str)	{ $this->strUrl = $str; continue; }								// URL

			$str	= $this->getValue("KEY", $aryFile[$i]);

			if($str) { $this->aryFunc[KEY][] = $str; $strKey = $str; $state = 7; continue; }			// 필터링 값 받기 시작

			if($state < 7) { continue; }



			/* 구분 단계 */
			$str	= $this->getValue("NEXT", $aryFile[$i]);

			if($str) {  $state = 2; $strKey = null; continue; }

			if($strKey == null || $strKey == "") { continue; }


			/* 사이트 링크 및 이름, 레벨 정보 등록 단계 Level 4*/
			$str	= $this->getValue("LINK", $aryFile[$i]);

			if($str) { $this->aryFunc[LINK][$strKey][] = $str; continue; }						// 링크
			
			$str	= $this->getValue("NAME", $aryFile[$i]);

			if($str) {$this->aryFunc[NAME][$strKey][] = $str; continue; }

			$str	= $this->getValue("LEVEL", $aryFile[$i]);

			if($str) {$this->aryFunc[LEVEL][$strKey][] = $str; continue; }

		}


		$this->trace("initConfig start (" . sizeof($this->aryFunc[KEY]) . ")", TRACE_LEVEL_DEFAULT);

		return sizeof($this->aryFunc[KEY]);


	}


	function getValue($key, $subject, $flag=false)
	{

		$pattern = ($flag == true) ? $key : "/{".$key.":.*?}/";

		preg_match_all($pattern, $subject, $out);

		foreach ($out as $out_1) {
			foreach ($out_1 as $out_2) {
				$strTemp .= $out_2;
			}
		}

		$strTemp		= str_replace("{".$key.":", "", $strTemp); 
		$strTemp		= str_replace("}", "", $strTemp); 
		$strTemp		= str_replace("\r", "", $strTemp);
		$strTemp		= str_replace("\n", "", $strTemp);

		return $strTemp;
	}


	/* 현재 클래스 로그 생성 */
	private function trace($txt, $level=1)
	{
		if($this->classHS)
		{
			$this->classHS->setFileName("ScrapingFunc.struct..php");
			$this->classHS->trace($txt, $level);
		}
		return;
	}
}



