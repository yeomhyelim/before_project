
<script>
function goOrderEvent(order) {

		var data			= new Object();

		data['order']		= order;

		C_getAddLocationUrl(data);
	}
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["SW00055"] //입점업체관리?></h2>
		<div class="clr"></div>
	</div>

<div class="titInfoTxt">
	쇼핑몰에서 입점한 업체들을 관리하는 메뉴입니다.<br>
	입점한 업체들에 대한 기본 정보 수정과 정산, 입점업체 삭제와 같은 세부 기능을 관리할 수 있습니다.
</div>
	<!-- ******** 컨텐츠 ********* -->
	<?if ($a_admin_type != "S"){?>
		<div class="searchTableWrap">
			<?include "search.skin.inc.php";?>
		</div>
	<?}?>
	<div class="tableListWrap">
		<p style="margin-top:10px;">* 총 <strong class="redTxt"><? echo $intTotal;?></strong>업체가 등록되었습니다.</p>
		<table class="tableList">
			<tr>
				<th>번호</th>
				<th>국가</th>
				<th>업체명</th>
				<th>Type</th>
				<th>상품(미승인)수
					<a href="javascript:goOrderEvent('ProdCntDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('ProdCntAsc');" class="btn_down"><span>▼</span></a>
				</th>
				<th>요청일
					<a href="javascript:goOrderEvent('RegDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('RegAsc');" class="btn_down"><span>▼</span></a>
				</th>
				<th>승인일
					<a href="javascript:goOrderEvent('AdmissionDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('AdmissionAsc');" class="btn_down"><span>▼</span></a>
				</th>
				<th>승인여부</th>
				<th>사유</th>
				<th>인증마크</th>
			</tr>
			<?if ($intTotal == 0){?>
				<tr>
					<td colspan="10"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
				</tr>
			<?}else{$i=0;?>
					<?
						while($row = mysql_fetch_array($result)){
						$i++;
						$intShNo = $row['SH_NO'];
						$shopMgr->setSH_NO($intShNo);
						$resultLogo = $shopMgr->getShopLogo($db);
					?>

					<tr>
						<td><?=$intListNum?></td>
						<td><?=$aryCountryList[$row[SH_COM_COUNTRY]]?></td>
						<td><a href="./?menuType=seller&mode=shopModify&act=shopSite&jsonMode=&shopNo=<?=$intShNo?>"><?=$row[SH_COM_NAME]?></a></td>
						<td><?=$aryType[$row[SH_COM_CATEGORY]];?></td>
						<td>
							<?=$LNG_TRANS_CHAR["SW00054"]//등록상품수?>: <a href="./?menuType=product&mode=prodList&shopNo=1&searchShop=<?=$intShNo?>&pageLine=50&page=1" target="_blank"><strong><?=NUMBER_FORMAT($row[SH_PROD_CNT])?></strong></a> <a href="./?menuType=seller&mode=shopProduct&act=shopModify&jsonMode=&shopNo=<?=$intShNo?>">( <?=NUMBER_FORMAT($row[SH_PROD_NO_APPR_CNT])?> ) </a>
						</td>
						<td><?=$row[SH_REG_DT]?></td>
						<td><?=$row[SH_ADMISSION_DT]?></td>
						<td>
						<?
						switch($row[SH_APPR]){
							case("Y") : 
								echo $LNG_TRANS_CHAR["CW00006"];
							break;
							case("N"):
								echo $LNG_TRANS_CHAR["CW00040"];
							break;
							case("R"):
								echo "승인요청";
								break;						
						}
						?>
						</td>
						<td><?=$row[SH_APPR_NO_REASON]?></td>
						<td class="gradeIco">
						<?if($row[SH_APPR]=='Y'){?>
							<span class="gradeIco"><img src="<?=$aryCreditGradeImg[$row[SH_COM_CREDIT_GRADE]]?>" width="20"></span>
							<span class="gradeIco"><img src="<?=$arySaleGradeImg[$row[SH_COM_SALE_GRADE]]?>" width="20"></span>
							<span class="gradeIco"><img src="<?=$aryLocusGradeImg[$row[SH_COM_LOCUS_GRADE]]?>" width="20"></span>
							<?}?>
						</td>
					</tr>

			<?
					$intListNum--;
				}
			}
			?>
			</tr>
		</table>
	</div>
	<!-- tableList -->
	<br>
	<!-- Pagenate object -->
	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<!-- Pagenate object -->
	<!-- ******** 컨텐츠 ********* -->

</div>
