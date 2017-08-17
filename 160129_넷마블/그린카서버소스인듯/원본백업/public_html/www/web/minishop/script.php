<script language="javascript" type="text/javascript" src="/skins/javascript/common.js"></script>
<script>

	var	G_PHP_SELF = "./";

	function goDataAnswerMoveEvent()		{ goDataAnswerMove();		}
	function goDataModifyMoveEvent()		{ goDataModifyMove();		}
	function goDataDeleteActEvent()			{ goDataDeleteAct();		}
	function goDataListMoveEvent()			{ goDataListMove();			}
	function goDataModifyCancelMoveEvent()	{ goDataModifyCancelMove(); }
	function goDataModifyActEvent()			{ goDataModifyAct();		}

	function goDataModifyAct() {
		goAct("dataModify", "modify");
	}

	function goDataModifyCancelMove() {
		var data				= new Array(5);
		data['menuType']		= "minishop";
		data['mode']			= "sellerProdReviewView";
		data['sh_no']			= $("input[name=sh_no]").val(); 
		data['ub_no']			= $("input[name=ub_no]").val(); 
		C_getSelfMove(data);
	}

	function goDataAnswerMove() {
	}

	function goDataModifyMove() {
		var data				= new Array(5);
		data['menuType']		= "minishop";
		data['mode']			= "sellerProdReviewModify";
		data['sh_no']			= $("input[name=sh_no]").val(); 
		data['ub_no']			= $("input[name=ub_no]").val(); 
		C_getSelfMove(data);
	}

	function goDataDeleteAct() {
		var x						= confirm("<?=$LNG_TRANS_CHAR['PS00018'] //삭제하시겠습니까??>");
		if(x == true) {
			goAct("dataDelete", "modify");
		}
	}

	function goDataListMove() {
		var data				= new Array(5);

		data['menuType']			= "minishop";
		data['mode']				= "sellerProdReviewList";
		data['sh_no']				= $("input[name=sh_no]").val(); 

		C_getSelfMove(data);
	}

	// ?menuType=minishop&mode=search&sh_no=4&searchField=N&searchKey=asdf
	function goSearch()
	{
		var data				= new Array(5);

		data['menuType']			= "minishop";
		data['mode']				= "search";
		data['sh_no']				= $("input[name=sh_no]").val(); 
		data['searchField']			= "N"; 
		data['searchKey']			= $("input[name=searchKey]").val(); 

		C_getSelfMove(data);
	}

	function goProdView(p_code)
	{
		var data				= new Array(5);

		data['menuType']			= "product";
		data['mode']				= "view";
		data['sh_no']				= $("input[name=sh_no]").val(); 
		data['prodCode']			= p_code; 

		C_getSelfMove(data);
	}

	function goSearchSort(sort)
	{
		var data				= new Array(5);

		data['menuType']			= "minishop";
		data['mode']				= "search";
		data['sh_no']				= $("input[name=sh_no]").val();
		data['sort']				= sort; 
		data['page']				= "1"; 
		data['searchField']			= "N"; 
		data['searchKey']			= $("input[name=searchKey]").val(); 

		C_getSelfMove(data);
	}

	function goDataViewMoveEvent(ub_no) {
		var data				= new Array(5);

		data['menuType']			= "minishop";
		data['mode']				= "sellerProdReviewView";
		data['sh_no']				= $("input[name=sh_no]").val(); 
		data['ub_no']				= ub_no; 

		C_getSelfMove(data);
	}

//	function goProdView(p_code)
//	{
//		var data				= new Array(5);
//
//		data['menuType']			= "product";
//		data['mode']				= "view";
//		data['sh_no']				= "4"; 
//		data['prodCode']			= p_code; 
//
//		C_getSelfMove(data);
//	}
//
//	function goSearchSort(sort)
//	{
//		var data				= new Array(5);
//
//		data['menuType']			= "minishop";
//		data['mode']				= "main";
//		data['sh_no']				= "4"; 
//		data['sort']				= sort; 
//		data['page']				= "1"; 
//
//		C_getSelfMove(data);
//	}
//
//	function goProdView(p_code)
//	{
//		var data				= new Array(5);
//
//		data['menuType']			= "product";
//		data['mode']				= "view";
//		data['sh_no']				= "4"; 
//		data['prodCode']			= p_code; 
//
//		C_getSelfMove(data);
//	}
</script>