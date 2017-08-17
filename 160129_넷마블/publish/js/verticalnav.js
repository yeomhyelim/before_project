/**
* 2015-07-15 넷마블 사이드메뉴 스크립트.
* jquery plugin
* motionblue.com
* */

/* TODO
1. 내가 서브인가?
2. 내가 닫히면, 부모의 높이가 바뀐다.
3. 열린게 클릭되면 닫는 높이를 보낸다.
4. 닫흰게 클릭되면 여는 높이를 보낸다.
5. 또는 서브리스트의 높이를 자동감지해야한다.(움직임이 멈출때까지)
6. 열거나 닫을때 부모가 있는지 확인한다.


* 저장데이터
 - 부모아이디
 - 엘리먼트타입
*/

/**
 * 모듈 공통 스크립트
 *  */
(function( window, document, $ ){
	if( $ === undefined ){
		return;
	}

	/**
	 * @description jQuery 플러그인 생성. jQuery.data 속성을 확인한 후 객체를 생성하거나, 객체의 함수를 호출한다.
	 * @param {Object} ns 생성할 이름.
	 * @param {Object} Cls 생성할 클래스명.
	 *  */
	$.addPlugin = function( ns, Cls ){
		// jQuery 함수를 호출한다.
		$.fn[ns] = function(options) {
			var args = arguments, that = this, $this, instance;
			if(this.length==0){
				return;
			}
			//셀렉터로 검색된 것이 여러개일경우 반환 함수에서 넘겨줄값은 0번째 jQuery객체의 값으로 반환.
			if( typeof options === "string" && (/get/gi).test( String(options) ) ){ // 문자열이고 "get_"를 포함하고 있으면 리턴가능한 함수 호출.
				//var i=0, len=that.length;
				//for( ;i<len;i+=1 ){
				$this = $(that[0]);
				instance = $this.data( ns );
				//
				if( instance ){
					if( instance[options] ){
						return instance[options].apply( instance, Array.prototype.slice.call(args, 1));
					}
				}
				//}
			}else{ // 플러그인 생성 또는 일반 함수 호출일 경우
				return this.each( function(){
					$this = $(this);
					instance = $this.data( ns );
					//
					if (instance) {
						if( typeof options === 'object' ){
							if( typeof instance.update === 'function'  ){
								instance.update.apply(instance, args);
							}
						}else{
							if( instance[options] ){
								instance[options].apply( instance, Array.prototype.slice.call(args, 1));
							}
						}
					}else {
						return new Cls()._init($this, options);
					}
				} );
			}
		};
	};
	
	/**
	 * @description 이벤트 전파 완전 차단.
	 * @param {Object} jquery, javascript 이벤트 객체.
	 * */
	$.stopEvent = function( e ){
		e = e || window.event;
		e = e.originalEvent || e || window.event;
		if( typeof e.preventDefault === 'function' ){ // other ...
			e.preventDefault();
			e.stopPropagation();
		} else { // IE
			e.returnValue = false;
			e.cancelBubble = true;
		};
	};

})( window, document, jQuery );


/**
 * side menu script
 *  */
(function( window, document ){
// TODO :: 개발완료후 'use strict' 제거 하세요.
'use strict';


function ___oGetEventName(){
	var evtNm = {
		start : 'mousedown',
		end : 'mouseup',
		move : 'mousemove',
		cancel : 'mouseleave'
	};
	
	if('ontouchstart' in window){ //  other mobile browser
		evtNm.start = 'touchstart';
		evtNm.move  = 'touchmove';
		evtNm.end = 'touchend';
		evtNm.cancel = 'touchcancel';
   } else if(window.navigator.msPointerEnabled && window.navigator.msMaxTouchPoints > 0) { // ie mobile browser
		evtNm.start = 'MSPointerDown';
		evtNm.move  = 'MSPointerMove';
		evtNm.end = 'MSPointerUp';
		evtNm.cancel = 'MSPointerCancel';
	}
	
	return evtNm;
};

// 이벤트 객체 반환
function ___getEventObj(e){
	e = e.originalEvent || e || window.event;
	return e;
};

// 터치 객체 반환
function ___getEventTouchObj(e){
	e = ___getEventObj(e);
	var touch;
	if(  e.type.indexOf('touch') > -1 ){
		touch = e.touches[0] ? e.touches[0] : e.changedTouches[0];
	}else{
		touch = e || window.event;
		if( touch.pageX == undefined ){
			touch.pageX = touch.clientX;
		};
		if( touch.pageY == undefined ){
			touch.pageY = touch.clientY;
		};
	};
	return touch;
};

var ___oEventMod = {
	/**
	 * event binding
	 * context, binding function, parameter 
	 *  */
	bind: function( obj, func, params ){
	return function( e ){
			if( e!==undefined ){
				var evt = e.originalEvent || e || window.event;
				return func.call( obj, evt, params );
			}else{
				return func.call( obj, params );
			}
			
		};
	},
	/**
	 * stop event
	 *  */
	fire : function(e){
		e = ___getEventObj(e);
		if( typeof e.preventDefault === 'function' ){ // other ...
			e.preventDefault();
			e.stopPropagation();
		} else { // IE
			e.returnValue = false;
			e.cancelBubble = true;
		}
	}
};

/*
_data = {};

:: set
tmpData = $.data();
if( tmpData === undefined ){
	tmpData = {};
	tmpData['key'] = value;
}

$.data( tmpData )


:: get
tmpData = $.data();
if( tmpData === undefined ){
	return undefined;
}else{
	return tmpData['key'];
}
*/

var __multiDepthNavNs = "multiDepthNav",
__sideMenuNs = "globalSideMenu",
__oEvtNm  = ___oGetEventName();


var __CMultiDepthNav = function(){
	if( !(this instanceof __CMultiDepthNav) ){
		return new __CMultiDepthNav();
	}
};

__CMultiDepthNav.prototype = (function(){
	
	// prototype으로 사용할 객체 반환.
	return {
		constructor : __CMultiDepthNav,
		_istiny : false,
		_$nav : null,
		_idcodemaplist : {},
		_isLayoutAnimate : false,
		_options: {
			istiny : false,
			tinySubAutoPosition : true,
			currentIdxs : {0:0, 1:0, 2:0},
			speed : 300,
			defaultId : null,
			onclick : null
		},
		/**
		 * 초기화 함수 플러그인 생성될때 자동으로 호출된다.
		 *  */
		_init : function( $dom, options ){
			this._options = $.extend( {}, this._options, options );
			//
			this._istiny = this._options.istiny;
			this._$nav = $dom;
			this._refactor( $dom );
			this._setDefault( this._options.defaultId );
			this._addEvent();
			//
			return $dom.data( __multiDepthNavNs, this );
		},
		_refactor : function( $ul ){
			var that = this,
			uldata = $ul.data('mdnav-data') || {};
			
			if( uldata.depth === undefined ){ // 최상위 UL
				uldata.depth = 1;
				uldata.index = 0;
				uldata.uid = '0';
				uldata.type = 'ul';
				uldata.currentIdx = -1;
			}
			
			$ul.attr('id', 'mdnavul_' + uldata.uid ).data( 'mdnav-data', uldata );
			
			$ul.children().each( function(i, item){
				var $li = $(item),
				itemdata = $.data( item, 'mdnav-data' ) || {};
				//
				itemdata.depth = uldata.depth;
				itemdata.index = i;
				itemdata.uid = uldata.uid + '_' + i;
				itemdata.ulIndex = uldata.index;
				itemdata.type = 'li';
				//
				if( item.id === undefined || item.id === '' ){ // 아이디가 없다.
					// 아이디를 강제로 부여하지 않는다.
					//item.id = "id_" + itemdata.uid;
					// 아이디대신 uid로 검색하게 한다.
					that._idcodemaplist[ itemdata.uid ] = itemdata.uid;
				}else{
					//TODO :: 아이디를 저장해 코드로 사용할 수 있게 매핑해야함(사용안함.)
					//that._idcodemaplist[ item.id ] = itemdata.uid;
				};
				//
				//
				if( $li.find( '>ul' ).length > 0 ){
					itemdata.hasSub = true;
				}else{
					itemdata.hasSub = false;
				}
				$.data( item, 'mdnav-data', itemdata );
				if( itemdata.hasSub ){
					that._wrapping( $li );
				}
				itemdata = null;
			} );
			//
			uldata = null;
		},
		_wrapping : function( $li ){
			var that = this, 
				$subul = $li.find( '>ul' ),
				classb = '',
				classt = '',
				cssobj = {},
				prsdata = $li.data( 'mdnav-data' ),
				idx = prsdata.index,
				uldata = $subul.data( 'mdnav-data' ) || {},
				depth = 0;
			//
			uldata.depth = prsdata.depth + 1;
			uldata.index = idx;
			uldata.uid = prsdata.uid;
			uldata.type = 'ul';
			depth = uldata.depth
			//
			$subul.data( 'mdnav-data', uldata );
			prsdata = null;
			uldata = null;
			// dom 래핑
			if( $subul.length > 0 ){ // 서브가 있을경우
				
				if( depth == 2 ){
					// 메뉴작아졌을때.
					if( this._istiny ){
						cssobj = {
							position : 'absolute',
							overflow : 'visible',
							height : 'auto',
							display : 'none'
						}
						if( this._options.tinySubAutoPosition ){
							cssobj.minHeight = 52;
						}
					}else{
						cssobj = {
							width : '100%',
							position : 'relative',
							overflow : 'hidden',
							height : 0
						}
					}
					
					
					// 기존퍼블리싱 에서 필요한. posbox_b, posbox_t 클래스 추가
					$( '<div class="posbox_b vnav-sub-wrap"></div>' ).css( cssobj ).appendTo( $li ).append( // ul 애니메이션을 위해 두번 감쌈.( 움직일 div, 위치 조절. )
						$( '<div class="posbox_t vnav-sub-viewport"></div>' ).css({
							//
						}).appendTo( $li.find( '>.vnav-sub-wrap' ) ) // appendTo end
					); // append end;
					
					var $viewport = $li.find('>.vnav-sub-wrap>.vnav-sub-viewport');
					if( $li.find('.left_tit').length > 0 ){
						$viewport.append( $li.find('.left_tit') );
					}
					//
					$viewport.append( $subul );
					//
					if( $li.find('.arrow').length > 0 ){
						$viewport.append( $li.find('.arrow') );
					}
				}else{
					$( '<div class="vnav-sub-wrap"></div>' ).css( {
						width : '100%',
						position : 'relative',
						overflow : 'hidden',
						height : 0
					} ).appendTo( $li ).append( // ul 애니메이션을 위해 두번 감쌈.( 움직일 div, 위치 조절. )
						$( '<div class="vnav-sub-viewport"></div>' ).css({
							width : '100%',
							position : 'absolute',
							height : 'auto'
						}).appendTo( $li.find( '>.vnav-sub-wrap' ) ).append( $subul ) // appendTo end
					); // append end;
						
				}
				//
				that._refactor( $subul );
			}
		},
		_setDefault: function( id ){
			var defaultId = id,
			$item = $('#'+defaultId);
			//
			if( $item.length == 0 ){
				return;
			}
			//
			var data = $item.data('mdnav-data'),
			depth = data.depth,
			index = -1,
			cIdx = $item.parent().data('mdnav-data').currentIdx,
			i = 0;
			//
			for( ;i<depth;i+=1 ){
				if( $item.data('mdnav-data').hasSub ){
					if( this._getOnlyHeight( $item.find( '>div' ) ) == 0 ){ // 이미열린것은 열지 않는다.
						this._onclick( $item, null, true );
					}
				}else{
					this._onclick( $item, null, true );
				}
				//
				$item = this._getParentItem( $item );
				if( $item===undefined ){ // 더이상 상위 아이템이 없다.
					break;
				}
			}
		},
		_allClose : function(){
			var that = this;
			// current idx 초기화
			that._$nav.data('mdnav-data').currentIdx = -1;
			that._$nav.find('ul').each( function(i, item){
				var $item = $(item);
				$item.data('mdnav-data').currentIdx = -1;
			} );
			// 닫기.
			that._$nav.find('li').each( function( i, item ){
				var $item = $(item),
					depth = $item.data('mdnav-data').depth;
				//
				that._deactivateItem( $item );
				//
				if( depth==2 ){
					that._closeItemSub( $item );
				}else{
					that._closeItem( $item, true );
				}
				
			});
		},
		_closeItemGroup : function( $li ){
			var that = this;
			/*
			if( $li.data('mdnav-data').depth==2 ){
				that._closeItemSub( $li );
			}else{
				that._closeItem( $li, true );
			}
			*/

			$li.find('ul').each( function(i, item){
				var $item = $(item);
				$item.data('mdnav-data').currentIdx = -1;
			} );

			$li.find('li').each( function( i, item ){
				var $item = $(item),
					depth = $item.data('mdnav-data').depth;
				//
				that._deactivateItem( $item );
				//
				if( depth==2 ){
					that._closeItemSub( $item );
				}else{
					that._closeItem( $item, true );
				}
			})
		},
		_setTiny : function(){
			var that = this,
			cssobj = {
				position : 'absolute',
				overflow : 'visible',
				width : 195,
				height : 'auto'
			};
			//

			that._$nav.find('li').each( function(i, item){
				var $item = $(item),
					data = $item.data('mdnav-data'),
					$wrap = null;
				//
				if( $item.data('mdnav-data').depth === 2 ){
					$wrap = $item.find('>.vnav-sub-wrap');
					$wrap.css( {
						position: 'relative',
						overflow: 'hidden',
						height: 0,
						top:0
					} ).show();
					//
					$item.off( 'mouseover.opensub' );
					$(document).off( 'mouseover.sidebarSubCheck' + data.uid);
				}// if
			} );

			this._$nav.find('>li').each( function(i, item){
				var $item = $(item),
				data = $item.data('mdnav-data'),
				$wrap = null;
				//
				$item.off(__oEvtNm.start);
				//$item.find('>.vnav-sub-wrap').hide();
				//
				if( data.hasSub ){
					$wrap = $item.find('>.vnav-sub-wrap').hide().css( cssobj );
					$wrap.find('>.vnav-sub-viewport').attr('style', '');
					//
					$item.off( 'mouseover.open' ).on('mouseover.open', function( e ){
						if( that._isLayoutAnimate ){ // 레이아웃 애니메이션 중에는 클릭할 수 없다.
							return false;
						}
						//
						var dom = this, 
							$this = $(this);
						//
						if( that._options.tinySubAutoPosition ){
							that._setSubPosition( $this );
						}
						$this.find('>.vnav-sub-wrap').show();

						$(document).on( 'mouseover.sidebarCheck' + $this.data('mdnav-data').uid, function(e){
							if( !$.contains( dom, e.target ) ){
								$this.find('>.vnav-sub-wrap').hide();
								that._closeItemGroup($this);
								//
								$(document).off( 'mouseover.sidebarCheck' + $this.data('mdnav-data').uid);
							};
						});
					});
				}
			} );
			
		},
		_setNormal : function(){
			var that = this, 
				cssobj = {
					width : '100%',
					position : 'relative',
					overflow : 'hidden',
					minHeight : 0,
					top : 'auto',
					height : 0
				},
				cIdx = this._$nav.data('mdnav-data').currentIdx;
			//
			
			that._allClose();
			
			that._$nav.find('>li').off( 'mouseover.open' );
			that._$nav.find('>li').each( function(i, item){
				var $item = $(item),
				data = $item.data('mdnav-data'),
				$wrap = null;
				//
				
				$item.off( 'mouseover.open' );
				//
				if( data.hasSub ){
					$wrap = $item.find('>.vnav-sub-wrap').css( cssobj ).show();
					// 열려있던 메뉴 열기.
					if( data.index == cIdx ){
						var h = that._getHeight( $wrap.find( '>.vnav-sub-viewport>ul' ) );
						/* 말풍선 변경하면서 주석처리.
						$wrap.css( {
							'height' : 'auto',
							'overflow' : 'visible'
						} );
						//*/
					}
				}
			});
			//
			that._addEvent();
			that._$nav.find('li').each( function(i, item){
				var $item = $(item),
					data = $item.data('mdnav-data'),
					$wrap = null;
				//
				if( $item.data('mdnav-data').depth === 2 ){
					$wrap = $item.find('>.vnav-sub-wrap');
					$wrap.css( {
						position: 'absolute'
					} );
					$item.on( 'mouseover.opensub', function( e ){
						var dom = this;
						//
						that._openItemSub( $(this), e );
						//
						$(document).on( 'mouseover.sidebarSubCheck' + data.uid, function(e){
							if( !$.contains( dom, e.target ) ){
								that._deactivateItem( $item );
								$item.find('>.vnav-sub-wrap').hide();
								that._closeItemGroup( $item ) ;
								//
								$(document).off( 'mouseover.sidebarSubCheck' + data.uid);
							};
						}); // out
					} ); // over
				}// if
			} );
			

		},
		_addEvent : function(){
			var that = this;
			// 최상위 ul 하위의 모든 li를 검색해 이벤트 등록.
			this._$nav.find( 'li' ).off( __oEvtNm.start ).on( __oEvtNm.start, function(e){
				if( that._isLayoutAnimate ){ // 레이아웃 애니메이션 중에는 클릭할 수 없다.
					return;
				}
				//
				var $this = $(this);
				if( !that._istiny && $this.data( 'mdnav-data' ).depth===2 ){
					//that._onclick( $(this), e );
					that._onClickCallback( $this, $this.data( 'mdnav-data' ).uid );
				}else{
					that._onclick( $this, e );
				}
				$.stopEvent(e);
			} );
		},
		_onclick : function( $li, e, noanimate ){
			var lidata = $li.data( 'mdnav-data' ),
				$ul = $li.parent(),
				uldata = $ul.data( 'mdnav-data' ),
				currentIdx = uldata.currentIdx,
				$closeLi = $li;
			//
			// 이전것 닫기.
			if( currentIdx > -1 ){
				$closeLi = $( $ul.children()[currentIdx] );
				// 현재 열린메뉴 재 선택시.
				if( lidata.index == currentIdx ){
					// 서브리스트가 있을때
					if( $closeLi.data( 'mdnav-data' ).hasSub ){
						this._deactivateItem( $closeLi );
					}else{ // 서브리스트가 없을때
						return;
					}
				}else{
					this._deactivateItem( $closeLi );
				}
				// 이전에 선택된 메뉴 닫기
				this._closeItem( $closeLi, noanimate );
			}
			
			if( lidata.index == currentIdx ){
				currentIdx = -1;
			}else{
				currentIdx = lidata.index;
			}
			
			//
			uldata.currentIdx = currentIdx;
			$li.parent().data( 'mdnav-data', uldata );
			
			if( currentIdx > -1 ){
				// css 활성화
				this._activateItem( $li );
				if( lidata.hasSub ){
					// 선택된것 열기.
					this._openItem( $li, noanimate );
				}
				this._onClickCallback( $li, $li.data( 'mdnav-data' ).uid );
			}else{
				// 토글 닫을때 콜백호출 막음.
				//this._onClickCallback( $li, $li.data( 'mdnav-data' ).uid );
			}
		},
		_onClickCallback : function( $li, uid, state ){
			if( typeof this._options.onclick === 'function' ){
				this._options.onclick.call( null, $li, uid, state );
			}
		},
		_openItemSub : function( $li, noanimate ){
			var $subWrap = $li.find( '>.vnav-sub-wrap' );
			if( $subWrap.length == 0 ){
				this._activateItem( $li );
				return;
			}
			//
			var that = this,
				$subviewport = $subWrap.find( '>.vnav-sub-viewport' ),
				h = that._getHeight( $subviewport.find( '>ul' ) ),
				speed = that._options.speed,
				lidata = $li.data('mdnav-data'),
				itemOffsetTop = $li.offset().top,
				listOffsetTop = that._$nav.parent().offset().top,
				toplimit = listOffsetTop - itemOffsetTop,
				topspace = 8, // css상의 상단 여백 크기.
				top = 0,
				wrapHeight = 0

				$subWrap.show();
				wrapHeight = that._getSpaceHeight( $subviewport.find('>ul') );
				wrapHeight += that._getSpaceHeight( $subWrap );
				wrapHeight += that._getSpaceHeight( $subviewport );
				$subviewport.find('>ul').find( '>li' ).each(function(i, item){
					wrapHeight += that._getHeight( $(item).find('>a') );
				})

				top = that._getHeight( $li ) - wrapHeight;

				// css 상에서의 상단여백을 더함.
				if( top < toplimit  ){
					top = toplimit + topspace;
				}
			// css
			this._activateItem( $li );

			$subWrap.stop().css('height', h).css({
				'position' : 'absolute',
				'overflow' : 'visible',
				'height' : 'auto',
				'top' : top,
			});

			$subviewport.stop().css( {
				'width' : '100%',
				'position' : 'relative',
				'height' : 'auto',
				'top' : 0
			} );
		},
		_closeItemSub : function( $li, noanimate ){
			$li.find('>.vnav-sub-wrap').hide();
			this._closeItemGroup( $li );
		},
		_openItem : function( $li, noanimate ){
			var $subWrap = $li.find( '>.vnav-sub-wrap' );
			if( $subWrap.length == 0 ){
				return;
			}
			//
			var	$subviewport = $subWrap.find( '>.vnav-sub-viewport' ),
				h = this._getHeight( $subviewport.find( '>ul' ) ),
				speed = this._options.speed,
				lidata = $li.data('mdnav-data');
			//
			if( noanimate ){
				$subWrap.stop().css('height', h).css({
					'overflow' : 'visible',
					'height' : 'auto'
				});
				$subviewport.stop().css( {
					'width' : '100%',
					'position' : 'relative',
					'height' : 'auto',
					'top' : 0
				} );
			}else{

				$subWrap.stop().css({
					'overflow' : 'hidden',
					'height' : 0
				}).show().animate( { height : this._getHeight( $subviewport.find( '>ul' ) ) }, { // 움직임 크기계산을위해 동적으로 재계산(버벅임 방지).
					duration : speed,
					easing:'easeOutCubic'
				} );
				// 움직임 크기계산을위해 동적으로 재계산(버벅임 방지)
				h = this._getHeight( $subviewport.find( '>ul' ) );
				$subviewport.stop().css( {
					'width' : '100%',
					'position' : 'absolute',
					'height' : h,
					'top' : $subWrap.height()-h
				} ).animate( { top : 0 }, {
					duration : speed,
					easing:'easeOutCubic',
					complete : function(){
						$(this).css({
							'height' : 'auto',
							'position' : 'relative'
						}).parent().css({
							'overflow' : 'visible',
							'height' : 'auto'
						});
					}
				} );
			}
		},
		_closeItem : function( $li, noanimate ){
			var $subWrap = $li.find( '>.vnav-sub-wrap' );
			if( $subWrap.length == 0 ){
				return;
			}
			//
			var	$subviewport = $subWrap.find( '>.vnav-sub-viewport' ),
				h = this._getHeight( $subviewport.find( '>ul' ) ),
				speed = this._options.speed;
			//
			if( noanimate ){
				$subWrap.stop().css({
					'overflow' : 'hidden',
					'height' : 0 
				});
				$subviewport.stop().css( {
					'position' : 'absolute',
					'height' : h,
					'top' : -h
				} );
			}else{
				$subWrap.stop().css({
					'overflow' : 'hidden'
				}).animate( { height : 0 }, {
					duration : speed,
					easing:'easeOutCubic'
				} );
					
				$subviewport.stop().css( {
					'position' : 'absolute',
					'height' : h
				} ).animate( { top : -h }, {
					duration : speed,
					easing:'easeOutCubic'
				} );
			}
			this._closeItemGroup( $li );
		},
		_activateItem : function( $li ){
			switch( $li.data('mdnav-data').depth ){
				case 1 :
					$li.addClass( 'slide_on' );
				break;
				case 2 :
					$li.addClass( 'on' );
				break; 
				case 3 :
					$li.addClass( 'on' );
				break; 
			}
		},
		_deactivateItem : function( $li ){
			switch( $li.data('mdnav-data').depth ){
				case 1 :
					$li.removeClass( 'slide_on' );
				break;
				case 2 :
					$li.removeClass( 'on' );
				break; 
				case 3 :
					$li.removeClass( 'on' );
				break; 
			}
		},
		_setSubPosition : function( $li ){
			var that = this,
				$this = $li,
				$wrap = $this.find('>.vnav-sub-wrap'),
				$viewport = $wrap.find( '>.vnav-sub-viewport' ),
				$subUl = $viewport.find('>ul'),
				$arrow = $viewport.find('>.arrow');
			//
			if( $li.data( 'mdnav-data' ).tinySubTop ){
				$wrap.css( 'top', $li.data( 'mdnav-data' ).tinySubTop );
				$arrow.css('top', $li.data( 'mdnav-data' ).tinySubArrowTop );
				return;
			}
			// 계산을 위한 변수
			var	top = 8,
				arrowTop = 375,
				itemOffsetTop = $this.offset().top,
				listOffsetTop = $this.parent().offset().top,
				itemHeight = that._getHeight( $this.find('>a') ),
				wrapHeight = that._getHeight( $wrap ),
				itemBottomY = itemOffsetTop - listOffsetTop + itemHeight;
			// 보이지않으면 높이 반환 안됨.
			$wrap.show();
			wrapHeight = that._getSpaceHeight( $subUl );
			wrapHeight += that._getSpaceHeight( $wrap );
			wrapHeight += that._getSpaceHeight( $viewport );
			wrapHeight += that._getHeight( $viewport.find('>.left_tit') );
			
			$subUl.find( '>li' ).each(function(i, item){
				wrapHeight += that._getHeight( $(item).find('>a') );
			})
			
			wrapHeight +=15;
				
			// css 상에서 기본 높이가 8로 되어있음.
			if( wrapHeight > itemBottomY ){
				top = 8;
			}else{
				top = itemBottomY - wrapHeight;
			}
			// 박스하단에 화살표 위치시 위치가 라운드쪽에 걸려 공백이 보이지 않게 상하단 패딩및 마진 크기를 더함.
			top = itemBottomY - wrapHeight + 20;
			
			if( top<8 ){
				top = 8;
			}
			
			// 화살표가 li의 상단에 높이값을 참조.
			arrowTop = itemOffsetTop - listOffsetTop - top;
			// 화살표가 li 중앙에 오게함.
			arrowTop = arrowTop + ( itemHeight / 2 ) - ( that._getHeight( $arrow ) / 2 )
			
			$li.data( 'mdnav-data' ).tinySubTop = top;
			$li.data( 'mdnav-data' ).tinySubArrowTop = arrowTop;
			
			//
			$wrap.css( 'top', top );
			$arrow.css('top', arrowTop );
		},
		_getParentItem : function( $li ){
			var lidata = $li.data( 'mdnav-data' ),
				arr = String(lidata.uid).split( '_' ),
				$parentList = null;
			//
			arr.splice( arr.length-2, 2 );
			if( arr.length == 0 ){ // 최상위뎁스 아이템
				// 호출할 상위 리스트가 없다.
			}else{
				var parentListId =  'mdnavul_' + arr.join('_');
				if( this._$nav.attr('id') == parentListId ){
					$parentList = this._$nav;
				}else{
					$parentList = this._$nav.find( '#' + parentListId );
				}
				return $( $parentList.children()[lidata.ulIndex] );
			}
			return undefined;
		},
		// Dom의 높이 값 + 여백 값을 반환
		_getHeight : function( $dom ){
			var h = parseInt( $dom.css( 'height' ).replace( /[^0-9]/gi, '' ) );
			h += parseInt( $dom.css( 'margin-top' ).replace( /[^0-9]/gi, '' ) );
			h += parseInt( $dom.css( 'margin-bottom' ).replace( /[^0-9]/gi, '' ) );
			h += parseInt( $dom.css( 'padding-top' ).replace( /[^0-9]/gi, '' ) );
			h += parseInt( $dom.css( 'padding-bottom' ).replace( /[^0-9]/gi, '' ) );
			return h;
		},
		// Dom의 높이값을 반환
		_getOnlyHeight : function( $dom ){
			return parseInt( $dom.css( 'height' ).replace( /[^0-9]/gi, '' ) );
		},
		// ClientHeight 값을 반환
		_getClientHeight : function(){
			if( !document.compatMode || (/BackCompat/gi).test( document.compatMode ) ){
				return document.body.clientHeight;
			}else{
				return document.documentElement.clientHeight;
			}
		},
		// margin-top, margin-bottom, padding-top, padding-bottom
		_getSpaceHeight : function( $dom ){
			var h = this._getPxNumber( $dom.css('margin-top') );
			h += this._getPxNumber( $dom.css('margin-bottom') );
			h += this._getPxNumber( $dom.css('padding-top') );
			h += this._getPxNumber( $dom.css('padding-bottom') );
			return h;
		},
		// 숫자반환
		_getPxNumber : function( numstr ){
			return parseFloat( numstr.replace( /px/gi, '' ) );
		},
		// sidebar 접기
		setTiny : function() {
			this._istiny = true;
			this._setTiny();
		},
		// sidebar 펼치기
		setNormal : function(){
			this._istiny = false;
			this._setNormal();
		},
		// 해당메뉴 열기
		goOpen : function( id ){
			this._setDefault( id );
		},
		setLayoutChangeState : function( isanimate ){
			this._isLayoutAnimate = isanimate;
		}
		
	};
	
}());


// jquery 플러그인 등록.
$.addPlugin( __multiDepthNavNs, __CMultiDepthNav );



/**
 * side menu 생성자 함수
 *  */
var __CSideMenu = function(){
	if(!(this instanceof __CSideMenu)){
		return new __CSideMenu();
	};
};

/**
 * side menu prototype
 *  */
__CSideMenu.prototype = (function(){
	
	
	
	// prototype으로 사용할 객체 반환.
	return {
		constructor : __CSideMenu,
		$dom : null,
		$nav : null,
		$uiBtn : null,
		_options : {
			istiny : false,
			isanimate : true,
			defaultId : "",
			tinySubAutoPosition : true,
			onclick : null,
		},
		_speed : 200,
		_istiny : false,
		/**
		 * 초기화 함수 플러그인 생성될때 자동으로 호출된다.
		 *  */
		_init : function( $dom, options ){
			this._options = $.extend( {}, this._options, options );
			this.$dom = $dom;
			this.$nav = $('.leftMenu');
			this.$uiBtn = $('#sideBtn');
			this._istiny =this._options.istiny; 
			//
			this._addEvent();
			this._initNav();
			//
			
			if( this._istiny ){
				this.close();
			}else{
				this.open();
			}
			
			return $dom.data( __sideMenuNs, this );
		},
		_initNav : function(){
			this.$nav.multiDepthNav( {
				istiny : this._options.istiny,
				tinySubAutoPosition : this._options.tinySubAutoPosition,
				defaultId : this._options.defaultId,
				onclick : this._options.onclick
			});
		},
		_addEvent : function(){
			var that = this;
			this.$uiBtn.click(function(){
				if( $('body').hasClass('min_left') ){ // 열기
					// 네비 설정변경.
					that.$nav.multiDepthNav( 'setNormal' );
					that._openLayout();
				}else{ // 닫기
					// 네비 설정변경.
					that.$nav.multiDepthNav( 'setTiny' );
					that._closeLayout();
				}
			});
		},
		_openLayout : function( callback ) {
			var that = this;
			that._setLayoutChangeState( true );
			if( this._options.isanimate ){
				// 버튼 스타일 조정
				this.$uiBtn.html('close').parent().addClass( 'close' );
				this.$uiBtn.stop().animate({width:174},{
					duration:this._speed,
					easing:'easeOutCubic'
				});
				//
				$('#container').stop().animate({'paddingLeft':175},{
					duration : this._speed,
					easing : 'easeOutCubic'
				});
				//
				this.$dom.find('.inside').stop().animate({width:174},{
					duration:this._speed,
					easing:'easeOutCubic',
					step:function( pos ){
						$('body').css( 'backgroundPosition', (pos-174) + 'px' + ' 0' );
					},
					complete : function(){
						// 바디 클래스 조정.
						if( $('body').hasClass('min_left') ){
							$('body').removeClass('min_left');
						}
						if( typeof callback === 'function' ){
							callback();
						}
						that._setLayoutChangeState( false );
						that._tabPageResize();
					}
				});
			}else{
				// 버튼 스타일 조정
				this.$uiBtn.html('close').parent().addClass( 'close' );
				// 바디 클래스 조정.
				if( $('body').hasClass('min_left') ){
					$('body').removeClass('min_left');
				}
				if( typeof callback === 'function' ){
					callback();
				}
				that._setLayoutChangeState( false );
				that._tabPageResize();
			}
			
		},
		_closeLayout : function( callback ){
			var that = this;
			that._setLayoutChangeState( true );
			if( that._options.isanimate ){
				this.$dom.find('.inside ul.leftMenu>li>a>b').css( {
					'textIndent' : -9999,
					'fontSize' : 0,
					'lineHeight' : 0,
					'padding' : 0,
					'height' : 38
				} );
				//
				// 버튼 스타일 조정
				this.$uiBtn.html('open').parent().removeClass( 'close' );
				this.$uiBtn.stop().animate({width:53},{
					duration:this._speed,
					easing:'easeOutCubic'
				});
				//
				$('#container').stop().animate({'paddingLeft':54},{
					duration : this._speed,
					easing : 'easeOutCubic'
				});
				//
				this.$dom.find('.inside').stop().animate({width:53},{
					duration:this._speed,
					easing:'easeOutCubic',
					step:function( pos ){
						$('body').css( 'backgroundPosition', (pos-174) + 'px' + ' 0' );
					},
					complete : function(){
						if( !$('body').hasClass('min_left') ){
							$('body').addClass('min_left');
						};
						//
						that.$dom.find('.inside ul.leftMenu>li>a>b').attr( 'style', '' );
						//
						if( typeof callback === 'function' ){
							callback();
						}
						that._setLayoutChangeState( false );
						that._tabPageResize();
					}
				});
			}else{
				// 버튼 스타일 조정
				this.$uiBtn.html('open').parent().removeClass( 'close' );
				// 바디 클래스 조정.
				if( !$('body').hasClass('min_left') ){
					$('body').addClass('min_left');
				};
				if( typeof callback === 'function' ){
					callback();
				}
				that._setLayoutChangeState( false );
				that._tabPageResize();
			}
			
		},
		_setLayoutChangeState : function( isanimate ){
			this.$nav.multiDepthNav( 'goOpen', isanimate );
		},
		_tabPageResize : function(){
			//PagePanel.Init();
			var $contOff = $('.iframe_cont').offset();

			var tabOffset = $("#__tabBarContainer").offset();
			var tabBarOffset =$(".tabBarContainer").offset();	
			var tabHeight = 0;
			if(!tabBarOffset){
				tabHeight = $(window).height() - tabBarOffset.top;
			}
			else{
				tabHeight = $(window).height() - tabOffset.top;
			}
			$('#__tabBarContainer').css('height', tabHeight);
			$('#__tabBarContainer').css('width', $(window).width() - tabOffset.left);
			PagePanel.PageSize(); 
		},
		open : function(){
			this._openLayout();
			// 네비 설정변경.
			this.$nav.multiDepthNav( 'setNormal' );
		},
		close : function(){
			this._closeLayout();
			// 네비 설정변경.
			this.$nav.multiDepthNav( 'setTiny' );
		},
		get_module : function(){
			return this;
		},
		goOpen : function( id ){
			this.$nav.multiDepthNav( 'goOpen', id );
		}
		
	};
}());

// jquery 플러그인 등록.
$.addPlugin( __sideMenuNs, __CSideMenu );



})(window, document);