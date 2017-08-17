<div id="contentArea">
	<div class="contentTop">
		<h2>상품 가져오기</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->	
	<div class="searchTableWrap mt20">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N">상품명</option>
				<option value="C">상품코드</option>
				<option value="M">제조사</option>
				<option value="O">원산지</option>
				<option value="D">모델명</option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?>/>
						
			<a class="btn_blue_big" href="javascript:goSearch('<?= $strMode ?>');"><strong>검색</strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th>카테고리선택</th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value="">1차 카테고리 선택</option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value="">2차 카테고리 선택</option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value="">3차 카테고리 선택</option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value="">4차 카테고리 선택</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>상품출시일</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchStartDt" name="searchLaunchStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchEndDt" name="searchLaunchEndDt" maxlength="10"/>
				</td>
			</tr>
			<tr>
				<th>상품등록일</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepStartDt" name="searchRepStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepEndDt" name="searchRepEndDt" maxlength="10"/>
					<span class="searchWrapImg">
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_today.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_week.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_15.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_month.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_2month.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_all.gif"/></a>
					</span>
				</td>
			</tr>
			<tr>
				<th>상품출력여부</th>
				<td>
					<input type="checkbox" id="searchWebView" name="searchWebView" value="Y">웹보임
					<input type="checkbox" id="searchMobileView" name="searchMobileView" value="Y">모바일보임
				</td>
			</tr>
		</table>
	</div>


	<div class="tableList mt20">
		<div class="tableListTopWrap">
			<span class="listCntNum">* 총 <strong>100개</strong>의 상품이 있습니다.</span>
			<div class="selectedSort">
				<span class="spanTitle mt5">목록갯수:</span>
				<select name="" style="vertical-align:middle;">
					<option value="">20</option>
					<option value="" selected>30</option>
					<option value="">40</option>
					<option value="">50</option>
					<option value="">60</option>
					<option value="">70</option>
					<option value="">80</option>
					<option value="">90</option>
					<option value="">100</option>
				</select>
			</div>
			<div class="clear"></div>
		</div><!-- tableListTopWrap -->


		<table id="prodListTable" >
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:100px;"/>
				<col/>
				<col style="width:150px;"/>
				<col style="width:150px;"/>
				<col style="width:100px;"/>

			</colgroup>
			<tr class="item1">
				<th><input type="checkbox" name=""/></th>
				<th>번호</th>
				<th>이미지</th>
				<th>상품명</th>
				<th>판매가</th>
				<th>가져온일자</th>
				<th>관리</th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="9">등록된 상품이 없습니다.</td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
				
				?>

			<tr class="item2">
				<td><input type="checkbox" name=""/></td>
				<td><?=$intListNum?></td>
				<td><img src="<?=$row[PM_REAL_NAME]?>" width="100" height="50"/> </td>
				<td><?=$row[P_NAME]?></td>				
				<td><input type="text" name="" <?=$nBox?>  value="<?=$row[P_SALE_PRICE]?>" style="width:80px;"/></td>
				<td><?=$row[P_REG_DT]?></td>
				<td>
					<a href="javascript:goScrapingModify('<?=$row[P_CODE]?>')" class="btn_blue_sml"><span>수정</span></a> 
					<a href="javascript:goScrapingDelete('<?=$row[P_CODE]?>')" class="btn_sml"><span>삭제</span></a>				
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate">
		
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->