			<!-- 비회원 로그인 폼 -->
			<div class="nonMemberLogin">
				<?if (is_array($aryCartNo)){?>
					<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_non_member_order.gif"/></h4>
					<div class="loginForm mt10">
						<a href="javascript:goNonMemberOrder();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/txt_non_member_order.gif" style="vertical-align:middle"/><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif" style="vertical-align:middle"/></a>
					</div><!-- loginForm -->
				<?}else{?>
					<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_meber_2.gif"/></h4>
					<div class="loginForm mt10">
						<label><?=$LNG_TRANS_CHAR["OW00015"] //주문자?></label><input type="input" name="searchOrderName" id="searchOrderName" style="width:60px" maxlength="30"/>
						<label><?=$LNG_TRANS_CHAR["OW00057"] //주문번호?></label><input type="input" name="searchOrderKey" id="searchOrderKey" maxlength="30"/>
						<a href="javascript:goNonOrderSearch();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif" style="vertical-align:middle"/></a>
					</div><!-- loginForm -->
				<?}?>
			</div>
			<!-- 비회원 로그인 폼 -->