<?
	## 설정
	if(!$_REQUEST['serchStartDate'])	{ $_REQUEST['serchStartDate']	= date("Y-m-d"); }
	if(!$_REQUEST['serchEndDate'])		{ $_REQUEST['serchEndDate']		= date("Y-m-d"); }
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$('input[name=serchStartDate]').simpleDatepicker();
		$('input[name=serchEndDate]').simpleDatepicker();
	});

	function goSearch() {
		var data = new Array(5);
		data['serchStartDate']	= $("input[name=serchStartDate]").val();
		data['serchEndDate']	= $("input[name=serchEndDate]").val();
		data['page']			= 1;
		C_getAddLocationUrl(data);
	}

	function goSort(type) { 
		var data = new Array(5);
		data['sortType'] = type;
		data['page']	= 1;
		C_getAddLocationUrl(data);
	}

	function goExcelDownload() {
		var data = new Array(5);
		data['mode']	= "excel";
		data['act']		= "excelVisitRefer";
		data['page']	= 1;
		C_getAddLocationUrl(data);
	}

	function goHostKeyWordDetailList(no) {
		var serchStartDate	= $("input[name=serchStartDate]").val();
		var serchEndDate	= $("input[name=serchEndDate]").val();
		var href			= "./?menuType=weblog&mode=popVisitRefer&serchStartDate="+serchStartDate+"&serchEndDate="+serchEndDate+"&no="+no;
		window.open(href,"","width=800px,height=500px");
	}
//-->
</script>

<div id="contentArea">
	<div class="contentTop">
		<h2>질의어별 방문자 분석</h2>
		<div class="clr"></div>
	</div>
</div>

<br>

<div class="">
	<input type="text" name="serchStartDate" value="<?=$_REQUEST['serchStartDate']?>" style="width:100px" readOnly/> -
	<input type="text" name="serchEndDate"   value="<?=$_REQUEST['serchEndDate']?>" style="width:100px" readOnly/>
	<a href="javascript:goSearch()" class="btn_sml"><span>검색</span></a>
	<a href="javascript:goExcelDownload()" class="btn_sml"><span>엑셀 다운로드</span></a>
</div>

<div class="tableList">
	<table>
		<colgroup>
			<col style="width:300px;"/>				
			<col />
			<col style="width:100px;background-color:#f1f7f9" />
		</colgroup>
		<tr>
			<th>KEYWORD<a href="javascript:goSort('KEYWORD_DESC')">▲</a><a href="javascript:goSort('KEYWORD_ASC')">▼</a></th>
			<th>RATE<a href="javascript:goSort('RATE_DESC')">▲</a><a href="javascript:goSort('RATE_ASC')">▼</a></th>
			<th>접속자수<a href="javascript:goSort('VISITCNT_DESC')">▲</a><a href="javascript:goSort('VISITCNT_ASC')">▼</a></th>
		</tr>
		<?while($row = mysql_fetch_array($logRefererResult)):
			$barSize = $row['CNT'] * 1;
			if($barSize >= 1000) { $barSize = 1000; }		?>
		<tr>
			<td style="text-align:left"><a href="javascript:goHostKeyWordDetailList('<?=$row['NO']?>')"><?=strHanCutUtf2($row['KEYWORD'], 30)?></a></td>
			<td><div style="height:20px;width:<?=$barSize?>px;border:1px solid"></div></td>
			<td><?=$row['CNT']?></td>
		</tr>
		<?endwhile;?>
	</table>
</div>

<br>

<div class="paginate">  
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
</div>  
