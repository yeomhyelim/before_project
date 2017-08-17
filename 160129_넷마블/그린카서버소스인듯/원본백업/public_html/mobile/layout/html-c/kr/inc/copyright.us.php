<div class="usCopyWrap">
	<div class="topBtnWrap">
		<a href="#top"><img src="/upload/images/btn_m_top.png" alt="TOP"/></a>
	</div>

	<div class="customerBtn">
		<a href="tel:82-70-4689-4622" class="ico_c1">
			<img src="/upload/images/banner1_us.png"/>
		</a>
		<a href="tel:82-70-4689-4607" class="ico_c2">
			<img src="/upload/images/banner2_us.png"/>
		</a>
		<a href="tel:82-2-461-5711" class="ico_c3">
			<img src="/upload/images/banner3_us.png"/>
		</a>
		<a href="tel:82-2-461-5711" class="ico_c4">
			<img src="/upload/images/banner4_us.png"/>
		</a>
	</div>

	<div class="bottomNavi">
			<?if ($g_member_no && $g_member_login){?>
				<a href="./?menuType=member&mode=act&act=logout"><?=$LNG_TRANS_CHAR["CW00049"]//로그아웃?></a>
			<?}else{?>
				<a href="./?menuType=member&mode=login"><?=$LNG_TRANS_CHAR["CW00045"]//로그인?></a>
			<?}?>
			<a href="./?menuType=shop&mode=shopApplyReg"><?= $LNG_TRANS_CHAR["CW00108"]; //입점신청 ?></a>
			<a href="./?menuType=html&mode=customer"><?=$LNG_TRANS_CHAR["CW00043"]; //고객센터?></a>
			<a href="./?menuType=mypage&mode=buyList"><?= $LNG_TRANS_CHAR["MW00048"]; //마이페이지 ?></a>
	</div>

	<div class="addrArea">
		<div class="addrWrap">
			<ul>
				<!--<li>Cosmetic : (주)에스앤텍 <span>|</span> 대표 최태호 <span>|</span> Tel : 031-705-1700 </li>
				<li>Permit No : 129-81-64930 통신판매신고 :  성남 0000000</li>	
				<li>경기도 성남시 분당수 야탑남로 230E-508(분당테크노파크)</li>-->
				<li> DYNESOZE Co., Ltd. <span>|</span> Tel : +82 31 705 1700 </li>
				<li>E-508, 700, Pangyo-ro, Bundang-gu, Seongnam-si,</li>
				<li>Gyeonggi-do, Korea(Zip. 463-760)</li>
				
			</ul>	
		</div>

		<div class="copyWrap">
			<div class="copy">
				<ul>
					<li>
						<a href="./?menuType=html&mode=company"><?=$LNG_TRANS_CHAR["PW00089"]//회사소개?></a>|
						<a href="./?menuType=html&mode=guide"><?=$LNG_TRANS_CHAR["MW00041"]//이용약관?></a>|<br />
						<a href="./?menuType=html&mode=guide"><?=$LNG_TRANS_CHAR["CW00109"]//개인정보취급방침?></a>|
						<a href="javascript:C_getHostTypeChangeActEvent('web')" target="_blank"><?=$LNG_TRANS_CHAR["CW00081"]//PC버전?></a>
					</li>
					<li style="font-size: 9px">COPY RIGHT(C) 2015 By DYNESOZE ALL RIGHTS RESERVED.</li>
				</ul>
			</div>
			<!--
			<div class="sns">
				<a href="#"><img src="/upload/images/btn_m_kko.png" alt="Kakaotalk"/></a>
				<a href="#"><img src="/upload/images/btn_m_fb.png" alt="facebook"/></a>
				<a href="#"><img src="/upload/images/btn_m_tw.png" alt="twitter"/></a>
			</div>
			-->
		</div>
	</div>
</div>


