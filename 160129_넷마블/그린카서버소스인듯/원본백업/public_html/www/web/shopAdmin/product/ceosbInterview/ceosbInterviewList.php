<div class="contentTop">
	<h2 class="left">
		감성 인터뷰 칼럼
	</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tableList">
	<table>
		<colgroup>
			<col width=40/>
			<col width=80/>
			<col />
			<col width=200/>
			<col width=200/>
			<col width=200/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>이미지</th>
			<th>정보</th>
			<th>방문 횟수</th>
			<th>사용유무</th>
			<th>작성일</th>
		</tr>
		<?while($row = mysql_fetch_array($ceosbInterviewColumnResult)):
			$strCode				= $row['IC_CODE'];
			$strTitle				= $row['IC_TITLE'];
			$strSummary				= $row['IC_SUMMARY'];
			$strKeyword				= $row['IC_KEYWORD'];
			$intVisitCnt			= $row['IC_VISIT_CNT'];
			$strImage1				= $row['IC_IMAGE1'];
			$strUse					= $row['IC_USE'];
			$strRegDate				= $row['IC_REG_DT'];
			$intKind				= $row['IC_KIND'];

			## 작성일 설정
			$strRegDate				= date("Y.m.d", strtotime($strRegDate));

			## 종류 설정
			$strKind				= $aryKind[$intKind];

			?>
		<tr>
			<td style="height:80px"><?=$intListNum--?></td>
			<td>
				<?if($strImage1):?>
				<img src="<?=$strImage1?>">
				<?endif;?>
			</td>
			<td style="text-align:left">
				<a href="javascript:goCeosbInterviewViewMoveEvent('<?=$strCode?>')">
				<ul>
					<li>메뉴 : <?=$strKind?></li>
					<li>코드 : <?=$strCode?></li>
					<li>제목 : <?=$strTitle?></li>
					<li>요약 : <?=$strSummary?></li>
					<li>키워드 : <?=$strKeyword?></li>
				</ul>
				</a>
			</td>
			<td><?=$intVisitCnt?></td>
			<td><?=$strUse?></td>
			<td><?=$strRegDate?></td>
		</tr>
		<?endwhile;?>
	</table>
</div>

<br>

<div class="button">
	<a href="javascript:goCeosbInterviewWriteMoveEvent();" class="btn_big" id="menu_auth_m" style=""><strong>등록</strong></a>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>