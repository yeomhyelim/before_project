			<table border="1">
				<tr>
					<th><?=iconv("utf-8","euc-kr","번호")?></th>
					<th><?=iconv("utf-8","euc-kr","참여자")?></th>
					<th><?=iconv("utf-8","euc-kr","전화번호")?></th>
					<th><?=iconv("utf-8","euc-kr","이메일")?></th>
					<th><?=iconv("utf-8","euc-kr","참여내용")?></th>
					<th><?=iconv("utf-8","euc-kr","포인트발급명")?></th>
					<th><?=iconv("utf-8","euc-kr","포인트")?></th>
					<th><?=iconv("utf-8","euc-kr","쿠폰")?></th>
					<th><?=iconv("utf-8","euc-kr","참여횟수")?></th>
					<th><?=iconv("utf-8","euc-kr","당첨횟수")?></th>
					<th><?=iconv("utf-8","euc-kr","작성일자")?></th>
				</tr>
				<? 
					$commentView		= new CommunityEventCommentView($db, $_REQUEST);
					while($row = mysql_fetch_array($result)) : 
						/** 참여횟수 **/
						if(!$row['CM_M_NO']):
							// 비회원
							$row['CM_PART_CNT']		= "-";
							$row['CM_WIN_CNT']		= "-";
							$row['CM_M_ID']			= "비회원";
						else:
							// 회원
							$param['b_code']	= $_REQUEST['b_code'];
							$param['cm_m_no']	= $row['CM_M_NO'];
							$param['cm_winner']	= "";
							$row['CM_PART_CNT']	= $commentView->getJoinCountEx($param);
		//					print_r($db->query); echo "<br>";

							/** 당첨횟수 **/
							$param['cm_winner']	= "Y";
							$row['CM_WIN_CNT']	= $commentView->getJoinCountEx($param);

						endif;
				
				   ?>
				<tr>
					<td><?=$list_num--?></td>
					<td><?=iconv("utf-8","euc-kr",$row['CM_NAME'])?>(<?=iconv("utf-8","euc-kr",$row['CM_M_ID'])?>)</td>
					<td><?=iconv("utf-8","euc-kr",$row['M_HP'])?></td>
					<td><?=iconv("utf-8","euc-kr",$row['CM_MAIL'])?></td>
					<td>
					<?=iconv("utf-8","euc-kr",strConvertCut($row['CM_TITLE'],0,"N"))?><br>
					<?if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full"):?>
						<?=iconv("utf-8","euc-kr",strConvertCut($row['CM_TEXT'],0,"Y"))?>
					<?else:?>
						<?=iconv("utf-8","euc-kr",strConvertCut($row['CM_TEXT'],0,"N"))?>
					<?endif;?>
					</td>
					<td><?=iconv("utf-8","euc-kr",$row['GM_TITLE'])?></td>
					<td><?=iconv("utf-8","euc-kr",$row['PT_POINT'])?></td>
					<td><?=iconv("utf-8","euc-kr",$row['CU_NAME'])?></td>
					<td><?=iconv("utf-8","euc-kr",$row['CM_PART_CNT'])?></td>
					<td><?=iconv("utf-8","euc-kr",$row['CM_WIN_CNT'])?></td>
					<td><?=iconv("utf-8","euc-kr",date("Y.m.d", strtotime($row['CM_REG_DT'])))?></td>
				</tr>
				<? endwhile; 
				   ?>
			</table>


