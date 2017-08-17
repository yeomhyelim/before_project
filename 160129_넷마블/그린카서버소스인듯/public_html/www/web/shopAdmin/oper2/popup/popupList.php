<?php
	## 스크립트 설정
	$aryScriptEx[] = "./common/js/oper2/oper2.popupList.js";
?>
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00001"] //팝업관리?></h2>
	<div class="clr"></div>
</div>

<div class="tableListWrap">
	<table class="tableList">
		<?php if(!$objPopupResult):?>
		<?php else:?>
		<?while($row = mysql_fetch_array($objPopupResult)):

			## 기본설정
			$intPoNo					= $row['PO_NO'];
			$strPoTitle					= $row['PO_TITLE'];
			$strPoStyle					= $row['PO_STYLE'];
			$strPoUse					= $row['PO_USE'];
			$strPoStartDT				= $row['PO_START_DT'];
			$strPoEndDT					= $row['PO_END_DT'];
			$strPoLink					= $row['PO_LINK'];
			$strPoLinkType				= $row['PO_LINK_TYPE'];
			$strPoLang					= $row['PO_LANG'];
			$intPoTop					= $row['PO_TOP'];
			$intPoLeft					= $row['PO_LEFT'];
			$strPoFile					= $row['PO_FILE'];

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
			$strSection					= $row['PO_IS_WEB'];
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/

			$strDefaultDir				= SHOP_HOME . "/upload/popup";
			$strWebDir					= "/upload/popup";

			## 번호 설정
			$intPoNoText				= $intPoNo;

			## 사용언어 설정
			$aryPoLang					= explode(",", $strPoLang);
			$strPoLangText				= "";
			if($aryPoLang):
				foreach($aryPoLang as $key => $data):
					if($strPoLangText) { $strPoLangText .= ","; }
					$strPoLangText		.= $S_ARY_COUNTRY[$data];
				endforeach;
			endif;

			## 팝업종류 설정
			$aryPopupStyleCode['basic']		= "일반팝업";
			$aryPopupStyleCode['layer']		= "레이어팝업";
			$strPoStyleText					= $aryPopupStyleCode[$strPoStyle];

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
			## 팝업구분 설정
			$aryPopupSection[1]				= "웹";
			$aryPopupSection[2]				= "모바일";
			$strPoSection					= $aryPopupSection[$strSection];

/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/

			## 링크주소 설정
			$strPoLinkText					= $strPoLink;

			## 링크열기 설정
			$aryPopupStyleCode['_blank']	= "새창에서 열기";
			$aryPopupStyleCode['_self']		= "부모창에서 열기";
			$strPoLinkTypeText				= $aryPopupStyleCode[$strPoLinkType];
			if(!$strPoLinkTypeText) { $strPoLinkTypeText = "링크없음"; }

			## 위치 설정
			$strPositionText				= "";
			if($intPoLeft):
				$strPositionText .= "LEFT: {$intPoLeft}";				
			endif;
			if($intPoTop):
				if($strPositionText) { $strPositionText .= ", "; }
				$strPositionText .= "TOP: {$intPoTop}";				
			endif;

			## 제목 설정
			$strPoTitleText						= $strPoTitle;

			## 진행상태
			$strPoStartDTText				= date("Y-m-d", strtotime($strPoStartDT));
			$strPoEndDTText					= date("Y-m-d", strtotime($strPoEndDT));
			$strPoUseText					= "<span class='icoIng'>진행중</span>";
			$now							= date("Y-m-d");
			if($strPoUse != "Y")						 { $strPoUseText = "<span class='icoPouse'>일지정지</span>";			}
			if(getDateDiff($now, $strPoStartDTText) < 0) { $strPoUseText = "<span class='icoSta'>진행전</span>";			}
			if(getDateDiff($now, $strPoEndDTText)   > 0) { $strPoUseText = "<span class='icoEnd'>진행완료</span>";			}

			## 이미지
			$imgFileText					= "/upload/images/no-image01.png";
			if($strPoFile):
				$imgFileText				= "{$webFolder}{$strPoFile}";
			endif;
		?>
		<tr>
			<td>
				
				<?if($imgFileText):?>
					<a href="<?=$strPoLinkText?>"><img src="<?=$imgFileText?>" style="width:200px;"></a>
				<?endif;?>
				<ul>
					<li><?=$strPoUseText?></li>
					<li>사용언어: <?=$strPoLangText?></li>
					<li>팝업종류: <?=$strPoStyleText?></li>
					<!-- {{ 2015.03.18 bdcho ;팝업 구분(웹/모바일) 추가 -->
					<li>팝업구분: <?=$strPoSection?></li>
					<!-- }} 2015.03.18 bdcho ;팝업 구분(웹/모바일) 추가 -->
					<!-- li>링크주소: <?=$strPoLinkText?></li -->
					<li>링크열기: <?=$strPoLinkTypeText?></li>
					<li>위치: <?=$strPositionText?></li>
					<li>제목: <?=$strPoTitleText?></li>
					<li>시작일: <?=$strPoStartDTText?></li>
					<li>종료일: <?=$strPoEndDTText?></li>
				</ul>
				
				
				<a href="javascript:goOper2PopupModifyMoveEvent('<?=$intPoNoText?>')" class="btn_sml"><span>수정</span></a>
				<a href="javascript:goOper2PopupDeleteActEvent('<?=$intPoNoText?>')" class="btn_sml"><span>삭제</span></a>
			</td>
		</tr>
		<?endwhile;?>
		<?php endif;?>
	</table>
</div>

<div class="paginate mt20">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:goOper2PopupWriteMoveEvent();"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00028"] //팝업추가?></strong></a>
</div>