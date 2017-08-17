
<table border="1">
	<tr>
		<th>번호</th>
		<th>회원명</th>
		<th>아이디</th>
		<th>이메일</th>
		<th>회원그룹</th>
		<th>연락처</th>				
		<?
		/* 사용자 항목 */
		foreach($aryUserItemList as $key => $joinURow){
			if (in_array($joinURow['JI_USE'],array("A","Y"))){
				if (!in_array($joinURow['JI_CODE'],array("PASS"))){
					if ($joinURow['JI_CODE'] == "ADDR") echo "<th>우편번호</th>";
					echo "<th>".$joinURow['JI_NAME_'.$strStLng]."</th>";
				}
			}
		}

		foreach($aryBusiItemList as $key => $joinSRow){
			if (in_array($joinSRow['JI_USE'],array("A","Y"))){
				if (!in_array($joinSRow['JI_CODE'],array("BUSI_INFO"))){
					echo "<th>".$joinSRow['JI_NAME_'.$strStLng]."</th>";
				}
			}
		}

		foreach($aryAddItemList as $key => $joinARow){
			if (in_array($joinARow['JI_USE'],array("A","Y"))){
				echo "<th>".$joinARow['JI_NAME_'.$strStLng]."</th>";
			}
		}

		foreach($aryTempItemList as $key => $joinTRow){
			if (in_array($joinTRow['JI_USE'],array("A","Y"))){
				echo "<th>".$joinTRow['JI_NAME_'.$strStLng]."</th>";
			}
		}

		?>
		<th>포인트</th>
		<th>쿠폰</th>
		<th>구매횟수</th>
		<th>구매금액</th>
		<?if ($strSearchOut == "Y"){?>
		<th>탈퇴일자</th>
		<?}else{?>
		<th>최근방문일</th>
		<th>가입일</th>
		<?}?>
	</tr>
	<?
	$index = 1;
	while($row = mysql_fetch_array($result)){
		
		$strMemberName = $row[M_F_NAME];
		if ($row[M_L_NAME]) {
			if ($strMemberName) $strMemberName = " ";
			$strMemberName .= $row[M_L_NAME];
		}
		
		$strMemberCateList = $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
		if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){

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
		
	?>
	<tr>
		<td><?=$index?></td>
		<td><?=$strMemberName;?></td>
		<td><?=$row['M_ID'];?></td>
		<td><?=$row['M_MAIL'];?></td>
		<td><?=$row['G_NAME'];?></td>
		<td><?=$row['M_PHONE'];?></td>
		<?
		/* 사용자 항목 */
		foreach($aryUserItemList as $key => $joinURow){
			if (in_array($joinURow['JI_USE'],array("A","Y"))){
				if (!in_array($joinURow['JI_CODE'],array("PASS"))){
					
					switch($joinURow['JI_CODE']){
						case "ADDR":
							echo "<td>".$row['M_ZIP']."</td>";
							echo "<td>".$row['M_'.$joinURow['JI_CODE']]." ".$row['M_ADDR2']."</td>";
						break;
						case "SEX":
							if ($row['M_SEX']=="M") $strSex = "남성";
							elseif($row['M_SEX']=="W") $strSex = "여성";
							else $strSex = "";
							echo "<td>".$strSex."</td>";
						break;
						case "BIRTH_CAL":
							if ($row['M_BIRTH_CAL']=="1") $strBirthCal = "음력";
							elseif($row['M_BIRTH_CAL']=="2") $strBirthCal = "양력";
							else $strBirthCal = "";
							echo "<td>".$strBirthCal."</td>";
						break;
						case "REC":
							echo "<td>".$row['M_REC_NAME']."</td>";
						break;
						default:
							if ($row['M_'.$joinURow['JI_CODE']]) echo "<td>".$row['M_'.$joinURow['JI_CODE']]."</td>";
							else echo "<td>&nbsp;</td>";
						break;
					}
				}
			}
		}

		/* 사업자정보 */
		foreach($aryBusiItemList as $key => $joinSRow){
			if (in_array($joinSRow['JI_USE'],array("A","Y"))){
				if (!in_array($joinSRow['JI_CODE'],array("BUSI_INFO"))){
					if ($row['M_'.$joinSRow['JI_CODE']]) echo "<td>".$row['M_'.$joinSRow['JI_CODE']]."</td>";
					else echo "<td>&nbsp;</td>";
				}
			}
		}
		
		/*추가항목 */
		foreach($aryAddItemList as $key => $joinARow){
			if (in_array($joinARow['JI_USE'],array("A","Y"))){
				if ($row['M_'.$joinARow['JI_CODE']]) echo "<td>".$row['M_'.$joinARow['JI_CODE']]."</td>";
				else echo "<td>&nbsp;</td>";
			}
		}
		
		/* 임시필드 */
		foreach($aryTempItemList as $key => $joinTRow){
			if (in_array($joinTRow['JI_USE'],array("A","Y"))){
				if ($row['M_'.$joinTRow['JI_CODE']]) echo "<td>".$row['M_'.$joinTRow['JI_CODE']]."</td>";
				else echo "<td>&nbsp;</td>";
			}
		}

		?>
		<td><?=number_format($row['M_POINT']);?></td>
		<td><?=$row['M_COUPON_CNT']?></td>
		<td><?=(!$row['M_BUY_CNT'])?0:$row['M_BUY_CNT'];?></td>
		<td><?=(!$row['M_BUY_PRICE'])?0:number_format($row['M_BUY_PRICE']);?></td>
		<?if ($strSearchOut == "Y"){?>
		<td><?=$row['M_OUT_DT']?></td>
		<?}else{?>
		<td><?=$row['M_LOGIN_DT']?></td>
		<td><?=$row['M_REG_DT']?></td>
		<?}?>
	</tr>


	<?$index++;?>
<?}?>
</table>
