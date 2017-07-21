<?php

form_security_validate('plugin_OnCallAlerts_technician_phone_update');

$technician_id = gpc_get_string('id');
$technician_phone = gpc_get_string('phoneUpdate');
$technician_name = gpc_get_string('name');

if(!empty($technician_id) &&
   !empty($technician_name) &&
   preg_match("#(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)#",$technician_phone)
  )
{
    
    $technician = new OnCallAlertsTechnician();
    $technician->name = $technician_name;
    $technician->phone = $technician_phone;
    $technician->id = $technician_id;
    
    if ($technician->save()) {
        form_security_purge('plugin_OnCallAlerts_technician_update');
        print_successful_redirect(plugin_page('management#tabs-2', true));
    } else {
        form_security_purge('plugin_OnCallAlerts_technician_update');
        print_successful_redirect(plugin_page('management&error#tabs-2', true));
    }
    
    form_security_purge('plugin_OnCallAlerts_technician_update');
    print_successful_redirect(plugin_page('management#tabs-2', true));
}
else
{
    form_security_purge('plugin_OnCallAlerts_technician_update');
    print_successful_redirect(plugin_page('management&error#tabs-2', true));
}


