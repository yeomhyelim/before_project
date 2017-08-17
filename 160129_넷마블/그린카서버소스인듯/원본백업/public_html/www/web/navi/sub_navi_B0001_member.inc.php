<?if (!$g_member_no){?>
<div class="subNaviWrap">
		<div class="title"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_title_menbership.gif"/></div>
		<ul>
			<li><a href="./?menuType=member&mode=login"><?=$LNG_TRANS_CHAR["MW00036"] //로그인?></a></li>
			<li><a href="./?menuType=member&mode=join1"><?=$LNG_TRANS_CHAR["MW00053"] //회원가입?></a></li>
			<li><a href="./?menuType=member&mode=findIdPwd"><?=$LNG_TRANS_CHAR["MW00038"] //아이디ㆍ비밀번호찾기?></a></li>
			<li><a href="./?menuType=order&mode=buyList"><?=$LNG_TRANS_CHAR["MW00048"] //마이페이지?></a></li>
		</ul>
</div>
<?}?>