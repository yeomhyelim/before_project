<?
	## 설졍
	require_once MALL_CONF_LIB."WebLogMgr.php";
	$webLogMgr						= new WebLogMgr();
	$param							= "";
	$param['NO']					= $_REQUEST['no'];
	$logRefererRow					= $webLogMgr->getLogRefererList($db, "OP_SELECT", $param);

	## 정렬 설정
	if($_REQUEST['sortType'] == "HOST_DESC")			{ $orderBy ="HOST DESC";		}
	else if($_REQUEST['sortType'] == "HOST_ASC")		{ $orderBy ="HOST ASC";			}
	else if($_REQUEST['sortType'] == "QUERY_DESC")		{ $orderBy ="QUERY DESC";		}
	else if($_REQUEST['sortType'] == "QUERY_ASC")		{ $orderBy ="QUERY ASC";		}
	else if($_REQUEST['sortType'] == "KEYWORD_DESC")	{ $orderBy ="KEYWORD DESC";		}
	else if($_REQUEST['sortType'] == "KEYWORD_ASC")		{ $orderBy ="KEYWORD ASC";		}
	else if($_REQUEST['sortType'] == "VISITDAY_DESC")	{ $orderBy ="Y DESC, M DESC, D DESC";	}
	else if($_REQUEST['sortType'] == "VISITDAY_ASC")	{ $orderBy ="Y ASC, M ASC, D ASC";		}
	else												{ $orderBy ="HOST DESC";		}

	$param							= "";
	$param['HOST_LIKE']				= $logRefererRow['HOST'];
	$param['YMD_START']				= $_REQUEST['serchStartDate'];
	$param['YMD_END']				= $_REQUEST['serchEndDate'];
	$param['ORDER_BY']				= $orderBy;
	$logRefererTotal				= $webLogMgr->getLogRefererList($db, "OP_COUNT2", $param);
	$logRefererResult				= $webLogMgr->getLogRefererList($db, "OP_LIST2", $param);

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	function goSort(type) { 
		var data = new Array(5);
		data['sortType'] = type;
		data['page']	= 1;
		C_getAddLocationUrl(data);
	}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2>호스트별 방문자 분석</h2>
	</div>
</div>

	<div id="contentArea">
		<div class="bodyTopLine"></div>
		<!-- ******************** contentsArea ********************** -->
			<div class="layoutWrap">
			<form name="form" id="form">
				<input type="hidden" name="menuType" value="<?=$strMenuType?>">
				<input type="hidden" name="mode" value="<?=$strMode?>">
				<input type="hidden" name="act" value="<?=$strMode?>">
				<div class="tableList">
					<table border="1px">
						<tr>
							<th>번호</th>
							<th>HOST<a href="javascript:goSort('HOST_DESC')">▲</a><a href="javascript:goSort('HOST_ASC')">▼</a></th>
							<th>QUERY<a href="javascript:goSort('QUERY_DESC')">▲</a><a href="javascript:goSort('QUERY_ASC')">▼</a></th>
							<th>KEYWORD<a href="javascript:goSort('KEYWORD_DESC')">▲</a><a href="javascript:goSort('KEYWORD_ASC')">▼</a></th>
							<th>접속일<a href="javascript:goSort('VISITDAY_DESC')">▲</a><a href="javascript:goSort('VISITDAY_ASC')">▼</a></th>
						</tr>
						<?while($row = mysql_fetch_array($logRefererResult)):
							$date = "{$row['Y']}.{$row['M']}.{$row['D']}";
						?>
						<tr>
							<td><?=$logRefererTotal--?></td>
							<td style="text-align:left"><?=$row['HOST']?></td>
							<td style="text-align:left"><?=$row['QUERY']?></td>
							<td><?=$row['KEYWORD']?></td>
							<td><?=$date?></td>
						</tr>
						<?endwhile;?>
					</table>
				</div>
			</form>
			</div>
		<!-- ******************** contentsArea ********************** -->
	</div>
	
	<br>
	<a href="javascript:self.close()" class="btn_big"><strong>닫기</strong></a>

</body>

</html>