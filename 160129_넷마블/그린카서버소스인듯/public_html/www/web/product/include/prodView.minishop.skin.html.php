<?
	## 설명
	## 쪽지는 회원만 보낼수 있습니다.

	## 설정
	$minishopImg = "/himg/product/A0001/photo_minishop.gif";
	if($storeRow['ST_LOGO']) { $minishopImg = "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_LOGO']}"; }
	include "prodView.minishop.skin.js.php";

	## 평점
	$average = round($averageRow['AVERAGE']);
	if(!$average) { $average = 0; }
?>
   <div class="partnerInfoWrap">
		<div class="infoWrap">
			<h4><?=$LNG_TRANS_CHAR["PW00043"] //판매자 정보?></h4>
			<a href="?menuType=minishop&mode=main&sh_no=<?=$prodRow['P_SHOP_NO']?>" target="_blank"><img src="<?=$minishopImg?>" class="shopPhoto" style="width:99px;height:103px"></a>
			<ul>
				<li class="shopName"><strong><?=$storeRow['ST_NAME_ENG']?></strong></li>
				<li class="rateWrap">
					<span><?=$LNG_TRANS_CHAR["PW00045"] //구매만족도?></span>
					<img src="/upload/images/icon_star_<?=$average?>.png" class="starIcon">
				</li>
				<li class="sendMailWrap">
					<a href="javascript:goPaperWriteMoveEvent()" class="sendMessage"><?=$LNG_TRANS_CHAR["MW00060"] //쪽지?></a>
					<a href="javascript:goMailWriteMoveEvent()" class="sendMail"><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></a>
				</li>
			</ul>
			<div class="clr"></div>
		</div>
		<div class="shopRelatedProd">
			<h4><?=$LNG_TRANS_CHAR["PW00044"] //판매자의 다른상품?></h4>
			<div class="shopProdList">
				<dl>
					<?$intCnt=1;
					  while($row = mysql_fetch_array($shopProduct_result, MYSQL_ASSOC)):?>
					<dd<?if($intCnt==5){echo " class='endProd'";}?>><a href="./?menuType=product&mode=view&prodCode=<?=$row['P_CODE']?>"><img src="<?=$row['PM_REAL_NAME']?>" class="prodImg"/></a></dd>
					<?  $intCnt++;
					  endwhile;?>
				</dl>
			</div>
		</div>
		<div class="clr"></div>
   </div>
   <input type="hidden" name="sh_no" value="<?=$prodRow['P_SHOP_NO']?>"/>