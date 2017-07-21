<?php

form_security_validate('plugin_OnCallAlerts_config_sms_update');

$select_project = gpc_get_string_array('select_project');

if(in_array('0',$select_project)) plugin_config_set('select_project', array('0'));
else  plugin_config_set('select_project', $select_project);


if(isset($_POST['newBug']))
{
    $newBug         = gpc_get_string('newBug');
    $select_newbug  = gpc_get_string_array('select_newbug');
    plugin_config_set('newBug', $newBug);
    plugin_config_set('select_newbug', $select_newbug);
}

if(isset($_POST['updateBug']))
{
    $updateBug          = gpc_get_string('updateBug');
    $select_updateBug   = gpc_get_string_array('select_updateBug');
    plugin_config_set('updateBug', $updateBug);
    plugin_config_set('select_updateBug', $select_updateBug);
}

if(isset($_POST['addNote']))
{
    $addNote        = gpc_get_string('addNote');
    $select_addNote = gpc_get_string_array('select_addNote');
    plugin_config_set('addNote', $addNote);
    plugin_config_set('select_addNote', $select_addNote); 
}
//var_dump($select_project);

form_security_purge('plugin_OnCallAlerts_config_sms_update');
print_successful_redirect(plugin_page('management', true));
