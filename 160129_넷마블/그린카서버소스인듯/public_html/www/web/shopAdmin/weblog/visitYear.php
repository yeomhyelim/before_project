<?
	$totalCnt = 0;
	for($x=1;$x<=12;$x++){
		
		$query="select sum(cnt) as cnt from $tb_counter where y='$nowY' and m='$x'";
		$row=$db->getSelect($query);//echo $query;

		$cnt=$row["cnt"];
		if (!$cnt) $cnt = 0;

		$strX .= "'".$x."',";
		$strY .= $cnt.",";	
	
		$aryMonth[$x] = $cnt;
		$totalCnt += $cnt;
	}

	$strY = SUBSTR($strY,0,STRLEN($strY)-1);
	$strX = SUBSTR($strX,0,STRLEN($strX)-1);
	
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
		
		$.jqplot.config.enablePlugins = true;
        var s1 = [<?=$strY?>];
        var ticks = [<?=$strX?>];
        
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
				yaxis:{
					tickOptions:{
						formatString:"%'d"
					}
				}
            },

            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                //$('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
	});
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00090"]//월별 방문자 분석?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<!-- 그래프 -->
		<div class="logGraphWrap" id="chart1"></div>
	<!-- 그래프 -->
	<div class="tableListWrap">
		<select name="nowY" size="1" onChange="form.submit()">
		<?
			for($y=2013;$y<=date("Y");$y++){
				if($y==$nowY)$str="selected";
				else $str="";
				echo "<option value='$y' $str>$y</option>";
			}
		?>
		</select>
	</div>

	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col style="width:80px;"/>				
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th>1<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>2<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>3<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>4<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>5<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>6<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>7<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>8<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>9<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>10<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>11<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th>12<?=$LNG_TRANS_CHAR["CW00013"]//월?></th>
				<th><?=$LNG_TRANS_CHAR["OW00026"]//총합계?></th>
			</tr>
			<tr>
			<?
			for($x=1;$x<=12;$x++){
				echo "<td>".number_format($aryMonth[$x])."</td>";
			}
			?>
				<td><?=number_format($totalCnt)?></td>
			</tr>

		</table>
	</div>
	<!-- tableList -->

	
</div>
