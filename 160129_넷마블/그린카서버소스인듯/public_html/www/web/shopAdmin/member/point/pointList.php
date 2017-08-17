<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00037"] //포인트관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<?include "search.inc.php";?>
	</div>
	<!-- 포인트 내역 및 목록수 설정 -->
	<div class="tableListWrap">
		<div class="tableListTopWrap">
			<span class="listCntNum">
				* 총 <?=$intTotal?>건의 <?=NUMBER_FORMAT($pointSumRow['TOT_POINT'])?> 포인트 내역이 있습니다.
				<?if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
				<?if ($param['M_CATE'] && STRLEN($param['M_CATE']) >= 6){?>
				 (총 소속합계: <?=NUMBER_FORMAT($pointCateSumRow['TOT_CATE_POINT'])?>)
				<?}?>
				<?}?>
			</span>
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
				<select name="pageLine" style="vertical-align:middle;" onchange="javascript:C_getMoveUrl('<?=$strMode?>','get','<?=$PHP_SELF?>');">
					<option value="10" <? if($intPageLine==10) echo 'selected';?>>10</option>
					<option value="20" <? if($intPageLine==20) echo 'selected';?>>20</option>
					<option value="30" <? if($intPageLine==30) echo 'selected';?>>30</option>
					<option value="40" <? if($intPageLine==40) echo 'selected';?>>40</option>
					<option value="50" <? if($intPageLine==50) echo 'selected';?>>50</option>
					<option value="60" <? if($intPageLine==60) echo 'selected';?>>60</option>
					<option value="70" <? if($intPageLine==70) echo 'selected';?>>70</option>
					<option value="80" <? if($intPageLine==80) echo 'selected';?>>80</option>
					<option value="90" <? if($intPageLine==90) echo 'selected';?>>90</option>
					<option value="100" <? if($intPageLine==100) echo 'selected';?>>100</option>
					<option value="200" <? if($intPageLine==200) echo 'selected';?>>200</option>
				</select>
			</div>
		<div class="clear"></div>
	</div>
	<!-- 포인트 내역 및 목록수 설정 -->
	<div>
		<table class="tableList">
			<colgroup>
				<col style="width:8%;">
				<col />
				<col style="width:15%;">
				<col style="width:12%;">
				<col />
				<col style="width:12%;">
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["EW00038"] //회원ID?>(<?=$LNG_TRANS_CHAR["EW00039"] //회원명?>)</th>
				<th><?=$LNG_TRANS_CHAR["EW00040"] //포인트종류?></th>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
				<th><?=$LNG_TRANS_CHAR["EW00032"] //포인트설명?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
			</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){

					/* 회원 소속 */
					$strMemberCateList = $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
					if ($S_FIX_MEMBER_CATE_USE_YN  == "Y")
					{

						if (!$memberCateMgr){
							require_once MALL_CONF_LIB."memberCateMgr.php";
							$memberCateMgr			= new MemberCateMgr();
						}
						$param								= "";
						$param['M_NO']						= $row['M_NO'];
						$param['ORDER_BY']					= "C.C_CODE ASC";
						$param['MEMBER_CATE_MGR_JOIN']		= "Y";
						$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYTOTAL", $param);
						
						if (is_array($aryMemberCateList)){
							foreach($aryMemberCateList as $key => $memberCateRow){
								//if ($key > 0) continue;
								$intMemberCateLevel	= strlen($memberCateRow['C_CODE']) / 3;
								//$strMemberCateList	= "";
								for($i = 1; $i<=3; $i++):
									if($intMemberCateLevel >= $i):
										$strCateCode		 = substr($memberCateRow['C_CODE'], 0, $i*3);
										${"strMemberCateName_".$i} = $MEMBER_CATE[$strCateCode]['C_NAME'];								
									endif;
								endfor;
								
								$strMemberCateList .= "<li>";
								$strMemberCateList .= $strMemberCateName_1;
								$strMemberCateList .= ($strMemberCateName_2)? " > {$strMemberCateName_2}":"";
								$strMemberCateList .= ($strMemberCateName_3)? " > {$strMemberCateName_3}":"";
								$strMemberCateList .= "</li>";
							}
						}				
					}
					/* 회원 소속 */

					/* 회원 포인트 이동 메모 */
					$strPointEtc = "";
					if ($S_FIX_MEMBER_POINT_GIFT_FLAG == "Y"){
						if ($row['PT_TYPE'] == "010") {
							$strPointEtc = "<br>(".$row['M_RECEIVE_ID']."(".$row['M_RECEIVE_NAME'].")님에게 포인트 선물 받았습니다.)";
						} else if($row['PT_TYPE'] == "011"){
							if ($row['PT_ETC']){
								$memberMgr->setM_NO($row['PT_ETC']);
								$pointSendMemberInfo = $memberMgr->getMemberView($db);
								$strPointEtc = "<br>(".$pointSendMemberInfo['M_ID']."(".$pointSendMemberInfo['M_NAME'].")님에게 포인트 선물 하였습니다.)";
							}
						} else {
							if ($row['PT_REG_NO'] > 1 && $row['PT_REG_NO']){
								$strPointEtc = "<br>(".$row['M_RECEIVE_ID']."(".$row['M_RECEIVE_NAME']."))";
							}
						}
					} else {
						if ($row['PT_REG_NO'] > 1 && $row['PT_REG_NO']){
							$strPointEtc = "<br>(".$row['M_RECEIVE_ID']."(".$row['M_RECEIVE_NAME']."))";
						}
					}
			?>
			<tr>
				<td><?=$intListNum--?></td>
				
				<td class="alignLeft">
					<ul>
						<li>
							<a href="javascript:goMemberCrmView('<?=$row[M_NO]?>');"><?if($S_MEM_CERITY == "1"){?><?=$row[M_ID]?><?}else{?><?=$row[M_MAIL]?><?}?>(<?=$row[M_NAME]?>)</a>
							<?if ($row[O_NO] > 0){?>
								<a class="btn_sml" href="javascript:goMemberOrderView('<?=$row[O_NO]?>');"><strong>구매</strong></a>
							<?}?>
						</li>
						<?=$strMemberCateList?>
					</ul>
				</td>
				<td style="width:45px;margin:0 auto;">
					<span><em><?=$row['POINT_TYPE_NM']?></em></span>
				</td>
				<td><?=getFormatPrice($row[PT_POINT],2,$S_ST_CUR)?></td>
				<td>
					<?=$row[PT_MEMO]?>
					<?=$strPointEtc;?>
				</td>
				<td><?=$row[PT_REG_DT]?></td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt10">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->
</div>
