<script type="text/javascript">

	$(document).ready(function(){

	});

	function goTest()  {
		var strJsonParam		= "menuType=<?=$strMenuType?>&mode=json&jsonMode=test";
		$.ajax ( {	 type:"POST", url:"./index.php", data :strJsonParam, dataType:"json",  success:function(data) {	
			alert(data[0].MSG);
		}		} );
	}

</script>

<a href="javascript:goTest()">XML</a>