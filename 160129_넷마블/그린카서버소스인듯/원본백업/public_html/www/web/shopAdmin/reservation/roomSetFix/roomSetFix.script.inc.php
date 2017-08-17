<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		//C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});

	function goAct() //객설시설등록
	{
		C_getAction("basicSetSave","<?=$PHP_SELF?>");
	}
	function goAct2() //하위시설등록
	{
		C_getAction("basicSetSave","<?=$PHP_SELF?>");
	}

	function goTableShow($i)
	{
		var $j=0;
		$('[name^=roomFix]').each(function(){

			$j=$j +1;
			if($j==$i){$(this).show();}
			if($j!=$i){$(this).hide()}

		});
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

	function goFixDelete(no){
		var x = confirm("선택한 데이터를 삭제하시겠습니까?/하위 시설들 데이터들도 함께 지워집니다!다시 한번 생각해주세요!");
		if (x==true)
		{
			var data = new Object;
			data['menuType']	= "reservation";
			data['mode']		= "act";
			data['act']			= "FixDelete";
			data['no']			= no;
			C_getSelfAction(data);
		}
	}

	function goFixDelete2(no){
		var x = confirm("선택한 하위시설 데이터를 삭제하시겠습니까?");
		if (x==true)
		{
			var data = new Object;
			data['menuType']	= "reservation";
			data['mode']		= "act";
			data['act']			= "FixDelete2";
			data['no']			= no;
			C_getSelfAction(data);
		}
	}

	function openLayer4(qstr, width, no, name){
        return TINY.box.show({
            iframe:'./?menuType=reservation&mode='+qstr+'&no='+no+'&name='+name,
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

	function openLayer5(qstr, width, no, no2){
        return TINY.box.show({
            iframe:'./?menuType=reservation&mode='+qstr+'&no='+no+'&no2='+no2,
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

//-->
</script>
