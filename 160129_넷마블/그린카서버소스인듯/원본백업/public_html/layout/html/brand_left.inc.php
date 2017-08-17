<div class="subNaviWrap">
	<h2><img src="/himg/layout.B0001/tit_sub_cate.gif"/></h2>
               <div class="naviList">
		<? include sprintf ( "%swww/include/mainMenu_%s.inc.php", $S_DOCUMENT_ROOT,'T0001'  ); ?>
               </div>
	</div>

       <div class="searchWrap">
		<? include sprintf ( "%swww/include/productSearch.inc.php", $S_DOCUMENT_ROOT  ); ?>
       </div>
<div class="subLeftCustomer mt20">
	<img src="/himg/layout.B0001/info_customer.gif"/>
</div>

<div class="subLeftBankInfo mt20">
	<img src="/himg/layout.B0001/info_bank.gif"/>
</div>

<div class="subLeftNotice mt20">
	<img src="/himg/layout.B0001/tit_notice.gif"/>
       <? $b_code="NOTICE"; include "{$S_DOCUMENT_ROOT}www/web/community/widget.index.php"; ?>
</div>