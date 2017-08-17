<?
	switch ($strMailMode){
		case "join":
						
			$strMemberInfoHtml  = "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">";
					
			/* 아이디 */
			if ($S_MEM_CERITY == "1"){
				if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y"){
					if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){

			$strMemberInfoHtml .= "	<tr>";
			$strMemberInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["MW00001"]."</th>";
			$strMemberInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$memberRow[M_ID]."</td>";
			$strMemberInfoHtml .= "	</tr>";
					}
				}
			}

			/* 이름 */
			if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y"){
				if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){
			
			$strMemberInfoHtml .= "	<tr>";
			$strMemberInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["MW00004"]."</th>";
			$strMemberInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$memberRow[M_F_NAME]." ".$memberRow[M_L_NAME]."</td>";
			$strMemberInfoHtml .= "	</tr>";
			
				}
			}
			
			
			/* 생년월일 */
			if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y"){
				if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){
			
			$strMemberInfoHtml .= "	<tr>";
			$strMemberInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["MW00006"]."</th>";
			$strMemberInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">";
			$strMemberInfoHtml .=    SUBSTR($memberRow[M_BIRTH],0,4).$LNG_TRANS_CHAR["CW00010"].SUBSTR($memberRow[M_BIRTH],5,2).$LNG_TRANS_CHAR["CW00011"].SUBSTR($memberRow[M_BIRTH],8).$LNG_TRANS_CHAR["CW00012"];
			
					if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){
						if($memberRow[M_BIRTH_CAL]=="1"){ $strMemberInfoHtml .= "(".$LNG_TRANS_CHAR["MW00015"].")";}
						else $strMemberInfoHtml .= "(".$LNG_TRANS_CHAR["MW00016"].")";
					}
			
			$strMemberInfoHtml .= "	</td></tr>";
			
				}
			}

			/* 핸드폰 */
			if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["JOIN"] == "Y"){
				if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){

			$strMemberInfoHtml .= "	<tr>";
			$strMemberInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["MW00008"]."</th>";
			$strMemberInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$memberRow[M_HP]."</td>";
			$strMemberInfoHtml .= "	</tr>";
				}
			}


			if ($S_JOIN_PHONE["USE"] == "Y" && $S_JOIN_PHONE["JOIN"] == "Y"){
				if (!$S_JOIN_PHONE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHONE["GRADE"])){

			$strMemberInfoHtml .= "	<tr>";
			$strMemberInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["MW00009"]."</th>";
			$strMemberInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$memberRow[M_PHONE]."</td>";
			$strMemberInfoHtml .= "	</tr>";
				}
			}
			
			/* 이메일 */
			if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){
				if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){

			$strMemberInfoHtml .= "	<tr>";
			$strMemberInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["MW00010"]."</th>";
			$strMemberInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$memberRow[M_MAIL]."</td>";
			$strMemberInfoHtml .= "	</tr>";
				}
			}			
							
			$strMemberInfoHtml .= "</table>";
		break;

		
	}
?>