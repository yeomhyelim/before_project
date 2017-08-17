<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";

	$memberMgr = new MemberMgr();
	

	$strSearchKey	= $_POST["q"]			? $_POST["q"]			: $_GET["q"];
	$strCallBack	= $_POST["callback"]	? $_POST["callback"]	: $_GET["callback"];
	$strM_ID		= $_POST["id"]			? $_POST["id"]			: $_REQUEST["id"];
	$strM_NICK_NAME = $_POST["nickname"]	? $_POST["nickname"]	: $_REQUEST["nickname"];
		
	switch ($strAct) {
		case "nickNameChk":
			// 닉네임 체크
			
			$memberMgr->setM_NICK_NAME($strM_NICK_NAME);
			$intCount = $memberMgr->getMemberNickNameCheck($db);

			if ($intCount > 0) {
				$result[0][MSG] = "이미 등록된 닉네임이 존재합니다.";
				$result[0][RET] = "N";
			} else {
				$result[0][MSG] = "사용가능한 닉네임입니다.";
				$result[0][RET] = "Y";
			}

			$result_array = json_encode($result);

		break;
	}

?>

