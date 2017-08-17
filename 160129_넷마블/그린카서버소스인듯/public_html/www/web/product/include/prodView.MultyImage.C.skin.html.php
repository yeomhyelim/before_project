<script language="javascript" type="text/javascript" src="../common/js/jquery.elevateZoom-2.5.5.min.js"></script>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$('#zoom_01').elevateZoom({
			zoomWindowWidth		: 400,
			zoomWindowHeight	: 400,
			zoomLevel 			: 1,
			zoomWindowOffetx	: 10
		});
	});
//-->
</script>

<img id="zoom_01" src='<?=$strViewImg?>' data-zoom-image="<?=$strViewImg2?>" style="width:<?=$intVSizeW?>px;height:<?=$intVSizeH?>px;"/>
<?if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($prodRow) == "Y"){?>
	<?if ($S_EVENT_INFO[$prodRow['P_EVENT']]["PRICE_TYPE"] == "1"){?>
	<div class="sailInfo">
		<?=$S_EVENT_INFO[$prodRow['P_EVENT']]["PRICE_MARK"]?><span>%</span>
	</div>
	<?}?>
<?}?>