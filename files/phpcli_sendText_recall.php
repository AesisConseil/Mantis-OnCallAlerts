<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

include('../../../config_inc.php');
require_once("../api/RSA/Crypt/RSA.php");

try {
    $db = new PDO('mysql:host=' . $g_hostname . ';dbname=' . $g_database_name, $g_db_username, $g_db_password);
} catch (Exception $e) {
    die($e->getMessage());
}

$date = new \DateTime();
$date->add(new DateInterval('P1D'));

$d = $date->format('Y-m-d');

$query = $db->query("SELECT * "
        . "FROM `mantis_plugin_OnCallAlerts_oncall_table` AS o "
        . "LEFT JOIN `mantis_plugin_OnCallAlerts_technician_table` AS t ON o.technician_id = t.id "
        . "WHERE  DATE_FORMAT(  `start_date` ,  \"%Y-%m-%d\" )  = '$d' ");

$t_results = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $db->query("SELECT * "
        . "FROM `mantis_config_table` ");

$Rconfig = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($Rconfig as $c) {
    $cId = $c['config_id'];
    unset($c['config_id']);
    $config[$cId] = $c['value'];
}

foreach ($t_results as $r) {
    $rsa = new Crypt_RSA();
    $rsa->loadKey($config['plugin_OnCallAlerts_publickey_server_text']);
    $transactionID = $rsa->encrypt($config['plugin_OnCallAlerts_data_server_text']);

    $time = new \DateTime();
    $dStart = new \DateTime($r['start_date']);
    $dEnd = new \DateTime($r['end_date']);

    $msgText = str_replace('#TECHNICIAN', $r['name'], $config['plugin_OnCallAlerts_msg_text_rappel']);
    $msgText = str_replace('#STARTDATE', $dStart->format('d/m/Y H:i'), $msgText);
    $msgText = str_replace('#ENDATE', $dEnd->format('d/m/Y H:i'), $msgText);


    $xml_decoded = "XMLDATA=<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
                        <ResponseService Version=\"2.3\">
                            <Header>
                                <Partner>{$config['plugin_OnCallAlerts_login_server_text']}</Partner>
                                <Password>{$config['plugin_OnCallAlerts_pwd_server_text']}</Password>
                                <TransactionID>" . base64_encode($transactionID) . "</TransactionID>
                            </Header>
                            <ResponseList>
                                <Response SequenceNumber=\"1\" Type=\"SMS\">
                                   <Time>{$time->format('YmdHis')}</Time>
                                    <Data>$msgText</Data>
                                    <Destination>{$r['phone']}</Destination>
                                 </Response>
                            </ResponseList>
                        </ResponseService>";

    $qdata = http_build_query(array($xml_decoded));
    $opts = array('http' =>
        array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
            "Content-Length: " . strlen($qdata) . "\r\n" .
            "User-Agent:SMS_Send/0.1\r\n",
            'method' => 'POST',
            'timeout' => 5,
            'content' => $qdata)
    );
    $context = stream_context_create($opts);

    try {
        $rSend = file_get_contents($config['plugin_OnCallAlerts_url_server_text'], false, $context);
        echo 'send to : ' . $r['phone']."\r";
    } catch (HttpException $ex) {
        echo $ex;
    }
}