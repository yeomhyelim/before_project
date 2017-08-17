<script type="text/javascript">
	$(document).ready(function(){

		var intVal ;

		var addlist="";
		var addlist2="";

		intVal = parseInt($('[name=hiddenDay]').val());

		$('input[name^=StartDt]').simpleDatepicker();
		$('input[name^=searchRegEndDt]').simpleDatepicker();
		$('input[name^=searchRegStart_Dt]').simpleDatepicker();
		$('input[name^=searchRegEnd_Dt]').simpleDatepicker();

		$('[name^=checkRoomNo]').click(function(){
				if(!!$(this).attr("checked")){
					addlist = addlist + $(this).val() + ",";
					addlist2 = addlist2 + $(this).parent().parent().find('[name^=selectPeo]').val() + ",";

					$('[name=roomList]').val(addlist);

				}
			});
		$('[name^=selectPeo]').change(function(){
			addlist2 = addlist2 + $(this).val() + ",";
			$('[name=peoList]').val(addlist2);
		});

		$(".selectDay").change(function(){

			if($(".selectDay").val()=="1") // 1박2일인 경우
			{
				var $i=0;
					$('[name^=calendar]').each(function(){
							$i=$i+1;
							if($i-1==intVal){
								$(this).css("background","#F5DEB3");
							}
							if($i-2==intVal){
								$(this).css("background","#FFFFFF");
							}
							if($i-3==intVal){
								$(this).css("background","#FFFFFF");
							}
					});

			$('[name=EndDt1]').each(function() {

				var strVal = $(this).val();

				$('[name=EndDt]').empty();
				$('[name=EndDt]').append(strVal);

				$('[name=resvDay]').empty();
				$('[name=resvDay]').append("(1박2일)");

			});
			}
			if($(".selectDay").val()=="2") // 2박3일인 경우
			{
					var $i=0;
					$('[name^=calendar]').each(function(){
							$i=$i+1;
							if($i-1==intVal){
								$(this).css("background","#FFFFFF");
							}
							if($i-2==intVal){
								$(this).css("background","#F5DEB3");
							}
							if($i-3==intVal){
								$(this).css("background","#FFFFFF");
							}
					});

			$('[name=EndDt2]').each(function() {

				var strVal = $(this).val();

				$('[name=EndDt]').empty();
				$('[name=EndDt]').append(strVal);

				$('[name=resvDay]').empty();
				$('[name=resvDay]').append("(2박3일)");



				});
			}

			if($(".selectDay").val()=="3") // 2박3일인 경우
			{
				var $i=0;
					$('[name^=calendar]').each(function(){
							$i=$i+1;
							if($i-1==intVal){
								$(this).css("background","#FFFFFF");
							}
							if($i-2==intVal){
								$(this).css("background","#FFFFFF");
							}
							if($i-3==intVal){
								$(this).css("background","#F5DEB3");
							}
					});

			$('[name=EndDt3]').each(function() {

				var strVal = $(this).val();

				$('[name=EndDt]').empty();
				$('[name=EndDt]').append(strVal);

				$('[name=resvDay]').empty();
				$('[name=resvDay]').append("(3박4일)");
			});
			}
		});


});
	function goAct(year,month,day,no){
		var x = confirm("선택하신 정보로 예약을 진행하시겠습니까?");
		if (x==true)
		{
//			var data = new Object;
//			data['menuType']	= "reservation";
//			data['mode']		= "step2";
//			data['y']			= "2";
//
//			C_getSelfAction(data);
			var addlist="";
			var addlist2="";
			var stay = $('[name=selectDay]').val();
			var p = $('[name=selectPeople]').val();

			$('[name^=checkAdd]').each(function(){
				if(!!$(this).attr("checked")){
					addlist = addlist + $(this).parent().find('[name^=addNolist]').val() + ",";
					addlist2 = addlist2 + $(this).parent().parent().find('[name^=Nolist]').val() + ",";
				}
			});
			var VRL = "./?menuType=reservation&mode=step2&y="+year+"&m="+month+"&d="+day+"&r_no="+no+"&stay="+stay+"&alist="+addlist+"&p="+p+"&blist="+addlist2;
			window.location.href = VRL;
		}
	}

	function goAct2(op){

		if(op!="1"){alert("예약확인부터 진행하여 주십시오.");return;}
		var roomlist = $('[name=roomList]').val();

		if(roomlist==""){alert("방을 선택하여 주십시오");return;}

		var x = confirm("입력하신 정보로 예약을 진행하시겠습니까?");
		if (x==true)
		{
			var addlist="";
			var addlist2="";
			var addlist3="";
			var addlist4="";
			var stay = $('[name=selectDay]').val();
			var d = $('[name=StartDt]').val();

			$('[name^=checkAdd]').each(function(){
				if(!!$(this).attr("checked")){
					addlist = addlist + $(this).parent().find('[name^=addNolist]').val() + ",";
					addlist2 = addlist2 + $(this).parent().parent().find('[name^=Nolist]').val() + ",";
				}
			});

			$('[name^=checkRoomNo]').each(function(){
				if(!!$(this).attr("checked")){
					addlist3 = addlist3 + $(this).val() + ",";
					addlist4 = addlist4 + $(this).parent().parent().find('[name^=selectPeo]').val() + ",";
				}
			});
			var VRL = "./?menuType=reservation&mode=adm_revConfirm&d="+d+"&stay="+stay+"&alist="+addlist+"&blist="+addlist2+"&clist="+addlist3+"&dlist="+addlist4;
			window.location.href = VRL;
		}
	}

	function goConfirm(){
		var tmp;
		var option;

		tmp = $('[name=StartDt]').val();
//		alert("ok");
		if(tmp==""){alert("예약날짜를 입력하여 주십시오");return;}

		option = 1;

		var URL = "./?menuType=reservation&mode=adm_revList&dt="+tmp+"&o="+option;
		window.location.href = URL;


	}
</script>