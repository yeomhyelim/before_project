
		<?php
				## 기본 설정
				$isNotifyTag = false;
				$isDetailTag = true;
				$isReviewTag = true;
				$isQnaTag = true;
				$isDeliveryTag = true;
				$isReview2Tag =true;
				if($S_PRODUCT_BBS_REVIEW_USE != "Y") { $isReviewTag = false; }
				if($S_PRODUCT_BBS_QNA_USE != "Y") { $isQnaTag = false; }
				if($S_PRODVIEW_REVIE2_SHOW != "Y") { $isReview2Tag = false; }

				## 체크
				## $select = detail, review, qna, delivery
				if(!$select) { return; }

				## 모듈설정
				$objBoardDataModule = new BoardDataModule($db);

				## 언어설정
				$strLang = $_GET['lang'];
				if(!$strLang) { $strLang = $S_SITE_LNG; }

				## 상품 고시 사용유무 설정
				if(!$arrProdNotifyInfo){ $isNotifyTag = false; }
			?>

			<div class="tabBox">
					<a href="#;" onclick="C_getTabChange('prodDetail','1')" id="btn-prodDetail1" class="on btn1"><?php echo $LNG_TRANS_CHAR["OW00001"]; //상세정보?></a> |
					<a href="#;" onclick="C_getTabChange('prodDetail','2')" id="btn-prodDetail2" class="btn2"><?php echo $LNG_TRANS_CHAR["CW00032"]; //배송&교환반품안내?></a>		
			</div>