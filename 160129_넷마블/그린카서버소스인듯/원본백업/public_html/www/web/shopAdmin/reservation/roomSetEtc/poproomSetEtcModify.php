<? include "roomSetEtc.helper.inc.php"?>
<? include "./include/header.inc.php"?>
<?php
	$intNo				= $_GET['no'];
	$param				= "";
	$param['AM_NO']		= $intNo;
	$row				= $reservationMgr->getRoomSetEtcView($db,$param);
?>
<script type="text/javascript">
<!--
	function goAct2(){

		C_getAction("roomSetEtcModify","<?=$PHP_SELF?>");
	}
//-->
</script>
<style type="text/css">
	#contentArea{position:relative;min-width:300px;padding:10px}
</style>

<div class="layerPopWrap">
    <div class="popTop">
        <h2>부대시설등록</h2>
		<A href="javascript:parent.TINY.box.hide();"><IMG class=closeBtn src="/shopAdmin/himg/common/btn_pop_close_white.png"></A>
        <div class="clr"></div>
    </div>
    <div class="tableFormWrap">
<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">
<input type="hidden" name="no" value="<?=$intNo?>">
         <table class="tableForm">
            <tr>
                <th><span>순서</span></th>
                <td>
                    <input id="am_ranking" name="am_ranking" type="text" value="<?echo $row['AM_ORDER'];?>">
                </td>
            </tr>
           <tr>
                <th><span>시설명</span></th>
                <td>
                    <input id="am_name" name="am_name" type="text" value="<?echo $row['AM_DEV'];?>">
                </td>
            </tr>
			<tr>
                <th><span>이용요금</span></th>
                <td>
                    <input id="am_price" name="am_price" type="text" value="<?echo $row['AM_PRICE'];?>">
                </td>
            </tr>
			<tr>
                <th><span>단위</span></th>
                <td>
                    <input id="am_unit" name="am_unit" type="text" value="<?echo $row['AM_UNIT'];?>">
                </td>
            </tr>
			<tr>
                <th>비고</th>
                <td>
                    <input id="am_memo" name="am_memo" type="text" value="<?echo $row['AM_MEMO'];?>">
                </td>
            </tr>
        </table>
</form>
    </div>
    <div class="btnCenter">
        <a href="javascript:goAct2();" class="btn_blue_big"><strong>수정</strong></a>
        <a href="#" onclick="window.parent.TINY.box.hide(); return false;" class="btn_big"><strong>닫기</strong></a>
    </div>
</div>

