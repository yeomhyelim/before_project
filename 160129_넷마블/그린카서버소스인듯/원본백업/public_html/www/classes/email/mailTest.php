TEST
<?php
#모든 에러출력
error_reporting(E_ALL);
ini_set("display_errors", 1);

// autoload
require 'PHPMailerAutoload.php' ;

class EmailInfo extends PHPMailer {



    function __construct () {
        parent::__construct () ;
    }

    function goSendEmail ( $param ) {

        ## 기본 설정

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


$param['SEND_NAME'] = "보내느사람";
$param['SEND_EMAIL'] = 'webmaster@dynesoze.co.kr';
$param['RECEIVE_NAME'] = '받는사람';
//$param['RECEIVE_EMAIL'] = 'dhnam@dynesoze.co.kr';
$param['RECEIVE_EMAIL'] = 'timan1802@gmail.com';
$param['TITLE'] = '제목';
$param['TEXT'] = '내용';


$objEmailInfo							= new EmailInfo();

if($objEmailInfo->goSendEmail ( $param )){
    echo 'ok';
}else {
    echo 'nn';
}

?>