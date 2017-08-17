	<script type="text/javascript">
		<!--
			var quickPage		= 1;
			var quickPageMax	= 0;
			$(document).ready(function() {
				$.getJSON("./?menuType=main&mode=json&act=quickProdList&quickPage="+quickPage+"&callback=?", function(data) {
					$(".quickProduct").html(data[0].QUICK_PROD_LIST);
					quickPageMax = data[0].QUICK_PAGE_MAX;
				});
			});

			function goQuickMenuPrevMoveEvent() {
				if(quickPage <= 1) { return false; }
				quickPage = quickPage - 1;
				$.getJSON("./?menuType=main&mode=json&act=quickProdList&quickPage="+quickPage+"&callback=?", function(data) {
					$(".quickProduct").html(data[0].QUICK_PROD_LIST);
				});
			}

			function goQuickMenuNextMoveEvent() {
				if(quickPage >= quickPageMax) { return false; }
				quickPage = quickPage + 1;
				$.getJSON("./?menuType=main&mode=json&act=quickProdList&quickPage="+quickPage+"&callback=?", function(data) {
					$(".quickProduct").html(data[0].QUICK_PROD_LIST);
				});
			}
		//-->
	</script>

	<div class="quickProduct"></div>
	<div class="quickBtnWrap">
		<a href="javascript:goQuickMenuPrevMoveEvent()" class="btnQuickPrev"><span>Prev</span></a>
		<a href="javascript:goQuickMenuNextMoveEvent()" class="btnQuickNext"><span>Next</span></a>
	</div>

