<?
	## 작성일		: 2013.07.08
	## 작성자		: kim hee sung
	## 내  용		: 미니샵에서 진행되는 액션 모음


	switch ($strAct) :

		case "dataModify":
		case "dataDelete":
			## 수정, 삭제
			include "{$S_DOCUMENT_ROOT}www/web/community/index.php";
		break;

	endswitch;

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>