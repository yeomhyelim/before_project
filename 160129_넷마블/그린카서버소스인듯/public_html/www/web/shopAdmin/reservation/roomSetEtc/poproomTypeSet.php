<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	function goAct(){

		C_getAction("roomTypeSetWrite","<?=$PHP_SELF?>");
	}
//-->
</script>
<style type="text/css">
	#contentArea{position:relative;min-width:300px;padding:10px}
</style>

<div class="layerPopWrap">
    <div class="popTop">
        <h2>객실유형등록</h2>
		<A href="javascript:parent.TINY.box.hide();"><IMG class=closeBtn src="/shopAdmin/himg/common/btn_pop_close_white.png"></A>
        <div class="clr"></div>
    </div>
    <div class="tableFormWrap">
<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">
         <table class="tableForm">
            <tr>
                <th><span>순서</span></th>
                <td>
                    <input id="am_ranking2" name="am_ranking2" type="text">
                </td>
            </tr>
           <tr>
                <th><span>객실유형</span></th>
                <td>
                    <input id="am_name2" name="am_name2" type="text">
                </td>
            </tr>
        </table>
</form>
    </div>
    <div class="btnCenter">
        <a href="javascript:goAct();" class="btn_blue_big"><strong>등록</strong></a>
        <a href="#" onclick="window.parent.TINY.box.hide(); return false;" class="btn_big"><strong>닫기</strong></a>
    </div>
</div>

