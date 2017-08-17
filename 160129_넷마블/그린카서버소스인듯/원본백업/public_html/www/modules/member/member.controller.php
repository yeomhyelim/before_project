<?php
    /**
     * /home/shop_eng/www/modules/member/member.controller.php
     * @author eumshop(thav@naver.com)
     * member controller class
     * **/

	require_once MALL_HOME . "/modules/controller.php";

    class  MemberController extends Controller {

		function getMessage() {
			echo "member controller class";
		}

		function getPointUpdateEx($param) {
			return $this->module->{"get{$this->name}PointUpdateEx"}($param);
		}

		function getPointUpdate() {
			return $this->module->{"get{$this->name}PointUpdate"}();
		}
    }
?>
