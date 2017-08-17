<input type="hidden" name="pageDesign" value="<?= $strPageDesign ?>" />

<script language=javascript>
	function layout_over(obj)
	{
		var layout_ = obj.src.split('.gif');
		obj.src = layout_[0] + '_on.gif';
	}

	function layout_out(obj)
	{
		var layout_ = obj.src.split('_on.gif');
		obj.src = layout_[0] + '.gif';
	}

</script>

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
	
	<?if($S_MALL_TYPE == "M" && $S_SHOP_USER_APPLY_USE == "Y"){?>
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=HD" <?if(substr($strPageDesign,0,1) == "H") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00175"] //입점사페이지?></a>	
	<?}?>

	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=SD" <?if(substr($strPageDesign,0,1) == "S") echo "class='selected'";?>><?=$LNG_TRANS_CHAR["BW00113"] //추가페이지?></a>
	<a href="./?menuType=layout&mode=cssFileEdit" <?if(!$strPageDesign) { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["BW00114"] //CSS 설정?></a>
	<a href="./?menuType=layout&mode=jsFileEdit" <?if(!$strPageDesign) { echo "class='selected'"; }?>>스크립트 설정</a>
</div>

<br>

<? include "pageDesignSubMenu/subMenu.{$strPageDesign}.php"; ?>

<div class="tableForm">
	<table>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00151"] //레이아웃?></th>
			<td><?	include $incFile;	?></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00153"] //디자인선택?></th>
			<td><input type="radio" name="" checked/>HTML</td>
		</tr>
	</table>
	<div class="designEditerWrap">
		<div class="tabBtnWrap">
			<div class="tabBtnLeft">
				<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=<?= $strPageDesign ?>"		class="<?=$strOrg!="Y"?"btn_blue_big":"btn_big"; ?>"><strong><?=$LNG_TRANS_CHAR["BW00154"] //편집화면?></strong></a>
				<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=<?= $strPageDesign ?>&org=Y" class="<?=$strOrg=="Y"?"btn_blue_big":"btn_big"; ?>"><strong><?=$LNG_TRANS_CHAR["BW00155"] //원본화면?></strong></a>
				<a href="javascript:goOpenWin('popDesignTagList')" class="btn_big"><strong><?=$LNG_TRANS_CHAR["BW00156"] //예약어?></strong></a>
				<strong class="editInfoTxt"><?=$row[DE_EDIT_GROUP]?> -> <span><?=$row[DE_EDIT_SECTION]?></span> <?=$LNG_TRANS_CHAR["BW00157"] //편집 중?></strong>
			</div>
			<div class="btnRight">
				<!-- 2013.04.22 이사님 요청으로 숨김 -->
				<!--a href="#" class="btn_blue_sml"><span>늘리기</span></a>
				<a href="#" class="btn_sml"><span>줄이기</span></a-->
				<a href="javascript:goFTPFileUploadMoveEvent()" class="btn_sml"><span><?=$LNG_TRANS_CHAR["BW00102"] //FTP 파일 업로드?></span></a>
			</div>
			<div class="clear"></div>
		</div>
		<textarea name="de_edit_text" class="designEditForm" data-textarea-tab-key-no-move><? include $userEditFile?></textarea>
	</div><!-- designEditerWrap -->
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goPageDesignSaveAct('maindesignModify');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00066"] //바로적용하기?></strong></a>
	</div>
</div><!-- tableForm -->

