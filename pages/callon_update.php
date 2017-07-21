<?php

form_security_validate('plugin_OnCallAlerts_callon_update');

$startDate = gpc_get_string('startDate');

if(!empty(gpc_get_string('endDate'))) $endDate = gpc_get_string('endDate');
else $endDate = $startDate;

if(preg_match("#([01][0-9]|2[0-3]):[0-5][0-9]#", gpc_get_string('startTime')) && preg_match("#([01][0-9]|2[0-3]):[0-5][0-9]#", gpc_get_string('endTime')))
{
    $startTime = gpc_get_string('startTime');
    $endTime = gpc_get_string('endTime');
}
else  {
    form_security_purge('plugin_OnCallAlerts_callon_update');
    print_successful_redirect(plugin_page('management&error#tabs-3', true));
}

$technicianID = gpc_get_string('technicianID');
$note = gpc_get_string('note');

if (!empty($startDate) && !empty($endDate)
) {

    $format = 'd/m/Y';

    $startDateTime = \DateTime::createFromFormat($format, $startDate);
    $endDateTime = \DateTime::createFromFormat($format, $endDate);

    if ($startDateTime <= $endDateTime) {

        $onCall = new OnCallAlertsOncall();
        $onCall->technician_id = $technicianID;
        $onCall->start_date = $startDateTime->format("Y-m-d").' '.$startTime.':00';
        $onCall->end_date = $endDateTime->format("Y-m-d").' '.$endTime.':00';
        $onCall->note = $note;

        if ($onCall->save()) {
            form_security_purge('plugin_OnCallAlerts_callon_update');
            print_successful_redirect(plugin_page('management#tabs-3', true));
        } else {
            form_security_purge('plugin_OnCallAlerts_callon_update');
            print_successful_redirect(plugin_page('management&error#tabs-3', true));
        }
    } else {
        form_security_purge('plugin_OnCallAlerts_callon_update');
        print_successful_redirect(plugin_page('management&error#tabs-3', true));
    }
} else {
    form_security_purge('plugin_OnCallAlerts_callon_update');
    print_successful_redirect(plugin_page('management&error#tabs-3', true));
}


