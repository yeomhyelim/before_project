
<ul class="cate1">
<? for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):	// 카테고리1?>
<? if($S_ARY_CATE1[$i]['LOW_CNT']<=1){echo "</li>"; continue;} ?>
  <li><?=$S_ARY_CATE1[$i]['NAME']?>
  <ul class="cate2">
<? for($j = 0;$j < sizeof($S_ARY_CATE2[$i]); $j++): // 카테고리2?>
<? if($S_ARY_CATE1[$i]['CODE'] != substr($S_ARY_CATE2[$i][$j]['CODE'], 0, 3)){ continue; } ?>
    <li><?=$S_ARY_CATE2[$i][$j]['NAME']?>
<? if($S_ARY_CATE2[$i][$j]['LOW_CNT']<=1){echo "</li>"; continue;} ?>
    <ul class="cate3">
<? for($k = 0;$k < sizeof($S_ARY_CATE3[$i][$j]); $k++): // 카테고리3?>
<? if($S_ARY_CATE2[$i][$j]['CODE'] != substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 0, 6)){ continue; } ?>
      <li><?=$S_ARY_CATE3[$i][$j][$k]['NAME']?></li>
<? endfor; // 카테고리3?>
    </ul>
	</li>
<? endfor; // 카테고리2?>
  </ul>
  </li>
<? endfor; // 카테고리1?>
</ul>