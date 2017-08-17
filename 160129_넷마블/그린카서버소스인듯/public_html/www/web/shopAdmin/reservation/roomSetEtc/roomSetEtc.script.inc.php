<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		//C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

	});

	function goAct()
	{
		C_getAction("writeRoomSetEtc","<?=$PHP_SELF?>");
	}

	function openLayer(qstr, width, height){
        return TINY.box.show({
            iframe:'./?menuType=reservation&mode='+qstr,
            //boxid:'frameless',
            width:(typeof(width)=="undefined")?450:width,
            height:(typeof(height)=="undefined")?300:height,
            fixed:false,
            //maskid:'bluemask',
            maskopacity:40,
            closejs:function(){
               //
            }
        });
    }

	function openLayer2(qstr, width, no){
        return TINY.box.show({
            iframe:'./?menuType=reservation&mode='+qstr+'&no='+no,
            //boxid:'frameless',
            width:(typeof(width)=="undefined")?450:width,
            height:(typeof(height)=="undefined")?300:height,
            fixed:false,
            //maskid:'bluemask',
            maskopacity:40,
            closejs:function(){
               //
            }
        });
    }

	function openLayer3(qstr, width, height, no){
        return TINY.box.show({
            iframe:'./?menuType=reservation&mode='+qstr+'&no='+no,
            //boxid:'frameless',
            width:(typeof(width)=="undefined")?450:width,
            height:(typeof(height)=="undefined")?300:height,
            fixed:false,
            //maskid:'bluemask',
            maskopacity:40,
            closejs:function(){
               //
            }
        });
    }

	function goAddSetDelete(no){
		var x = confirm("선택한 데이터를 삭제하시겠습니까?");
		if (x==true)
		{
			var data = new Object;
			data['menuType']	= "reservation";
			data['mode']		= "act";
			data['act']			= "addsetDelete";
			data['no']			= no;
			C_getSelfAction(data);
		}
	}
//-->
</script>
