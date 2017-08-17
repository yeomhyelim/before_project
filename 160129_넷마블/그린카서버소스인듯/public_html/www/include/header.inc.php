<?
	## 스크립트 호출
	include MALL_HOME . "/web/app/setScript/setScript.php";
	include MALL_HOME . "/web/app/setStyle/setStyle.php";

	## MATA TAG 설정
	$strMataTagPath = SHOP_HOME . "/layout/html/inc-metatag.php";
	$strMetaTag = FileDevice::getContents($strMataTagPath);

	## favicon 설정
	$strFavicon = $S_SITE_FAVICON_FILE;
	if($strFavicon):
		$strFavicon = "/upload/site/{$strFavicon}";
	endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $strMetaTag;?>

	<title>::  <?=$S_SITE_TITLE?> ::</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="ROBOTS" content="ALL" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />

	<?php if($strFavicon):?>
	<link rel="shortcut icon" href="<?php echo $strFavicon;?>" type="image/x-icon">
	<?php endif;?>

	<? include sprintf( "%s/include/header.css.inc.php", MALL_HOME); ?>
<?if($aryCss):
  foreach($aryCss as $key => $data):?>
	<link rel="stylesheet" type="text/css" href="<?=$data?>" />
<?endforeach;
  endif;?>

	<script language="javascript" type="text/javascript" src="../common/js/jquery-1.7.2.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery-1.8.24-ui.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.validate.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.alphanumeric.pack.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.cycle.all.min.js"></script>

	<script language="javascript" type="text/javascript" src="../common/js/jquery.easing.1.3.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/common.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/commonReady.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/kakao.link.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/sns.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/scripts.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/ZeroClipboard.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.formatCurrency-1.4.0.min.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/cal.js"></script>
	<?if($S_SITE_FACEBOOK == "Y"):?>
	<script src='http://connect.facebook.net/en_US/all.js'></script>
<?endif;?>
<script language="javascript" type="text/javascript" src="../common/js/jquery.smartPop.js"></script>
	<script language="javascript" type="text/javascript" src="../common/js/jquery.countdown.js"></script>
 <?if($aryScript):
  foreach($aryScript as $key => $data):?>
	<script language="javascript" type="text/javascript" src="<?=$data?>"></script>
<?endforeach;
  endif;?>
<?if($SITE_BOOKMARK_USE=="Y"): // 북마크 사용 ?>
	<script language="javascript" type="text/javascript" src="../common/js/jFav.js"></script>
<?endif;?>

	<script type="text/javascript">
		<!--
			var strSiteHost			= "<?=$S_HTTP_HOST?>";
			var strSiteJsLng		= "<?=($S_JS_LNG)?$S_JS_LNG:$S_SITE_LNG;?>";
			var strSiteReqUri		= "<?=SUBSTR($S_REQUEST_URI,1,STRLEN($S_REQUEST_URI))?>";
			var strMemberLogin		= "<?=$g_member_login?>";
			var G_PHP_PARAM			= "<?=$_SERVER['QUERY_STRING']?>";
			var G_APP_PARAM			= new Object();
			var strDevice			= "<?php echo $strHostType;?>";

			function cateMouseOverOut(obj,img)
			{
				obj.src = img;
			}

			<?if ($S_WINDOW_FRAME_USE == "Y"){?>
//			document.onkeydown = function() {
//				if (event.keyCode == 116) {
//					event.keyCode = 505;
//				}
//				if (event.keyCode == 505) {
//					location.reload();
//					return false;
//				}
//			}
			<?}?>

			$(document).ready(function() {

				<?if($SITE_BOOKMARK_USE=="Y"): // 북마크 사용 ?>
				try{ $('#bookMark').jFav(); } catch (e1) { }
				<?endif;?>

				$("#snsFacebook").bind('click', function() { goFacebook('<?=$S_SITE_URL?>', '<?=$S_SITE_URL.$S_WEB_LOGO_IMG?>', '<?=$S_SITE_KNAME?>', '<?=$S_SITE_TITLE?>', ''); });
				$("#snsTwitter").bind('click', function() { goTwitter('<?=$S_SITE_TITLE?>', '<?=$S_SITE_URL?>'); });
				$("#snsM2day").bind('click', function() { goMe2Day('<?=$S_SITE_TITLE?>', '<?=$S_SITE_URL?>'); });

				$("#mainNaviWrap").find("a").each( function() {
		//			var aryHref		= $(this).attr("href").split("&");
		//			var strHref		= aryHref[0] + "&" + aryHref[1];
					var strHref		= $(this).attr("href");
					if(location.href.indexOf(strHref) > 0) {
						var aryName = $(this).find("img").attr("src").split(".");
						$(this).find("img").attr("src", aryName[0] + "_on." +  aryName[1]);
						$(this).find("img").attr("onmouseover", "");
						$(this).find("img").attr("onmouseout", "");
					}
				});
			});

			<?if($S_SITE_FACEBOOK == "Y"):?>
			/* facebook 답벼락 */
			FB.init({appId: "<?=$S_SITE_FACEBOOK_APP_ID?>", status: true, cookie: true});
			<?endif;?>

			<?if($S_MAIN_LAYERPOP_LOGIN_USE=="Y"):?>
			function goLoginLayerpop(type) {
				var strUrl = "/kr/?menuType=member&mode=login&target=layer&clickType="+type;
				$.smartPop.open({
						bodyClose: false,
						width: 455,
						height: 460,
						conOptUse:'Y',	// 배경 투명하게..
						url: strUrl

						});
			}
			<?endif;?>
			<?if($S_MAIN_LAYERPOP_JOIN_USE=="Y"):?>
			function goJoinLayerpop() {
				var strUrl = "/kr/?menuType=member&mode=join1&target=layer";
				$.smartPop.open({  bodyClose: false, width: 690, height: 830, conOptUse:'Y', url: strUrl });
			}
			function goJoinLayerpop2() {
				$.smartPop.close();
				goJoinLayerpop();
			}

			<?endif;?>

			/* smartPop 레이어 띄우기 */
			function goOpenWinSmartPop(url, img, width, height, closeImg) {

				var strImg = "";
				if (img)
				{
					strImg = "<img src='"+img+"' style='width:"+width+"px;height:"+height+"px'>";
				}

				if (C_isNull(closeImg))
				{
					$.smartPop.open({width:width,url:url,height:height,conOptUse:'Y',closeImg:{width:32,height:32,src:'/images/common/btn_pop_close.png'},bodyClose: false,html: strImg});
				} else {
					$.smartPop.open({width:width,url:url,height: height,conOptUse:'Y',bodyClose: false,html: strImg});
				}
			}

			function goLayerPopClose(url,clickType)
			{
				<?if($S_MAIN_LAYERPOP_LOGIN_USE == "Y"){?>
				$.smartPop.close();
				<?}?>

				if (!C_isNull(url))
				{
					if (clickType == "order" || clickType == "buyList" || clickType == "communityView")
					{
						location.reload();
						return;
					}

					location.href = url
				}
			}

			function goOpenWinSmartPopClose(){
				$.smartPop.close();
			}

			<?if($S_SITE_COPY == "Y"): /** 복사 방지 2013.09.25 kim hee sung **/ ?>
			  //no mouse right button
			  $("html").rightClick(function(e){}).noContext();
			  //no key
			  $(document).bind('keydown', 'ctrl+a', function(){return false;}).bind('keydown', 'ctrl+c', function(){return false;});
			  //no drag
			  $(document).mousedown(function(){$(document).mousemove(function(e){return false;});});
			<?endif;?>
		//-->
	</script>
<!-- 다음 우편번호 검색 -->
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
function daumPopZip() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
//                 document.getElementById('sample4_postcode').value = data.zonecode; //5자리 새우편번호 사용
//                 document.getElementById('sample4_roadAddress').value = fullRoadAddr;
//                 document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

                document.getElementById('bzip1').value = data.postcode1; 
                document.getElementById('bzip2').value = data.postcode2; 
                document.getElementById('baddr1').value = fullRoadAddr;

                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }
</script>
<!-- 다음 우편번호 검색 -->

	<link rel="shortcut icon" href="/upload/<?=( ! empty ( $S_SITE_FAVICON_FILE ) ? 'site/' . $S_SITE_FAVICON_FILE : 'images/favicon.ico' )?>" type="image/x-icon">
</head>


<?// include sprintf("%swww/include/%s.inc.php", $S_DOCUMENT_ROOT, $S_SKIN_EQ); ?>
