<?php
$deviceToken = 'b09da1c10fe8d1000b9351406e7944c9832f84618dabd416de5921965dc364ac'; // �۽����� �α׷� ���� ����̽� ��ū ���� �Է�
#$message = '��ū���� �־ ������ �ߵǳ���?';
$message = 'hello?';
$badge = 1;
$sound = '';

// Payload �ۼ� (JSON)
$body = array();
$body['aps'] = array('alert' => $message);
if ($badge)
    $body['aps']['badge'] = $badge;
if ($sound)
    $body['aps']['sound'] = $sound;

// ���� APNS������ �������� �̿��� ���� ���
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/cesces/pushTest/SnTec.pem');
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

// ���� ������ ssl://gateway.push.apple.com:2195 �� �����ؾ���
if (!$fp) {
    print "Failed to connect $err $errstr\n";
    return;
}
else {
    print "Connection OK\n";
}

// �迭�� json���� ����
$payload = json_encode($body);
$msg = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n",strlen($payload)) . $payload;
print "Sending message :" . $payload . "\n";
fwrite($fp, $msg);
fclose($fp);
?>