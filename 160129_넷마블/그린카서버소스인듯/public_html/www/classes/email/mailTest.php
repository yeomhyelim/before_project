TEST
<?php
#��� �������
error_reporting(E_ALL);
ini_set("display_errors", 1);

// autoload
require 'PHPMailerAutoload.php' ;

class EmailInfo extends PHPMailer {



    function __construct () {
        parent::__construct () ;
    }

    function goSendEmail ( $param ) {

        ## �⺻ ����

        $this->isMail();                                      // Set mailer to use php's mail\

        $this->setFrom($param['SEND_EMAIL'], $param['SEND_NAME']);
        $this->addReplyTo ( $param['SEND_EMAIL'] , $param['SEND_NAME'] ) ;
        $this->addAddress ( $param['RECEIVE_EMAIL'] , $param['RECEIVE_NAME'] ) ;
        $this->Subject		= $param['TITLE'] ;
        $this->Body			= $param['TEXT'] ;
        $this->AltBody		= $param['TEXT'] ;


        echo 'goSend';
        print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
        //print_r($param);
        if ( ! $this->send () )
            return false;
        else
            return true ;
    }


}


$param['SEND_NAME'] = "���������";
$param['SEND_EMAIL'] = 'webmaster@dynesoze.co.kr';
$param['RECEIVE_NAME'] = '�޴»��';
//$param['RECEIVE_EMAIL'] = 'dhnam@dynesoze.co.kr';
$param['RECEIVE_EMAIL'] = 'timan1802@gmail.com';
$param['TITLE'] = '����';
$param['TEXT'] = '����';


$objEmailInfo							= new EmailInfo();

if($objEmailInfo->goSendEmail ( $param )){
    echo 'ok';
}else {
    echo 'nn';
}

?>