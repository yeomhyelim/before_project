<?
	## 작성일 : 2013.06.13
	## 작성자 : kim hee sung
	## 내  용 : 베스트 상품 리스트

	$bestCate = $_REQUEST['lcate'];
	if(!$bestCate) { $bestCate			= substr($row['P_CATE'], 0, 3); }
	if(!$bestCate) { $bestCate			= substr($prodRow['P_CATE'], 0, 3); }
?>

<script type="text/javascript">
	<!--
		$(document).ready(function() {
			$.getJSON("./?menuType=main&mode=json&act=bestProductList&lcate=<?=$bestCate?>&cnt=5&callback=?", function(data) {
				if($.browser.msie && $.browser.version < 8.0) {
					var element = madeBestElementIEVersion(data);
				}else{
					var element = madeBestElementOrderVersion(data);
				}
			});
		});

		function madeBestElementIEVersion(data) {
			var cnt		= data['TOTAL'];
			if(cnt > 0) {
				for(var i=0;i<cnt;i++){
					var img				= data['DATA'][i]['PM_REAL_NAME'];
					var href			= "?menuType=product&mode=view&prodCode=" + data['DATA'][i]['P_CODE'];
					var name			= data['DATA'][i]['P_NAME'];
					var price			= data['DATA'][i]['P_SALE_PRICE'] + "원";
					var element			= document.createElement("div");
					var linkElement		= document.createElement("a");
					var ulElement		= document.createElement("ul");
					var imgElement		= document.createElement("<img style='width:70px;height:70px;'>");
					var nameElement		= document.createElement("li");
					var priceElement	= document.createElement("li");
					nameElement.setAttribute("className", "title");
					nameElement.innerHTML	= name;
					priceElement.setAttribute("className", "price");
					priceElement.innerHTML	= price;
					imgElement.setAttribute("className", "prodImg");
					imgElement.setAttribute("style", "width:70px;height:70px;");
					imgElement.setAttribute("src", img);
					linkElement.setAttribute("href", href);
					linkElement.appendChild(nameElement);
					ulElement.appendChild(linkElement);
					ulElement.appendChild(priceElement);
					element.setAttribute("className", "prodList");
					element.appendChild(imgElement);
					element.appendChild(ulElement);
					$("div#bestProductArea").append(element);
				}
			}
		}

		function madeBestElementOrderVersion(data) {
			var cnt		= data['TOTAL'];
			if(cnt > 0) {
				for(var i=0;i<cnt;i++){
					var img				= data['DATA'][i]['PM_REAL_NAME'];
					var href			= "?menuType=product&mode=view&prodCode=" + data['DATA'][i]['P_CODE'];
					var name			= data['DATA'][i]['P_NAME'];
					var price			= data['DATA'][i]['P_SALE_PRICE'] + "원";
					var element			= document.createElement("div");
					var linkElement		= document.createElement("a");
					var ulElement		= document.createElement("ul");
					var imgElement		= document.createElement("img");
					var nameElement		= document.createElement("li");
					var priceElement	= document.createElement("li");
					nameElement.setAttribute("class", "title");
					nameElement.innerHTML	= name;
					priceElement.setAttribute("class", "price");
					priceElement.innerHTML	= price;
					imgElement.setAttribute("class", "prodImg");
					imgElement.setAttribute("style", "width:70px;height:70px;");
					imgElement.setAttribute("src", img);
					linkElement.setAttribute("href", href);
					linkElement.appendChild(nameElement);
					ulElement.appendChild(linkElement);
					ulElement.appendChild(priceElement);
					element.setAttribute("class", "prodList");
					element.appendChild(imgElement);
					element.appendChild(ulElement);
					$("div#bestProductArea").append(element);
				}
			}
		}

	//-->
</script>


<div id="bestProductArea"></div>


