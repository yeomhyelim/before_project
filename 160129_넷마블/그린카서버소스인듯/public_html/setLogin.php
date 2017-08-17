<?php
$deviceToken = 'b09da1c10fe8d1000b9351406e7944c9832f84618dabd416de5921965dc364ac'; // 앱실행후 로그로 찍힌 디바이스 토큰 정보 입력
#$message = '토큰값만 있어도 전송이 잘되나요?';
$message = 'hello?';
$badge = 1;
$sound = '';

// Payload 작성 (JSON)
$body = array();
$body['aps'] = array('alert' => $message);
if ($badge)
    $body['aps']['badge'] = $badge;
if ($sound)
    $body['aps']['sound'] = $sound;

// 애플 APNS서버와 인증서를 이용해 소켓 통신
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/cesces/pushTest/SnTec.pem');
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

// 실제 배포시 ssl://gateway.push.apple.com:2195 로 변경해야함
if (!$fp) {
    print "Failed to connect $err $errstr\n";
    return;
}
else {
    print "Connection OK\n";
}

// 배열을 json으로 변경
$payload = json_encode($body);
$msg = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n",strlen($payload)) . $payload;
print "Sending message :" . $payload . "\n";
fwrite($fp, $msg);
fclose($fp);
?>