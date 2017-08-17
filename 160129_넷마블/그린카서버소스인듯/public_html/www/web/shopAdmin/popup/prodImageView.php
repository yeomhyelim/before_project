<?
	if ($intNo > 0)
	{	
		$productMgr->setPM_NO($intNo);
		$row = $productMgr->getProdImgView($db);

		if ($row) {

			$strFileName	= $row[PM_SAVE_NAME];
			if (SUBSTR($row[PM_REAL_NAME],0,4) == "http") $strFilePath	= $row[PM_REAL_NAME]; 
			else $strFilePath	= "../".$row[PM_REAL_NAME];
			
			$imgSize		= @GetImageSize($strFilePath);
			$imgWidth		= $imgSize[0];
			$imgHeight		= $imgSize[1]+75;	
?>
<html>
<head>
<title><?=$row[PM_SAVE_NAME]?></title>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<SCRIPT LANGUAGE="JavaScript">
<!--
	window.resizeTo('<?=$imgWidth?>','<?=$imgHeight?>');
//-->
</SCRIPT>
</head>
<body oncontextmenu='return false' onselectstart='return false' leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<a href="javascript:window.close();"><img src="<?=$strFilePath;?>" border="0" height="<?=$imgSize[1]?>"></a>
</body>
</html>
<?}}?>