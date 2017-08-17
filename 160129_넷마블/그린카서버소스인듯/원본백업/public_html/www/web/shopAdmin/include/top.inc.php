<?	
	$nBox = "class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";
	$priceBox = "class=\"priceBox\" onfocus=\"this.className='priceBoxOn'\" onblur=\"this.className='priceBox'\"";
	$priceBox2 = "class=\"priceBox2\" onfocus=\"this.className='priceBoxOn'\" onblur=\"this.className='priceBox2'\"";
	$pBox = "class=\"pbox\" onfocus=\"this.className='xbox'\" onblur=\"this.className='pbox'\"";

	## STEP 1.
	## 설정
	$login_id = $a_admin_id;
	if($S_MEM_CERITY == 2) { $login_id = $a_admin_mail; }
?>
<script type="text/javascript">
	function menuFn(index) { 
		$("#menu"+index).hover(function(){ 
			$('.showSecond'+index).css('display','block');
			},function(){
				$('.showSecond'+index).css('display','none');
			});
		$('.showSecond'+index).hover(function(){ 
			$(this).css('display','block');
			}, function(){ 
			$(this).css('display','none');
		}); 
	}

	$(document).ready(function () {	
		
		$('#nav li').hover(
			function () {
				//show its submenu
				$('ul', this).slideDown(100);

			}, 
			function () {
				//hide its submenu
				$('ul', this).slideUp(100);			
			}
		);

		$("#topSiteUseLng").change(function() {			
			if ($(this).val())
			{
				var data = "menuType=basic&mode=json&act=changeUseLng&siteUserUseLng="+$(this).val();
				
				$.ajax({
					url			: "./index.php"
				   ,data		: data
				   ,type		: "POST"
				   ,dataType	: "json"
				   ,success		: function(data) {	
						if(data['__STATE__'] == "SUCCESS") {
							location.reload();
						} else {
							alert("You can not change the language.");
						}
				   }
				});
			}
		});
	});


	/* 실시간 현재시간 */
	var i=0; 
	function clockF() 
	{ 
		today = new Date(); 
		
		i=i+1000; 
		servertime=<?=time()?>*1000; 
		processtime=servertime+i; 
		today.setTime(processtime); 

		var sec = (today.getSeconds() < 10) ? "0" + today.getSeconds() : today.getSeconds();
		var nowTime = today.getHours() + ":" + today.getMinutes() + ":" + sec; 
		$(".clockWrap").html("<strong>" + nowTime + "</strong>");
        
        //에디터 엔터키 값인 p태그가 한칸 띄어지는 걸로 보이는 것 수정. 2015.06.15. 남덕희
        //iframe 컨트롤이 제대로 안되서 여기다 적용...;;
        $('#tx_canvas_wysiwyg1').contents().find('.tx-content-container p').css('margin','1em 0 1em 0');
	} 

	setInterval('clockF()' , 1000) ;

</script>

<div id="topArea">

	<div id="topWrap">
		<div class="globalWrap">
			<?if (($a_admin_level > 0) && ($a_admin_main_use == "N")){?>
				<h1><img src="/shopAdmin/himg/common/logo_adm.png"></h1>
			<?}else{?>
				<h1><a href="/shopAdmin/?menuType=main&mode=memberList"><img src="/shopAdmin/himg/common/logo_adm.png"></a></h1><!-- eum  -->
			<?}?>
			<div class="loginInfo">
				<strong><?=$a_admin_name?></strong>(<?=$login_id?>)
				
				<?if($_SESSION["ADMIN_TYPE"] == "S"): // 입점몰 로그인 ?>
					<a href="./sellerLogin.php?mode=shopAdmLogout" class="btn_adm_logout"><span><?=$LNG_TRANS_CHAR["GW00001"] //로그아웃?></span></a> |
				<?else:?>
					<a href="./login.php?mode=shopAdmLogout" class="btn_adm_logout"><span><?=$LNG_TRANS_CHAR["GW00001"] //로그아웃?></span></a> |
					<a href="<?=$S_SITE_URL?>" target="_blank" class="btn_myhome"><span>My Shop</span></a> |
					<a href="javascript:goFTPFileUploadMoveEvent()"  class="btn_ftp"><span>FTP</span></a>
				<?endif;?>	
				<?if ($S_ADMIN_LANG_VIEW_YN == "Y"){?>
					<?if($_SESSION["ADMIN_TYPE"] == "S"){ // 입점몰 로그인 ?>
					<select id="topSiteUseLng" class="langSlt">
						<?
							$aryCountryLng = array('KR'=>'한국어','US'=>'English','CN'=>'中国语');
							$arrTopSiteUseLng = explode("/",$S_USE_LNG); 
							if (count($arrTopSiteUseLng) == 1) array_push($arrTopSiteUseLng, "KR");
							foreach($arrTopSiteUseLng as $lngKey => $lngVal){?>
							<option value="<?=$lngVal?>" <?=($a_admin_lng == $lngVal)?"selected":"";?>><?=$aryCountryLng[$lngVal]?></option>
						<?}?>
					</select>
					<?}?>	
				<?}?>
			</div>
			<div class="clear"></div>
		</div>

		<div id="mainNavi">
				<span class="clockWrap"><strong><?=date("H:i:s")?></strong></span>
				<ul class="mnBox">
				<?
					//if ($a_admin_type != "S"){
						//$i=0;
						//if ($a_admin_type == "S" || $S_MALL_TYPE == 'R') $i = 1;
						$i=1;
						for($i;$i<sizeof($aryMallAdminLMenu);$i++){
							if($aryMallAdminLMenu[$i]['MN_NO'] == 2 && $S_LAYOUT_SETUP_USE != "Y"):
								//$aryMallAdminLMenu[$i]['MN_URL'] = "./?menuType=layout&mode=skinSave";
								$aryMallAdminLMenu[$i]['MN_URL'] = "./?menuType=layout&mode=sliderBannerList";
								
							endif;
							if ($a_admin_level == 0){
								echo "<li class=\"mn".($i)."\"><a href=\"".$aryMallAdminLMenu[$i][MN_URL]."\"><span></span><strong>".$aryMallAdminLMenu[$i]["MN_NAME_".$strAdmSiteLng]."</strong></a></li>";
							}else {
								
								if (is_array($aryAdminTopMenu)){
									for($j=0;$j<sizeof($aryAdminTopMenu);$j++){
										
										if ($aryAdminTopMenu[$j][MN_NO] == $aryMallAdminLMenu[$i][MN_NO] && $aryMallAdminMenu[$aryAdminTopMenu[$j][MN_NO]][MN_USE] == "Y"){
											$aryAdminTopSubMenu1 = $aryAdminTopSubMenu2 = null;

											$aryAdminTopSubMenu1 = getTopLowMenuArray($a_admin_no, $aryAdminTopMenu[$j][MN_CODE]);

											if(!$aryAdminTopSubMenu1) { continue; }

											$aryAdminTopSubMenu2 = getTopLowMenuArray02($a_admin_no, $aryAdminTopMenu[$j][MN_CODE], $aryAdminTopSubMenu1[0][MN_CODE]);
											
											if (is_array($aryAdminTopSubMenu2)){
//												echo $aryAdminTopSubMenu2[0][MN_NO] . "<br>";
													// 20150702 입점사 관리자 회원관리 주석처리
													if($aryAdminTopSubMenu2[0][MN_NO] != "152"){
															echo "<li class=\"mnA".($j)."\"><a href=\"".$aryMallAdminMenu[$aryAdminTopSubMenu2[0][MN_NO]][MN_URL]."\"><span></span><strong>".$aryMallAdminLMenu[$i]["MN_NAME_".$strAdmSiteLng]."</strong></a></li>";	
													}
													
											} else {
												echo "<li class=\"mnA".($j)."\"><a href=\"".$aryMallAdminMenu[$aryAdminTopSubMenu1[0][MN_NO]][MN_URL]."\"><span></span><strong>".$aryMallAdminLMenu[$i]["MN_NAME_".$strAdmSiteLng]."</strong></a></li>";
											}
											break;
										}
									}
								}
							}
						}
				?>
				</ul>
			<div class="clear"></div>
		</div><!-- mainNavi -->
	</div><!-- topWrap -->
</div>
