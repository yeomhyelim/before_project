<?
	## 설정
	$tab			= $_REQUEST['tab']; 
	$memberNo		= $_REQUEST['memberNo'];

?>
<div class="crmNavi">
	<ul>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberModify&memberNo=<?=$memberNo?>"<?if($tab == "memberModify") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00173"] //기본정보?></a></li>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo=<?=$memberNo?>"<?if($tab == "memberOrderList") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00174"] //주문내역?></a></li>
		<!--li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberCouponList&memberNo=<?=$memberNo?>"<?if($tab == "memberCouponList") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00175"] //쿠폰?></a></li>-->
		<!--li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberPointList&memberNo=<?=$memberNo?>"<?if($tab == "memberPointList") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00176"] //포인트?></a></li>-->
		<?if($a_admin_type != "S"){//입점몰은 숨김 남덕희?>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberQnaList&memberNo=<?=$memberNo?>"<?if($tab == "") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00177"] //1:1게시판?></a></li>
		<?}?>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberProdQnaList&memberNo=<?=$memberNo?>"<?if($tab == "") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00178"] //상품문의?></a></li>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberProdReportList&memberNo=<?=$memberNo?>"<?if($tab == "memberProdReportList") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00179"] //관리자상담관리?></a></li>
		<?if($a_admin_type != "S"){//입점몰은 숨김 남덕희?>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberSmsSend&memberNo=<?=$memberNo?>" <?if($tab == "memberSmsSend") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00180"] //SMS 전송?></a></li>
		<li><a href="./?menuType=member&mode=popMemberCrmView&tab=memberMailSend&memberNo=<?=$memberNo?>" <?if($tab == "memberMailSend") { echo "class='selected'"; }?>><?=$LNG_TRANS_CHAR["MW00181"] //이메일 전송?></a></li>
		<?}?>
		<!-- li><a href="#"><?=$LNG_TRANS_CHAR["MW00182"] //쪽지전송?></a></li -->
	</ul>
</div>


<!-- li><a href="">회원상세정보</a></li>
<li><a href="">주문내역</a></li>
<li><a href="">적립금내역</a></li>
<li><a href="">쿠폰내역</a></li>
<li><a href="">1:1문의 내역</a></li>
<li><a href="">게시글내역</a></li>
<li><a href="">회원SMS전송관리</a></li -->
						