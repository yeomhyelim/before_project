<?include "day_revList.helper.php";?>
<?include "search2.inc.php";?>
<div id="contentArea">
	<div class="contentTop">
		<h2>예약정보 상세보기</h2>
		<div class="clr"></div>
	</div>
	<br>



	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">

	</div>




	<div class="tableListWrap mt20">
		<table class="tableList">
			<colgroup>
				<col width="70"/>
				<col width="70"/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name=""></th>
				<th>번호</th>
				<th>상세보기</th>
				<th>기본정보</th>
				<th>예약정보</th>
				<th>결제금액</th>
				<th>결제정보</th>
				<th>예약상태</th>
			</tr height="60"><?$k=0;?>
			<?while($row = mysql_fetch_array($resultResrv)){?>
			<tr>

				<td><input type="checkbox" name=""></td>
				<td><?echo $intListNum;?></td>
				<td><button name="detail<?echo $k;?>" onclick="javascript:goShowDetailInfo(<?echo $k;?>);" value="">상세보기↓  </button></td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li><span>예약번호</span>: <?echo $row['RS_NUMBER'];?></li>
						<li><span>고객명</span>: <?echo $row['RS_NAME'];?></li>
						<li><span>연락처</span>: 010-1234-1234</li>
					</ul>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList_2">
						<li><span>신청객실</span>: 오토캠핑</li>
						<li><span>이용기간</span>: <?echo substr($row['RS_S_DT'],0,10);?>~<?echo substr($row['RS_E_DT'],0,10);?></li>
						<li class="endList"><span>이용인원</span>: 4명</li>
					</ul>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList_2">
						<li><span>객실요금</span>: <?echo number_format($row['RS_R_PRICE']);?>원</li>
						<li><span>추가요금</span>: <?echo number_format($row['RS_A_PRICE']);?>원</li>
						<li class="endList"><span>금액합계</span>: <?echo number_format($row['RS_PAYCASH']);?>원</li>
					</ul>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList_3">
						<li><span>결제방법</span>: <?echo $row['RS_BBOOK'];?></li>
						<li><span>결제액</span>:<?echo number_format($row['RS_PAYCASH']);?>(<?echo $row['RS_PAY_TP'];?>: 미결제)</li>
						<li><span>접수일</span>: <?echo substr($row['RS_REG_DT'],0,10);?></li>
						<li><span>결제일</span>: 2014.11.11</li>
					</ul>
				</td>
				<td>
					<select name="">
						<option <?if($row['RS_STATUS']=="입금대기"){echo "selected";}?>>입금대기</option>
						<option <?if($row['RS_STATUS']=="입금완료"){echo "selected";}?>>입금완료</option>
						<option <?if($row['RS_STATUS']=="선금입금"){echo "selected";}?>>선금입금</option>
						<option <?if($row['RS_STATUS']=="잔금입금"){echo "selected";}?>>잔금입금</option>
						<option <?if($row['RS_STATUS']=="예약취소"){echo "selected";}?>>예약취소</option>
					</select>
				</td>
			</tr>
			<tr name="hiddenroomsetting<?echo $k;?>" style="display:none">
				<?
					$intRNo				= $row['RS_R_NO'];
					$resultRoom			= $reservationMgr->getRoomBasic3($db,$intRNo);
					$resultRBasic		= $reservationMgr->getRoomBasicSetSelect($db,$intRNo);
					$resultComm			= $reservationMgr->getRoomSetFixView3($db);
					$strDealerImg		= "";
						if ($resultRoom['R_LIST_IMAGE'])
						{
						$strDealerImg = "<img class='listImg' src='../upload/images/".$resultRoom["R_LIST_IMAGE"]."'  style='width:120px;height:100px;'/>";
						}
						$strBasic			= explode(',',$resultRBasic['R_SET']);
						$intBasic			= count($strBasic);
				?>
				<td colspan="2">객실사진</td>
				<td width="120"><?=$strDealerImg?></td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li>무료 와이파이</li>
						<li>무료 주차</li>
						<li>호텔 대표번호: 02-2157-2157</li>
					</ul>
				</td>
				<td colspan="2"><table>
					<?while($rowComm = mysql_fetch_array($resultComm)){?>
						<?
							$param					= "";
							$param['CG_NO']			= $rowComm['CG_NO'];
						?>
					<tr>
						<th><?echo $rowComm['CG_NAME'];?></th>
						<td>
							<?$resultCode = $reservationMgr->getRoomSetFixView4($db,$param);?>
							<?
								while($rowCode = mysql_fetch_array($resultCode)){

								$strChk = "";

								for($i=0;$i<$intBasic;$i++)
								{
									if($rowCode['CC_NAME_KR']==$strBasic[$i]){$strChk = "checked";}
								}
							?>
						<input type="checkbox" name="checkBaseSetting[]"  value="<?echo $rowCode['CC_NAME_KR'];?>" <?echo $strChk;?>> <?echo $rowCode['CC_NAME_KR'];?>
								<?}?>
						</td>
					</tr>
					<?}?></table>
				</td>
				<td colspan="2">
					<table>
					<?
					$strAddlist		= $row['RS_ADD_LIST'];
					$strAddlist2	= $row['RS_BDD_LIST'];

					$list			= explode(',',$strAddlist);
					$list2			= explode(',',$strAddlist2);

					for($i=0;$i<count($list);$i++){?>
						<?$param = "";?>
						<?$param['AM_NO'] = $list[$i];?>
						<?$rowAddSet = $reservationMgr->getRoomSetEtcView($db,$param);?>
							<tr class="timeBox">
								<th width="120px">부대시설</th>
								<td><?echo $rowAddSet['AM_DEV'];?> <?echo $list2[$i];?><?echo $rowAddSet['AM_UNIT'];?>(<?echo number_format($rowAddSet['AM_PRICE']);?>원)</td>
							</tr>
					<?}?>
					</table>
				</td>
			</tr>
			<?$intListNum--;$k++;}?>

		</table>
	</div>
</div>
<div class="paginate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"goPostPageMoveEvent","")?>
</div>
