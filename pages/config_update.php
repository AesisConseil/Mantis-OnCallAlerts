<?php

form_security_validate('plugin_OnCallAlerts_config_update');

$nb_day_log = gpc_get_string('nb_day_log');
$msg_text = str_replace(array("\n","\r"),'',gpc_get_string('msg_text'));
$msg_text_rappel =  str_replace(array("\n","\r"),'',gpc_get_string('msg_text_rappel'));
$msg_text_test =  str_replace(array("\n","\r"),'',gpc_get_string('msg_text_test'));
$url_server = gpc_get_string('url_server_text');
$url_mantis = gpc_get_string('url_mantis_text');
$publickey_server = gpc_get_string('publickey_server_text');
$login_server = gpc_get_string('login_server_text');
$pwd_server = gpc_get_string('pwd_server_text');
$data_server = gpc_get_string('data_server_text');


if (is_numeric($nb_day_log)) { 
    plugin_config_set('nb_day_log', $nb_day_log);
}

if (!empty($msg_text)) {
    plugin_config_set('msg_text', $msg_text);
}

if (!empty($msg_text_test)) {
    plugin_config_set('msg_text_test', $msg_text_test);
}

if (!empty($msg_text_rappel)) {
    plugin_config_set('msg_text_rappel', $msg_text_rappel);
}

plugin_config_set('url_server_text', $url_server);
plugin_config_set('url_mantis_text', $url_mantis);
plugin_config_set('publickey_server_text', $publickey_server);
plugin_config_set('login_server_text', $login_server);
plugin_config_set('pwd_server_text', $pwd_server);
plugin_config_set('data_server_text', $data_server);

form_security_purge('plugin_OnCallAlerts_config_update');
print_successful_redirect(plugin_page('config', true));
