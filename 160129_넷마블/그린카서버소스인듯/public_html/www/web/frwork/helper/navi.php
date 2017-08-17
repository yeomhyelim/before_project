
<script type="text/javascript">
<!--
	
	$(document).ready(function(){
		<?if ($strMenuType != "main"){?>
		goQuickMovePage("loadPage",1);
		<?}?>

		goQuickLink ("lLoadPage",1);
	});	
	
	/* 최근본상품 리스트 출력 */
	function goQuickLink(act, cartPage)
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			lxmlhttp = new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			lxmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		lxmlhttp.onreadystatechange=function()
		{
			if (lxmlhttp.readyState==4 && lxmlhttp.status==200)
			{
				$("#divQuickLink").html(lxmlhttp.responseText);
			}
		}

		lxmlhttp.open("GET","./?menuType=main&mode=json&act="+act+"&cartPage="+cartPage,true);
		lxmlhttp.send();
	}
	/* 최근본상품 리스트 출력 */

	
	/* 퀵 장바구니 상품 리스트 출력 */
	function goQuickMovePage(act, cartPage)
	{	
		
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$("#divQuickCart").html(xmlhttp.responseText);
			}
		}
		
		xmlhttp.open("GET","./?menuType=main&mode=json&act="+act+"&cartPage="+cartPage,true);
		xmlhttp.send();
	}

	/* 퀵장바구니 아이템 삭제 */
	function goQuickCartDel(act, no)
	{
		var x = confirm("선택한 상품을 삭제하시겠습니까?");
		if (x == true)
		{
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					goQuickMovePage("loadPage",1);
				}
			}
			
			xmlhttp.open("GET","./?menuType=main&mode=json&act="+act+"&no="+no,true);
			xmlhttp.send();
		}
	}

	/* 퀵 장바구니 상품 리스트 출력 */

//-->
</script>