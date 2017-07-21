<?php

if( isset($_GET['id']) && !empty($_GET['id']))
{
    $planing = new OnCallAlertsPlaning();
    $planing->id = $_GET['id'];
    if($planing->delete()) print_successful_redirect(plugin_page('management#tabs-4', true));
    else print_successful_redirect(plugin_page('management&error#tabs-4', true));
}
else
{
    print_successful_redirect(plugin_page('management&error#tabs-4', true));
}


