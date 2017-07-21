<?php

if( isset($_GET['id']) && !empty($_GET['id']))
{
    $technician = new OnCallAlertsTechnician();
    $technician->id = $_GET['id'];
    if($technician->delete()) print_successful_redirect(plugin_page('management#tabs-2', true));
    else print_successful_redirect(plugin_page('management&error#tabs-2', true));
    
    print_successful_redirect(plugin_page('management#tabs-2', true));
}
else
{
    print_successful_redirect(plugin_page('management&error#tabs-2', true));
}


