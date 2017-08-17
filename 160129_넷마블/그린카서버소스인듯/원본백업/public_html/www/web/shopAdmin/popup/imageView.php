<?
	if ($intNo > 0)
	{	
		$row = $db->getSelect("SELECT * FROM ".TBL_COMM_FILE." WHERE F_NO=".$intNo);
		
		if ($row) {

			$strFileName	= $row[F_ORG_NAME];
			$strFilePath	= "../".$row[F_FILE_PATH];
			
			$imgSize		= @GetImageSize($strFilePath);
			$imgWidth		= $imgSize[0];
			$imgHeight		= $imgSize[1]+75;	

?>
<html>
<head>
<title><?=$row[F_ORG_NAME]?></title>
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