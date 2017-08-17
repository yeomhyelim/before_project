<?
	## update 현황
	## 2013.04.23 언어 구분 변경
	## 2013.04.24 페이지별 parameter 값을 그대로 유지하며 마지막에  policyLng=kr 을 붙이는 형태로 변경

	## STEP 1.
	## parameter 만들기
	$queryString	= $_SERVER['QUERY_STRING'];
	$aryQuery		= explode("&", $queryString);
	$newQuery		= "";
	foreach($aryQuery as $query):
		if(ereg("lang", $query)) { continue; }
		$temp = explode("=", $query);
		if(!$temp[1]) { continue; }
		if($newQuery) { $newQuery .= "&"; }
		$newQuery .= $query;
	endforeach;


?>

<script type="text/javascript">
	function goTabPageMove(query, lng) {
		location.href = "./?" + query + "&lang=" + lng;
	}
</script>

<?if($S_USE_LNG!="KR"):?>
<div class="langugeTabWrap">
	<div class="tabBtn">
		<?if(eregi("KR", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','KR')" class="tabKr<?if($strStLng=="KR") {echo " selected";}?>">Korean</a>
		<?endif;?>
		<?if(eregi("US", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','US')" class="tabUs<?if($strStLng=="US") {echo " selected";}?>">English</a>
		<?endif;?>
		<?if(eregi("AU", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','AU')" class="tabFr<?if($strStLng=="AU") {echo " selected";}?>">Australia</a>
		<?endif;?>
		<?if(eregi("JP", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','JP')" class="tabJp<?if($strStLng=="JP") {echo " selected";}?>">Japan</a>
		<?endif;?>
		<?if(eregi("CN", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','CN')" class="tabCn<?if($strStLng=="CN") {echo " selected";}?>">Chinese</a>
		<?endif;?>
		<?if(eregi("ID", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','ID')" class="tabId<?if($strStLng=="ID") {echo " selected";}?>">Indonesia</a>
		<?endif;?>
		<?if(eregi("FR", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','FR')" class="tabFr<?if($strStLng=="FR") {echo " selected";}?>">France</a>
		<?endif;?>
		<?if(eregi("RU", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','RU')" class="tabRu<?if($strStLng=="RU") {echo " selected";}?>">Russia</a>
		<?endif;?>
		<?if(eregi("TW", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','TW')" class="tabTw<?if($strStLng=="TW") {echo " selected";}?>">Taiwan</a>
		<?endif;?>
		<?if(eregi("MN", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','MN')" class="tabMn<?if($strStLng=="MN") {echo " selected";}?>">Mongolia</a>
		<?endif;?>
		<?if(eregi("DE", $S_USE_LNG)):?>
		<a href="javascript:goTabPageMove('<?=$newQuery?>','DE')" class="tabDe<?if($strStLng=="DE") {echo " selected";}?>">Germany</a>
		<?endif;?>
	</div>
</div>
<?endif;?>