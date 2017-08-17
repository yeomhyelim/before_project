<?if ($S_SITE_LNG == "KR" && !$strDevice && $strDevice != "m"){?>
<script type="text/javascript" src='<?=$g_conf_js_url?>'></script>
<script type="text/javascript">
<!--

	/* 플러그인 설치(확인) */	
	StartSmartUpdate();

	/* Payplus Plug-in 실행 */
	function  jsf__pay( form )
	{
		var RetVal = false;

		if ((navigator.userAgent.indexOf('MSIE') > 0) || (navigator.userAgent.indexOf('Trident/7.0') > 0))
		{
			if ( document.Payplus.object == null )
			{
				openwin = window.open( "/common/kcp/chk_plugin.html", "chk_plugin", "width=420, height=100, top=300, left=300" );
			}
		}
		// 그 외 브라우져에서는 체크로직이 변경됩니다.
		else
		{
			var inst = 0;
			for (var i = 0; i < navigator.plugins.length; i++){
				if (navigator.plugins[i].name == "KCP")
				{
					inst = 1;
				}
			}
			
			if (inst != 1)
			{
				openwin = window.open( "/common/kcp/chk_plugin.html", "chk_plugin", "width=420, height=100, top=300, left=300" );
			}
		}

//		if( document.Payplus.object == null )
//		{
//			openwin = window.open( "/common/kcp/chk_plugin.html", "chk_plugin", "width=420, height=100, top=300, left=300" );
//		}

		/* Payplus Plugin 실행 */
		if ( MakePayMessage( form ) == true )
		{
			//openwin = window.open( "/common/kcp/proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
			RetVal = true ;
		}
		
		else
		{
			/*  res_cd와 res_msg변수에 해당 오류코드와 오류메시지가 설정됩니다.
				ex) 고객이 Payplus Plugin에서 취소 버튼 클릭시 res_cd=3001, res_msg=사용자 취소
				값이 설정됩니다.
			*/
			res_cd  = document.form.res_cd.value ;
			res_msg = document.form.res_msg.value ;

//			alert ( "Payplus Plug-in 실행 결과\n" + "res_cd = " + res_cd + "|" + "res_msg=" + res_msg ) ;
			goInitLoading("");

		}

		return RetVal ;
	}

	// Payplus Plug-in 설치 안내 
	function init_pay_button()
	{
//		if( document.Payplus.object == null )
//			document.getElementById("display_setup_message").style.display = "block" ;
//		else
//			document.getElementById("display_pay_button").style.display = "block" ;


		if ((navigator.userAgent.indexOf('MSIE') > 0) || (navigator.userAgent.indexOf('Trident/7.0') > 0))
		{
			try
			{
				if( document.Payplus.object == null )
				{
					document.getElementById("display_setup_message").style.display = "block" ;
				}else{
					document.getElementById("display_pay_button").style.display = "block" ;
				}
			}
			catch (e)
			{
				document.getElementById("display_setup_message").style.display = "block" ;
			}
		}else{
			try
			{
				if( Payplus == null )
				{
					document.getElementById("display_setup_message").style.display = "block" ;
				}else{
					document.getElementById("display_pay_button").style.display = "block" ;
				}
			}
			catch (e)
			{
				document.getElementById("display_setup_message").style.display = "block" ;
			}
		}
	}

//-->
</script>
<?}?>