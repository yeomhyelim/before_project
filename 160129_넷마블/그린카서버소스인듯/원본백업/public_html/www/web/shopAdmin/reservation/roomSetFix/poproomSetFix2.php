<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$intNo				= $_GET['no'];
	$strName			= $_GET['name'];
	$param				= "";
	$param['CG_NO']		= $intNo;
?>

<script type="text/javascript">
<!--
	function goAct2(){

		C_getAction("roomSetFixWrite2","<?=$PHP_SELF?>");
	}
//-->
</script>
<style type="text/css">
	#contentArea{position:relative;min-width:300px;padding:10px}
</style>

<div class="layerPopWrap">
    <div class="popTop">
        <h2><font color="blue"><?echo $strName;?></font>시설등록</h2>
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
                    <input id="cc_sort" name="cc_sort" type="text">
                </td>
            </tr>
           <tr>
                <th><span>시설구분</span></th>
                <td>
                    <input id="cc_name_kr" name="cc_name_kr" type="text">
                </td>
            </tr>
			<tr>
                <th><span>코드</span></th>
                <td>
                    <input id="cc_code" name="cc_code" type="text">
                </td>
            </tr>
			<tr>
                <th><span>사용여부</span></th>
                <td>
                    <input id="cc_use" name="cc_use" type="text" value="Y">
                </td>
            </tr>
			<tr style="display:none">
                <th><span>상위시설남버</span></th>
                <td>
                    <input id="cg_no" name="cg_no" type="text" value="<?echo $intNo;?>">
                </td>
            </tr>
        </table>
</form>
    </div>
    <div class="btnCenter">
        <a href="javascript:goAct2();" class="btn_blue_big"><strong>등록</strong></a>
        <a href="#" onclick="window.parent.TINY.box.hide(); return false;" class="btn_big"><strong>닫기</strong></a>
    </div>
</div>

