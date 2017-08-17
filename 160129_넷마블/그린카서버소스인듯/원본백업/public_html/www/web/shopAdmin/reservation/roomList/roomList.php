<div id="contentArea">
	<div class="contentTop">
		<h2>객실관리</h2>
		<div class="clr"></div>
	</div>
	<br>



	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">

	</div>




	<div class="tableListWrap mt20">
		<a href="/shopAdmin/?menuType=reservation&mode=roomWrite" class="btn_blue_big"><strong>등록</strong></a>
		<table class="tableList">
			<tr>
				<th rowspan="2">번호</th>
				<th rowspan="2" colspan="2">객실정보</th>
				<th colspan="3">요금정보</th>
				<th rowspan="2">등록일</th>
				<th rowspan="2">관리</th>
			</tr>
			<tr>
				<th>비수기</th>
				<th>준성수기</th>
				<th>성수기</th>
			</tr>
			<?while($row = mysql_fetch_array($resultRoom)){?>
			<?
				$strDealerImg = "";
				if ($row['R_LIST_IMAGE']){
				$strDealerImg = "<img class='listImg' src='../upload/images/".$row["R_LIST_IMAGE"]."'  style='width:80px;height:80px;'/>";
			}
			?>
			<tr>
				<td><?echo $intRoomTt;?></td>
				<td style="width:80px;"><?=$strDealerImg?></td>
				<td>
					<ul>
						<li>객실명 : <?echo $row['R_NAME'];?></li>
						<li>면적: <?echo $row['R_AREA']*3.3;?>㎡(<?echo $row['R_AREA'];?>평)</li>
						<li>객실유형: <?echo $row['R_TYPE'];?></li>
						<li>기준/최대: <?echo $row['R_ST_PER'];?>명/<?echo $row['R_MAX_PER'];?>명</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>주중: <?echo number_format($row['R_B_MPRICE']);?>원</li>
						<li>주말: <?echo number_format($row['R_B_WPRICE']);?>원</li>
						<li>휴일: <?echo number_format($row['R_B_SPRICE']);?>원</li>
						<li>1인추가: <?echo number_format($row['R_BI_PRICE']);?>원</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>주중: <?echo number_format($row['R_Z_MPRICE']);?>원</li>
						<li>주말: <?echo number_format($row['R_Z_WPRICE']);?>원</li>
						<li>휴일: <?echo number_format($row['R_Z_SPRICE']);?>원</li>
						<li>1인추가: <?echo number_format($row['R_ZI_PRICE']);?>원</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>주중: <?echo number_format($row['R_S_MPRICE']);?>원</li>
						<li>주말: <?echo number_format($row['R_S_WPRICE']);?>원</li>
						<li>휴일: <?echo number_format($row['R_S_SPRICE']);?>원</li>
						<li>1인추가: <?echo number_format($row['R_SI_PRICE']);?>원</li>
					</ul>
				</td>
				<td>
					<?echo substr($row['R_REG_DT'],0,10);?>
					<?if($row['R_PRINT']=="on"){?><p>출력</p><?}else{?><p>출력안함</p><?}?>
				</td>
				<td>
					<a href="./?menuType=reservation&mode=roomModify&no=<?echo $row['R_NO'];?>" class="btn_blue_sml"><span>수정</span></a>
					<a href="javascript:goRoomBasicDelete(<?echo $row["R_NO"];?>);" class="btn_sml"><span>삭제</span></a>
				</td>
				<?$intRoomTt--;?>
			</tr>
			<?}?>
		</table>
	</div>
</div>
