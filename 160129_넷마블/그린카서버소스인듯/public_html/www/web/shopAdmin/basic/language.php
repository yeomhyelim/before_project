<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00065"] //사용언어 설정?> </h2>
			<div class="locationWrap"><span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00065"] //사용언어 설정?></strong></div>
			<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["BW00066"] //언어설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00066"] //언어설정?></th>
				<td>
					<?php foreach($aryS_USE_LNG as $key => $lang):
					
							## 기본설정
							$langLower = strtolower($lang);

							## 국가명 설정
							$strKName = $S_ARY_LANG_INFO[$lang]['K_NAME'];
							$strSName = $S_ARY_LANG_INFO[$lang]['S_NAME'];
					?>
					<img src="/shopAdmin/himg/common/icon_na_<?php echo $langLower;?>.gif" style="vertical-align:middle;"/> <?php echo $strKName;?>(<?php echo $strSName;?>)
					<?php endforeach;?>
				</td>
			</tr>			
		</table>
	</div>

	<div class="tableForm mt40">
		<h3><?=$LNG_TRANS_CHAR["BW00067"] //언어기준 설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00068"] //기준 언어?></th>
				<td>
					<img src="/shopAdmin/himg/common/icon_na_<?php echo $strLangSLower;?>.gif" style="vertical-align:middle;"/> <?php echo $strLangSKName;?>(<?php echo $strLangSSNAme;?>)
				</td>
			</tr>			
		</table>
	</div>
	<div class="tableForm mt40">
		<h3><?=$LNG_TRANS_CHAR["BW00069"] //통화기준 설정?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00070"] //기준 통화?></th>
				<td>
					<strong><?php echo $strLangSMoneySign;?></strong>(<?php echo $strS_ST_CUR;?>)
				</td>
			</tr>			
		</table>
	</div>
	<!-- ******** 컨텐츠 ********* -->

	<div class="noticeInfoWrap">
		<ul>
			<li>- <?=$LNG_TRANS_CHAR["BS00045"] //사용언어는 이음샵 계약에 따라 수동세팅됩니다.?> </li>
			<li>- <?=$LNG_TRANS_CHAR["BS00046"] //전세계 언어 사용 가능하며 필요언어 설정은 고객센터(T: 02-2268-8875)로 문의해 주세요.?></li>
		</ul>
	</div>
</div>