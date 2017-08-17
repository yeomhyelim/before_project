<?

DEFINE("MALL_HOME", "/home/shop/www");

require_once "ScrapingFunc.struct.php";
require_once "Snoopy.class.php";
require_once "Scraping.class.php";
require_once "HS_Trace.class.php";

$scrapingRun = new ScrapingRun($argv[1], $argv[2]);
$scrapingRun->Run();

class ScrapingRun
{
	private $scraping				= null;				// scraping
	private $hs						= null;				// log
	private $url						= null;				// url
	private $sId						= null;				// session id

	public function ScrapingRun($url, $sId)
	{
		$this->trace("ScrapingRun start ($url, $sId)", TRACE_LEVEL_NORM);	
		$this->url					= $url;
		$this->sId					= $sId;
		$this->hs					= new HS_Trace();
		$this->scraping			= new Scraping($this->hs);
		$this->scraping->setSessionID($sId);
		$this->trace("ScrapingRun end", TRACE_LEVEL_NORM);	
	}


	public function Run()
	{	
		$this->trace("Run Start", TRACE_LEVEL_DEFAULT);
		$this->trace($this->url);
		$this->scraping->scrapingInfoLoad($this->url);
		$this->scraping->scrapingRunLoad($this->url);

		$this->trace("Run End", TRACE_LEVEL_DEFAULT);
	}

	/* 현재 클래스 로그 생성 */
	private function trace($txt, $level=1)
	{
		if($this->classHS)
		{
			$this->classHS->setFileName("ScrapingRun.class..php");
			$this->classHS->trace($txt, $level);
		}
		return;
	}

}





?>