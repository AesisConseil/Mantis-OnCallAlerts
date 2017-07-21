<?php

form_security_validate('plugin_OnCallAlerts_planing_update');

$day = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');

foreach ($day as $d)
{
    $$d = gpc_get_bool($d);
}

if(preg_match("#([01][0-9]|2[0-3]):[0-5][0-9]#", gpc_get_string('startTime')) && preg_match("#([01][0-9]|2[0-3]):[0-5][0-9]#", gpc_get_string('endTime')))
{
    $startTime = gpc_get_string('startTime');
    $endTime = gpc_get_string('endTime');
}
else  {
    form_security_purge('plugin_OnCallAlerts_callon_update');
    print_successful_redirect(plugin_page('management&error#tabs-4', true));
}

$technicianID = gpc_get_string('technicianID');
$note = gpc_get_string('note');

if (!empty($startTime) && !empty($endTime)
) {
    $format = 'H:i';

    $startDateTime = \DateTime::createFromFormat($format, $startTime);
    $endDateTime = \DateTime::createFromFormat($format, $endTime);

    if ($startDateTime <= $endDateTime) {

        $planing = new OnCallAlertsPlaning();
        $planing->technician_id = $technicianID;
        $planing->monday = $monday;
        $planing->tuesday = $tuesday;
        $planing->wednesday = $wednesday;
        $planing->thursday = $thursday;
        $planing->friday = $friday;
        $planing->saturday = $saturday;
        $planing->sunday = $sunday;
        $planing->start_time = $startTime.':00';
        $planing->end_time = $endTime.':00';
        $planing->note = $note;

        if ($planing->save()) {
            form_security_purge('plugin_OnCallAlerts_callon_update');
            print_successful_redirect(plugin_page('management#tabs-4', true));
        } else {
            form_security_purge('plugin_OnCallAlerts_callon_update');
            print_successful_redirect(plugin_page('management&error#tabs-4', true));
        }
    } else {
        form_security_purge('plugin_OnCallAlerts_callon_update');
        print_successful_redirect(plugin_page('management&error#tabs-4', true));
    }
} else {
    form_security_purge('plugin_OnCallAlerts_callon_update');
    print_successful_redirect(plugin_page('management&error#tabs-4', true));
}


