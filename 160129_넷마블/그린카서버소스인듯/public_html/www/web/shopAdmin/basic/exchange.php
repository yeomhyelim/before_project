<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00071"] //환율 설정?></h2>
		<div class="locationWrap"><span>home</span> / <span><?=$LNG_TRANS_CHAR["BW00087"] //기본설정?></span> / <strong><?=$LNG_TRANS_CHAR["BW00065"] //사용언어 설정?></strong></div>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<h3><?=$LNG_TRANS_CHAR["BW00071"] //환율설정?> (<?=$LNG_TRANS_CHAR["BW00070"] //기준통화?>: <?=$siteRow[S_ST_CUR]?> / <?=date("Y")?>. <?=date("m")?>. <?=date("d")?>)</h3>
	<div class="tableList mt10">
		<div class="titInfoTxt">
			<?=$LNG_TRANS_CHAR["BS00034"] //환율 변동이 있는경우 기준통화를 기준으로 변동된 환율을 등록해 주세요.<br>관세청 환율은 해당일자의 기준을 위해서 존재하며 실제 적용 환을은 <strong>쇼핑몰 환율</strong>의 값이적용됩니다.?>
		</div>
		<table>
			<colgroup>
				<col/>
				<col/>
				<col/>
				<col/>
			<colgroup/>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00072"] //국가?></th>
				<th><?=$LNG_TRANS_CHAR["BW00073"] //화폐단위?></th>
				<th><?=$LNG_TRANS_CHAR["BW00074"] //관세청환율?></th>
				<th><?=$LNG_TRANS_CHAR["BW00075"] //쇼핑몰환율?></th>
			</tr>
			<?
			for($i=0;$i<sizeof($aryUseLng);$i++){
				$strInputBox = strtolower($aryUseLng[$i]);
				$strUseLng	= $aryUseLng[$i];
				$strUseCur	= $S_ARY_NAT_CUR[$strUseLng];
				$strUseNat	= $S_ARY_COUNTRY[$strUseLng];
				if ($strUseLng == "ES") {
					/* 스페인어를 사용하는 국가가 여러일수도 있음 */
					$strUseCur = $S_LNG_ES_CUR;
					$strUseNat = $S_ARY_COUNTRY[$S_LNG_ES_NAT];
				}
			?>
			<tr>
				<td><?=$strUseNat?></td>
				<td><?=$strUseCur?></td>
				<td>
					<input type="text" name="cur_rate_st_<?=$strInputBox?>" id="cur_rate_st_<?=$strInputBox?>" value="<?=$S_ARY_CUR[$aryUseLng[$i]][$strUseCur][1]?>" class="_w50 _txtAlnR"/>
				</td>
				<td>
					<input type="text" name="cur_rate_shop_<?=$strInputBox?>" id="cur_rate_shop_<?=$strInputBox?>" value="<?=$S_ARY_CUR[$aryUseLng[$i]][$strUseCur][0]?>"  class="_w50 _txtAlnR"/>
				</td>
			</tr>
			<?}?>
		</table>
	</div>

	<div class="buttonWrap">
		<a class="btn_Big_Blue" href="javascript:goCurModify();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<h3 class="mt40"><?=$LNG_TRANS_CHAR["BW00076"] //일자별 환율설정 정보?></h3>
	<div class="tableList">
		<div class="titInfoTxt">
			<?=$LNG_TRANS_CHAR["BS00035"] //환율을 변동 적용했던 History입니다.?>
		</div>
		<table>
			<colgroup>
				<col style="width:200px;"/>
				<col/>
				<col/>
				<col/>
				<col/>
			<colgroup/>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00077"] //날짜?></th>
				<th><?=$LNG_TRANS_CHAR["BW00072"] //국가?></th>
				<th><?=$LNG_TRANS_CHAR["BW00073"] //화폐단위?></th>
				<th><?=$LNG_TRANS_CHAR["BW00074"] //관세청환율?></th>
				<th><?=$LNG_TRANS_CHAR["BW00075"] //쇼핑몰환율?></th>
			</tr>
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="5"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
			</tr>
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){
					$siteMgr->setSCR_ST_DT($row[SCR_ST_DT]);
					$aryStCurList = $siteMgr->getSiteCurView($db);

					$strUseNat	= $aryStCurList[0][SCR_NAT];
					if ($aryStCurList[0][SCR_NAT] == "ES") {
						/* 스페인어를 사용하는 국가가 여러일수도 있음 */
						$strUseNat = $S_LNG_ES_NAT;
					}
			?>
			<tr>
				<td rowspan="<?=$row[CNT]?>" style="border-top:1px solid #333;">
					<?=$row[SCR_ST_DT]?>
				</td>
				<td><?=$S_ARY_COUNTRY[$strUseNat]?></td>
				<td><?=$aryStCurList[0][SCR_CUR]?></td>
				<td><?=$aryStCurList[0][SCR_ST_CUR_RATE]?></td>
				<td><?=$aryStCurList[0][SCR_SHOP_CUR_RATE]?></td>
			</tr>
			<?
					if (is_array($aryStCurList)){
						for($i=1;$i<sizeof($aryStCurList);$i++){
			?>
			<tr>
				<td><?=$S_ARY_COUNTRY[$aryStCurList[$i][SCR_NAT]]?></td>
				<td><?=$aryStCurList[$i][SCR_CUR]?></td>
				<td><?=$aryStCurList[$i][SCR_ST_CUR_RATE]?></td>
				<td><?=$aryStCurList[$i][SCR_SHOP_CUR_RATE]?></td>
			</tr>
			<?			}
					}

					$intListNum--;
				}
			?>
		</table>
	</div>
</div>