<ul>
	<? if($g_member_no): // 회원 모드?>	
	<li class="loginTxt"><?=callLangTrans($LNG_TRANS_CHAR["CW00044"], array("{$g_member_name} {$g_member_last_name}"))?></li>
	<?else:?>

	<?endif;?>
	<li class="chLanguage">
		<a href="/kr/<?=$S_REQUEST_URI_PARAM?>">Korean</a> |
		<a href="/us/<?=$S_REQUEST_URI_PARAM?>">English</a> |
		<a href="/cn/<?=$S_REQUEST_URI_PARAM?>">Chinese</a> |
		<a href="/jp/<?=$S_REQUEST_URI_PARAM?>">Japanese</a>
	</li>
	<!-- li class="linkShop"><img src="/images/top_link_shop.gif"/></li -->
	<div class="clear"></div>
</ul>
