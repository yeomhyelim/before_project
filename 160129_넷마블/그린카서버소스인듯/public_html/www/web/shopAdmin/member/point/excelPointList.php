		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00038"] //회원ID?></th>
				<th><?=$LNG_TRANS_CHAR["EW00039"] //회원명?></th>
				<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
				<th><?="소속1"?></th>
				<th><?="소속2"?></th>
				<?}?>
				<th><?=$LNG_TRANS_CHAR["EW00040"] //포인트종류?></th>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
				<th><?=$LNG_TRANS_CHAR["EW00032"] //포인트설명?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
			</tr>
			<?
				while($row = mysql_fetch_array($result)){

					/* 회원 소속 */
					$strMemberCateList = $strMemberCateList0 = $strMemberCateList1 = "";
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
								$strMemberCateList	= $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
								for($i = 1; $i<=3; $i++):
									if($intMemberCateLevel >= $i):
										
										$strCateCode		 = substr($memberCateRow['C_CODE'], 0, $i*3);
										${"strMemberCateName_".$i} = $MEMBER_CATE[$strCateCode]['C_NAME'];
									endif;
								endfor;
								
								$strMemberCateList .= $strMemberCateName_1;
								$strMemberCateList .= ($strMemberCateName_2)? " > {$strMemberCateName_2}":"";
								$strMemberCateList .= ($strMemberCateName_3)? " > {$strMemberCateName_3}":"";
								
								${"strMemberCateList".$key} = $strMemberCateList;
							}
						}				
					}
					/* 회원 소속 */
			?>
			<tr>
				<td><?if($S_MEM_CERITY == "1"){?><?=$row[M_ID]?><?}else{?><?=$row[M_MAIL]?><?}?></td>
				<td><?=$row[M_NAME]?></td>
				<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
				<td><?=$strMemberCateList0?></td>
				<td><?=$strMemberCateList1?></td>
				<?}?>
				<td><?=$row['POINT_TYPE_NM']?></td>
				<td><?=getFormatPrice($row[PT_POINT],2,$S_ST_CUR)?></td>
				<td>
					<?=$row[PT_MEMO]?>
					<?
						if ($row['PT_REG_NO'] > 1 && $row['PT_REG_NO']){
							echo "<br>(".$row['M_RECEIVE_ID']."(".$row['M_RECEIVE_NAME']."))";
						}
					?>
				</td>
				<td><?=$row[PT_REG_DT]?></td>
			</tr>
			<?
				}
			?>
		</table>