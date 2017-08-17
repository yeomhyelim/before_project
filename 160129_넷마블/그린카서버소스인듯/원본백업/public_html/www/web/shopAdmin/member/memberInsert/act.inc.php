<?
	
	require_once MALL_CONF_LIB."MemberMgr.php";	
	require_once MALL_CONF_LIB."CouponMgr.php";

	$memberMgr = new MemberMgr();
	$couponMgr = new CouponMgr();
	
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/* Join Form */
	$strM_ID		= $_POST["id"]				? $_POST["id"]				: $_REQUEST["id"];
	$strM_PASS		= $_POST["pwd1"]			? $_POST["pwd1"]			: $_REQUEST["pwd1"];
	$strM_NAME		= $_POST["name"]			? $_POST["name"]			: $_REQUEST["name"];
	$strM_F_NAME	= $_POST["f_name"]			? $_POST["f_name"]			: $_REQUEST["f_name"];
	$strM_L_NAME	= $_POST["l_name"]			? $_POST["l_name"]			: $_REQUEST["l_name"];

	$strM_NICK_NAME = $_POST["nickname"]		? $_POST["nickname"]		: $_REQUEST["nickname"];
	
	$strM_BIRTH1	= $_POST["birth1"]			? $_POST["birth1"]			: $_REQUEST["birth1"];
	$strM_BIRTH2	= $_POST["birth2"]			? $_POST["birth2"]			: $_REQUEST["birth2"];
	$strM_BIRTH3	= $_POST["birth3"]			? $_POST["birth3"]			: $_REQUEST["birth3"];
	$strM_BIRTH		= $strM_BIRTH1."-".$strM_BIRTH2."-".$strM_BIRTH3;

	$strM_SEX		= $_POST["sex"]				? $_POST["sex"]				: $_REQUEST["sex"];
	$strM_MAIL		= $_POST["mail"]			? $_POST["mail"]			: $_REQUEST["mail"];
	
	$strM_PHONE1	= $_POST["phone1"]			? $_POST["phone1"]			: $_REQUEST["phone1"];
	$strM_PHONE2	= $_POST["phone2"]			? $_POST["phone2"]			: $_REQUEST["phone2"];
	$strM_PHONE3	= $_POST["phone3"]			? $_POST["phone3"]			: $_REQUEST["phone3"];
	$strM_PHONE		= $strM_PHONE1;
	if ($strM_PHONE2) $strM_PHONE .= "-".$strM_PHONE2;
	if ($strM_PHONE3) $strM_PHONE .= "-".$strM_PHONE3;
	
	$strM_FAX1		= $_POST["fax1"]			? $_POST["fax1"]			: $_REQUEST["fax1"];
	$strM_FAX2		= $_POST["fax2"]			? $_POST["fax2"]			: $_REQUEST["fax2"];
	$strM_FAX3		= $_POST["fax3"]			? $_POST["fax3"]			: $_REQUEST["fax3"];
	$strM_FAX		= $strM_FAX1;
	if ($strM_FAX2) $strM_FAX .= "-".$strM_FAX2;
	if ($strM_FAX3) $strM_FAX .= "-".$strM_FAX3;
		
	$strM_HP1		= $_POST["hp1"]				? $_POST["hp1"]				: $_REQUEST["hp1"];
	$strM_HP2		= $_POST["hp2"]				? $_POST["hp2"]				: $_REQUEST["hp2"];
	$strM_HP3		= $_POST["hp3"]				? $_POST["hp3"]				: $_REQUEST["hp3"];
	$strM_HP		= $strM_HP1;
	if ($strM_HP2) $strM_HP .= "-".$strM_HP2;
	if ($strM_HP3) $strM_HP .= "-".$strM_HP3;
	
	$strM_ZIP1		= $_POST["zip1"]			? $_POST["zip1"]			: $_REQUEST["zip1"];
	$strM_ZIP2		= $_POST["zip2"]			? $_POST["zip2"]			: $_REQUEST["zip2"];
	$strM_ZIP		= $strM_ZIP1;
	if ($strM_ZIP2) $strM_ZIP .= "-".$strM_ZIP2;
	
	$strM_ADDR		= $_POST["addr1"]			? $_POST["addr1"]			: $_REQUEST["addr1"];
	$strM_ADDR2		= $_POST["addr2"]			? $_POST["addr2"]			: $_REQUEST["addr2"];
	$strM_SMSYN		= $_POST["smsYN"]			? $_POST["smsYN"]			: $_REQUEST["smsYN"];
	$strM_MAILYN	= $_POST["mailYN"]			? $_POST["mailYN"]			: $_REQUEST["mailYN"];
	$strM_TEXT		= $_POST["memo"]			? $_POST["memo"]			: $_REQUEST["memo"];
	$strM_REC_ID	= $_POST["rec_id"]			? $_POST["rec_id"]			: $_REQUEST["rec_id"];
	
	$strM_WED		= $_POST["weddingYN"]		? $_POST["weddingYN"]		: $_REQUEST["weddingYN"];
	$strM_WED_DAY1	= $_POST["weddingDay1"]		? $_POST["weddingDay1"]		: $_REQUEST["weddingDay1"];
	$strM_WED_DAY2	= $_POST["weddingDay2"]		? $_POST["weddingDay2"]		: $_REQUEST["weddingDay2"];
	$strM_WED_DAY3	= $_POST["weddingDay3"]		? $_POST["weddingDay3"]		: $_REQUEST["weddingDay3"];
	$strM_WED_DAY	= $strM_WED_DAY1."-".$strM_WED_DAY2."-".$strM_WED_DAY3;
	
	$strM_JOB			= $_POST["job"]				? $_POST["job"]				: $_REQUEST["job"];
	$strM_CONCERN		= $_POST["concern"]			? $_POST["concern"]			: $_REQUEST["concern"];
	$strM_CHILD			= $_POST["child"]			? $_POST["child"]			: $_REQUEST["child"];	
	$strM_COM_NM		= $_POST["com_nm"]			? $_POST["com_nm"]			: $_REQUEST["com_nm"];
	
	$strM_BUSI_NM		= $_POST["busi_nm"]			? $_POST["busi_nm"]			: $_REQUEST["busi_nm"];
	
	$strM_BUSI_NUM1		= $_POST["busi_num1"]		? $_POST["busi_num1"]		: $_REQUEST["busi_num1"];
	$strM_BUSI_NUM2		= $_POST["busi_num2"]		? $_POST["busi_num2"]		: $_REQUEST["busi_num2"];
	$strM_BUSI_NUM3		= $_POST["busi_num3"]		? $_POST["busi_num3"]		: $_REQUEST["busi_num3"];
	$strM_BUSI_NUM		= $strM_BUSI_NUM1;
	if ($strM_BUSI_NUM2) $strM_BUSI_NUM .= "-".$strM_BUSI_NUM2;
	if ($strM_BUSI_NUM3) $strM_BUSI_NUM .= "-".$strM_BUSI_NUM3;
	
	$strM_BUSI_UPJ		= $_POST["busi_upj"]		? $_POST["busi_upj"]		: $_REQUEST["busi_upj"];
	$strM_BUSI_UTE		= $_POST["busi_ute"]		? $_POST["busi_ute"]		: $_REQUEST["busi_ute"];
	
	$strM_BUSI_ZIP1		= $_POST["busi_zip1"]		? $_POST["busi_zip1"]		: $_REQUEST["busi_zip1"];
	$strM_BUSI_ZIP2		= $_POST["busi_zip2"]		? $_POST["busi_zip2"]		: $_REQUEST["busi_zip2"];
	$strM_BUSI_ZIP		= $strM_BUSI_ZIP1;
	if ($strM_BUSI_ZIP2) $strM_BUSI_ZIP .= "-".$strM_BUSI_ZIP2;
	$strM_BUSI_ADDR1 = $_POST["busi_addr1"]		? $_POST["busi_addr1"]			: $_REQUEST["busi_addr1"];
	$strM_BUSI_ADDR2 = $_POST["busi_addr2"]		? $_POST["busi_addr2"]			: $_REQUEST["busi_addr2"];
		
	$strM_FOREIGN		= $_POST["foreign"]			? $_POST["foreign"]			: $_REQUEST["foreign"];
	$strM_FOREIGN_NUM	= $_POST["foreign_num"]		? $_POST["foreign_num"]		: $_REQUEST["foreign_num"];
	$strM_PASSPORT		= $_POST["passport"]		? $_POST["passport"]		: $_REQUEST["passport"];
	$strM_DRIVE_NUM		= $_POST["drive_num"]		? $_POST["drive_num"]		: $_REQUEST["drive_num"];
	$strM_NATION		= $_POST["nation"]			? $_POST["nation"]			: $_REQUEST["nation"];
	
	$strM_TMP1			= $_POST["tmp1"]			? $_POST["tmp1"]			: $_REQUEST["tmp1"];
	$strM_TMP2			= $_POST["tmp2"]			? $_POST["tmp2"]			: $_REQUEST["tmp2"];
	$strM_TMP3			= $_POST["tmp3"]			? $_POST["tmp3"]			: $_REQUEST["tmp3"];
	$strM_TMP4			= $_POST["tmp4"]			? $_POST["tmp4"]			: $_REQUEST["tmp4"];
	$strM_TMP5			= $_POST["tmp5"]			? $_POST["tmp5"]			: $_REQUEST["tmp5"];

	$strM_COUNTRY	= $_POST["country"]			? $_POST["country"]			: $_REQUEST["country"];
	$strM_CITY		= $_POST["city"]			? $_POST["city"]			: $_REQUEST["city"];
	$strM_STATE1	= $_POST["state_1"]			? $_POST["state_1"]			: $_REQUEST["state_1"];
	$strM_STATE2	= $_POST["state_2"]			? $_POST["state_2"]			: $_REQUEST["state_2"];
	$strM_STATE		= $strM_STATE1;

	$strM_GROUP		= $_POST["memberGroup"]				? $_POST["memberGroup"]				: $_REQUEST["memberGroup"];

	if ($strM_COUNTRY == "US") $strM_STATE = $strM_STATE2;

	if (!$strM_SMSYN) $strM_SMSYN = "N";
	if (!$strM_MAILYN) $strM_MAILYN = "N";
	/* Join Form */

	$memberMgr->setM_ID($strM_ID);
	$memberMgr->setM_PASS($strM_PASS);
	$memberMgr->setM_F_NAME($strM_F_NAME);
	$memberMgr->setM_L_NAME($strM_L_NAME);
	$memberMgr->setM_NICK_NAME($strM_NICK_NAME);
	$memberMgr->setM_BIRTH($strM_BIRTH);
	$memberMgr->setM_SEX($strM_SEX);
	$memberMgr->setM_MAIL($strM_MAIL);
	$memberMgr->setM_PHONE($strM_PHONE);
	$memberMgr->setM_HP($strM_HP);
	$memberMgr->setM_WED_DAY($strM_WED_DAY);
	$memberMgr->setM_WED($strM_WED);
	$memberMgr->setM_ZIP($strM_ZIP);
	$memberMgr->setM_ADDR($strM_ADDR);
	$memberMgr->setM_ADDR2($strM_ADDR2);
	$memberMgr->setM_SMSYN($strM_SMSYN);
	$memberMgr->setM_MAILYN($strM_MAILYN);
	$memberMgr->setM_TEXT($strM_TEXT);
	$memberMgr->setM_REC_ID($strM_REC_ID);
	$memberMgr->setM_CONCERN($strM_CONCERN);
	$memberMgr->setM_JOB($strM_JOB);
	$memberMgr->setM_FAX($strM_FAX);
	$memberMgr->setM_COUNTRY($strM_COUNTRY);
	$memberMgr->setM_CITY($strM_CITY);
	$memberMgr->setM_STATE($strM_STATE);
	$memberMgr->setM_AUTH("Y");

	$memberMgr->setM_CHILD($strM_CHILD);
	$memberMgr->setM_COM_NM($strM_COM_NM);
	$memberMgr->setM_BUSI_NM($strM_BUSI_NM);
	$memberMgr->setM_BUSI_NUM($strM_BUSI_NUM);
	$memberMgr->setM_BUSI_UPJ($strM_BUSI_UPJ);
	$memberMgr->setM_BUSI_UTE($strM_BUSI_UTE);
	$memberMgr->setM_BUSI_ZIP($strM_BUSI_ZIP);
	$memberMgr->setM_BUSI_ADDR1($strM_BUSI_ADDR1);
	$memberMgr->setM_BUSI_ADDR2($strM_BUSI_ADDR2);
	$memberMgr->setM_FOREIGN($strM_FOREIGN);
	$memberMgr->setM_FOREIGN_NUM($strM_FOREIGN_NUM);
	$memberMgr->setM_PASSPORT($strM_PASSPORT);
	$memberMgr->setM_DRIVE_NUM($strM_DRIVE_NUM);
	$memberMgr->setM_NATION($strM_NATION);
	$memberMgr->setM_PHOTO($strM_PHOTO);
	$memberMgr->setM_TMP1($strM_TMP1);
	$memberMgr->setM_TMP2($strM_TMP2);
	$memberMgr->setM_TMP3($strM_TMP3);
	$memberMgr->setM_TMP4($strM_TMP4);
	$memberMgr->setM_TMP5($strM_TMP5);

			
	switch ($strAct) {

		case "memberWrite":
			
			$settingRow = $memberMgr->getSettingView($db);

			if ($S_MEM_CERITY == "1"){
				$intCount = $memberMgr->getMemberIdCheck($db);
				if ($intCount > 0){
					goErrMsg($LNG_TRANS_CHAR['MS00024']); //"중복된 아이디가 존재합니다."
					exit;
				}

				if ($S_JOIN_NICK_NAME_USE == "Y"){
					$intCount = $memberMgr->getMemberNickNameCheck($db);
					if ($intCount > 0){
						goErrMsg($LNG_TRANS_CHAR["MS00025"]); //"중복된 닉네임이 존재합니다."
						exit;
					}
				}

				/* 불가 ID 체크*/
				$aryRegNoIdList = explode(",",$settingRow[J_NO_ID]);
				for($i=0;$i<sizeof($aryRegNoIdList);$i++){
					if ($aryRegNoIdList[$i] == $strM_ID){
						goErrMsg($LNG_TRANS_CHAR['MS00026']); //"등록할 수 없는 아이디입니다."
						break;
						exit;
					}
				}
			}
			
			/* 이메일 중복 체크 */
			$intCount = $memberMgr->getMemberMailCheck($db);
			if ($intCount > 0){
				goErrMsg($LNG_TRANS_CHAR["MS00027"]);
				exit;
			}

			/* 가입시 회원그룹 */
			if ($strM_GROUP) $memberMgr->setM_GROUP($strM_GROUP); 
			else $memberMgr->setM_GROUP($settingRow[J_GROUP]);

			/* 추천인 확인 */
			if ($strM_REC_ID){
				$memberMgr->setM_REC_ID("");
			}

			$memberMgr->getMemberInsert($db);
			$intM_NO = $db->getLastInsertID();
			$memberMgr->setM_NO($intM_NO);

			/* 사진 업로드 */
			$strMemberPhotoPath = "../upload/member";
			if ($_FILES["photo"][name]){
		
				if (!getAllowImgFileExt($_FILES["photo"][name])){
					$memberMgr->setM_PHOTO("");
				} else {
				
					$strFileName	= $_FILES["photo"][name];
					$strFileTmpName = $_FILES["photo"][tmp_name];
					$intFileSize	= $_FILES["photo"][size];
					$strFileType	= $_FILES["photo"][type];

					$fres = $fh->doUpload("photo_".$intM_NO,"../".$strMemberPhotoPath,$strFileName,$strFileTmpName,$intFileSize,$strFileType);

					if($fres) {
						$memberMgr->setM_PHOTO($fres[file_real_name]);
					} 
				}
			}
			/* 사진 업로드 */
			$memberMgr->getMemberAddInsert($db);
			

			/* 가입시 포인트 확인*/
			if ($settingRow[J_POINT] > 0){
				$memberMgr->setM_NO($intM_NO);	
				$memberMgr->setM_POINT($settingRow[J_POINT]);
				$memberMgr->getMemberPointUpdate($db);
				
				/* 포인트 관리 데이터 INSERT */
				$memberMgr->setM_NO($intM_NO);
				$memberMgr->setB_NO(0);
				$memberMgr->setO_NO(0);
				$memberMgr->setPT_TYPE('004');
				$memberMgr->setPT_POINT($memberMgr->getM_POINT());
				$memberMgr->setPT_MEMO($LNG_TRANS_CHAR["MW00238"]); //회원가입포인트
				$memberMgr->setPT_START_DT(date("Y-m-d"));
				$memberMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
				$memberMgr->setPT_REG_IP($S_REOMTE_ADDR);
				$memberMgr->setPT_ETC($intRecNo);
				$memberMgr->setPT_REG_NO(1);
				$memberMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);
				$memberMgr->getMemberPointInsert($db);
			}
			
			/* 추천인 포인트 지급 */
			if ($strM_REC_ID){
				$memberMgr->setM_ID("");
				$memberMgr->setM_MAIL("");
				
				if ($S_MEM_CERITY == "1"){
					$memberMgr->setM_ID($strM_REC_ID);
				} else {
					$memberMgr->setM_MAIL($strM_REC_ID);
				}
				$intRecNo = $memberMgr->getMemberRecNo($db);

				if ($intRecNo > 0) {
					
					/*추천인 M_NO UPDATE */
					$memberMgr->setM_REC_ID($intRecNo);
					$memberMgr->getMemberRecNoUpdate($db);

					/* 신규 가입회원 포인트 지급 */
					if ($settingRow[J_REC_POINT1] > 0){
						$memberMgr->setM_NO($intM_NO);	
						$memberMgr->setM_POINT($settingRow[J_REC_POINT1]);
						$memberMgr->getMemberPointUpdate($db);
						
						/* 포인트 관리 데이터 INSERT */
						$memberMgr->setM_NO($intM_NO);
						$memberMgr->setB_NO(0);
						$memberMgr->setO_NO(0);
						$memberMgr->setPT_TYPE('004');
						$memberMgr->setPT_POINT($memberMgr->getM_POINT());
						$memberMgr->setPT_MEMO($LNG_TRANS_CHAR["MW00239"]); //회원가입[추천인]
						$memberMgr->setPT_START_DT(date("Y-m-d"));
						$memberMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
						$memberMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$memberMgr->setPT_ETC($intRecNo);
						$memberMgr->setPT_REG_NO(1);
						$memberMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);
						$memberMgr->getMemberPointInsert($db);
					}
					
					/* 추천인 포인트 지급 */
					if ($settingRow[J_REC_POINT2] > 0){
						$memberMgr->setM_NO($intRecNo);	
						$memberMgr->setM_POINT($settingRow[J_REC_POINT2]);
						$memberMgr->getMemberPointUpdate($db);
						
						/* 포인트 관리 데이터 INSERT */
						$memberMgr->setM_NO($intRecNo);
						$memberMgr->setO_NO(0);
						$memberMgr->setB_NO(0);
						$memberMgr->setPT_TYPE('004');
						$memberMgr->setPT_POINT($memberMgr->getM_POINT());
						$memberMgr->setPT_MEMO($LNG_TRANS_CHAR["MW00240"]); //추천인[회원가입]
						$memberMgr->setPT_START_DT(date("Y-m-d"));
						$memberMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
						$memberMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$memberMgr->setPT_ETC($intM_NO);
						$memberMgr->setPT_REG_NO(1);
						$memberMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);
						$memberMgr->getMemberPointInsert($db);
					}
				}
			}
			
			/* 회원가입쿠폰발급 */
			if ($intM_NO > 0){
				$couponMgr->setSearchCouponIssue("3");
				$couponMgr->setSearchCouponUse("Y");			
				$intCouponTotal = $couponMgr->getCouponTotal($db);
				$couponMgr->setLimitFirst(0);
				$couponMgr->setPageLine($intCouponTotal);
				
				if ($intCouponTotal > 0){
					$couponRet = $couponMgr->getCouponList($db);
					while($couponRow = mysql_fetch_array($couponRet)){
						$couponMgr->setCU_NO($couponRow[CU_NO]);

						$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
						$couponMgr->setCI_CODE($strCouponCode);
						$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
						if ($intDupCnt > 0){
							$strFlag = false;

							while($strFlag == false){

								$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
								$couponMgr->setCI_CODE($strCouponCode);
								$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
								
								if($intDupKeyCnt=="0"){
									$strFlag = true;
									break;
								}
							}
						}
						
						$couponMgr->setM_NO($intM_NO);
						$couponMgr->setCI_REG_NO($intM_NO);
						$couponMgr->getIssueInsert($db);
					}
				}
			}

			/** 사용언어 */
			$memberMgr->setM_LNG($S_SITE_LNG);
			$memberMgr->getMemberLngUpdate($db);
			/** 사용언어 */
			
			/** 소속 INSERT */
			if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
		
				## 회원 카테고리 코드 설정
				$c_code		= "";
				if($_POST['c_cate_1']) { $c_code = $_POST['c_cate_1']; }
				if($_POST['c_cate_2']) { $c_code = $_POST['c_cate_2']; }
				if($_POST['c_cate_3']) { $c_code = $_POST['c_cate_3']; }
				if($_POST['c_cate_4']) { $c_code = $_POST['c_cate_4']; }
				
				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();

				## insert
				$param					= "";
				$param['C_CODE']		= $c_code;
				$param['M_NO']			= $intM_NO;
				$memberCateMgr->getMemberCateJoinInsertEx($db, $param);

				if (strlen($c_code) == 6){
					$param				= "";
					$param['C_CODE']	= $c_code;
					$param['C_LEVEL']	= 3;
					$c_low_code			= $memberCateMgr->getMemberCateHighLowListEx($db,$param);

					if ($c_low_code){
						$param					= "";
						$param['C_CODE']		= $c_low_code;
						$param['M_NO']			= $intM_NO;
						$memberCateMgr->getMemberCateJoinInsertEx($db, $param);
					}
				}
			}
			/** 소속 INSERT */

			$strUrl = "./?menuType=".$strMenuType."&mode=memberInsertWrite";

		break;
	}

?>