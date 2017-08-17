<?

## 스킨 설정
$strSkin = $S_SHOP_PROD_LIST_SKIN;
if(!$strSkin) { $strSkin = "shopSkin"; }

$EUMSHOP_APP_INFO = "";
$EUMSHOP_APP_INFO['name'] = "상품리스트";
$EUMSHOP_APP_INFO['mode'] = "productList";
$EUMSHOP_APP_INFO['skin'] = $strSkin;
include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>