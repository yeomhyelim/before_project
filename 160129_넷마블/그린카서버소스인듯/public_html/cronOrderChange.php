<!DOCTYPE html>
<head>
    <title>:: Admin ::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <?php
    require_once "./config.inc.php";
    require_once "./conf/shop.inc.php";
    require_once "./conf/site_skin.conf.inc.php";

    require_once MALL_CONF_MYSQL;
    require_once MALL_CONF_FILE;
    require_once MALL_COMM_LIB;
    require_once MALL_CONF_TBL;
    require_once MALL_CONF_SESS;
    require_once MALL_CONF_COOKIE;

    $db->connect();
    include_once(__DIR__ . '/config/db_etc.php');
    /*
    include_once( __DIR__ .'/config/db_etc.php');
    require_once __DIR__."/www/module/MemberAdmMgr.php";
    require_once __DIR__."/www/module/OrderAdmMgr.php";
    require_once __DIR__."/www/module/ShopOrderNewMgr.php";
    */
    require_once MALL_CONF_LIB . "ProductMgr.php";
    require_once MALL_CONF_LIB . "OrderMgr.php";
    require_once MALL_CONF_LIB . "MemberMgr.php";
    require_once MALL_CONF_LIB . "SiteMgr.php";

    require_once MALL_SHOP . "/conf/order.inc.php";
    require_once MALL_CONF_LIB . "ShopOrderNewMgr.php";

    if (is_file(MALL_SHOP . "/conf/shop.manual.inc.php")):
        require_once MALL_SHOP . "/conf/shop.manual.inc.php";
    endif;


    $orderMgr = new OrderMgr();
    $shopOrderMgr = new ShopOrderMgr();
    $memberMgr = new MemberMgr();


    #모든 에러출력
    #error_reporting(E_ALL);
    #ini_set("display_errors", 1);

    //include_once( $_SERVER["DOCUMENT_ROOT"] .'/conf/shop.inc.php');
    //include_once( $_SERVER["DOCUMENT_ROOT"] .'/config/db_etc.php');


    //mysql_connect("$etc_db_host", "$etc_db_user", "$etc_db_pass") or
    //die("Could not connect: " . mysql_error());
    //mysql_select_db("$etc_db_name");


    $mysqli = new mysqli($etc_db_host, $etc_db_user, $etc_db_pass, $etc_db_name);

    // 연결 오류 발생 시 스크립트 종료
    if ($mysqli->connect_errno) {
        die('Connect Error: ' . $mysqli->connect_error);
    }


    /* Create table doesn't return a resultset */
    /* #배송완료(D) 상태를 $S_AUTO_ORDER_END 이상이면 구매완료로 변경 */
    //$query = "UPDATE ORDER_MGR SET O_STATUS = 'E'	WHERE  O_STATUS = 'D' 	AND O_REG_DT < date_sub(now(), interval  day);";

    #SELECT	O.*, CONCAT(IFNULL(M.M_F_NAME,''), CASE WHEN IFNULL(M.M_F_NAME,'') != '' THEN ' ' ELSE '' END, IFNULL(M.M_L_NAME,'')) M_NAME,M.M_ID,OC.*,OME.MEMO_CNT
    $shopAdminDeliveryListQuery = <<< EOF
SELECT	*
FROM (
SELECT	OC.O_NO	,OC.OC_NO, IFNULL(P.P_SHOP_NO,0) P_SHOP_NO	, COUNT(*) P_SHOP_CNT
FROM ORDER_CART OC
LEFT OUTER
JOIN PRODUCT_MGR P ON OC.P_CODE = P.P_CODE
WHERE OC.OC_NO IS NOT NULL AND SUBSTRING(IFNULL(OC.OC_ORDER_STATUS,''),1,1) NOT IN ('C','S','R','T','E')
    AND OC.OC_DELIVERY_STATUS = 'D' AND IFNULL(OC.OC_ORDER_STATUS,'') = '' AND OC.OC_DELIVERY_END_DT < DATE_SUB(NOW(), INTERVAL $S_AUTO_ORDER_END DAY)
GROUP BY OC.O_NO, IFNULL(P.P_SHOP_NO,0)	) OC
JOIN ORDER_MGR O ON OC.O_NO = O.O_NO
LEFT OUTER
JOIN MEMBER_MGR M ON O.M_NO = M.M_NO
LEFT OUTER
JOIN SHOP_ORDER SO ON OC.O_NO = SO.O_NO AND OC.P_SHOP_NO = SO.SH_NO
LEFT OUTER
JOIN (
SELECT IFNULL(AD_TEMP2,0) O_NO, COUNT(*) MEMO_CNT
FROM BOARD_AD_USER_REPORT
GROUP BY IFNULL(AD_TEMP2,0)) OME ON O.O_NO = OME.O_NO
WHERE OC.O_NO IS NOT NULL AND O.O_STATUS NOT IN ('F','W','C','R','T','J','O')
ORDER BY O.O_NO DESC
EOF;
    $a_admin_no = 1; //강제지정 master

    //echo $shopAdminDeliveryListQuery;exit;
    if ($shopAdminDeliveryListResult = $mysqli->query($shopAdminDeliveryListQuery)) {
        printf("query success\n");
        if ($shopAdminDeliveryListResult->num_rows == 0) echo '구매확정 할 주문이 없습니다.';


        while ($shopAdminDeliveryListRow = mysqli_fetch_object($shopAdminDeliveryListResult)) {

            $intOC_NO = $shopAdminDeliveryListRow->OC_NO;
            $param = array();
            $param['OC_NO'] = $intOC_NO;
            $param['OC_ORDER_STATUS'] = 'E';
            $param["OC_MOD_NO"] = $a_admin_no;

            ## 구매완료
            $param["OC_E_REG_DT"] = "Y";
            $re = $shopOrderMgr->getOrderCartStatusUpdate($db, $param);

            $intO_NO = $shopOrderMgr->getOrderNo($db, $param);
            $param['OC_REG_NO'] = $a_admin_no;
            $param['O_NO'] = $intO_NO;
            $aryOrderNoList[$key] = $intO_NO;

            ## 주문별 상태 UPDATE(마스터/입점사)
            if ($intO_NO > 0) {

//                $orderMgr->setO_NO($intO_NO);
//                $orderRow			= $orderMgr->getOrderView($db);
//                $strOrderPrevStatus	= $orderRow["O_STATUS"];
//
//                if (in_array($param['OC_ORDER_STATUS'],array("C1","S1","R1","T1"))){
//                    $param['OC_UPDATE_TYPE'] = "P";
//                }

                $re2 = $shopOrderMgr->getOrderStatusAllUpdate($db, $param);

                /* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
                //사용 안함
                //include MALL_WEB_PATH."shopAdmin/order/list_v2.0/orderMallStatusUpdate.php";
            }


            /* HISTORY INSERT */
//        $strOrderStatusMemo			= $_POST['orderStatusMemo'];
            $strOrderStatusMemo = "자동구매확정";
            $strOrderStatusText = $intOC_NO . "/" . $param['OC_ORDER_STATUS'];

            $param['m_no'] = $a_admin_no;
            $param['h_tab'] = TBL_ORDER_MGR;
            $param['h_key'] = $intO_NO;
            $param['h_code'] = "002"; //구매상태
            $param['h_memo'] = $strOrderStatusMemo;
            $param['h_text'] = $strOrderStatusText;
            $param['h_reg_no'] = $a_admin_no;
            $param['h_adm_no'] = $a_admin_no;
            $re3 = $shopOrderMgr->getOrderStatusHistoryUpdate($db, $param);
            /* HISTORY INSERT */

            echo $intOC_NO;
            echo PHP_EOL . '<br>';
            echo 'getOrderCartStatusUpdate :' . ($re == 1 ? 'OK' : 'NOT OK');
            echo 'getOrderStatusAllUpdate :' . ($re1 == 1 ? 'OK' : 'NOT OK');
            echo 'getOrderStatusHistoryUpdate :' . ($re3 == 1 ? 'OK' : 'NOT OK');
            echo PHP_EOL . '<br>';

        }

    } else {
        printf("failed\n");
        exit;
    }

    // 접속 종료
    $mysqli->close();

    ?>
