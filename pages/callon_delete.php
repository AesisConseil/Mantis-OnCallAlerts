<?php

if( isset($_GET['id']) && !empty($_GET['id']))
{
    $onCall = new OnCallAlertsOncall();
    $onCall->id = $_GET['id'];
    if($onCall->delete()) print_successful_redirect(plugin_page('management#tabs-3', true));
    else print_successful_redirect(plugin_page('management&error#tabs-3', true));
}
else
{
    print_successful_redirect(plugin_page('management&error#tabs-3', true));
}


