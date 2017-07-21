<?php

$technician = new OnCallAlertsTechnician();
$infosTechnician  = $technician->getById($_GET['idTech']);

$oncall = new OnCallAlertsOncall();
$infosOnCall = $oncall->getById($_GET['idoncall']);

$dStart = new \DateTime($infosOnCall->start_date);
$dEnd = new \DateTime($infosOnCall->end_date);

$text = new OnCallAlertsSendText();

$msgText = str_replace('#TECHNICIAN',$infosTechnician->name,plugin_config_get('msg_text_rappel'));
$msgText = str_replace('#STARTDATE',$dStart->format('d/m/Y H:i'),$msgText);
$msgText = str_replace('#ENDATE',$dEnd->format('d/m/Y H:i'),$msgText);

if($text->sendText($msgText, $infosTechnician->phone))
{
    Logger::trace("Text send to {$infosTechnician->phone} with msg: '$msgText'");
    print_successful_redirect(plugin_page('management&#tabs-3', true));
}
else print_successful_redirect(plugin_page('management&errorText#tabs-3', true));
 