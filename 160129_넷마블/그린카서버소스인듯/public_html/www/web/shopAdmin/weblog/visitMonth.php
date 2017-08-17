<?

	for($x=1;$x<=$totalDay;$x++){
		$cnt=$counter[$x];
	
		if (!$cnt) $cnt = 0;
		
		$strX .= "'".$x."',";
		$strY .= $cnt.",";	
	
		$aryDay[$x] = $cnt;		
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
		<h2><?=$LNG_TRANS_CHAR["MM00091"]//일별 방문자 분석?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<!-- 그래프 -->
		<div class="logGraphWrap" id="chart1"></div>
	<!-- 그래프 -->
	<div class="tableList">
		<select name="nowY" size="1" onChange="form.submit()">
		<?
			for($y=2013;$y<=date("Y");$y++){
				if($y==$nowY)$str="selected";
				else $str="";
				echo "<option value='$y' $str>$y</option>";
			}
		?>
		</select>
	    <select name=nowM size=1 onChange="form.submit()">
		<?
			for($m=1;$m<=12;$m++){
				if($m==$nowM)$str="selected";
				else $str="";
				echo "<option value='$m' $str>$m</option>";
			}
		?>
       </select>
	</div>

	<div class="tableList">
		<table>
			<colgroup>
				<col style="width:80px;"/>				
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00168"]//일자?></th>
				<th><?=$LNG_TRANS_CHAR["OW00169"]//접속자수?></th>
				<th><?=$LNG_TRANS_CHAR["OW00168"]//일자?></th>
				<th><?=$LNG_TRANS_CHAR["OW00169"]//접속자수?></th>
			</tr>
			<tr>
			<?
			for($x=1;$x<=$totalDay;$x++){
				if ($x % 2 == 1) echo "<tr>";
				echo "<td>$x</td>";
				echo "<td>".number_format($aryDay[$x])."</td>";
				if ($x % 2 == 0) echo "</tr>";
			}
			
			if ($x % 2 == 0) echo "<td></td><td></td></tr>";
			?>
		</table>
	</div>
	<!-- tableList -->

	
</div>
