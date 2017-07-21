<?php

$planing = new OnCallAlertsPlaning();
$resPlaning = $planing->fetchall();

$technician = new OnCallAlertsTechnician();
$resTechnician = $technician->fetchall();

$aCsv = array();

$date= new \DateTime();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=export_planing_'.$date->format('d-m-y_H-i').'.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array( plugin_lang_get('technician'), 
                            plugin_lang_get('phone') , 
                            plugin_lang_get('monday') ,
                            plugin_lang_get('tuesday') ,
                            plugin_lang_get('wednesday') ,
                            plugin_lang_get('thursday') ,
                            plugin_lang_get('friday') ,
                            plugin_lang_get('saturday') ,
                            plugin_lang_get('sunday') ,
                            plugin_lang_get('startTime'), 
                            plugin_lang_get('endTime'), 
                            plugin_lang_get('note')));




if ($resPlaning)
{
    foreach ($resPlaning as $p)
    {
       $t = $technician->getById($p->technician_id);
       
       $r = array($t->name,$t->phone);
       
       unset($p->id); unset($p->technician_id);
       foreach ($p as $pp) array_push ($r, utf8_decode ($pp));
       
       $aCsv[] = $r;       
    }
    
}
                    
if($aCsv)
{
    foreach($aCsv as $csvL)
    {
        fputcsv($output, $csvL);
    }
}

