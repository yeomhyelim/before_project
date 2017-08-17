<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$intNo				= $_GET['no'];
	$param				= "";
	$param['CG_NO']		= $intNo;
	$row				= $reservationMgr->getRoomSetFixView($db,$param);
?>

<script type="text/javascript">
<!--
	function goAct2(){

		C_getAction("roomSetFixModify","<?=$PHP_SELF?>");
	}
//-->
</script>
<style type="text/css">
	#contentArea{position:relative;min-width:300px;padding:10px}
</style>

<div class="layerPopWrap">
    <div class="popTop">
        <h2>객실시설등록</h2>
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
                    <input id="cg_sort" name="cg_sort" type="text" value="<?echo $row['CG_SORT'];?>">
                </td>
            </tr>
           <tr>
                <th><span>시설구분</span></th>
                <td>
                    <input id="cg_name" name="cg_name" type="text" value="<?echo $row['CG_NAME'];?>">
                </td>
            </tr>
			<tr style="display:none">
                <th><span>코드</span></th>
                <td>
                    <input id="cg_cord" name="cg_cord" type="text" value="" style="display:none">
                </td>
            </tr>
			<tr>
                <th><span>사용여부</span></th>
                <td>
                    <input id="cg_use" name="cg_use" type="text" value="<?echo $row['CG_USE'];?>">
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

