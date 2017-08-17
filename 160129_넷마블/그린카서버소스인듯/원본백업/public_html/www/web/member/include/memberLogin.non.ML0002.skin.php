			<!-- 비회원 로그인 폼 -->
			<div class="nonMemberLogin">
				<?if (is_array($aryCartNo)){?>
					<div class="loginForm">
						<h3 class="nonMemberTit"><span><?=$LNG_TRANS_CHAR["MW00039"] // 비회원 로그인?><span></h3>
						<ul>
							<li class="txtNonInfo"><?=$LNG_TRANS_CHAR["MW00055"] //비회원으로 주문합니다.?></li>
							<li class="btnWrap"><a href="javascript:goNonMemberOrder();" class="nonLoginBigBtn"><span><?=$LNG_TRANS_CHAR["MW00056"]//주문하기?></span></a></li>
						</ul>
					</div><!-- loginForm -->
				<?}else{?>
					<div class="loginForm">
						<h3 class="nonMemberTit"><span><?=$LNG_TRANS_CHAR["MW00039"] // 비회원 로그인?><span></h3>
						<div class="pnoLoginForm">
							<table>
								<tr>
									<td>
										<label class="orderName"><span><?=$LNG_TRANS_CHAR["OW00015"] //주문자?></span></label>
										<span class="orderName"><input type="input" name="searchOrderName" id="searchOrderName" maxlength="30"/><span>
									</td>
									<th rowspan="2">
										<a href="javascript:goNonOrderSearch();" class="nonOrderloginBtn"><span><?=$LNG_TRANS_CHAR["MW00036"] //로그인?></span></a>
									</th>
								</tr>
								<tr>
									<td>
										<label class="orderNo"><span><?=$LNG_TRANS_CHAR["OW00057"] //주문번호?></span></label>
										<span class="orderNo"><input type="input" name="searchOrderKey" id="searchOrderKey" maxlength="30"/></span></td>
								</tr>
							</table>
						</div>
						<div class="clr"></div>
					</div><!-- loginForm -->
				<?}?>
			</div>
			<!-- 비회원 로그인 폼 -->