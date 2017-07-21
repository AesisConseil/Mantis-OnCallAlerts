<?php

$technician = new OnCallAlertsTechnician();

$infosTechnician  = $technician->getById($_GET['id']);

$text = new OnCallAlertsSendText();

$msgText = str_replace('#TECHNICIAN',$infosTechnician->name,plugin_config_get('msg_text_test'));

if($text->sendText($msgText, $infosTechnician->phone))
{
    Logger::trace("Text send to {$infosTechnician->phone} with msg: '$msgText'");
    print_successful_redirect(plugin_page('management&#tabs-2', true));
}
else print_successful_redirect(plugin_page('management&errorText#tabs-2', true));