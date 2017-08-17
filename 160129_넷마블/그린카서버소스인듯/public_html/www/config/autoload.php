<?php
function autoload($strClassName)
{
		## 기본 설정
		$isUseClass				= false;

		## 모듈 검사 및 요청
		$aryModule2List			= array("Module", "View", "Controller");
		foreach($aryModule2List as $strModule2) {
			$strModule2Lower	= strtolower($strModule2);
			$strMyClassName		= str_replace($strModule2, "", $strClassName);
			
			if($strMyClassName != $strClassName) {
				$strClassFile	= MALL_HOME . "/module2/{$strMyClassName}.{$strModule2Lower}.php"; 
				if(is_file($strClassFile)) {
					require_once $strClassFile;
					$isUseClass = true;
				}
				break;
			}
		}

		## 클레스 검사 및 요청
		if(!$isUseClass) {
			$aryTemp			= explode(' ', preg_replace( '/([a-z0-9])([A-Z])/', "$1 $2", $strClassName));
			$strTempLower		= strtolower($aryTemp[0]);
			$strClassFile		= MALL_HOME . "/classes/{$strTempLower}/{$strClassName}.class.php";
			if(is_file($strClassFile)) {
				require_once $strClassFile;
				$isUseClass		= true;
			}
		}
}
if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    //SPL autoloading was introduced in PHP 5.1.2
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
        spl_autoload_register('autoload', true, true);
    } else {
        spl_autoload_register('autoload');
    }
} else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function __autoload($classname)
    {
        autoload($classname);
    }
}



