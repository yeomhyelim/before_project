<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00104"] //페이지 디자인 설정?></h2>
	<div class="clr"></div>
</div>

<br>

<!-- ******** 컨텐츠 ********* -->

<div class="tabImgWrap">
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=MH" <?if(substr($strPageDesign,0,1) == "M") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00105"] //메인페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=PD" <?if(substr($strPageDesign,0,1) == "P") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00106"] //상품리스트페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=VD" <?if(substr($strPageDesign,0,1) == "V") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00107"] //상품뷰페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=RD" <?if(substr($strPageDesign,0,1) == "R") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00108"] //브랜드페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=OD" <?if(substr($strPageDesign,0,1) == "O") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00109"] //주문페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=ED" <?if(substr($strPageDesign,0,1) == "E") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00110"] //회원페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=YD&subPageDesign=buyList" <?if(substr($strPageDesign,0,1) == "Y") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00111"] //MY페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=BD" <?if(substr($strPageDesign,0,1) == "B") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00112"] //커뮤니티페이지?></a>	
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=SD" <?if(substr($strPageDesign,0,1) == "S") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00113"] //추가페이지?></a>
	<a href="./?menuType=layout&mode=cssFileEdit"><?=$LNG_TRANS_CHAR["BW00114"] //CSS 설정?></a>
	<a href="./?menuType=layout&mode=jsFileEdit" <?if(!$strPageDesign) { echo "class='selected'"; }?>>스크립트 설정</a>
</div>

<br>

<div class="tableForm mt20">
	<div class="designEditerWrap">
		<textarea name="js_edit" id="js_edit" class="designEditForm" data-textarea-tab-key-no-move><?include $jsFile?></textarea>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goJsFileEditActEvent()" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00066"] //바로적용하기?></strong></a>
	</div>
</div>

