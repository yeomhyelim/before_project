<?php
    /**
     * /home/shop_eng/www/module/DataEditMgr.php
     * @author eumshop(thav@naver.com)
     * dataEdit module class (basic.1.0)
	 * 2013.04.09 이후 ****Ex($param) 함수 형으로 변경하여 작업중...
     * **/

	require_once MALL_HOME . "/modules/module.php";

    class DataEditModule extends Module {

		function __construct($db, &$field) {
			$this->db		= $db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "dataEdit module class (basic.1.0)";
		}

		
		function getDataEditMgrSelectEx($op="OP_LIST", $param)
		{
		}

		/********************************** count **********************************/

		/********************************** Insert **********************************/

		/********************************** Insert Select ***************************/

		/********************************** Update **********************************/


		/********************************** Delete **********************************/


		/********************************** Create **********************************/


		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/

    }
?>
