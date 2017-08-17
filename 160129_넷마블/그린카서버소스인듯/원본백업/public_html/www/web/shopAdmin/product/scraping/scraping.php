<div id="contentArea">
	<div class="contentTop">
		<h2>상품 가져오기</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->	
	<div class="tableForm mt20">
		<table>
			<colgroup>
				<col style="width:100px;"/>
				<col/>
			</colgroup>
			<tr>
				<th>적용카테고리</th>
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
				<th>가져올 URL</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:500px;" name="scrapOpenUrl" id="scrapOpenUrl" value="dalin-car" /> <a href="javascript:goScpJson('scrapingInfo')" class="btn_sml" ><strong>검색</strong></a> <!--<a href="#" class="btn_sml"><span>불러온 페이지 저장</span></a>//-->
				</td>
			</tr>
			<tr>
				<th>목록에서 선택</th>
				<td>
					<dl class="tdListUl">
						<dd>
							<span class="spanTitle">쇼핑몰선택</span>
							<?=drawSelectBoxMoreQuery("selectshopList", $scrapingRow, "","","goSelectShopList(this.form)","","","",0,1);?>
						</dd>
						<dd>
							<span class="spanTitle">페이지선택</span>
							<?=drawSelectBoxMoreQuery("selectshopPageList", $scrapingPageRow, "","","goScrapingJson3()","","","",0,1);?>
							<a href="javascript:goScrapingJson2()" class="btn_sml"><strong>검색</strong></a>
							<a href="?menuType=product&mode=scrapingMake" class="btn_sml"><strong>작업</strong></a>
						</dd>
					</dl>
				</td>
			</tr>
			<tr>
				<th>검색결과</th>
				<td>총 <strong class="txtColorBlue" id="pageTotal">0페이지</strong>에서 <strong class="txtColorBlue" id="listTotal">0개</strong>의 상품이 검색 되었습니다.</td>
			</tr>
			<tr>
				<th>실행</th>
				<td>
					<ul class="inlineBtn">
			<!--			<li><div id="run"><a href="javascript:goScpJson('scrapingRun')" class="btn_blue_big"><strong><img src="/shopAdmin/himg/common/ajax-loader_trans.gif" class="lodingIcon"/> 지금 가져오기 실행</strong></a></div></li>		//-->
						<li><div id="run"><a href="javascript:goScpJson('scrapingRunFile')" class="btn_blue_big"><strong><img src="/shopAdmin/himg/common/ajax-loader_trans.gif" class="lodingIcon"/> 파일 가져오기 실행</strong></a></div></li>
						<li><a href="javascript:goScpJson('userSaveDB')" class="btn_big"><strong>가져온 목록 DB 저장</strong></a></li>					
					</ul>
					<div class="clear"></div>
					<!--<a href="javascript:goScrapingJsonStop()" class="btn_blue_big"><strong><img src="/shopAdmin/himg/common/ajax-loader_trans_on.gif" class="lodingIcon"/> 지금 가져오기 정지</strong></a>//-->
				</td>
			</tr>
		</table>
	</div>

	<div class="tableList mt20">
		<div class="tableListTopWrap">
			<span class="listCntNum">* 총 <strong>0개</strong>의 상품이 있습니다.</span>
			<div class="selectedSort">
	<!--			<span class="spanTitle mt5">목록갯수:</span>
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
				</select>		//-->
			</div>
			<div class="clear"></div>
		</div><!-- tableListTopWrap -->
		<div id="traceLog"></div>

		<table id="sampleTable"><?=$dataHtml?></table>
	</div>
	<div class="paginate">

		<input type="hidden" name="pid" id="pid" value="" />
		<input type="hidden" name="trLastNo" id="trLastNo" value="0" />
<!--
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
//-->
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->