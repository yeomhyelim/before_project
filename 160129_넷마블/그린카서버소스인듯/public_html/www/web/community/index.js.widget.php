<?
	## STEP 1.
	## 공통 JS 파일 모음
	$aryJsFile[]	= "../skins/javascript/common.js";
	$aryJsFile[]	= "/common/js/community/data.js";

	## STEP 2.
	## 요청한 위젯 스킨별 JS 설정
	switch($_REQUEST['BOARD_INFO']['bi_widget_skin']) :

		case "qna":
			// 상품 QNA
			$aryJsFile[] = "../skins/user/community/widget/product/javascript/product.js";
		break;
		case "review":
			// 리뷰 스킨
			$aryJsFile[] = "../skins/user/community/widget/product/javascript/product.js";
		break;
		case "open":
			$aryJsFile[] = "../skins/user/community/widget/data/javascript/open.js";
		break;
	endswitch;
?>

<?foreach($aryJsFile as $file):
  if(in_array($file, $aryJsFileUse)) { continue; }
  $aryJsFileUse[] = $file; ?>
<script language="javascript" type="text/javascript" src="<?=$file?>"></script>
<?endforeach;?>

<script type="text/javascript">
<!--
	var G_PHP_SELF		= "./";
	var strSiteJsLng	= "<?=$S_SITE_LNG?>";
//-->
</script>
