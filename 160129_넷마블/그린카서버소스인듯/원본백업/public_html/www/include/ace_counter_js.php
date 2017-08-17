<?php if ( isset ( $ACE_COUNTER_ID ) && ! empty ( $ACE_COUNTER_ID ) ) : ?>

<?
$aceCounterScriptArr = array
(
	'member_joinEnd'	=> 'var _jn=\'joinw\';var _jid=\'' . $_SESSION['SESS_MEMBER_JOIN_ID'] . '\'' ,		// 회원가입
	'mypage_popDropout'	=> 'var _jn=\'withdraw\';' ,					// 회원탈퇴
	'login'				=> '' ,
	'order_cart'		=> '<!-- AceCounter eCommerce (Cart_Inout) v7.5 Start -->
							<!-- Function and Variables Definition Block Start -->
							<script language=\'javascript\'>
							var _JV="AMZ2013010701";//script Version
							var _UD=\'undefined\';var _UN=\'unknown\';
							var _ace_countvar = 0;
							function _IDV(a){return (typeof a!=_UD)?1:0}
							var _CRL=\'http://\'+\'gtc2.acecounter.com:8080/\';
							var _GCD=\'' . $ACE_COUNTER_ID . '\';
							if( document.URL.substring(0,8) == \'https://\' ){ _CRL = \'https://gtc2.acecounter.com/logecgather/\' ;};
							if(!_IDV(_A_i)) var _A_i = new Image() ;if(!_IDV(_A_i0)) var _A_i0 = new Image() ;if(!_IDV(_A_i1)) var _A_i1 = new Image() ;if(!_IDV(_A_i2)) var _A_i2 = new Image() ;if(!_IDV(_A_i3)) var _A_i3 = new Image() ;if(!_IDV(_A_i4)) var _A_i4 = new Image() ;
							function _RP(s,m){if(typeof s==\'string\'){if(m==1){return s.replace(/[#&^@,]/g,\'\');}else{return s.replace(/[#&^@]/g,\'\');} }else{return s;} };
							function _RPS(a,b,c){var d=a.indexOf(b),e=b.length>0?c.length:1; while(a&&d>=0){a=a.substring(0,d)+c+a.substring(d+b.length);d=a.indexOf(b,d+e);}return a};
							function AEC_F_D(pd,md,cnum){ var i = 0 , amt = 0 , num = 0 ; var cat = \'\' ,nm = \'\' ; num = cnum ; md=md.toLowerCase(); if( md == \'b\' || md == \'i\' || md == \'o\' ){ for( i = 0 ; i < _A_pl.length ; i ++ ){ if( _A_pl[i] == pd ){ nm = _RP(_A_pn[i]); amt = ( parseInt(_RP(_A_amt[i],1)) / parseInt(_RP(_A_nl[i],1)) ) * num ; cat = _RP(_A_ct[i]); _A_cart = _CRL+\'?cuid=\'+_GCD; _A_cart += \'&md=\'+md+\'&ll=\'+_RPS(escape(cat+\'@\'+nm+\'@\'+amt+\'@\'+num+\'^&\'),\'+\',\'%2B\'); break;};};if(_A_cart.length > 0 ) _A_i.src = _A_cart;setTimeout("",2000);};};
							function AEC_D_A(){ var i = 0,_AEC_str= \'\'; var ind = 0; for( i = 0 ; i < _A_pl.length ; i ++ ){ _AEC_str += _RP(_A_ct[i])+\'@\'+_RP(_A_pn[i])+\'@\'+_RP(_A_amt[i],1)+\'@\'+_RP(_A_nl[i],1)+\'^\'; if(  escape(_AEC_str).length > 800 ){ if(ind > 4) ind = 0; _AEC_str = _RPS(escape(_AEC_str),\'+\',\'%2B\')+\'&cmd=on\' ; AEC_S_F(_AEC_str , \'o\', ind) ; _AEC_str = \'\' ; ind++; }; }; if( _AEC_str.length > 0 ){ if(ind+1 > 4) ind = 0; AEC_S_F(_RPS(escape(_AEC_str),\'+\',\'%2B\'), \'o\', ind+1) ; }; };
							function AEC_B_A(){var i=0,_AEC_str=\'\',_A_cart=\'\';var ind = 0;_A_cart = _CRL+\'?cuid=\'+_GCD+\'&md=b\';for( i = 0 ; i < _A_pl.length ; i ++ ){ _AEC_str += ACE_REPL(_A_ct[i])+\'@\'+ACE_REPL(_A_pn[i])+\'@\'+ACE_REPL(_A_amt[i],1)+\'@\'+ACE_REPL(_A_nl[i],1)+\'^\';if(escape(_AEC_str).length > 800 ){if(ind > 4) ind = 0;_AEC_str = _RPS(escape(_AEC_str),\'+\',\'%2B\')+\'&cmd=on\';AEC_S_F(_AEC_str,\'b\',ind); _AEC_str = \'\' ;ind++;};}; if( _AEC_str.length > 0 ){if(ind+1 > 4) ind = 0; AEC_S_F(_RPS(escape(_AEC_str),\'+\',\'%2B\'),\'b\',ind+1);};};
							function AEC_U_V(pd,bnum){ var d_cnt = 0 ; var A_amt = 0 ; var A_md = \'n\' ;var _AEC_str = \'\' ; for( j = 0 ; j < _A_pl.length; j ++ ){ if( _A_pl[j] == pd ){ d_cnt = 0; if( _A_nl[j] != bnum ){ d_cnt = bnum - parseInt(_RP(_A_nl[j],1)) ; A_amt = Math.round( parseInt(_RP(_A_amt[j],1)) / parseInt(_RP(_A_nl[j],1))); if( d_cnt > 0 ){ A_md = \'i\' ; }else{ A_md = \'o\' ;};_A_amt[j] = A_amt*Math.abs(d_cnt) ; _A_nl[j] = Math.abs(d_cnt);_AEC_str += _RP(_A_ct[j])+\'@\'+_RP(_A_pn[j])+\'@\'+_RP(_A_amt[j],1)+\'@\'+_RP(_A_nl[j],1)+\'^\';};};};if( _AEC_str.length > 0 ){ AEC_S_F(_RPS(escape(_AEC_str),\'+\',\'%2B\') ,A_md, 0);};};
							function AEC_S_F(str,md,idx){ var i = 0,_A_cart = \'\'; var k = eval(\'_A_i\'+idx); if(md == \'I\' ) md = \'i\' ; if(md == \'O\' ) md = \'o\' ; if(md == \'B\' ) md = \'b\' ; if( md == \'b\' || md == \'i\' || md == \'o\'){ _A_cart = _CRL+\'?cuid=\'+_GCD ; _A_cart += \'&md=\'+md+\'&ll=\'+(str)+\'&\'; k.src = _A_cart;window.setTimeout(\'\',2000);};};
							if(!_IDV(_A_pl)) var _A_pl = Array(1) ;
							if(!_IDV(_A_nl)) var _A_nl = Array(1) ;
							if(!_IDV(_A_ct)) var _A_ct = Array(1) ;
							if(!_IDV(_A_pn)) var _A_pn = Array(1) ;
							if(!_IDV(_A_amt)) var _A_amt = Array(1) ;
							</script>
							<!-- Function and Variables Definition Block End-->
							<!-- AceCounter eCommerce (Product_Detail) v7.5 Start -->
							<!-- Data Allocation (Product_Detail) -->' ,							// 장바구니

	'product_view'		=> '<!-- *) 제품상세페이지 분석코드 -->
							<!-- AceCounter eCommerce (Product_Detail) v7.5 Start -->
							<!-- Function and Variables Definition Block Start -->
							<script language=\'javascript\'>
							var _JV="AMZ2013010701";//script Version
							var _UD=\'undefined\';var _UN=\'unknown\';
							function _IDV(a){return (typeof a!=_UD)?1:0}
							var _CRL=\'http://\'+\'gtc2.acecounter.com:8080/\';
							var _GCD=\'' . $ACE_COUNTER_ID . '\';
							if( document.URL.substring(0,8) == \'https://\' ){ _CRL = \'https://gtc2.acecounter.com/logecgather/\' ;};
							if(!_IDV(_A_i)) var _A_i = new Image() ;if(!_IDV(_A_i0)) var _A_i0 = new Image() ;if(!_IDV(_A_i1)) var _A_i1 = new Image() ;if(!_IDV(_A_i2)) var _A_i2 = new Image() ;if(!_IDV(_A_i3)) var _A_i3 = new Image() ;if(!_IDV(_A_i4)) var _A_i4 = new Image() ;
							function _RP(s,m){if(typeof s==\'string\'){if(m==1){return s.replace(/[#&^@,]/g,\'\');}else{return s.replace(/[#&^@]/g,\'\');} }else{return s;} };
							function _RPS(a,b,c){var d=a.indexOf(b),e=b.length>0?c.length:1; while(a&&d>=0){a=a.substring(0,d)+c+a.substring(d+b.length);d=a.indexOf(b,d+e);}return a};
							function AEC_F_D(pd,md,cnum){ var i = 0 , amt = 0 , num = 0 ; var cat = \'\' ,nm = \'\' ; num = cnum ;md=md.toLowerCase(); if( md == \'b\' || md == \'i\' || md == \'o\' ){ for( i = 0 ; i < _A_pl.length ; i ++ ){ if( _A_pl[i] == pd ){ nm = _RP(_A_pn[i]); amt = ( parseInt(_RP(_A_amt[i],1)) / parseInt(_RP(_A_nl[i],1)) ) * num ; cat =  _RP(_A_ct[i]); var _A_cart = _CRL+\'?cuid=\'+_GCD; _A_cart += \'&md=\'+md+\'&ll=\'+_RPS(escape(cat+\'@\'+nm+\'@\'+amt+\'@\'+num+\'^&\'),\'+\',\'%2B\'); break;};};if(_A_cart.length > 0 ) _A_i.src = _A_cart;setTimeout("",2000);};};
							if(!_IDV(_A_pl)) var _A_pl = Array(1) ;
							if(!_IDV(_A_nl)) var _A_nl = Array(1) ;
							if(!_IDV(_A_ct)) var _A_ct = Array(1) ;
							if(!_IDV(_A_pn)) var _A_pn = Array(1) ;
							if(!_IDV(_A_amt)) var _A_amt = Array(1) ;
							if(!_IDV(_pd)) var _pd = \'\' ;
							if(!_IDV(_ct)) var _ct = \'\' ;
							if(!_IDV(_amt)) var _amt = \'\' ;
							</script>
							<!-- Function and Variables Definition Block End-->

							<!-- AceCounter eCommerce (Product_Detail) v7.5 Start -->
							<!-- Data Allocation (Product_Detail) -->
							<script language=\'javascript\'>

							_pd =_RP("' . $prodRow['P_NAME'] . '");
							_ct =_RP($(\'div[class*="productLocationWrap"]:last li:last\').text());
							_amt = _RP("' . $prodRow['P_SALE_PRICE'] . '",1); // _RP(1)-> 가격

							_A_amt=Array("' . $prodRow['P_SALE_PRICE'] . '");
							_A_nl=Array(1);
							_A_pl=Array("' . $prodRow['P_NO'] . '");
							_A_pn=Array("' . $prodRow['P_NAME'] . '");
							_A_ct=Array($(\'div[class*="productLocationWrap"]:last li:last\').text());
							</script>' ,
	'product_search'	=> 'var _skey=\' ' . $search . '\';' ,			// 상품검색
	'order_orderEnd'	=> '<!-- *) 제품결제처리 (결제처리완료 ex:card.php) -->
							<!-- AceCounter eCommerce (Cart_Inout) v7.5 Start -->
							<!-- Function and Variables Definition Block Start -->
							<script language=\'javascript\'>
							var _JV="AMZ2013010701";//script Version
							var _UD=\'undefined\';var _UN=\'unknown\';
							var _ace_countvar = 0;
							var _DC = document.cookie ;
							function _IDV(a){return (typeof a!=_UD)?1:0}
							var _CRL=\'http://\'+\'gtc2.acecounter.com:8080/\';
							var _GCD=\'' . $ACE_COUNTER_ID . '\';
							if( document.URL.substring(0,8) == \'https://\' ){ _CRL = \'https://gtc2.acecounter.com/logecgather/\' ;};
							if(!_IDV(_A_i)) var _A_i = new Image() ;if(!_IDV(_A_i0)) var _A_i0 = new Image() ;if(!_IDV(_A_i1)) var _A_i1 = new Image() ;if(!_IDV(_A_i2)) var _A_i2 = new Image() ;if(!_IDV(_A_i3)) var _A_i3 = new Image() ;if(!_IDV(_A_i4)) var _A_i4 = new Image() ;
							function _RP(s,m){if(typeof s==\'string\'){if(m==1){return s.replace(/[#&^@,]/g,\'\');}else{return s.replace(/[#&^@]/g,\'\');} }else{return s;} };
							if(!_IDV(_ll)) var _ll=\'\'; if(!_IDV(_AEC_order_code)) var _AEC_order_code=\'\';
							function _AGC(nm) { var cn = nm + "="; var nl = cn.length; var cl = _DC.length; var i = 0; while ( i < cl ) { var j = i + nl; if ( _DC.substring( i, j ) == cn ){ var val = _DC.indexOf(";", j ); if ( val == -1 ) val = _DC.length; return unescape(_DC.substring(j, val)); }; i = _DC.indexOf(" ", i ) + 1; if ( i == 0 ) break; } return \'\'; }
							function _ASC( nm, val, exp ){var expd = new Date(); if ( exp ){ expd.setTime( expd.getTime() + ( exp * 1000 )); document.cookie = nm+"="+ escape(val) + "; expires="+ expd.toGMTString() +"; path="; }else{ document.cookie = nm + "=" + escape(val);};}
							function AEC_B_L(){	var _AEC_order_code_cookie=\'\';if(document.cookie.indexOf(\'AECORDERCODE\')>=0){ _AEC_order_code_cookie = _AGC(\'AECORDERCODE\');};	if(_AEC_order_code!=\'\' && _AEC_order_code==_AEC_order_code_cookie){return \'\';	}else{	_ASC("AECORDERCODE",_AEC_order_code,86400 * 30 * 12);	var i=0;_ll=\'\'; for( i = 0 ; i < _A_pl.length ; i ++ ){	_ll += _RP(_A_ct[i])+\'@\'+_RP(_A_pn[i])+\'@\'+_RP(_A_amt[i],1)+\'@\'+_RP(_A_nl[i],1)+\'^\';}; };};
							function AEC_S_F(str,md,idx){ var i = 0,_A_cart = \'\'; var k = eval(\'_A_i\'+idx); md=md.toLowerCase(); if( md == \'b\' || md == \'i\' || md == \'o\'){ _A_cart = _CRL+\'?cuid=\'+_GCD ; _A_cart += \'&md=\'+md+\'&ll=\'+(str)+\'&\'; k.src = _A_cart;window.setTimeout(\'\',2000);};};
							if(!_IDV(_A_pl)) var _A_pl = Array(1) ;
							if(!_IDV(_A_nl)) var _A_nl = Array(1) ;
							if(!_IDV(_A_ct)) var _A_ct = Array(1) ;
							if(!_IDV(_A_pn)) var _A_pn = Array(1) ;
							if(!_IDV(_A_amt)) var _A_amt = Array(1) ;
							</script>' ,
) ;

if ( ! empty ( $aceCounterScriptArr[$strMenuType . '_' . $strMode] ) )
{
	if ( $strMenuType . '_' . $strMode == 'mypage_popDropout' && $_GET['callBack'] != 'goMemberDropoutCallBackEvent' )
		$aceCounterScriptArr[$strMenuType . '_' . $strMode] = '' ;


	else if ( $strMenuType . '_' . $strMode == 'order_cart' )
	{
		if ( is_array ( $arrCartRow ) )
		{
			$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '<script>';
			foreach ( $arrCartRow  as $key => $row )
			{

				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_amt[_ace_countvar]=\'' . trim ( $row['CART_PRICE'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_nl[_ace_countvar]=\'' . trim ( $row['P_QTY'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_pl[_ace_countvar]=\'' . trim ( $row['P_CODE'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_pn[_ace_countvar]=\'' . urlencode ( $row['P_NAME'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_ct[_ace_countvar]=\'\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_ace_countvar++;' ;
			}
			$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '</script>';
		}
	}
	else if ( $strMenuType . '_' . $strMode == 'order_orderEnd' )
	{
		$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '<script>';
			foreach ( $arrCartRow  as $key => $row )
			{

				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_amt[_ace_countvar]=\'' . trim ( $row['CART_PRICE'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_nl[_ace_countvar]=\'' . trim ( $row['P_QTY'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_pl[_ace_countvar]=\'' . trim ( $row['P_CODE'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_pn[_ace_countvar]=\'' . urlencode ( $row['P_NAME'] ) . '\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_A_ct[_ace_countvar]=\'\';' ;
				$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '_ace_countvar++;' ;
			}
			$aceCounterScriptArr[$strMenuType . '_' . $strMode] .= '</script>';

		$aceCounterScriptArr[$strMenuType . '_' . $strMode] .=
			'<!-- AceCounter eCommerce (Buy_Finish) v7.5 Start -->
			<script language=\'javascript\'>
			var _A_amt_tmp = new Array();var _A_nl_tmp = new Array();var _A_pl_tmp = new Array();var _A_pn_tmp = new Array();var _A_ct_tmp = new Array();(function(){for(var k=0; k < _A_pn.length; k++){if(typeof(_A_amt_tmp[_A_pn[k]])==\'undefined\') _A_amt_tmp[_A_pn[k]]=0;if(typeof(_A_nl_tmp[_A_pn[k]])==\'undefined\') _A_nl_tmp[_A_pn[k]]=0;if(typeof(_A_pl_tmp[_A_pn[k]])==\'undefined\') _A_nl_tmp[_A_pn[k]]=0;if(typeof(_A_pn_tmp[_A_pn[k]])==\'undefined\') _A_nl_tmp[_A_pn[k]]=0;if(typeof(_A_ct_tmp[_A_pn[k]])==\'undefined\') _A_nl_tmp[_A_pn[k]]=0;_A_amt_tmp[_A_pn[k]]+=(_A_amt[k]*1.0);_A_nl_tmp[_A_pn[k]]+=(_A_nl[k]*1.0);_A_pl_tmp[_A_pn[k]]=_A_pl[k];_A_pn_tmp[_A_pn[k]]=_A_pn[k];_A_ct_tmp[_A_pn[k]]=_A_ct[k];};var i=0;var a=new Array(),b=new Array(),c=new Array(),d=new Array(),e=new Array();for(var key in _A_pn_tmp){if((typeof Prototype)!=\'undefined\'){ if (key==\'each\'){break;};};a[i]=_A_amt_tmp[key];b[i]=_A_nl_tmp[key];c[i]=_A_pl_tmp[key];d[i]=_A_pn_tmp[key];e[i]=_A_ct_tmp[key];i++;}; _A_amt_tmp=a;_A_nl_tmp=b;_A_pl_tmp=c;_A_pn_tmp=d;_A_ct_tmp=e;})();var _A_amt=_A_amt_tmp;var _A_nl=_A_nl_tmp;var _A_pl=_A_pl_tmp;var _A_pn=_A_pn_tmp;var _A_ct=_A_ct_tmp;

			var _AEC_order_code=\''. $orderRow['O_KEY'] . '\';		// 주문코드
			var _amt = \''. $strCartPriceEndTotalText .'\' ;              // 총 구매액
			AEC_B_L();			// 구매완료 함수
			</script>' ;	// 구매완료
	}
	echo $aceCounterScriptArr[$strMenuType . '_' . $strMode] ;
}
?>

<!-- AceCounter Log Gathering Script V.7.5.2013010701 -->
<script language='javascript'>
	var _AceGID=(function(){var Inf=['gtc2.acecounter.com','8080','<?=$ACE_COUNTER_ID?>','AW','0','NaPm,Ncisy','ALL','0']; var _CI=(!_AceGID)?[]:_AceGID.val;var _N=0;var _T=new Image(0,0);if(_CI.join('.').indexOf(Inf[3])<0){ _T.src =( location.protocol=="https:"?"https://"+Inf[0]:"http://"+Inf[0]+":"+Inf[1]) +'/?cookie'; _CI.push(Inf);  _N=_CI.length; } return {o: _N,val:_CI}; })();
	var _AceCounter=(function(){var G=_AceGID;if(G.o!=0){var _A=G.val[G.o-1];var _G=( _A[0]).substr(0,_A[0].indexOf('.'));var _C=(_A[7]!='0')?(_A[2]):_A[3];	var _U=( _A[5]).replace(/\,/g,'_');var _S=((['<scr','ipt','type="text/javascr','ipt"></scr','ipt>']).join('')).replace('tt','t src="'+location.protocol+ '//cr.acecounter.com/Web/AceCounter_'+_C+'.js?gc='+_A[2]+'&py='+_A[4]+'&gd='+_G+'&gp='+_A[1]+'&up='+_U+'&rd='+(new Date().getTime())+'" t');document.writeln(_S); return _S;} })();
</script>
<noscript><img src='http://gtc2.acecounter.com:8080/?uid=<?=$ACE_COUNTER_ID?>&je=n&' border=0 width=0 height=0></noscript>
<!-- AceCounter Log Gathering Script End -->
<? endif; ?>