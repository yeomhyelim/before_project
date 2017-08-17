<? if($S_PG_ESCROW  != "N") : ?>
        <!-- 에스크로 팝업 -->
        <script language="JavaScript">
                function go_check()
                {
                        var status  = "width=500 height=450 menubar=no,scrollbars=no,resizable=no,status=no";
                        var obj     = window.open('', 'kcp_pop', status);

                        document.form.method = "post";
                        document.form.target = "kcp_pop";
                        document.form.action = "http://admin.kcp.co.kr/Modules/escrow/kcp_pop.jsp";
                        document.form.submit();
                }
        </script>

        <input type="hidden" name="site_cd" value="<?php echo $S_PG_SITE_CODE;?>">
        <a href="javascript:go_check();"><img src="/upload/images/img_escrow.gif"></a>

<? endif; ?>