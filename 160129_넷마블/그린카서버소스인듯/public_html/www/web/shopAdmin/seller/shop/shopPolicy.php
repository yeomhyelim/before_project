<div class="contentTop">
	<h2>입점사 약관관리</h2>
	<div class="clr"></div>
</div>
<!-- 언어 선택 탭 //-->
<?include "./include/tab_language.inc.php";?>
<!-- 언어 선택 탭 //-->

<div class="tableForm">
	<input type="hidden" name="lang" value="<?php echo $strLang;?>">
	<h3>입점사 약관관리(<?php echo $strCountryName;?>)</h3>
	<table>
		<tr>
			<td>
				<textarea name="policy" id="policy" style="width:100%;height:450px" title="higheditor_full"><?php echo $strPolicy;?></textarea>
			</td>
		</tr>
		<tr>
			<td><ul>
					<li>{{__회사명__}}</li>
					<li>{{__운영쇼핑몰명__}}</li>
				</ul>
			</td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a href="javascript:void(0);" onclick="goSellerShopPolicyModifyActEvent();" class="btn_Big_Blue" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
</div>
