<?php if ( isset ( $NAVER_COUNTER_ID ) && ! empty ( $NAVER_COUNTER_ID ) ) : ?>
<!-- NaverCounter Start -->
<!-- 공통 적용 스크립트 , 모든 페이지에 노출되도록 설치. 단 전환페이지 설정값보다 항상 하단에 위치해야함 -->
<script type="text/javascript" src="http://wcs.naver.net/wcslog.js"> </script>
<?
$naverCounterScriptArr = array
(
	'order_orderEnd'	=> array ( 1 , "$strCartPriceEndTotalText" ) ,	// 구매완료
	'member_joinEnd'	=> array ( 2 , 1 ) ,							// 회원가입
	'order_cart'		=> array ( 3 , 10 ) ,	// 장바구니
	//'order_cart'		=> array ( 3 , "$strCartPriceEndTotalText" ) ,	// 장바구니
) ;
if ( ! empty ( $naverCounterScriptArr[$strMenuType . '_' . $strMode] ) )
{
	$NAVER_COUNTER_SCRIPT = '<!-- 전환페이지 설정 -->' ;
	$NAVER_COUNTER_SCRIPT .= '<script type="text/javascript">var _nasa={}; _nasa["cnv"] = wcs.cnv("' . $naverCounterScriptArr[$strMenuType . '_' . $strMode][0] . '", "' . $naverCounterScriptArr[$strMenuType . '_' . $strMode][1] . '");</script>';
	echo $NAVER_COUNTER_SCRIPT ;
}
?>
<script type="text/javascript"> if (!wcs_add) var wcs_add={};wcs_add["wa"] = "<?=$NAVER_COUNTER_ID?>";if (!_nasa) var _nasa={};wcs.inflow();wcs_do(_nasa);</script>
<!-- NaverCounter End -->
<? endif ; ?>