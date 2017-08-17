<?
	## 설정
	if($a_admin_type == "S"):
		## 계금주
		$sh_com_deposit = $shopRow['SH_COM_DEPOSIT'];	

		## 계좌정보
		if($shopRow['SH_COM_BANK_NUM']):
			$sh_com_bank = "{$aryBank[$shopRow['SH_COM_BANK']]}({$shopRow['SH_COM_BANK_NUM']})";
		endif;

		## 상점노출
		$sh_com_prod_auth = $LNG_TRANS_CHAR["SW00068"];
		if($shopRow['SH_COM_PROD_AUTH'] == "Y"):
			$sh_com_prod_auth = $LNG_TRANS_CHAR["SW00067"];
		endif;

		## 정산기준가
		$sh_com_acc_price = "입고가";
		if($shopRow['SH_COM_ACC_PRICE'] == "S"):
			$sh_com_acc_price = "판매가";
		endif;

		## 정산수수료
		$sh_com_acc_rate = $shopRow['SH_COM_ACC_RATE'];

		## 배송정책
		$sh_com_delivery = "상점정책설정";
		if(!$shopRow['SH_COM_DELIVERY'] ||  $shopRow[SH_COM_DELIVERY] == "C"):
			$sh_com_delivery = "본사정책유지";
		else:
			$sh_com_delivery = "상점정책설정";
		endif;

	endif;
?>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/product";
	var uploadFile 	= "../kr/index.php";
	var htmlYN		= "Y";
//]]>
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["SW00024"] //상점 정보?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["BW00006"]; //회사정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopProduct','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopGrade','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00082"]; //등급 심사 정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSU_NO?>');" class="selected"><?= $LNG_TRANS_CHAR["SW00083"]; //거래/배송정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00084"]; //관리자정보 ?></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<!--  ****************  -->
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["SW00034"] //정산 및 배송설정?></h3>
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00035"] //예금주?></span></th>
				<td colspan="3">
					<?if($a_admin_type == "S"):?>
					<?=$sh_com_deposit?>
					<?else:?>
					<input type="text" <?=$nBox?>  style="width:150px;" id="com_deposit" name="com_deposit" value="<?=$shopRow['SH_COM_DEPOSIT']?>"/>
					<?endif;?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00036"] //계좌정보?></span></th>
				<td colspan="3">
					<?if($a_admin_type == "S"):?>
						<?=$sh_com_bank?>
					<?else:?>
						<?=drawSelectBoxMore("com_bank",$aryBank,$shopRow[SH_COM_BANK],$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['SW00044']."::",$html="N")?>
						<input type="text" <?=$nBox?>  style="width:200px;" id="com_bank_num" name="com_bank_num" value="<?=$shopRow[SH_COM_BANK_NUM]?>"/>
					<?endif;?>
				</td>
			</tr>
		</table>

		<!--  ****************  -->
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["SW00037"] //정산 및 배송설정?></h3>
		<table class="tableForm">
			<!--tr>
				<th><?=$LNG_TRANS_CHAR["SW00038"] //정산기준가?></th>
				<td colspan="3">
					<?if($a_admin_type == "S"):?>
						<?=$sh_com_acc_price?>
					<?else:?>
						<input type="radio" name="com_acc_price" id="com_acc_price" value="S" <?=($shopRow[SH_COM_ACC_PRICE] == "S")?"checked":"";?>>판매가
						<input type="radio" name="com_acc_price" id="com_acc_price" value="P" <?=(!$shopRow[SH_COM_ACC_PRICE] || $shopRow[SH_COM_ACC_PRICE] == "P")?"checked":"";?>>입고가
					<?endif;?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00039"] //정산수수료?></th>
				<td colspan="3">
					<?if($a_admin_type == "S"):?>
						<?=$sh_com_acc_rate?>
					<?else:?>
						<input type="text" <?=$nBox?>  style="width:80px;" id="com_acc_rate" name="com_acc_rate" value="<?=$shopRow[SH_COM_ACC_RATE]?>"/>
					<?endif;?>
				</td>
			</tr-->
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00040"] //배송정책?></th>
				<td colspan="3">
					<?if($a_admin_type == "S"):?>
						<?=$sh_com_delivery?>
					<?else:?>
						<input type="radio" name="com_delivery" id="com_delivery" value="C" <?=(!$shopRow[SH_COM_DELIVERY] || $shopRow[SH_COM_DELIVERY] == "C")?"checked":"";?>>본사정책유지
						<input type="radio" name="com_delivery" id="com_delivery" value="S" <?=($shopRow[SH_COM_DELIVERY] == "S")?"checked":"";?>>상점정책설정
					<?endif;?>
				</td>
			</tr>

			<tr id="trStoreDelivery" <?=($shopRow[SH_COM_DELIVERY] == "S")?"":"style=\"display:none\"";?>>
				<th>&nbsp;</th>
				<td colspan="3">
					<table>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00041"] //배송비 무료 금액?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:100px;" id="com_delivery_st_price" name="com_delivery_st_price" value="<?=$shopRow[SH_COM_DELIVERY_ST_PRICE]?>"/>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["SW00045"] //기본 배송비 금액?></th>
							<td>
								<input type="text" <?=$nBox?>  style="width:100px;" id="com_delivery_price" name="com_delivery_price" value="<?=$shopRow[SH_COM_DELIVERY_PRICE]?>"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00042"] //택배업체?></th>
				<td colspan="3">
					<ul class="deliveryCompany">
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="001" <?=($aryShopDeliveryCom["001"])?"checked":"";?>> 우체국 EMS</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="006" <?=($aryShopDeliveryCom["006"])?"checked":"";?>> 이노지스택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="011" <?=($aryShopDeliveryCom["011"])?"checked":"";?>> KGB택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="002" <?=($aryShopDeliveryCom["002"])?"checked":"";?>> 경동택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="007" <?=($aryShopDeliveryCom["007"])?"checked":"";?>> 한진택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="012" <?=($aryShopDeliveryCom["012"])?"checked":"";?>> 현대택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="003" <?=($aryShopDeliveryCom["003"])?"checked":"";?>> CJ대한통운</li>
<!--						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="008" <?=($aryShopDeliveryCom["008"])?"checked":"";?>> CJ GLS</li> //-->
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="004" <?=($aryShopDeliveryCom["004"])?"checked":"";?>> 동부택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="009" <?=($aryShopDeliveryCom["009"])?"checked":"";?>> 삼성 HTH</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="005" <?=($aryShopDeliveryCom["005"])?"checked":"";?>> 로젠택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="010" <?=($aryShopDeliveryCom["010"])?"checked":"";?>> 옐로우캡</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="051" <?=($aryShopDeliveryCom["051"])?"checked":"";?>> 천일택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="052" <?=($aryShopDeliveryCom["052"])?"checked":"";?>> 대신택배</li>
						<li><input type="checkbox" name="com_delivery_cor[]" id="com_delivery_cor[]" value="053" <?=($aryShopDeliveryCom["053"])?"checked":"";?>> 합동택배</li>

					</ul>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00032"] //해외 배송 택배사 선택?></th>
				<td>
					<ul class="deliveryCompany">
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="013" <?=($aryShopDeliveryForComAll["013"])?"checked":"";?>> EMS</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="014" <?=($aryShopDeliveryForComAll["014"])?"checked":"";?>> K-Packet</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="015" <?=($aryShopDeliveryForComAll["015"])?"checked":"";?>> RR Register</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="016" <?=($aryShopDeliveryForComAll["016"])?"checked":"";?>> Air Parcel</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="017" <?=($aryShopDeliveryForComAll["017"])?"checked":"";?>> DHL</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="018" <?=($aryShopDeliveryForComAll["018"])?"checked":"";?>> TNT</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="019" <?=($aryShopDeliveryForComAll["019"])?"checked":"";?>> UPS</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="020" <?=($aryShopDeliveryForComAll["020"])?"checked":"";?>> FedEx</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="021" <?=($aryShopDeliveryForComAll["021"])?"checked":"";?>> 하나택배</li>

						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="022" <?=($aryShopDeliveryForComAll["022"])?"checked":"";?>> 사가와택배</li>

						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="023" <?=($aryShopDeliveryForComAll["023"])?"checked":"";?>> 순풍택배</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="024" <?=($aryShopDeliveryForComAll["024"])?"checked":"";?>> 원통택배</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="025" <?=($aryShopDeliveryForComAll["025"])?"checked":"";?>> 중퉁택배</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="026" <?=($aryShopDeliveryForComAll["026"])?"checked":"";?>> airmail</li>
						<li><input type="checkbox" name="com_delivery_for_cor[]" id="com_delivery_for_cor[]" value="027" <?=($aryShopDeliveryForComAll["027"])?"checked":"";?>> 윈다택배</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00043"] //배송정책?></th>
				<td colspan="3">
					<textarea style="width:100%;height:150px;" name="com_delivery_text" id="com_delivery_text" title="higheditor_full"><?=$shopRow[SH_COM_DELIVERY_TEXT]?></textarea>
				</td>
			</tr>
		</table>
	</div>

	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goAct('shopSettingUpdate');" id="menu_auth_m"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<?if($a_admin_type != "S"): // 입점몰 로그인은 목록 페이지 없음 ?>
		<a class="btn_new_gray" href="javascript:goMoveUrl('shopList','');"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00001"] //취소?></strong></a>
		<?endif;?>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->