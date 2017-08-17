<form id="orderStatusChange" action="./" method="post">
    <input type="hidden" name="orderSettleStatus" value="A"> <!-- 결제완료 -->
    <input type="hidden" name="menuType" value="order">
    <input type="hidden" name="mode" value="act">
    <input type="hidden" name="act" value="orderSettleStatus">
    <input type="hidden" name="" value="">
<?php
//호출 URL
//http://localhost/shopAdmin/?menuType=order&mode=orderStatusChange

#crontab 설정
#24 2 * * * wget -q -O - 'http://fingbook.com/shopAdmin/?menuType=order&mode=orderStatusChange&cronKey=ejrgml1802' >> /tmp/tmp_orderStatusChange
#www/web/shopAdmin/include/adminCheck.php 에서 cronKey로 login 체크 우회


//echo 'ndh';
mysql_connect("localhost", "webbania_mall2", "dndwls9123!") or
die("Could not connect: " . mysql_error());
mysql_select_db("webbania_mall2");


$query_result = mysql_query("
SELECT *
FROM ORDER_MGR
WHERE O_STATUS = 'D' #배송완료
AND O_REG_DT > date_sub(now(), interval 7 day)
");

$i = 0;
while ($row = mysql_fetch_array($query_result)) {
?>
<input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[O_NO]?>" checked="checked"><?=$row[O_J_NAME]?> : <?=$row[O_J_TITLE]?> : <?=$row[O_KEY]?> <br>
<?
    $i++;
//    printf("ID: %s  Name: %s", $row[0], $row[1]);
}
mysql_free_result($query_result);
?>

</form>

<script>
    /* [입금확인전] 결제상태변경 */
    function goOrderSettleStatusUpdate(no)
    {
//        //결제상태를 [결제완료]로 변경하시겠습니까?
//        if (!confirm("결제상태를 [결제완료]로 변경하시겠습니까?")) {
//            return;
//        }

        var aryCnt	= (parseInt("50") * 4) + 5;
        var data	= new Array(aryCnt);
        var intCnt	= 0;

       // data		= goSearchDataSet(data);

        if (!no)
        {
            $("input[id^=chkNo]").each(function() {
                if($(this).attr("checked")=="checked") {
                    data["chkNo["+intCnt+"]"]	= $(this).val();
                    intCnt++;
                }
            });
        } else {
            data["chkNo["+intCnt+"]"]	= no;
            intCnt++;
        }

        if (intCnt == 0)
        {
            alert("변경하실 주문정보를 선택 해주세요."); //변경하실 주문정보를 선택 해주세요.
            return;
        }

        data['orderSettleStatus']	= "A";
        data['menuType']			= "order";
        data['mode']				= "act";
        data['act']					= "orderSettleStatus";
       // data['page']				= $("input[name=page]").val();

        C_getSelfAction(data);
    }



 //   form.submit();

 $(function() {
     // Handler for .ready() called.
     //$( "#orderStatusChange" ).trigger( "submit" );
     goOrderSettleStatusUpdate(0);
 });


</script>